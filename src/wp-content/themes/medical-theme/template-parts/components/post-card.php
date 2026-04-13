<?php
/**
 * 投稿カードコンポーネント
 *
 * get_template_part( 'template-parts/components/post-card', null, $args ) で呼び出す。
 * ループ内で the_post() 済みのグローバル $post を使用する。
 *
 * $args:
 *   heading_tag  string  見出しタグ名（デフォルト: 'h2'）
 *   placeholder  string  サムネイルなし時の代替テキスト（デフォルト: 'お知らせ'）
 */

$heading_tag = $args['heading_tag'] ?? 'h2';
$placeholder = $args['placeholder'] ?? 'お知らせ';
?>
<article class="relative bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
    <a href="<?php the_permalink(); ?>" class="absolute inset-0 z-10" aria-label="<?php the_title_attribute(); ?>"></a>
    <?php if (has_post_thumbnail()): ?>
        <div class="block overflow-hidden">
            <?php the_post_thumbnail('medium', [
                'class' =>
                    'w-full h-48 object-cover hover:scale-105 transition-transform duration-300',
            ]); ?>
        </div>
    <?php else: ?>
        <div class="w-full h-48 bg-teal-50 flex items-center justify-center text-teal-400 text-2xl font-medium">
            <?php echo esc_html($placeholder); ?>
        </div>
    <?php endif; ?>
    <div class="p-5">
        <time class="text-gray-400 text-xs" datetime="<?php echo get_the_date('Y-m-d'); ?>">
            <?php echo get_the_date('Y年m月d日'); ?>
        </time>
        <<?php echo esc_attr(
            $heading_tag,
        ); ?> class="font-bold text-gray-900 mt-1 mb-2 line-clamp-2">
            <?php the_title(); ?>
        </<?php echo esc_attr($heading_tag); ?>>
        <p class="text-gray-500 text-sm line-clamp-3"><?php the_excerpt(); ?></p>
    </div>
</article>
