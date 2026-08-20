<?php
/**
 * Plugin Name: TED TEC Reviews Carousel
 * Description: Renders the existing TED TEC reviews carousel with data stored by Rich Showcase for Google Reviews.
 * Version: 1.0.0
 * Author: TED TEC
 * Requires at least: 6.2
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
    exit;
}

define('TEDTEC_REVIEWS_VERSION', '1.0.0');
define('TEDTEC_REVIEWS_DIR', plugin_dir_path(__FILE__));

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

    private static function static_fallback() {
        return array(
            'business' => array(
                'rating' => 5.0,
                'review_count' => 42,
                'google_url' => 'https://maps.google.com/?cid=13511083272697794854',
            ),
            'reviews' => array(
                array('id'=>'static-re','name'=>'Rê A.','avatar_url'=>'','rating'=>5,'text'=>'Meu pc levou uma queda, não ligava mais… mas o Rafael (Ted) resolveu sem dificuldades!! Nota 10!','timestamp'=>1785161458,'author_url'=>'','review_url'=>''),
                array('id'=>'static-grazianne','name'=>'Grazianne O.','avatar_url'=>'','rating'=>5,'text'=>'Simplesmente fantástico, rápido, honesto e resolve! Muito obrigada!','timestamp'=>1784682082,'author_url'=>'','review_url'=>''),
                array('id'=>'static-jose','name'=>'José M.','avatar_url'=>'','rating'=>5,'text'=>'Atendimento muito bom, desde o início até a finalização. Solícito na resolução do problema e preço justo. Recomendo!','timestamp'=>1784589222,'author_url'=>'','review_url'=>''),
                array('id'=>'static-marilu','name'=>'Marilu D.','avatar_url'=>'','rating'=>5,'text'=>'Rafael tem domínio técnico, agilidade e atendimento excelente. Além disto muito atencioso. Sou sua cliente há tempos e indico sempre para amigos e familiares.','timestamp'=>1784078720,'author_url'=>'','review_url'=>''),
                array('id'=>'static-pedro','name'=>'Pedro A.','avatar_url'=>'','rating'=>5,'text'=>'Perfeito, nada a falar. Atendimento extraordinário.','timestamp'=>1783823953,'author_url'=>'','review_url'=>''),
                array('id'=>'static-joao','name'=>'João Batista de L.','avatar_url'=>'','rating'=>5,'text'=>'Excelente profissional! Prestativo e conhecedor de TI como poucos! Super recomendo!','timestamp'=>1783449799,'author_url'=>'','review_url'=>''),
                array('id'=>'static-diego','name'=>'Diego S.','avatar_url'=>'','rating'=>5,'text'=>'Ótimo atendimento! A máquina que mandei para a manutenção ficou excelente!','timestamp'=>1783367299,'author_url'=>'','review_url'=>''),
                array('id'=>'static-juliane','name'=>'Juliane C.','avatar_url'=>'','rating'=>5,'text'=>'Atendimento super rápido, em casa, eficiente e com preço justo. Super recomendo!','timestamp'=>1782952409,'author_url'=>'','review_url'=>''),
                array('id'=>'static-pedro-amorim','name'=>'Pedro Amorim G.','avatar_url'=>'','rating'=>5,'text'=>'Trabalho muito bom e agradável.','timestamp'=>1782427578,'author_url'=>'','review_url'=>''),
                array('id'=>'static-maysa','name'=>'Maysa Santos de O.','avatar_url'=>'','rating'=>5,'text'=>'Reparou a dobradiça que estava estralando, limpou por dentro. Excelente atendimento, ágil, cuidadoso e experiente.','timestamp'=>1780452585,'author_url'=>'','review_url'=>''),
                array('id'=>'static-gonzalo','name'=>'Gonzalo V.','avatar_url'=>'','rating'=>5,'text'=>'Rápida e eficaz!! Top das galáxias.','timestamp'=>1778365111,'author_url'=>'','review_url'=>''),
                array('id'=>'static-emilly','name'=>'Emilly G.','avatar_url'=>'','rating'=>5,'text'=>'Excelente atendimento e um ótimo serviço.','timestamp'=>1778252936,'author_url'=>'','review_url'=>''),
            ),
        );
    }
}

add_action('plugins_loaded', array('TedTec_Reviews_Carousel', 'init'), 20);
