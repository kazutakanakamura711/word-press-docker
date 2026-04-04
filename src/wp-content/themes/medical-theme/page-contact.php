<?php
/**
 * Template Name: Contact
 */
get_header(); ?>
<main>
    <!-- ページヘッダー -->
    <?php $header_img_url = function_exists( 'get_field' ) ? get_field( 'page_header_image' ) : ''; ?>
    <div class="relative bg-teal-700 text-white py-16<?php echo $header_img_url ? ' bg-blend-overlay bg-cover bg-center' : ''; ?>"
        <?php if ( $header_img_url ): ?>style="background-image: url('<?php echo esc_url( $header_img_url ); ?>')"<?php endif; ?>>
        <?php if ( $header_img_url ): ?>
            <div class="absolute inset-0 bg-teal-900/60"></div>
        <?php endif; ?>
        <div class="relative z-10 max-w-6xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-3">お問い合わせ</h1>
            <p class="text-teal-200">ご予約・ご質問はこちらからお気軽にどうぞ</p>
        </div>
    </div>

    <div class="max-w-2xl mx-auto px-4 py-16">
        <?php if (have_posts()):
            while (have_posts()):
                the_post(); ?>
            <div class="text-gray-700 leading-relaxed mb-10"><?php the_content(); ?></div>
        <?php
            endwhile;
        endif; ?>

        <?php
        $cf7 = get_posts([
            'post_type' => 'wpcf7_contact_form',
            'posts_per_page' => 1,
            'title' => '医療クリニック お問い合わせ',
        ]);
        echo $cf7
            ? do_shortcode('[contact-form-7 id="' . esc_attr($cf7[0]->ID) . '"]')
            : '<p class="text-gray-600">現在フォームを準備中です。</p>';
        ?>
    </div>
</main>
<?php get_footer(); ?>
