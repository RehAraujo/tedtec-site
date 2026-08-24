<?php
/**
 * Plugin Name: TED TEC Reviews Carousel
 * Description: Renders the existing TED TEC reviews carousel with data stored by Rich Showcase for Google Reviews.
 * Version: 1.1.0
 * Author: TED TEC
 * Requires at least: 6.2
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
    exit;
}

define('TEDTEC_REVIEWS_VERSION', '1.1.0');
define('TEDTEC_REVIEWS_DIR', plugin_dir_path(__FILE__));
define('TEDTEC_REVIEWS_URL', plugin_dir_url(__FILE__));

require_once TEDTEC_REVIEWS_DIR . 'includes/class-review-normalizer.php';
require_once TEDTEC_REVIEWS_DIR . 'includes/class-rich-showcase-provider.php';
require_once TEDTEC_REVIEWS_DIR . 'includes/class-carousel-renderer.php';

final class TedTec_Reviews_Carousel {
    const SHORTCODE = 'tedtec_reviews_carousel';
    const LAST_GOOD_OPTION = 'tedtec_reviews_last_good';

    public static function init() {
        add_shortcode(self::SHORTCODE, array(__CLASS__, 'shortcode'));
    }

    public static function shortcode($atts = array()) {
        $atts = shortcode_atts(array('limit' => 12), $atts, self::SHORTCODE);
        $limit = max(1, min(30, absint($atts['limit'])));

        self::enqueue_assets();

        $provider = new TedTec_Rich_Showcase_Provider();
        $normalizer = new TedTec_Review_Normalizer();
        $payload = $normalizer->normalize_payload($provider->get_payload(), $limit);

        if ($normalizer->is_valid_payload($payload)) {
            update_option(self::LAST_GOOD_OPTION, $payload, false);
        } else {
            $payload = get_option(self::LAST_GOOD_OPTION, array());
            $payload = $normalizer->normalize_payload($payload, $limit);
        }

        if (!$normalizer->is_valid_payload($payload)) {
            $payload = $normalizer->normalize_payload(self::static_fallback(), $limit);
        }

        return TedTec_Carousel_Renderer::render($payload);
    }

    private static function enqueue_assets() {
        $script_path = TEDTEC_REVIEWS_DIR . 'assets/js/carousel.js';
        $version = file_exists($script_path) ? (string) filemtime($script_path) : TEDTEC_REVIEWS_VERSION;

        wp_enqueue_script(
            'tedtec-reviews-carousel',
            TEDTEC_REVIEWS_URL . 'assets/js/carousel.js',
            array(),
            $version,
            true
        );
    }

    private static function static_fallback() {
        return array(
            'business' => array(
                'rating' => 5.0,
                'review_count' => 42,
                'google_url' => 'https://maps.google.com/?cid=13511083272697794854',
            ),
            'reviews' => array(),
        );
    }
}

add_action('plugins_loaded', array('TedTec_Reviews_Carousel', 'init'), 20);
