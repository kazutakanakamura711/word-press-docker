<?php
/**
 * Template Name: Gallery
 * Galleryページテンプレート
 * gallery_itemカスタム投稿タイプを1:1正方形グリッドで表示
 */
get_header();
the_post();

$gallery_items = new WP_Query(array(
    'post_type'      => 'gallery_item',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
));
?>
<main class="l-main">
    <?php get_template_part('template-parts/page-hero'); ?>

    <section class="p-gallery">
        <div class="l-container">
            <h2 class="p-gallery__heading c-section-heading">Gallery</h2>

            <?php if ($gallery_items->have_posts()) : ?>
            <div class="p-gallery__grid">
                <?php while ($gallery_items->have_posts()) : $gallery_items->the_post(); ?>
                    <?php if (has_post_thumbnail()) : ?>
                    <div class="p-gallery__item">
                        <?php the_post_thumbnail('large', array('class' => 'p-gallery__image')); ?>
                        <?php if (get_the_title()) : ?>
                            <p class="p-gallery__caption"><?php the_title(); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <?php else : ?>
                <p>ギャラリー画像はまだ登録されていません。</p>
            <?php endif; ?>

        </div>
    </section>
</main>
<?php get_footer(); ?>
