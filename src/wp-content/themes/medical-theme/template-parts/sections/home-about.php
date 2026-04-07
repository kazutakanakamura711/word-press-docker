<?php
/**
 * Home - About セクション
 * クリニックの理念・概要
 */
?>
<section class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <!-- 画像 -->
            <div class="relative">
                <div class="bg-teal-50 rounded-2xl overflow-hidden aspect-square">
                    <?php $about_img_url = function_exists('get_field')
                        ? get_field('about_section_image')
                        : ''; ?>
                    <?php if ($about_img_url): ?>
                        <img
                            src="<?php echo esc_url($about_img_url); ?>"
                            alt="クリニックについて"
                            class="w-full h-full object-cover"
                            loading="lazy"
                        >
                    <?php else: ?>
                        <div class="bg-gray-100 rounded-2xl aspect-square flex items-center justify-center text-gray-400 text-sm">クリニック写真</div>
                    <?php endif; ?>
                </div>
                <!-- アクセント -->
                <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-teal-100 rounded-2xl -z-10"></div>
            </div>

            <!-- テキスト -->
            <div>
                <p class="text-teal-600 text-sm font-semibold tracking-widest uppercase mb-3">About Us</p>
                <h2 class="text-4xl font-bold text-gray-900 mb-6 leading-tight">
                    クリニックに<br>ついて
                </h2>
                <div class="w-12 h-1 bg-teal-500 mb-8 rounded-full"></div>
                <p class="text-gray-600 leading-relaxed mb-6">
                    私たちのクリニックは、地域の皆様が安心して通える「かかりつけ医」として、
                    予防から治療まで幅広くサポートいたします。
                </p>
                <p class="text-gray-600 leading-relaxed mb-8">
                    患者様一人ひとりのお話に耳を傾け、丁寧な診察と分かりやすい説明を心がけています。
                    どうぞお気軽にご相談ください。
                </p>

                <!-- 特徴リスト -->
                <ul class="space-y-3">
                    <?php
                    $features = [
                        '経験豊富な専門医が在籍',
                        '最新の医療設備を完備',
                        '予約優先制で待ち時間を軽減',
                        '土曜日も診療対応（午前のみ）',
                    ];
foreach ($features as $feature): ?>
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="shrink-0 w-5 h-5 bg-teal-100 text-teal-600 rounded-full flex items-center justify-center text-xs font-bold">✓</span>
                            <?php echo esc_html($feature); ?>
                        </li>
                    <?php endforeach;
?>
                </ul>
            </div>
        </div>
    </div>
</section>
