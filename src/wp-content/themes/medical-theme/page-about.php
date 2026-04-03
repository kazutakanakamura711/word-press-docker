<?php get_header(); ?>
<main>
    <!-- ページヘッダー -->
    <div class="bg-teal-700 text-white py-16">
        <div class="max-w-6xl mx-auto px-4 text-center">
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
                <!-- 院長写真 -->
                <div class="md:col-span-1">
                    <?php
                    // get_field() はACF（Advanced Custom Fields）プラグインの関数。
                    // ACFが未インストール・未有効化の場合は500エラーになるため function_exists() で確認する。
                    $director_image_url = function_exists('get_field') ? get_field('院長写真') : '';
                    $director_image_url = $director_image_url ?: '';
                    ?>
                    <?php if ( $director_image_url ): ?>
                        <img src="<?php echo esc_url( $director_image_url ); ?>" alt="院長写真" class="rounded-2xl w-full object-cover aspect-square">
                    <?php else: ?>
                        <div class="bg-gray-100 rounded-2xl aspect-square flex items-center justify-center text-gray-400 text-sm">院長写真</div>
                    <?php endif; ?>
                    <div class="mt-4 text-center">
                        <p class="font-bold text-gray-900 text-lg">院長 氏名</p>
                        <p class="text-gray-500 text-sm mt-1">専門科目</p>
                    </div>
                </div>
                <!-- 挨拶文 -->
                <div class="md:col-span-2 space-y-4 text-gray-700 leading-relaxed">
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
                    <p class="text-right font-medium text-gray-900">
                        院長 氏名
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

        <!-- クリニック概要 -->
        <section>
            <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                <span class="w-1.5 h-8 bg-teal-500 rounded-full inline-block"></span>
                クリニック概要
            </h2>
            <table class="w-full border-collapse text-sm">
                <tbody class="divide-y divide-gray-100">
                    <?php
                    $info = [
                        ['クリニック名', get_bloginfo('name')],
                        ['所在地', '〒000-0000　都道府県市区町村 番地'],
                        ['電話番号', '000-000-0000'],
                        ['診療科目', '内科・小児科・整形外科 など'],
                        ['診療時間', '月〜金 9:00〜18:00 / 土 9:00〜13:00'],
                        ['休診日', '日曜・祝日'],
                        ['最寄り駅', '○○線「○○駅」徒歩5分'],
                    ];
                    foreach ($info as [$label, $value]): ?>
                        <tr class="even:bg-gray-50">
                            <th class="text-left py-4 px-4 font-semibold text-teal-700 w-40"><?php echo esc_html(
                                $label,
                            ); ?></th>
                            <td class="py-4 px-4 text-gray-700"><?php echo esc_html($value); ?></td>
                        </tr>
                    <?php endforeach;
                    ?>
                </tbody>
            </table>
        </section>

    </div>
</main>
<?php get_footer(); ?>
