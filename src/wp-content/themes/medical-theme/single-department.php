<?php get_header(); ?>
<main>
    <?php if (have_posts()):
        while (have_posts()):
            the_post(); ?>

        <!-- ページヘッダー -->
        <?php
        $header_img_url = '';
        if (function_exists('get_field')) {
            // 診療案内ページをスラッグで取得して、現在の診療科に紐づくサービス画像を探す
            $services_page_obj = get_page_by_path('services');
            $services_page_id = $services_page_obj ? $services_page_obj->ID : null;
            if ($services_page_id) {
                $current_dept_id = get_the_ID();
                for ($i = 1; $i <= 16; $i++) {
                    $num = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $linked_dept = get_field("service_{$num}_department", $services_page_id);
                    $linked_dept_id = is_object($linked_dept)
                        ? $linked_dept->ID
                        : (int) $linked_dept;
                    if ($linked_dept_id === $current_dept_id) {
                        $header_img_url =
                            get_field("service_{$num}_image", $services_page_id) ?: '';
                        break;
                    }
                }
            }
        }
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
                <h1 class="text-4xl font-bold"><?php the_title(); ?></h1>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 py-16 flex flex-col gap-20">

        <!-- アイキャッチ -->
        <?php if (has_post_thumbnail()): ?>
            <div class="mb-12 rounded-2xl overflow-hidden">
                <?php the_post_thumbnail('large', ['class' => 'w-full h-64 object-cover']); ?>
            </div>
        <?php endif; ?>

        <div class="flex flex-col gap-16">

            <!-- 取扱い疾患 -->
            <?php
            $diseases_raw = function_exists('get_field') ? get_field('diseases') : '';
            $diseases = $diseases_raw
                ? array_filter(array_map('trim', explode("\n", $diseases_raw)))
                : [];
            ?>
            <?php if ($diseases): ?>
                <section>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                        <span class="w-1.5 h-6 bg-teal-500 rounded-full inline-block"></span>
                        取扱い疾患
                    </h2>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <?php foreach ($diseases as $item): ?>
                            <li class="flex items-center gap-3 bg-teal-50 rounded-lg px-4 py-3 text-gray-700">
                                <span class="shrink-0 w-5 h-5 bg-teal-100 text-teal-600 rounded-full flex items-center justify-center text-xs font-bold">✓</span>
                                <?php echo esc_html($item); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <!-- こんな症状はお早目に受診を -->
            <?php
            $visit_soon_raw = function_exists('get_field') ? get_field('visit_soon') : '';
            $visit_soon_items = $visit_soon_raw
                ? array_filter(array_map('trim', explode("\n", $visit_soon_raw)))
                : [];
            ?>
            <?php if ($visit_soon_items): ?>
                <section>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                        <span class="w-1.5 h-6 bg-teal-500 rounded-full inline-block"></span>
                        こんな症状はお早目に受診を
                    </h2>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <?php foreach ($visit_soon_items as $item): ?>
                            <li class="flex items-center gap-3 bg-teal-50 rounded-lg px-4 py-3 text-gray-700">
                                <span class="shrink-0 w-5 h-5 bg-teal-100 text-teal-600 rounded-full flex items-center justify-center text-xs font-bold">✓</span>
                                <?php echo esc_html($item); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <!-- 検査・治療について -->
            <?php $examination = function_exists('get_field') ? get_field('examination') : ''; ?>
            <?php if ($examination): ?>
                <section>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                        <span class="w-1.5 h-6 bg-teal-500 rounded-full inline-block"></span>
                        検査・治療について
                    </h2>
                    <p class="text-gray-700 leading-relaxed"><?php echo nl2br(
                        esc_html($examination),
                    ); ?></p>
                </section>
            <?php endif; ?>

            <!-- 診療設備 -->
            <?php
            $equipment_images = [];
            if (function_exists('get_field')) {
                for ($i = 1; $i <= 6; $i++) {
                    $n = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $img = get_field("equipment_image_{$n}");
                    if ($img) {
                        $equipment_images[] = $img;
                    }
                }
            }
            ?>
            <?php if ($equipment_images): ?>
                <section>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                        <span class="w-1.5 h-6 bg-teal-500 rounded-full inline-block"></span>
                        診療設備
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php foreach ($equipment_images as $img): ?>
                            <div class="rounded-xl overflow-hidden shadow-sm">
                                <img src="<?php echo esc_url($img['url']); ?>"
                                    alt="<?php echo esc_attr($img['alt']); ?>"
                                    class="w-full h-56 object-cover" loading="lazy">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

        </div>

        <!-- 一覧へ戻る -->
        <div>
            <a href="<?php echo esc_url(home_url('/services/')); ?>"
                class="inline-flex items-center gap-2 text-teal-700 hover:text-teal-900 font-medium transition-colors">
                &larr; 診療案内に戻る
            </a>
        </div>

        </div><!-- /.max-w-4xl -->

    <?php
        endwhile;
    endif; ?>
</main>
<?php get_footer(); ?>
