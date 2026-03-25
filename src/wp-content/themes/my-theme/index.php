<?php get_header(); ?>
<main>
    <?php if (have_posts()): ?>
        <?php while (have_posts()):
            the_post(); ?>
            <article>
                <h2>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>
                <p><?php the_excerpt(); ?></p>
            </article>
        <?php
        endwhile; ?>
    <?php else: ?>
        <p>記事がありません</p>
    <?php endif; ?>
</main>
<?php get_footer(); ?>
