<?php get_header(); ?>
<main>
    <?php if (have_posts()):
        the_post(); ?>
        <article>
            <h1><?php the_title(); ?></h1>
            <div><?php the_content(); ?></div>
        </article>
    <?php
    endif; ?>
</main>
<?php get_footer(); ?>
