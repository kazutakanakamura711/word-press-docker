<?php
// 管理バーを非表示
add_filter('show_admin_bar', '__return_false');

// テーマの基本設定
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'my-theme-style',
        get_template_directory_uri() . '/assets/css/style.css',
        array(),
        wp_get_theme()->get('Version')
    );

    // テーマJS
    wp_enqueue_script(
        'my-theme-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );

    // Swiper（カルーセル用）
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), null, true);
});

// 抜粋の省略記号を [...] から ... に変更
add_filter('excerpt_more', function() {
    return '...';
});

// アイキャッチ画像の有効化
add_theme_support('post-thumbnails');

// メニューの登録
add_theme_support('menus');
register_nav_menus(array(
    'header-menu' => 'ヘッダーメニュー',
    'footer-menu' => 'フッターメニュー',
));