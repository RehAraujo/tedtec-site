<?php

if (!defined('ABSPATH')) {
    exit;
}
final class TedTec_Rich_Showcase_Provider {
    const CORE_CLASS = '\\WP_Rplg_Google_Reviews\\Includes\\Core\\Core';
    const PLACE_ID = 'ChIJOxayg-g0bCYRJtHf16YCgbs';

    public function get_payload() {
        $core_class = self::CORE_CLASS;
        if (!class_exists($core_class) || !method_exists($core_class, 'get_reviews')) {
            return array();
        }

        $feed = $this->find_feed();
        if (!$feed || empty($feed->post_content)) {
            return array();
        }

        try {
            $core = new $core_class();
            $data = $core->get_reviews($feed);
        } catch (Throwable $error) {
            return array();
        }

        if (!is_array($data) || !isset($data['reviews']) || !is_array($data['reviews'])) {
            return array();
        }

        $review_ids = $this->load_stable_review_ids($data['reviews']);
        $reviews = array();
        foreach ($data['reviews'] as $review) {
            if (!is_object($review) && !is_array($review)) {
                continue;
            }
            $row = (array) $review;
            $local_id = isset($row['id']) ? absint($row['id']) : 0;
            $reviews[] = array(
                'id' => isset($review_ids[$local_id]) ? $review_ids[$local_id] : (string) $local_id,
                'name' => isset($row['author_name']) ? $row['author_name'] : '',
                'avatar_url' => isset($row['author_avatar']) ? $row['author_avatar'] : '',
                'rating' => isset($row['rating']) ? $row['rating'] : 0,
                'text' => isset($row['text']) ? $row['text'] : '',
                'timestamp' => isset($row['time']) ? $row['time'] : 0,
                'author_url' => isset($row['author_url']) ? $row['author_url'] : '',
                'review_url' => isset($row['url']) ? $row['url'] : '',
                'hidden' => !empty($row['hide']),
            );
        }

        $business = array();
        if (!empty($data['businesses'][0])) {
            $source_business = (array) $data['businesses'][0];
            $business = array(
                'rating' => isset($source_business['rating']) ? $source_business['rating'] : 0,
                'review_count' => isset($source_business['review_count']) ? $source_business['review_count'] : 0,
                'google_url' => isset($source_business['url']) ? $source_business['url'] : '',
            );
        }

        return array('business' => $business, 'reviews' => $reviews);
    }

    private function find_feed() {
        $ids = array_filter(array_map('absint', explode(',', (string) get_option('grw_feed_ids', ''))));
        foreach ($ids as $id) {
            $feed = get_post($id);
            if (!$feed || $feed->post_type !== 'grw_feed') {
                continue;
            }
            $connection = json_decode($feed->post_content);
            if (empty($connection->connections) || !is_array($connection->connections)) {
                continue;
            }
            foreach ($connection->connections as $item) {
                if (isset($item->id) && hash_equals(self::PLACE_ID, (string) $item->id)) {
                    return $feed;
                }
            }
        }
        return null;
    }

    private function load_stable_review_ids($reviews) {
        global $wpdb;
        $local_ids = array();
        foreach ($reviews as $review) {
            $row = (array) $review;
            if (!empty($row['id'])) {
                $local_ids[] = absint($row['id']);
            }
        }
        $local_ids = array_values(array_unique(array_filter($local_ids)));
        if (!$local_ids) {
            return array();
        }

        $table = $wpdb->prefix . 'grp_google_review';
        $exists = $wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', $table));
        if ($exists !== $table) {
            return array();
        }

        $placeholders = implode(',', array_fill(0, count($local_ids), '%d'));
        $query = $wpdb->prepare("SELECT id, review_id FROM {$table} WHERE id IN ({$placeholders})", $local_ids);
        $rows = $wpdb->get_results($query);
        $result = array();
        foreach ($rows as $row) {
            if (!empty($row->review_id)) {
                $result[(int) $row->id] = (string) $row->review_id;
            }
        }
        return $result;
    }
}
