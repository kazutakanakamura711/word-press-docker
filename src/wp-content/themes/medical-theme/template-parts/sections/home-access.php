<?php
/**
 * Home - Access セクション
 * 「診療時間・アクセス」ページのACFをSSOTとして参照する。
 * 診療時間は render_business_hours_table() で出力する。
 */

$access_id = get_page_id_by_slug('access');
$address =
    $access_id && function_exists('get_field') ? get_field('clinic_address', $access_id) : '';
$phone = $access_id && function_exists('get_field') ? get_field('clinic_phone', $access_id) : '';
$station =
    $access_id && function_exists('get_field')
        ? get_field('clinic_nearest_station', $access_id)
        : '';

// 診療時間の出力をバッファに取得し、ACFデータ有無を判定する
ob_start();
render_business_hours_table($access_id);
$hours_output = ob_get_clean();
?>
<section class="py-24 bg-teal-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
            <p class="text-teal-600 text-sm font-semibold tracking-widest uppercase mb-3">Access</p>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">アクセス</h2>
            <div class="w-12 h-1 bg-teal-500 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- 診療時間 -->
            <div class="bg-white rounded-2xl p-8 shadow-sm">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="text-teal-600">🕐</span> 診療時間
                </h3>
                <?php if ($hours_output): ?>
                    <?php echo $hours_output; ?>
                <?php else: ?>
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b-2 border-teal-100">
                                <th class="text-left py-2 text-gray-500 font-medium">曜日</th>
                                <th class="text-center py-2 text-gray-500 font-medium">午前</th>
                                <th class="text-center py-2 text-gray-500 font-medium">午後</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <tr class="text-gray-700">
                                <td class="py-3 font-medium">月〜金</td>
                                <td class="py-3 text-center">9:00〜12:30</td>
                                <td class="py-3 text-center">14:00〜18:00</td>
                            </tr>
                            <tr class="text-gray-700">
                                <td class="py-3 font-medium">土</td>
                                <td class="py-3 text-center">9:00〜13:00</td>
                                <td class="py-3 text-center text-gray-300">–</td>
                            </tr>
                            <tr class="text-red-400">
                                <td class="py-3 font-medium">日・祝</td>
                                <td class="py-3 text-center">休診</td>
                                <td class="py-3 text-center">休診</td>
                            </tr>
                        </tbody>
                    </table>
                <?php endif; ?>
                <p class="text-gray-400 text-xs mt-4">※受付は診療終了30分前まで</p>
            </div>

            <!-- 所在地情報 -->
            <div class="bg-white rounded-2xl p-8 shadow-sm">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="text-teal-600">📍</span> 所在地
                </h3>
                <dl class="space-y-5 text-sm">
                    <div>
                        <dt class="font-semibold text-teal-700 mb-1">クリニック名</dt>
                        <dd class="text-gray-700"><?php bloginfo('name'); ?></dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-teal-700 mb-1">住所</dt>
                        <dd class="text-gray-700"><?php echo nl2br(
                            esc_html($address ?: '〒000-0000　都道府県市区町村 番地'),
                        ); ?></dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-teal-700 mb-1">電話番号</dt>
                        <dd>
                            <?php $tel = $phone ?: '000-000-0000'; ?>
                            <a href="tel:<?php echo esc_attr(
                                $tel,
                            ); ?>" class="text-teal-700 hover:underline font-medium"><?php echo esc_html(
                                $tel,
                            ); ?></a>
                        </dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-teal-700 mb-1">アクセス</dt>
                        <dd class="text-gray-700"><?php echo esc_html(
                            $station ?: '○○線「○○駅」徒歩5分',
                        ); ?></dd>
                    </div>
                </dl>
                <div class="mt-8">
                    <a href="<?php echo esc_url(home_url('/access')); ?>"
                       class="inline-flex items-center gap-2 text-teal-700 hover:text-teal-900 border border-teal-700 hover:border-teal-900 font-medium px-5 py-2 rounded-full text-sm transition-colors">
                        詳しいアクセス・地図を見る
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
