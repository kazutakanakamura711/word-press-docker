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
                <article class="relative bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                    <a href="<?php the_permalink(); ?>" class="absolute inset-0 z-10" aria-label="<?php the_title_attribute(); ?>"></a>
                    <?php if (has_post_thumbnail()): ?>
                        <div class="block overflow-hidden">
                            <?php the_post_thumbnail('medium', [
                                'class' =>
                                    'w-full h-48 object-cover hover:scale-105 transition-transform duration-300',
                            ]); ?>
                        </div>
                    <?php else: ?>
                        <div class="w-full h-48 bg-teal-50 flex items-center justify-center text-teal-400 text-sm font-medium">お知らせ</div>
                    <?php endif; ?>
                    <div class="p-5">
                        <time class="text-gray-400 text-xs" datetime="<?php echo get_the_date(
                            'Y-m-d',
                        ); ?>">
                            <?php echo get_the_date('Y年m月d日'); ?>
                        </time>
                        <h2 class="font-bold text-gray-900 mt-1 mb-2 line-clamp-2">
                            <?php the_title(); ?>
                        </h2>
                        <p class="text-gray-500 text-sm line-clamp-3"><?php the_excerpt(); ?></p>
                    </div>
                </article>
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
