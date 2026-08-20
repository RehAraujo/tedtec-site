<?php
if (!defined('ABSPATH')) {
    exit;
}

$rating = isset($business['rating']) ? (float) $business['rating'] : 0;
$review_count = isset($business['review_count']) ? absint($business['review_count']) : 0;
$formatted_rating = number_format_i18n($rating, 1);
?>
<div class="tt-section-heading tt-section-heading--center" data-reveal>
  <p class="tt-eyebrow" style="justify-content:center;display:flex;">Avaliações no Google</p>
  <h2>Confiança construída em cada atendimento</h2>
  <div class="tt-review-score" aria-label="Nota <?php echo esc_attr($formatted_rating); ?> de 5, baseada em <?php echo esc_attr($review_count); ?> avaliações">
    <span class="tt-review-score-num"><?php echo esc_html($formatted_rating); ?></span>
    <span class="tt-review-stars" aria-hidden="true">★★★★★</span>
  </div>
  <p><?php echo esc_html(sprintf(_n('%d avaliação real de cliente atendido pela TedTec no Google.', '%d avaliações reais de clientes atendidos pela TedTec no Google.', $review_count, 'tedtec-reviews-carousel'), $review_count)); ?></p>
</div>

<div class="tt-carousel" data-tt-carousel role="region" aria-roledescription="carrossel" aria-label="Avaliações de clientes" data-reveal>
  <div class="tt-carousel-viewport">
    <ul class="tt-carousel-track" data-tt-track>
<?php foreach ($reviews as $index => $review) :
    $initial = function_exists('mb_substr') ? mb_substr($review['name'], 0, 1) : substr($review['name'], 0, 1);
    $bg = $index % 2 === 0 ? '#47d1c5' : '#2d2d2f';
    $stars = str_repeat('★', (int) $review['rating']) . str_repeat('☆', 5 - (int) $review['rating']);
?>
      <li class="tt-carousel-slide" data-review-id="<?php echo esc_attr($review['id']); ?>">
        <article class="tt-review-card">
          <div class="tt-review-top">
            <span class="tt-review-avatar-wrap">
<?php if (!empty($review['avatar_url'])) : ?>
              <img decoding="async" class="tt-review-avatar-img" src="<?php echo esc_url($review['avatar_url']); ?>" alt="" loading="lazy" width="40" height="40" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
<?php endif; ?>
              <span class="tt-review-avatar" style="background:<?php echo esc_attr($bg); ?>;<?php echo !empty($review['avatar_url']) ? '' : 'display:flex;'; ?>"><?php echo esc_html($initial); ?></span>
            </span>
            <div>
              <strong><?php echo esc_html($review['name']); ?></strong>
              <span class="tt-review-stars-sm" aria-label="<?php echo esc_attr($review['rating']); ?> de 5 estrelas"><?php echo esc_html($stars); ?></span>
            </div>
          </div>
          <p class="tt-review-text"><?php echo esc_html($review['text']); ?></p>
        </article>
      </li>
<?php endforeach; ?>
    </ul>
  </div>
  <button type="button" class="tt-carousel-arrow tt-carousel-arrow--prev" data-tt-prev aria-label="Avaliação anterior">‹</button>
  <button type="button" class="tt-carousel-arrow tt-carousel-arrow--next" data-tt-next aria-label="Próxima avaliação">›</button>
  <div class="tt-carousel-dots" data-tt-dots></div>
</div>
