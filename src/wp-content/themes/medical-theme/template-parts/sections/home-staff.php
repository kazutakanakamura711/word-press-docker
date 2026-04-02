<?php
/**
 * Home - Staff セクション
 * スタッフ紹介（staff カスタム投稿タイプ or フォールバック）
 */
$staff_posts = new WP_Query([
    'post_type' => 'staff',
    'posts_per_page' => 4,
    'orderby' => 'menu_order',
    'order' => 'ASC',
]);

$fallback_staff = [
    ['name' => '氏名', 'position' => '院長・内科医'],
    ['name' => '氏名', 'position' => '副院長・小児科医'],
    ['name' => '氏名', 'position' => '看護師長'],
    ['name' => '氏名', 'position' => '医療事務'],
];
?>
<section class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
            <p class="text-teal-600 text-sm font-semibold tracking-widest uppercase mb-3">Staff</p>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">スタッフ紹介</h2>
            <div class="w-12 h-1 bg-teal-500 mx-auto rounded-full"></div>
        </div>

        <?php if ($staff_posts->have_posts()): ?>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <?php
                while ($staff_posts->have_posts()):
                    $staff_posts->the_post(); ?>
                    <div class="text-center">
                        <div class="aspect-square rounded-2xl bg-gray-100 overflow-hidden mb-4">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('medium', [
                                    'class' => 'w-full h-full object-cover',
                                ]); ?>
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-gray-300 text-4xl">👤</div>
                            <?php endif; ?>
                        </div>
                        <h3 class="font-bold text-gray-900"><?php the_title(); ?></h3>
                        <?php
                        $position = get_post_meta(get_the_ID(), 'staff_position', true);
                        if ($position): ?>
                            <p class="text-teal-600 text-sm mt-1"><?php echo esc_html(
                                $position,
                            ); ?></p>
                        <?php endif;
                        ?>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <?php foreach ($fallback_staff as $member): ?>
                    <div class="text-center">
                        <div class="aspect-square rounded-2xl bg-gray-100 flex items-center justify-center text-gray-300 text-4xl mb-4">👤</div>
                        <h3 class="font-bold text-gray-900"><?php echo esc_html(
                            $member['name'],
                        ); ?></h3>
                        <p class="text-teal-600 text-sm mt-1"><?php echo esc_html(
                            $member['position'],
                        ); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="text-center mt-12">
            <a href="<?php echo esc_url(home_url('/staff')); ?>"
               class="inline-flex items-center gap-2 border border-teal-700 text-teal-700 hover:bg-teal-700 hover:text-white font-semibold px-8 py-3 rounded-full transition-colors duration-200">
                スタッフ一覧を見る
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</section>
