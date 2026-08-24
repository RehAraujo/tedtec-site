<?php
/**
 * Plugin Name: TED TEC Hero Preview
 * Description: Carrega o motion técnico do Hero V2 nas páginas autorizadas do TED TEC.
 * Version: 0.3.2
 * Author: TED TEC
 */

if (!defined('ABSPATH')) {
    exit;
}

function tedtec_hero_preview_enqueue_assets() {
    if (!is_page(array(509, 1091))) {
        return;
    }

    $script_path = plugin_dir_path(__FILE__) . 'assets/hero-motion.js';

    wp_enqueue_script(
        'tedtec-hero-preview-motion',
        plugin_dir_url(__FILE__) . 'assets/hero-motion.js',
        array(),
        file_exists($script_path) ? (string) filemtime($script_path) : '0.3.2',
        true
    );
}
add_action('wp_enqueue_scripts', 'tedtec_hero_preview_enqueue_assets', 20);

function tedtec_hero_preview_litespeed_excludes($excludes) {
    if (!is_array($excludes)) {
        $excludes = array();
    }

    $excludes[] = 'tedtec-hero-preview-motion';
    $excludes[] = 'hero-motion.js';

    return array_values(array_unique($excludes));
}
add_filter('litespeed_optimize_js_excludes', 'tedtec_hero_preview_litespeed_excludes');
add_filter('litespeed_optm_js_defer_exc', 'tedtec_hero_preview_litespeed_excludes');
add_filter('litespeed_optm_gm_js_exc', 'tedtec_hero_preview_litespeed_excludes');
