<?php get_header(); ?>
<main class="max-w-3xl mx-auto px-4 py-16">
    <?php if (have_posts()): while (have_posts()): the_post(); ?>
        <article>
            <!-- ヘッダー -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-4">
                    <span class="bg-teal-100 text-teal-700 text-xs font-medium px-3 py-1 rounded-full">
                        <?php echo esc_html(get_post_type_object(get_post_type())->label); ?>
                    </span>
                    <time class="text-gray-400 text-sm" datetime="<?php echo get_the_date('Y-m-d'); ?>">
                        <?php echo get_the_date('Y年m月d日'); ?>
                    </time>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 leading-tight"><?php the_title(); ?></h1>
            </div>

            <!-- アイキャッチ -->
            <?php if (has_post_thumbnail()): ?>
                <div class="mb-8 rounded-xl overflow-hidden">
                    <?php the_post_thumbnail('large', ['class' => 'w-full h-auto object-cover']); ?>
                </div>
            <?php endif; ?>

            <!-- 本文 -->
            <div class="text-gray-700 leading-relaxed space-y-4">
                <?php the_content(); ?>
            </div>
        </article>

        <!-- 一覧へ戻る -->
        <div class="mt-12">
            <a href="<?php echo get_post_type_archive_link(get_post_type()); ?>"
               class="inline-flex items-center gap-2 text-teal-700 hover:text-teal-900 font-medium transition-colors">
                &larr; 一覧に戻る
            </a>
        </div>
    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>
