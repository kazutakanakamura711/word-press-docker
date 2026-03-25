<?php
/**
 * Template Name: Contact
 * Contactページテンプレート
 * ContactForm7導入後にフォームを追加予定
 */
get_header();
the_post();
?>
<main class="l-main">
    <?php get_template_part('template-parts/page-hero'); ?>

    <section class="p-contact">
        <div class="l-container">
            <h2 class="p-contact__heading c-section-heading">Contact</h2>
            <p class="p-contact__lead">お気軽にお問い合わせください。</p>
            <div class="p-contact__form">
                <?php
                $cf7 = get_posts([
                    'post_type' => 'wpcf7_contact_form',
                    'posts_per_page' => 1,
                    'orderby' => 'date',
                    'order' => 'ASC',
                ]);
                echo $cf7
                    ? do_shortcode('[contact-form-7 id="' . esc_attr($cf7[0]->ID) . '"]')
                    : '<p>現在フォームを準備中です。</p>';
                ?>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
