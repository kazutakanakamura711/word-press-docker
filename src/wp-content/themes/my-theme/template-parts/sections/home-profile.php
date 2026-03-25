<?php
/**
 * Home - Profile セクション
 * プロフィール画像（1:1正方形）+ 名前 + 肩書き を中央表示
 */
?>
<section class="p-home-profile">
    <div class="p-home-profile__inner l-container">
        <h2 class="p-home-profile__heading c-section-heading">Profile</h2>
        <div class="p-home-profile__avatar">
            <img
                src="<?php echo esc_url(
                    get_template_directory_uri() . '/assets/images/img-profile.webp',
                ); ?>"
                alt="KAZUTAKA NAKAMURA"
                loading="lazy"
            >
        </div>
        <p class="p-home-profile__name">KAZUTAKA NAKAMURA</p>
        <p class="p-home-profile__title">フロントエンドエンジニア</p>
    </div>
</section>
