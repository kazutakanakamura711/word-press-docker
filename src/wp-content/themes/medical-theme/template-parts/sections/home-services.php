<?php
/**
 * Home - Services セクション
 * 「診療案内」ページのACFフィールド（service_01〜service_05）を参照する。
 * ACF未設定の場合はフォールバックデータを表示する。
 */

// 診療案内ページのACFフィールドを参照（SSOT）
$services_page_id = get_page_id_by_slug( 'services' );
$acf_services     = [];
if ( $services_page_id && function_exists( 'get_field' ) ) {
    for ( $i = 1; $i <= 6; $i++ ) {
        $num   = str_pad( $i, 2, '0', STR_PAD_LEFT );
        $title = get_field( "service_{$num}_title", $services_page_id );
        $desc  = get_field( "service_{$num}_description", $services_page_id );
        $icon  = get_field( "service_{$num}_icon", $services_page_id );
        if ( $title ) {
            $acf_services[] = [
                'title' => $title,
                'desc'  => $desc ?: '',
                'icon'  => $icon ?: '',
            ];
        }
    }
}

// フォールバックデータ（ACF未設定時）
$fallback_services = [
    [ 'icon' => '🫀', 'title' => '内科',     'desc' => '風邪・発熱・生活習慣病など、一般的な内科疾患に対応いたします。' ],
    [ 'icon' => '🩺', 'title' => '小児科',   'desc' => 'お子様の成長・発達から感染症まで、お子様の健康をサポートします。' ],
    [ 'icon' => '🦴', 'title' => '整形外科', 'desc' => '肩・腰・膝の痛みやスポーツ外傷など、運動器全般の治療を行います。' ],
    [ 'icon' => '🧬', 'title' => '皮膚科',   'desc' => 'アトピー・湿疹・蕁麻疹などの皮膚疾患を専門的に診察します。' ],
    [ 'icon' => '🔬', 'title' => '心療内科', 'desc' => 'ストレス・不眠・不安障害など、こころとからだの不調に対応します。' ],
    [ 'icon' => '🏥', 'title' => '健康診断', 'desc' => '各種健康診断・特定健診・人間ドックに対応しています。' ],
];

$services_to_show = $acf_services ?: $fallback_services;
?>
<section class="py-24 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
            <p class="text-teal-600 text-sm font-semibold tracking-widest uppercase mb-3">Services</p>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">診療案内</h2>
            <div class="w-12 h-1 bg-teal-500 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ( $services_to_show as $service ) : ?>
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                    <?php if ( ! empty( $service['icon'] ) && filter_var( $service['icon'], FILTER_VALIDATE_URL ) ) : ?>
                        <div class="w-16 h-16 rounded-xl overflow-hidden mb-5">
                            <img src="<?php echo esc_url( $service['icon'] ); ?>" alt="" class="w-full h-full object-cover">
                        </div>
                    <?php elseif ( ! empty( $service['icon'] ) ) : ?>
                        <div class="text-4xl mb-5"><?php echo $service['icon']; ?></div>
                    <?php endif; ?>
                    <h3 class="text-xl font-bold text-gray-900 mb-3"><?php echo esc_html( $service['title'] ); ?></h3>
                    <p class="text-gray-500 text-sm leading-relaxed"><?php echo esc_html( $service['desc'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-12">
            <a href="<?php echo esc_url( home_url( '/services' ) ); ?>"
                class="inline-flex items-center gap-2 bg-teal-700 hover:bg-teal-600 text-white font-semibold px-8 py-3 rounded-full transition-colors duration-200">
                診療案内をすべて見る
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</section>
