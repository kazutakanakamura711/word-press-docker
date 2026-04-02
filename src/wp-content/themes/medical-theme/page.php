<?php get_header(); ?>
<main class="max-w-6xl mx-auto px-4 py-16">
    <?php if (have_posts()): ?>
        <?php while (have_posts()): the_post(); ?>
            <article class="prose max-w-none">
                <h1 class="text-3xl font-bold text-gray-900 mb-8"><?php the_title(); ?></h1>
                <div class="text-gray-700 leading-relaxed"><?php the_content(); ?></div>
            </article>
        <?php endwhile; ?>
    <?php endif; ?>
</main>
<?php get_footer(); ?>
