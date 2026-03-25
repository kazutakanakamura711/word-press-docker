<?php
// カスタム投稿タイプの登録
add_action('init', function() {

    // Applications（自作アプリ紹介）
    register_post_type('application', array(
        'label'         => 'Applications',
        'public'        => true,
        'has_archive'   => true,
        'supports'      => array('title', 'editor', 'thumbnail'),
        'menu_icon'     => 'dashicons-screenoptions',
        'rewrite'       => array('slug' => 'application'),
        'show_in_rest'  => true,
    ));

    // Gallery（ギャラリー画像）
    register_post_type('gallery_item', array(
        'label'         => 'Gallery',
        'public'        => true,
        'has_archive'   => true,
        'supports'      => array('title', 'thumbnail'),
        'menu_icon'     => 'dashicons-format-gallery',
        'rewrite'       => array('slug' => 'gallery-item'),
        'show_in_rest'  => true,
    ));

});