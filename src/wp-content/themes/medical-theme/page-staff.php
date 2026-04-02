<?php get_header(); ?>
<main>
    <!-- ページヘッダー -->
    <div class="bg-teal-700 text-white py-16">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-3">スタッフ紹介</h1>
            <p class="text-teal-200">私たちのチームをご紹介します</p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-16">
        <?php $staff_posts = new WP_Query([
            'post_type' => 'staff',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
        ]); ?>

        <?php if ($staff_posts->have_posts()): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                while ($staff_posts->have_posts()):
                    $staff_posts->the_post(); ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                        <!-- 写真 -->
                        <div class="aspect-square bg-gray-100 overflow-hidden">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('medium', [
                                    'class' => 'w-full h-full object-cover',
                                ]); ?>
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-gray-300 text-5xl">👤</div>
                            <?php endif; ?>
                        </div>
                        <!-- 情報 -->
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-1"><?php the_title(); ?></h2>
                            <?php
                            $position = get_the_content() ?: get_post_meta(get_the_ID(), 'staff_position', true);
                            if ($position): ?>
                                <p class="text-teal-600 text-sm font-medium mb-3"><?php echo esc_html(strip_tags($position)); ?></p>
                            <?php endif;
                            ?>
                            <?php if (get_the_excerpt()): ?>
                                <p class="text-gray-500 text-sm leading-relaxed"><?php the_excerpt(); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>

        <?php else: ?>
            <!-- フォールバック（スタッフ未登録時のプレースホルダー） -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                $placeholders = [
                    ['name' => '氏名', 'position' => '院長・内科医'],
                    ['name' => '氏名', 'position' => '副院長・小児科医'],
                    ['name' => '氏名', 'position' => '看護師長'],
                    ['name' => '氏名', 'position' => '看護師'],
                    ['name' => '氏名', 'position' => '医療事務'],
                    ['name' => '氏名', 'position' => '医療事務'],
                ];
                foreach ($placeholders as $member): ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="aspect-square bg-gray-100 flex items-center justify-center text-gray-300 text-6xl">👤</div>
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-1"><?php echo esc_html(
                                $member['name'],
                            ); ?></h2>
                            <p class="text-teal-600 text-sm font-medium"><?php echo esc_html(
                                $member['position'],
                            ); ?></p>
                        </div>
                    </div>
                <?php endforeach;
                ?>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>
