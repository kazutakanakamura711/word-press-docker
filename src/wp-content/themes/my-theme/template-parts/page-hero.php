<?php
/**
 * 共通ページヒーロー
 * 各固定ページのアイキャッチ画像をヒーロー背景として表示します
 * 引数: $args['title'] でタイトルを上書き可能
 */
$hero_title   = isset($args['title']) ? $args['title'] : get_the_title();
$hero_img_url = get_the_post_thumbnail_url(null, 'full');
?>

<section class="c-page-hero" <?php if ($hero_img_url) : ?>style="background-image: url('<?php echo esc_url($hero_img_url); ?>');"<?php endif; ?>>
    <div class="c-page-hero__inner l-container">
        <h1 class="c-page-hero__title"><?php echo esc_html($hero_title); ?></h1>
    </div>
</section>
