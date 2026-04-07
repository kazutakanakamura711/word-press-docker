<?php

// 管理バーを非表示
add_filter('show_admin_bar', '__return_false');

// テーマの基本設定
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'medical-theme-style',
        get_template_directory_uri() . '/assets/css/style.css',
        [],
        wp_get_theme()->get('Version'),
    );

    wp_enqueue_script(
        'medical-theme-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        wp_get_theme()->get('Version'),
        true,
    );
});

// アイキャッチ画像の有効化
add_theme_support('post-thumbnails');

// タイトルタグを自動出力
add_theme_support('title-tag');

// 抜粋の省略記号を変更
add_filter('excerpt_more', function () {
    return '...';
});

// メニューの登録
add_theme_support('menus');
register_nav_menus([
    'header-menu' => 'ヘッダーメニュー',
    'footer-menu' => 'フッターメニュー',
]);
