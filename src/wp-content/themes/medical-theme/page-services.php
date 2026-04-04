<?php get_header(); ?>
<main>
    <!-- ページヘッダー -->
    <?php $header_img_url = function_exists( 'get_field' ) ? get_field( 'page_header_image' ) : ''; ?>
    <div class="relative bg-teal-700 text-white py-16<?php echo $header_img_url ? ' bg-blend-overlay bg-cover bg-center' : ''; ?>"
        <?php if ( $header_img_url ): ?>style="background-image: url('<?php echo esc_url( $header_img_url ); ?>')"<?php endif; ?>>
        <?php if ( $header_img_url ): ?>
            <div class="absolute inset-0 bg-teal-900/60"></div>
        <?php endif; ?>
        <div class="relative z-10 max-w-6xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-3">診療案内</h1>
            <p class="text-teal-200">各診療科目の詳細をご確認いただけます</p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-16">
        <?php
        // 診療案内ページ自身のACFフィールド（service_01〜service_05）を参照する
        // ACFが未設定の場合はフォールバックデータを表示する
        $fallback_services = [
            [ 'title' => '内科',     'desc' => '風邪・発熱・生活習慣病など、一般的な内科疾患に対応いたします。', 'icon' => '' ],
            [ 'title' => '小児科',   'desc' => 'お子様の成長・発達から感染症まで、お子様の健康をサポートします。', 'icon' => '' ],
            [ 'title' => '整形外科', 'desc' => '肩・腰・膝の痛みやスポーツ外傷など、運動器全般の治療を行います。', 'icon' => '' ],
            [ 'title' => '皮膚科',   'desc' => 'アトピー・湿疹・蕁麻疹などの皮膚疾患を専門的に診察します。', 'icon' => '' ],
            [ 'title' => '心療内科', 'desc' => 'ストレス・不眠・不安障害など、こころとからだの不調に対応します。', 'icon' => '' ],
            [ 'title' => '健康診断', 'desc' => '各種健康診断・特定健診・人間ドックに対応しています。', 'icon' => '' ],
        ];

        $acf_services = [];
        if ( function_exists( 'get_field' ) ) {
            for ( $i = 1; $i <= 6; $i++ ) {
                $num   = str_pad( $i, 2, '0', STR_PAD_LEFT );
                $title = get_field( "service_{$num}_title" );
                $desc  = get_field( "service_{$num}_description" );
                $icon  = get_field( "service_{$num}_icon" );
                if ( $title ) {
                    $acf_services[] = [
                        'title' => $title,
                        'desc'  => $desc ?: '',
                        'icon'  => $icon ?: '',
                    ];
                }
            }
        }

        $services_to_show = $acf_services ?: $fallback_services;
        $fallback_icons   = [ '🫀', '🩺', '🦴', '🧬', '🔬' ];
        ?>

        <div class="space-y-16">
            <?php foreach ( $services_to_show as $index => $service ) :
                $is_even  = $index % 2 === 0;
                $icon_url = $service['icon'];
            ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center <?php echo $is_even ? '' : 'md:[direction:rtl]'; ?>">
                <div class="<?php echo $is_even ? '' : 'md:[direction:ltr]'; ?>">
                    <?php if ( $icon_url ) : ?>
                        <div class="rounded-2xl overflow-hidden shadow-md mb-6 md:mb-0">
                            <img src="<?php echo esc_url( $icon_url ); ?>"
                                alt="<?php echo esc_attr( $service['title'] ); ?>"
                                class="w-full h-64 object-cover" loading="lazy">
                        </div>
                    <?php else : ?>
                        <div class="rounded-2xl bg-teal-50 h-64 flex items-center justify-center text-6xl shadow-sm">
                            <?php echo $fallback_icons[ $index ] ?? '🏥'; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="<?php echo $is_even ? '' : 'md:[direction:ltr]'; ?>">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4"><?php echo esc_html( $service['title'] ); ?></h2>
                    <p class="text-gray-600 leading-relaxed"><?php echo esc_html( $service['desc'] ); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>
