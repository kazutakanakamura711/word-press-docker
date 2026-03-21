<?php
// スタイルの読み込み
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'my-theme-style',
        get_stylesheet_uri()
    );
});

// ナビゲーションメニューの登録
add_theme_support('menus');
register_nav_menus(array(
    'header-menu' => 'ヘッダーメニュー',
    'footer-menu' => 'フッターメニュー',
));

// アイキャッチ画像の有効化
add_theme_support('post-thumbnails');

// カスタム投稿タイプの登録
add_action('init', function() {
    register_post_type('doctor', array(
        'label'         => '医師紹介',
        'public'        => true,
        'has_archive'   => true,
        'supports'      => array('title', 'editor', 'thumbnail'),
        'menu_icon'     => 'dashicons-businessperson',
        'rewrite'       => array('slug' => 'doctor'),
    ));
});