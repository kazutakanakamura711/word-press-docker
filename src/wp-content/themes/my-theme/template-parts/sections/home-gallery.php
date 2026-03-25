<?php
/**
 * Home - Gallery セクション
 * 概要テキスト + セクション画像のプレビュー
 * 「gallery」スラッグページのアイキャッチ画像がセクション画像になります
 */
$gallery_page = get_page_by_path('gallery');
$section_img  = $gallery_page ? get_the_post_thumbnail_url($gallery_page->ID, 'large') : '';
$section_text = $gallery_page ? apply_filters('the_content', $gallery_page->post_excerpt ?: $gallery_page->post_content) : '';
?>

<section class="p-home-gallery">
    <div class="l-container">
        <h2 class="p-home-gallery__heading c-section-heading">Gallery</h2>

        <div class="p-home-gallery__intro">
            <?php if ($section_img) : ?>
                <div class="p-home-gallery__image">
                    <img src="<?php echo esc_url($section_img); ?>" alt="Gallery" loading="lazy">
                </div>
            <?php endif; ?>
            <?php if ($section_text) : ?>
                <div class="p-home-gallery__text">
                    <?php echo wp_kses_post($section_text); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="p-home-gallery__link-wrap">
            <a href="<?php echo esc_url(get_permalink($gallery_page)); ?>" class="c-button c-button--primary">
                View Gallery
            </a>
        </div>
    </div>
</section>
