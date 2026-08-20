<?php

if (!defined('ABSPATH')) {
    exit;
}
final class TedTec_Review_Normalizer {
    public function normalize_payload($payload, $limit) {
        if (!is_array($payload)) {
            return array();
        }

        $business = isset($payload['business']) && is_array($payload['business']) ? $payload['business'] : array();
        $normalized_business = array(
            'rating' => max(0, min(5, (float) (isset($business['rating']) ? $business['rating'] : 0))),
            'review_count' => max(0, absint(isset($business['review_count']) ? $business['review_count'] : 0)),
            'google_url' => esc_url_raw(isset($business['google_url']) ? $business['google_url'] : ''),
        );

        $reviews = array();
        $seen = array();
        foreach ((array) (isset($payload['reviews']) ? $payload['reviews'] : array()) as $review) {
            if (!is_array($review) || !empty($review['hidden'])) {
                continue;
            }
            $id = sanitize_key(isset($review['id']) ? (string) $review['id'] : '');
            $name = sanitize_text_field(isset($review['name']) ? $review['name'] : '');
            $text = trim(wp_strip_all_tags(html_entity_decode((string) (isset($review['text']) ? $review['text'] : ''), ENT_QUOTES, 'UTF-8')));
            $timestamp = absint(isset($review['timestamp']) ? $review['timestamp'] : 0);
            $rating = max(0, min(5, (int) round((float) (isset($review['rating']) ? $review['rating'] : 0))));

            if ($id === '' || isset($seen[$id]) || $name === '' || $text === '' || $rating < 1) {
                continue;
            }
            $seen[$id] = true;
            $reviews[] = array(
                'id' => $id,
                'name' => $name,
                'avatar_url' => esc_url_raw(isset($review['avatar_url']) ? $review['avatar_url'] : ''),
                'rating' => $rating,
                'text' => $text,
                'timestamp' => $timestamp,
                'author_url' => esc_url_raw(isset($review['author_url']) ? $review['author_url'] : ''),
                'review_url' => esc_url_raw(isset($review['review_url']) ? $review['review_url'] : ''),
            );
        }

        usort($reviews, static function($a, $b) {
            return $b['timestamp'] <=> $a['timestamp'];
        });

        return array(
            'business' => $normalized_business,
            'reviews' => array_slice($reviews, 0, max(1, absint($limit))),
            'generated_at' => time(),
        );
    }

    public function is_valid_payload($payload) {
        return is_array($payload)
            && !empty($payload['reviews'])
            && is_array($payload['reviews'])
            && !empty($payload['business']['rating']);
    }
}
