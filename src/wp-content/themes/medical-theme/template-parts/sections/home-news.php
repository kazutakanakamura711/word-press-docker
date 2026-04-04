<?php
/**
 * Home - News セクション
 * 最新のお知らせ（newsカスタム投稿タイプ）
 */
$news_posts = new WP_Query([
    'post_type'      => 'news',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);
?>
<section class="py-24 bg-white">
    <div class="max-w-4xl mx-auto px-4">
        <div class="flex items-end justify-between mb-12">
            <div>
                <p class="text-teal-600 text-sm font-semibold tracking-widest uppercase mb-2">News</p>
                <h2 class="text-4xl font-bold text-gray-900">お知らせ</h2>
            </div>
            <a href="<?php echo esc_url(get_post_type_archive_link('news')); ?>"
                class="text-teal-700 hover:text-teal-900 font-medium text-sm flex items-center gap-1 transition-colors">
                すべて見る
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <?php if ($news_posts->have_posts()): ?>
            <div class="divide-y divide-gray-100">
                <?php while ($news_posts->have_posts()): $news_posts->the_post(); ?>
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-6 py-5 hover:bg-gray-50 rounded-lg px-3 -mx-3 transition-colors">
                        <time class="text-gray-400 text-sm flex-shrink-0 sm:w-32 sm:pt-0.5" datetime="<?php echo get_the_date('Y-m-d'); ?>">
                            <?php echo get_the_date('Y年m月d日'); ?>
                        </time>
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-900">
                                <a href="<?php the_permalink(); ?>" class="hover:text-teal-700 transition-colors">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php else: ?>
            <div class="py-12 text-center text-gray-400">
                <p>現在お知らせはありません。</p>
            </div>
        <?php endif; ?>
    </div>
</section>
