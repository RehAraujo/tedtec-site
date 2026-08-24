<?php
/**
 * Plugin Name: TED TEC Global Footer
 * Description: Substitui o Astra Footer Builder pelo rodapé institucional aprovado da TED TEC.
 * Version: 1.0.0
 * Author: TED TEC
 */

if (!defined('ABSPATH')) {
    exit;
}

function tedtec_global_footer_should_render() {
    if (is_admin() || is_preview() || is_feed() || is_404() || wp_doing_ajax()) {
        return false;
    }

    if (is_page(array(1091, 1074, 904)) || (is_singular() && post_password_required())) {
        return false;
    }

    return is_singular(array('page', 'post'));
}

function tedtec_global_footer_register() {
    if (!tedtec_global_footer_should_render() || !class_exists('Astra_Builder_Footer')) {
        return;
    }

    $astra_footer = Astra_Builder_Footer::get_instance();
    remove_action('astra_footer', array($astra_footer, 'footer_markup'), 10);
    add_action('astra_footer', 'tedtec_global_footer_render', 10);
}
add_action('wp', 'tedtec_global_footer_register', 20);

function tedtec_global_footer_enqueue_assets() {
    if (!tedtec_global_footer_should_render()) {
        return;
    }

    $css_path = plugin_dir_path(__FILE__) . 'assets/footer.css';
    $js_path  = plugin_dir_path(__FILE__) . 'assets/footer.js';

    wp_enqueue_style(
        'tedtec-global-footer',
        plugin_dir_url(__FILE__) . 'assets/footer.css',
        array(),
        file_exists($css_path) ? (string) filemtime($css_path) : '1.0.0'
    );

    wp_enqueue_script(
        'tedtec-global-footer',
        plugin_dir_url(__FILE__) . 'assets/footer.js',
        array(),
        file_exists($js_path) ? (string) filemtime($js_path) : '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'tedtec_global_footer_enqueue_assets', 30);

function tedtec_global_footer_render() {
    if (!tedtec_global_footer_should_render()) {
        return;
    }

    $home = home_url('/');
    ?>
    <footer class="tt-final-footer" aria-label="Rodapé TED TEC">
        <div class="tt-final-footer-main" data-tt-footer-reveal>
            <div class="tt-final-footer-brand">
                <a class="tt-final-footer-logo" href="<?php echo esc_url($home); ?>" aria-label="TED TEC — página inicial"><img class="tt-brand-mark" src="<?php echo esc_url(home_url('/wp-content/uploads/2026/08/tedtec-mark.png')); ?>" alt="" width="46" height="38"><img class="tt-brand-wordmark" src="<?php echo esc_url(home_url('/wp-content/uploads/2026/08/cropped-cropped-cropped-cropped-Ativo-3@150x-scaled-1.png')); ?>" alt="TED TEC" width="122" height="20"></a>
            </div>
            <nav class="tt-final-footer-nav" aria-label="Links rápidos"><a href="<?php echo esc_url(home_url('/#tt3-next')); ?>">Como funciona</a><a href="<?php echo esc_url(home_url('/#services')); ?>">Serviços</a><a href="<?php echo esc_url(home_url('/#sobre')); ?>">Sobre</a><a href="<?php echo esc_url(home_url('/#avaliacoes')); ?>">Avaliações</a></nav>
            <div class="tt-final-footer-actions">
                <div class="tt-social-links" aria-label="Contatos e redes sociais">
                    <a class="tt-social-link" href="tel:+5561995147911" aria-label="Telefone" style="--social-color:#47d1c5"><span class="tt-social-fill"></span><svg viewBox="0 0 512 512" aria-hidden="true"><path d="M493.4 24.6l-104-24c-11.3-2.6-22.9 3.3-27.5 13.9l-48 112c-4.2 9.8-1.4 21.3 6.9 28l60.6 49.6c-36 76.7-98.9 140.5-177.2 177.2l-49.6-60.6c-6.8-8.3-18.2-11.1-28-6.9l-112 48C3.9 366.5-2 378.1.6 389.4l24 104C27.1 504.2 36.7 512 48 512c256.1 0 464-207.5 464-464 0-11.2-7.7-20.9-18.6-23.4z"/></svg><span class="tt-social-tooltip" role="tooltip">Telefone</span></a>
                    <a class="tt-social-link" href="mailto:tedtecno21@gmail.com" aria-label="E-mail" style="--social-color:#ea4335"><span class="tt-social-fill"></span><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 4h20v16H2zM2 6l10 7L22 6" fill="none" stroke="currentColor" stroke-width="2"/></svg><span class="tt-social-tooltip" role="tooltip">E-mail</span></a>
                    <a class="tt-social-link" href="https://www.facebook.com/share/1EYNFkz4R8/?mibextid=wwXIfr" aria-label="Facebook" target="_blank" rel="noopener noreferrer" style="--social-color:#557dbc"><span class="tt-social-fill"></span><svg viewBox="0 0 320 512" aria-hidden="true"><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/></svg><span class="tt-social-tooltip" role="tooltip">Facebook</span></a>
                    <a class="tt-social-link" href="https://www.instagram.com/tedtecno?igsh=MTdzMmVtMzR0M2Fhbg==" aria-label="Instagram" target="_blank" rel="noopener noreferrer" style="--social-color:#c13584"><span class="tt-social-fill"></span><svg viewBox="0 0 448 512" aria-hidden="true"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9S121.4 442.2 92 430.6c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1C57.2 104.2 72.3 89.1 92 81.2c29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg><span class="tt-social-tooltip" role="tooltip">Instagram</span></a>
                    <a class="tt-social-link" href="https://www.tiktok.com/@tedtec" aria-label="TikTok" target="_blank" rel="noopener noreferrer" style="--social-color:#25f4ee"><span class="tt-social-fill"></span><svg viewBox="0 0 32 32" aria-hidden="true"><path d="M16.7.03h5.2c.1 2.04.84 4.12 2.33 5.56 1.49 1.48 3.6 2.16 5.65 2.39v5.37a13.1 13.1 0 0 1-7.76-2.54c0 3.9.02 7.79-.03 11.67-.1 1.86-.72 3.72-1.8 5.25a9.76 9.76 0 0 1-7.88 4.28 9.69 9.69 0 0 1-5.44-1.37A9.92 9.92 0 0 1 2.1 23c-.03-.67-.04-1.33-.02-1.98.24-2.54 1.5-4.97 3.44-6.62a9.72 9.72 0 0 1 8.2-2.3c.03 1.98-.05 3.95-.05 5.93a4.19 4.19 0 0 0-4.03.49 4.24 4.24 0 0 0-1.82 2.33c-.27.68-.2 1.43-.18 2.15.32 2.19 2.42 4.03 4.67 3.83a4.54 4.54 0 0 0 3.69-2.15c.25-.44.53-.9.55-1.42.13-2.39.08-4.76.1-7.15.01-5.37-.02-10.73.03-16.09z"/></svg><span class="tt-social-tooltip" role="tooltip">TikTok</span></a>
                    <a class="tt-social-link" href="https://g.page/r/CSbR39emAoG7EAE/review" aria-label="Google Reviews" target="_blank" rel="noopener noreferrer" style="--social-color:#dc4e41"><span class="tt-social-fill"></span><svg viewBox="0 0 24 28" aria-hidden="true"><path d="M12 12.28h11.33c.1.61.18 1.2.18 2C23.51 21.12 18.92 26 12 26 5.36 26 0 20.64 0 14S5.36 2 12 2c3.23 0 5.95 1.19 8.05 3.14l-3.27 3.14c-.89-.86-2.45-1.86-4.78-1.86-4.1 0-7.44 3.39-7.44 7.58S7.9 21.58 12 21.58c4.75 0 6.53-3.4 6.81-5.17H12v-4.13z"/></svg><span class="tt-social-tooltip" role="tooltip">Google Reviews</span></a>
                </div>
                <button class="tt-share-button" type="button" data-tt-share aria-label="Compartilhar" style="--social-color:#47d1c5"><span class="tt-social-fill"></span><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><path d="m8.6 10.7 6.8-4.1M8.6 13.3l6.8 4.1" fill="none" stroke="currentColor" stroke-width="1.8"/></svg><span class="tt-share-label" data-tt-share-label aria-live="polite">Compartilhar ↗</span><span class="tt-social-tooltip" role="tooltip">Compartilhar</span></button>
            </div>
        </div>
        <div class="tt-final-footer-bottom"><p class="tt-final-footer-credit"><span>© 2026 All rights reserved</span><span aria-hidden="true">·</span><a href="https://renatajoin.com" target="_blank" rel="noopener noreferrer">Desenvolvido por Rê Araujo ↗</a></p></div>
    </footer>
    <?php
}
