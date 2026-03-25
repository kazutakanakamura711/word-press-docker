<?php
/**
 * Template Name: Applications
 * Applicationsページテンプレート
 */
get_header();
the_post();

$apps = new WP_Query([
    'post_type' => 'application',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
]);
?>
<main class="l-main">
    <?php get_template_part('template-parts/page-hero'); ?>

    <section class="p-applications">
        <div class="l-container">
            <h2 class="p-applications__heading c-section-heading">Applications</h2>

            <?php if ($apps->have_posts()): ?>
            <div class="p-applications__list">
                <?php
                while ($apps->have_posts()):
                    $apps->the_post(); ?>
                <article class="p-applications__item">
                    <?php if (has_post_thumbnail()): ?>
                        <div class="p-applications__image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="p-applications__body">
                        <h3 class="p-applications__title"><?php the_title(); ?></h3>
                        <div class="p-applications__text"><?php the_content(); ?></div>
                        <?php
                        $technologies = get_field('technologies');
                        if ($technologies):
                            $tags = array_map('trim', explode(',', $technologies)); ?>
                        <ul class="p-applications__tags">
                            <?php foreach ($tags as $tag): ?>
                            <li class="p-applications__tag"><?php echo esc_html($tag); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php
                        endif;
                        ?>
                        <?php
                        $app_url = get_field('app_url');
                        $github_url = get_field('github_url');
                        if ($app_url || $github_url): ?>
                        <div class="p-applications__links">
                            <?php if ($app_url): ?>
                            <a href="<?php echo esc_url(
                                $app_url,
                            ); ?>" class="c-button c-button--primary" target="_blank" rel="noopener noreferrer">App</a>
                            <?php endif; ?>
                            <?php if ($github_url): ?>
                            <a href="<?php echo esc_url(
                                $github_url,
                            ); ?>" class="c-button c-button--secondary" target="_blank" rel="noopener noreferrer">GitHub</a>
                            <?php endif; ?>
                        </div>
                          <?php endif;
                        ?>
                    </div>
                </article>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
            <?php else: ?>
                <p>アプリはまだ登録されていません。</p>
            <?php endif; ?>

        </div>
    </section>
</main>
<?php get_footer(); ?>
