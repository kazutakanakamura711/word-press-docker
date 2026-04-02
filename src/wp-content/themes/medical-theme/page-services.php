<?php get_header(); ?>
<main>
    <!-- ページヘッダー -->
    <div class="bg-teal-700 text-white py-16">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-3">診療案内</h1>
            <p class="text-teal-200">各診療科目の詳細をご確認いただけます</p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-16">
        <?php
        $services = new WP_Query([
            'post_type'      => 'service',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ]);
        ?>

        <?php if ($services->have_posts()): ?>
            <div class="space-y-16">
                <?php
                $index = 0;
                while ($services->have_posts()):
                    $services->the_post();
                    $is_even = $index % 2 === 0;
                    $thumb_url = get_the_post_thumbnail_url(null, 'large');
                    $index++;
                ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center <?php echo $is_even ? '' : 'md:[direction:rtl]'; ?>">
                    <?php if ($thumb_url): ?>
                        <div class="rounded-2xl overflow-hidden shadow-md <?php echo $is_even ? '' : 'md:[direction:ltr]'; ?>">
                            <img src="<?php echo esc_url($thumb_url); ?>"
                                alt="<?php the_title_attribute(); ?>"
                                class="w-full h-64 object-cover"
                                loading="lazy">
                        </div>
                    <?php endif; ?>
                    <div class="<?php echo $is_even ? '' : 'md:[direction:ltr]'; ?>">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4"><?php the_title(); ?></h2>
                        <div class="text-gray-600 leading-relaxed"><?php the_content(); ?></div>
                    </div>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php else: ?>
            <p class="text-gray-500 text-center">診療案内は準備中です。</p>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>
