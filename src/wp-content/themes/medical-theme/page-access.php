<?php get_header(); ?>
<main>
    <!-- ページヘッダー -->
    <div class="bg-teal-700 text-white py-16">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-3">アクセス</h1>
            <p class="text-teal-200">クリニックへのアクセス方法をご確認ください</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-12">
            <!-- 基本情報 -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">クリニック情報</h2>
                <dl class="space-y-4 text-gray-700">
                    <div class="flex gap-4">
                        <dt class="w-24 font-semibold text-teal-700 flex-shrink-0">クリニック名</dt>
                        <dd><?php bloginfo('name'); ?></dd>
                    </div>
                    <div class="flex gap-4">
                        <dt class="w-24 font-semibold text-teal-700 flex-shrink-0">住所</dt>
                        <dd>〒000-0000<br>都道府県市区町村 番地</dd>
                    </div>
                    <div class="flex gap-4">
                        <dt class="w-24 font-semibold text-teal-700 flex-shrink-0">電話</dt>
                        <dd><a href="tel:000-000-0000" class="text-teal-700 hover:underline">000-000-0000</a></dd>
                    </div>
                    <div class="flex gap-4">
                        <dt class="w-24 font-semibold text-teal-700 flex-shrink-0">最寄り駅</dt>
                        <dd>○○線「○○駅」徒歩5分</dd>
                    </div>
                </dl>
            </div>

            <!-- 診療時間 -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">診療時間</h2>
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-teal-700 text-white">
                            <th class="py-2 px-3 text-left rounded-tl-lg">曜日</th>
                            <th class="py-2 px-3 text-center">午前</th>
                            <th class="py-2 px-3 text-center rounded-tr-lg">午後</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php
                        $hours = [
                            ['月', '9:00〜12:30', '14:00〜18:00'],
                            ['火', '9:00〜12:30', '14:00〜18:00'],
                            ['水', '9:00〜12:30', '–'],
                            ['木', '9:00〜12:30', '14:00〜18:00'],
                            ['金', '9:00〜12:30', '14:00〜18:00'],
                            ['土', '9:00〜13:00', '–'],
                        ];
                        foreach ($hours as [$day, $am, $pm]): ?>
                        <tr class="even:bg-gray-50">
                            <td class="py-2 px-3 font-medium text-gray-700"><?php echo esc_html(
                                $day,
                            ); ?></td>
                            <td class="py-2 px-3 text-center text-teal-700"><?php echo esc_html(
                                $am,
                            ); ?></td>
                            <td class="py-2 px-3 text-center <?php echo $pm === '–'
                                ? 'text-gray-400'
                                : 'text-teal-700'; ?>"><?php echo esc_html($pm); ?></td>
                        </tr>
                        <?php endforeach;
                        ?>
                        <tr class="bg-red-50">
                            <td class="py-2 px-3 font-medium text-red-400">日・祝</td>
                            <td class="py-2 px-3 text-center text-red-400">休診</td>
                            <td class="py-2 px-3 text-center text-red-400">休診</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Googleマップ -->
        <div class="rounded-2xl overflow-hidden shadow-md h-80">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6481.676873291861!2d139.76447671177976!3d35.68097997247305!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188bfbee1467bb%3A0x410f8b6e7e3ee34f!2z5p2x5Lqs6aeF!5e0!3m2!1sja!2sjp!4v1775094122653!5m2!1sja!2sjp"
                width="100%"
                height="100%"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
        </div>
    </div>
</main>
<?php get_footer(); ?>
