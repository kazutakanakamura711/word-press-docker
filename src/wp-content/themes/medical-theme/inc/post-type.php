<?php

// カスタム投稿タイプの登録
add_action('init', function () {
    // News（お知らせ）
    register_post_type('news', [
        'label' => 'お知らせ',
        'public' => true,
        'has_archive' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'menu_icon' => 'dashicons-megaphone',
        'rewrite' => ['slug' => 'news'],
        'show_in_rest' => true,
    ]);

    // Service（診療科目）
    // page-services.php の診療案内と home-services.php のフォールバックで利用
    register_post_type('service', [
        'label' => '診療案内',
        'public' => true,
        'has_archive' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'menu_icon' => 'dashicons-heart',
        'rewrite' => ['slug' => 'service'],
        'show_in_rest' => true,
    ]);
});
