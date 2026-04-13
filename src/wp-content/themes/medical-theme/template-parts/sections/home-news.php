<?php
/**
 * Home - News セクション
 * 最新のお知らせ（newsカスタム投稿タイプ）
 */
$news_posts = new WP_Query([
    'post_type' => 'news',
    'posts_per_page' => 3,
    'orderby' => 'date',
    'order' => 'DESC',
]); ?>
<section class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-4">
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                while ($news_posts->have_posts()):
                    $news_posts->the_post(); ?>
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
                            <div class="w-full h-48 bg-teal-50 flex items-center justify-center text-teal-400 text-2xl font-medium">お知らせ</div>
                        <?php endif; ?>
                        <div class="p-5">
                            <time class="text-gray-400 text-xs" datetime="<?php echo get_the_date(
                                'Y-m-d',
                            ); ?>">
                                <?php echo get_the_date('Y年m月d日'); ?>
                            </time>
                            <h3 class="font-bold text-gray-900 mt-1 mb-2 line-clamp-2">
                                <?php the_title(); ?>
                            </h3>
                            <p class="text-gray-500 text-sm line-clamp-3"><?php the_excerpt(); ?></p>
                        </div>
                    </article>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        <?php else: ?>
            <div class="py-12 text-center text-gray-400">
                <p>現在お知らせはありません。</p>
            </div>
        <?php endif; ?>
    </div>
</section>
