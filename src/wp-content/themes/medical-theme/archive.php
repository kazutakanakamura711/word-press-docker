<?php get_header(); ?>
<main class="max-w-6xl mx-auto px-4 py-16">
    <h1 class="text-3xl font-bold text-gray-900 mb-10">
        <?php
        $obj = get_queried_object();
        echo $obj instanceof WP_Post_Type
            ? esc_html($obj->label)
            : post_type_archive_title('', false);
        ?>
    </h1>

    <?php if (have_posts()): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while (have_posts()):
                the_post(); ?>
                <?php get_template_part('template-parts/components/post-card', null, [
                    'heading_tag' => 'h2',
                ]); ?>
            <?php
            endwhile; ?>
        </div>

        <!-- ページネーション -->
        <?php
        $pagination = paginate_links([
            'type' => 'list',
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;',
        ]);
        if ($pagination): ?>
            <div class="mt-12 flex justify-center gap-2">
                <?php echo $pagination; ?>
            </div>
        <?php endif;
        ?>
    <?php else: ?>
        <p class="text-gray-500">記事がありません。</p>
    <?php endif; ?>
</main>
<?php get_footer(); ?>
