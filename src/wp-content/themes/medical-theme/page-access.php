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
            <h1 class="text-4xl font-bold mb-3">アクセス</h1>
            <p class="text-teal-200">クリニックへのアクセス方法をご確認ください</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-16">
        <?php
        // 「診療時間・アクセス」ページをSSOTとして基本情報・診療時間を参照する
        $access_id = get_page_id_by_slug('access');
        $address =
            $access_id && function_exists('get_field')
                ? get_field('clinic_address', $access_id)
                : '';
        $phone =
            $access_id && function_exists('get_field') ? get_field('clinic_phone', $access_id) : '';
        $station =
            $access_id && function_exists('get_field')
                ? get_field('clinic_nearest_station', $access_id)
                : '';
        ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-12">
            <!-- 基本情報 -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">クリニック情報</h2>
                <dl class="space-y-4 text-gray-700">
                    <div class="flex gap-4">
                        <dt class="w-24 font-semibold text-teal-700 shrink-0">クリニック名</dt>
                        <dd><?php bloginfo('name'); ?></dd>
                    </div>
                    <div class="flex gap-4">
                        <dt class="w-24 font-semibold text-teal-700 shrink-0">住所</dt>
                        <dd><?php echo esc_html(
                            $address ?: '〒000-0000 都道府県市区町村 番地',
                        ); ?></dd>
                    </div>
                    <div class="flex gap-4">
                        <dt class="w-24 font-semibold text-teal-700 shrink-0">電話</dt>
                        <dd>
                            <?php $phone_display = $phone ?: '000-000-0000'; ?>
                            <a href="tel:<?php echo esc_attr(
                                preg_replace('/[^0-9]/', '', $phone_display),
                            ); ?>" class="text-teal-700 hover:underline"><?php echo esc_html(
    $phone_display,
); ?>
                            </a>
                        </dd>
                    </div>
                    <div class="flex gap-4">
                        <dt class="w-24 font-semibold text-teal-700 shrink-0">最寄り駅</dt>
                        <dd><?php echo esc_html($station ?: '○○線「○○駅」徒歩5分'); ?></dd>
                    </div>
                </dl>
            </div>

            <!-- 診療時間 -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">診療時間</h2>
                <?php render_business_hours_table($access_id ?: null); ?>
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
