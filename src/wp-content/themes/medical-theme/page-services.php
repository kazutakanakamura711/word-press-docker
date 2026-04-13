<?php get_header(); ?>
<main>
    <!-- ページヘッダー -->
    <?php
    $header_img_url = function_exists('get_field') ? get_field('page_header_image') : '';
    $header_bg_style = $header_img_url
        ? "background-image: url('" . esc_url($header_img_url) . "')"
        : '';
    ?>
    <div class="relative bg-teal-700 text-white py-16<?php echo $header_img_url
        ? ' bg-blend-overlay bg-cover bg-center'
        : ''; ?>"
        <?php if ($header_img_url): ?>style="<?php echo $header_bg_style; ?>"<?php endif; ?>>
        <?php if ($header_img_url): ?>
            <div class="absolute inset-0 bg-teal-900/60"></div>
        <?php endif; ?>
        <div class="relative z-10 max-w-6xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-3">診療案内</h1>
            <p class="text-teal-200">各診療科目の詳細をご確認いただけます</p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-16">
        <?php
        // 診療案内ページ自身のACFフィールド（service_01〜service_16）を参照する
        // ACFが未設定の場合はフォールバックデータを表示する
        $fallback_services = [
            [
                'title' => '内科',
                'desc' => '風邪・発熱・生活習慣病など、一般的な内科疾患に対応いたします。',
                'image' => '',
            ],
            [
                'title' => '小児科',
                'desc' => 'お子様の成長・発達から感染症まで、お子様の健康をサポートします。',
                'image' => '',
            ],
            [
                'title' => '整形外科',
                'desc' => '肩・腰・膝の痛みやスポーツ外傷など、運動器全般の治療を行います。',
                'image' => '',
            ],
            [
                'title' => '皮膚科',
                'desc' => 'アトピー・湿疹・蕁麻疹などの皮膚疾患を専門的に診察します。',
                'image' => '',
            ],
            [
                'title' => '心療内科',
                'desc' => 'ストレス・不眠・不安障害など、こころとからだの不調に対応します。',
                'image' => '',
            ],
            [
                'title' => '健康診断',
                'desc' => '各種健康診断・特定健診・人間ドックに対応しています。',
                'image' => '',
            ],
        ];

        $acf_services = [];
        if (function_exists('get_field')) {
            for ($i = 1; $i <= 16; $i++) {
                $num = str_pad($i, 2, '0', STR_PAD_LEFT);
                $title = get_field("service_{$num}_title");
                $desc = get_field("service_{$num}_description");
                $image = get_field("service_{$num}_image");
                if ($title) {
                    $dept = get_field("service_{$num}_department");
                    $acf_services[] = [
                        'title' => $title,
                        'desc' => $desc ?: '',
                        'image' => $image ?: '',
                        'dept_url' => $dept ? get_permalink($dept) : '',
                    ];
                }
            }
        }

        $services_to_show = $acf_services ?: $fallback_services;
        ?>

        <div class="space-y-16">
            <?php foreach ($services_to_show as $index => $service):

                $is_even = $index % 2 === 0;
                $image_url = $service['image'];
                ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center <?php echo $is_even
                ? ''
                : 'md:[direction:rtl]'; ?>">
                <div class="<?php echo $is_even ? '' : 'md:[direction:ltr]'; ?>">
                    <?php if ($image_url): ?>
                        <div class="rounded-2xl overflow-hidden shadow-md mb-6 md:mb-0">
                            <img src="<?php echo esc_url($image_url); ?>"
                                alt="<?php echo esc_attr($service['title']); ?>"
                                class="w-full h-64 object-cover" loading="lazy">
                        </div>
                    <?php else: ?>
                        <div class="rounded-2xl bg-teal-50 h-64 flex items-center justify-center text-teal-300 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="<?php echo $is_even ? '' : 'md:[direction:ltr]'; ?>">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4"><?php echo esc_html(
                        $service['title'],
                    ); ?></h2>
                    <p class="text-gray-600 leading-relaxed"><?php echo esc_html(
                        $service['desc'],
                    ); ?></p>
                    <?php if (!empty($service['dept_url'])): ?>
                        <a href="<?php echo esc_url($service['dept_url']); ?>"
                            class="inline-flex items-center gap-1 mt-6 text-teal-700 hover:text-teal-900 font-medium text-sm transition-colors">
                            詳細を見る
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php
            endforeach; ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>
