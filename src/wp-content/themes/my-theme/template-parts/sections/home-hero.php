<?php
/**
 * Home - Hero セクション
 * ヒーロー画像 + プロフィール画像（小）+ 名前
 * ヒーロー画像: assets/images/hero.jpg（固定）
 * プロフィール画像: assets/images/profile.jpg（固定）
 */
$hero_img_url = get_template_directory_uri() . '/assets/images/img-top-hero.webp';
$site_name    = get_bloginfo('name');

// プロフィール画像: assets/images/profile.jpg（固定）
// プロフィールアイコン（小）: Profileページのアイキャッチ画像（管理画面から変更可能）
$profile_page    = get_page_by_path('profile');
$profile_img_url = $profile_page ? get_the_post_thumbnail_url($profile_page->ID, 'medium') : '';
$profile_img_url = $profile_img_url ?: get_template_directory_uri() . '/assets/images/img-profile.webp';
?>

<section class="p-home-hero" <?php if ($hero_img_url) : ?>style="background-image: url('<?php echo esc_url($hero_img_url); ?>');"<?php endif; ?>>
    <div class="p-home-hero__inner l-container">
        <div class="p-home-hero__profile">
            <div class="p-home-hero__avatar">
                <img src="<?php echo esc_url($profile_img_url); ?>" alt="<?php echo esc_attr($site_name); ?>" loading="lazy">
            </div>
            <div class="p-home-hero__text">
                <h1 class="p-home-hero__name"><?php echo esc_html($site_name); ?></h1>
                <p class="p-home-hero__tagline"><?php bloginfo('description'); ?></p>
            </div>
        </div>
    </div>
</section>
