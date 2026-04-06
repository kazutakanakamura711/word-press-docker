<?php
/**
 * Home - Services セクション
 * 「診療案内」ページのACFフィールド（service_01〜service_16）を参照する（SSOT）。
 * ACF未設定の場合はフォールバックデータを表示する。
 */

$services_page_id = get_page_id_by_slug( 'services' );
$services_to_show = [];

if ( $services_page_id && function_exists( 'get_field' ) ) {
    for ( $i = 1; $i <= 16; $i++ ) {
        $num   = str_pad( $i, 2, '0', STR_PAD_LEFT );
        $title = get_field( "service_{$num}_title", $services_page_id );
        if ( $title ) {
            $services_to_show[] = $title;
        }
    }
}

// フォールバックデータ（ACF未設定時）
if ( empty( $services_to_show ) ) {
    $services_to_show = [ '内科', '小児科', '整形外科', '皮膚科', '心療内科', '健康診断' ];
}
?>
<section class="py-24 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
            <p class="text-teal-600 text-sm font-semibold tracking-widest uppercase mb-3">Services</p>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">診療案内</h2>
            <div class="w-12 h-1 bg-teal-500 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php foreach ( $services_to_show as $title ) : ?>
                <div class="bg-white rounded-xl py-5 px-6 text-center shadow-sm border border-gray-100 hover:border-teal-300 hover:shadow-md transition-all">
                    <p class="font-semibold text-gray-800"><?php echo esc_html( $title ); ?></p>
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
