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
            <h1 class="text-4xl font-bold mb-3">医院について</h1>
            <p class="text-teal-200">院長挨拶・クリニックの理念</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-16 space-y-20">

        <!-- 院長挨拶 -->
        <section>
            <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                <span class="w-1.5 h-8 bg-teal-500 rounded-full inline-block"></span>
                院長挨拶
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 items-start">
                <!-- 院長画像 -->
                <div class="md:col-span-1">
                    <?php
                    $director_image_url = function_exists( 'get_field' ) ? get_field( '院長画像' ) : '';
                    $director_image_url = $director_image_url ?: '';
                    ?>
                    <?php if ( $director_image_url ): ?>
                        <img src="<?php echo esc_url( $director_image_url ); ?>" alt="院長画像" class="rounded-2xl w-full object-cover aspect-square">
                    <?php else: ?>
                        <div class="bg-gray-100 rounded-2xl aspect-square flex items-center justify-center text-gray-400 text-sm">院長画像</div>
                    <?php endif; ?>
                    <div class="mt-4 text-center">
                        <?php $director_name = function_exists( 'get_field' ) ? get_field( 'director_name' ) : ''; ?>
                        <p class="font-bold text-gray-900 text-lg"><?php echo esc_html( $director_name ?: '院長 氏名' ); ?></p>
                    </div>
                </div>
                <!-- 挨拶文 -->
                <div class="md:col-span-2 space-y-4 text-gray-700 leading-relaxed">
                    <?php
                    $director_message = function_exists( 'get_field' ) ? get_field( 'director_message' ) : '';
                    if ( $director_message ) :
                        echo wpautop( esc_html( $director_message ) );
                    else: ?>
                    <p>
                        このたびは当クリニックのホームページをご覧いただき、誠にありがとうございます。
                    </p>
                    <p>
                        私たちのクリニックは、地域の皆様の「かかりつけ医」として、
                        お一人おひとりが安心して受診できる環境づくりを大切にしております。
                    </p>
                    <p>
                        患者様のお話にじっくりと耳を傾け、最善の医療を提供できるよう
                        スタッフ一同、日々努力してまいります。
                        どうぞお気軽にご相談ください。
                    </p>
                    <?php endif; ?>
                    <p class="text-right font-medium text-gray-900">
                        <?php echo esc_html( $director_name ?: '院長 氏名' ); ?>
                    </p>
                </div>
            </div>
        </section>

        <!-- クリニックの理念 -->
        <section>
            <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                <span class="w-1.5 h-8 bg-teal-500 rounded-full inline-block"></span>
                クリニックの理念
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php
                $philosophies = [
                    [
                        'num' => '01',
                        'title' => '患者様中心の医療',
                        'desc' =>
                            '患者様一人ひとりの状況や気持ちに寄り添い、最適な医療を提供します。',
                    ],
                    [
                        'num' => '02',
                        'title' => '予防と健康増進',
                        'desc' =>
                            '病気の早期発見・早期治療だけでなく、予防医学にも力を入れています。',
                    ],
                    [
                        'num' => '03',
                        'title' => '地域医療への貢献',
                        'desc' =>
                            '地域の皆様が健康で豊かな生活を送れるよう、地域医療の充実に努めます。',
                    ],
                ];
                foreach ($philosophies as $p): ?>
                    <div class="bg-teal-50 rounded-2xl p-8">
                        <p class="text-teal-400 font-bold text-3xl mb-3"><?php echo esc_html(
                            $p['num'],
                        ); ?></p>
                        <h3 class="text-lg font-bold text-gray-900 mb-3"><?php echo esc_html(
                            $p['title'],
                        ); ?></h3>
                        <p class="text-gray-600 text-sm leading-relaxed"><?php echo esc_html(
                            $p['desc'],
                        ); ?></p>
                    </div>
                <?php endforeach;
                ?>
            </div>
        </section>

        <!-- 診療時間 -->
        <section>
            <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                <span class="w-1.5 h-8 bg-teal-500 rounded-full inline-block"></span>
                診療時間
            </h2>
            <?php render_business_hours_table(); ?>
        </section>

        <!-- クリニック概要 -->
        <section>
            <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                <span class="w-1.5 h-8 bg-teal-500 rounded-full inline-block"></span>
                クリニック概要
            </h2>
            <table class="w-full border-collapse text-sm">
                <tbody class="divide-y divide-gray-100">
                    <?php
                    $clinic_src_id = get_page_id_by_slug( 'access' );
                    $address = ( $clinic_src_id && function_exists( 'get_field' ) ) ? get_field( 'clinic_address', $clinic_src_id ) : '';
                    $phone   = ( $clinic_src_id && function_exists( 'get_field' ) ) ? get_field( 'clinic_phone', $clinic_src_id ) : '';
                    $station = ( $clinic_src_id && function_exists( 'get_field' ) ) ? get_field( 'clinic_nearest_station', $clinic_src_id ) : '';
                    $info    = [
                        [ 'クリニック名', get_bloginfo( 'name' ) ],
                        [ '所在地',       $address ?: '〒000-0000　都道府県市区町村 番地' ],
                        [ '電話番号',     $phone   ?: '000-000-0000' ],
                        [ '最寄り駅',     $station ?: '○○線「○○駅」徒歩5分' ],
                    ];
                    foreach ( $info as [ $label, $value ] ): ?>
                        <tr class="even:bg-gray-50">
                            <th class="text-left py-4 px-4 font-semibold text-teal-700 w-40"><?php echo esc_html( $label ); ?></th>
                            <td class="py-4 px-4 text-gray-700"><?php echo esc_html( $value ); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

    </div>
</main>
<?php get_footer(); ?>
