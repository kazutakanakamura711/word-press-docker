<?php
/**
 * Home - Services セクション
 * 診療科目のカード一覧（serviceカスタム投稿タイプ or フォールバック）
 */
$services = new WP_Query([
    'post_type'      => 'service',
    'posts_per_page' => 6,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
]);

// 投稿がない場合のフォールバックデータ
$fallback_services = [
    ['icon' => '🫀', 'title' => '内科', 'desc' => '風邪・発熱・生活習慣病など、一般的な内科疾患に対応いたします。'],
    ['icon' => '🩺', 'title' => '小児科', 'desc' => 'お子様の成長・発達から感染症まで、お子様の健康をサポートします。'],
    ['icon' => '🦴', 'title' => '整形外科', 'desc' => '肩・腰・膝の痛みやスポーツ外傷など、運動器全般の治療を行います。'],
    ['icon' => '🧬', 'title' => '皮膚科', 'desc' => 'アトピー・湿疹・蕁麻疹などの皮膚疾患を専門的に診察します。'],
    ['icon' => '😌', 'title' => '心療内科', 'desc' => 'ストレス・不眠・不安障害など、こころとからだの不調に対応します。'],
    ['icon' => '🔬', 'title' => '健康診断', 'desc' => '各種健康診断・特定健診・人間ドックに対応しています。'],
];
?>
<section class="py-24 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
            <p class="text-teal-600 text-sm font-semibold tracking-widest uppercase mb-3">Services</p>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">診療案内</h2>
            <div class="w-12 h-1 bg-teal-500 mx-auto rounded-full"></div>
        </div>

        <?php if ($services->have_posts()): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php while ($services->have_posts()): $services->the_post(); ?>
                    <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="w-16 h-16 rounded-xl overflow-hidden mb-5">
                                <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover']); ?>
                            </div>
                        <?php endif; ?>
                        <h3 class="text-xl font-bold text-gray-900 mb-3"><?php the_title(); ?></h3>
                        <p class="text-gray-500 text-sm leading-relaxed"><?php echo wp_trim_words(get_the_excerpt() ?: get_the_content(), 40); ?></p>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php else: ?>
            <!-- フォールバック（投稿登録前のプレースホルダー） -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($fallback_services as $service): ?>
                    <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                        <div class="text-4xl mb-5"><?php echo $service['icon']; ?></div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3"><?php echo esc_html($service['title']); ?></h3>
                        <p class="text-gray-500 text-sm leading-relaxed"><?php echo esc_html($service['desc']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="text-center mt-12">
            <a href="<?php echo esc_url(home_url('/services')); ?>"
                class="inline-flex items-center gap-2 bg-teal-700 hover:bg-teal-600 text-white font-semibold px-8 py-3 rounded-full transition-colors duration-200">
                診療案内をすべて見る
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</section>
