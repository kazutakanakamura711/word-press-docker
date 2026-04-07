<?php get_header(); ?>
<main class="max-w-6xl mx-auto px-4 py-16">
    <h1 class="text-3xl font-bold text-gray-900 mb-10">お知らせ</h1>
    <?php if (have_posts()): ?>
        <div class="divide-y divide-gray-100">
            <?php while (have_posts()):
                the_post(); ?>
                <div class="flex gap-6 py-5 hover:bg-gray-50 transition-colors rounded-lg px-3 -mx-3">
                    <time class="text-gray-400 text-sm shrink-0 pt-0.5 w-28" datetime="<?php echo get_the_date(
                        'Y-m-d',
                    ); ?>">
                        <?php echo get_the_date('Y年m月d日'); ?>
                    </time>
                    <div>
                        <h2 class="font-medium text-gray-900">
                            <a href="<?php the_permalink(); ?>" class="hover:text-teal-700 transition-colors">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                    </div>
                </div>
            <?php
            endwhile; ?>
        </div>
        <div class="mt-10 flex justify-center gap-2">
            <?php echo paginate_links(['prev_text' => '&laquo;', 'next_text' => '&raquo;']); ?>
        </div>
    <?php else: ?>
        <p class="text-gray-500">お知らせはありません。</p>
    <?php endif; ?>
</main>
<?php get_footer(); ?>
