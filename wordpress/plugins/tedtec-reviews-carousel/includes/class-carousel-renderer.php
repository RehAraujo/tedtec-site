<?php

if (!defined('ABSPATH')) {
    exit;
}
final class TedTec_Carousel_Renderer {
    public static function render($payload) {
        if (empty($payload['reviews']) || !is_array($payload['reviews'])) {
            return '<p class="tt-review-empty" role="status">As avaliações estão temporariamente indisponíveis. <a href="https://maps.google.com/?cid=13511083272697794854" target="_blank" rel="noopener">Ver avaliações no Google</a>.</p>';
        }

        $business = isset($payload['business']) ? $payload['business'] : array();
        $reviews = $payload['reviews'];
        $template = TEDTEC_REVIEWS_DIR . 'templates/carousel.php';
        if (!is_readable($template)) {
            return '';
        }

        ob_start();
        include $template;
        return (string) ob_get_clean();
    }
}
