<?php get_header(); ?>
<main>
    <h1>
        <?php
        if (is_category()) {
            echo 'カテゴリー：' . single_cat_title('', false);
        } elseif (is_month()) {
            echo get_the_date('Y年n月');
        } else {
            echo 'アーカイブ';
        }
        ?>
    </h1>

    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article>
                <h2>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>
                <p><?php the_excerpt(); ?></p>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <p>記事がありません</p>
    <?php endif; ?>
</main>
<?php get_footer(); ?>