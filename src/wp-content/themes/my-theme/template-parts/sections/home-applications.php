<?php
/**
 * Home - Applications セクション
 * 概要テキスト + セクション画像 + アプリカルーセル
 * 「applications」スラッグページのアイキャッチ画像がセクション画像になります
 */
$apps_page = get_page_by_path('applications');
$section_img = $apps_page ? get_the_post_thumbnail_url($apps_page->ID, 'large') : '';
$section_text = $apps_page
    ? apply_filters('the_content', $apps_page->post_excerpt ?: $apps_page->post_content)
    : '';

// applicationカスタム投稿タイプを取得
$apps = new WP_Query([
    'post_type' => 'application',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
]);
?>

<section class="p-home-applications">
    <div class="l-container">
        <h2 class="p-home-applications__heading c-section-heading">Applications</h2>

        <div class="p-home-applications__intro">
            <?php if ($section_img): ?>
                <div class="p-home-applications__image">
                    <img src="<?php echo esc_url(
                        $section_img,
                    ); ?>" alt="Applications" loading="lazy">
                </div>
            <?php endif; ?>
            <?php if ($section_text): ?>
                <div class="p-home-applications__text">
                    <?php echo wp_kses_post($section_text); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($apps->have_posts()): ?>
        <div class="p-home-applications__carousel swiper js-apps-swiper">
            <div class="swiper-wrapper">
                <?php
                while ($apps->have_posts()):
                    $apps->the_post(); ?>
                <div class="swiper-slide">
                    <div class="c-app-card">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="c-app-card__image">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php endif; ?>
                        <div class="c-app-card__body">
                            <h3 class="c-app-card__title"><?php the_title(); ?></h3>
                            <p class="c-app-card__text"><?php echo esc_html(
                                get_the_excerpt() ?: wp_strip_all_tags(get_the_content()),
                            ); ?></p>
                            <?php
                            $technologies = get_field('technologies');
                            if ($technologies):
                                $tags = array_map('trim', explode(',', $technologies)); ?>
                            <ul class="c-app-card__tags">
                                <?php foreach ($tags as $tag): ?>
                                <li class="c-app-card__tag"><?php echo esc_html($tag); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php
                            endif;
                            ?>
                            <?php
                            $app_url = get_field('app_url');
                            $github_url = get_field('github_url');
                            if ($app_url || $github_url): ?>
                            <div class="c-app-card__links">
                                <?php if ($app_url): ?>
                                <a href="<?php echo esc_url(
                                    $app_url,
                                ); ?>" class="c-app-card__link" target="_blank" rel="noopener noreferrer">App</a>
                                <?php endif; ?>
                                <?php if ($github_url): ?>
                                <a href="<?php echo esc_url(
                                    $github_url,
                                ); ?>" class="c-app-card__link" target="_blank" rel="noopener noreferrer">GitHub</a>
                                <?php endif; ?>
                            </div>
                            <?php endif;
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.js-apps-swiper', {
                loop: true,
                slidesPerView: 1,
                spaceBetween: 24,
                pagination: { el: '.swiper-pagination', clickable: true },
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                breakpoints: {
                    768: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 },
                },
            });
        });
        </script>
        <?php endif; ?>
    </div>
</section>
