<?php
function mytheme_customize_register( $wp_customize ) {

    // セクション追加
    $wp_customize->add_section( 'mytheme_hero', [
        'title'    => 'ヒーローエリア',
        'priority' => 30,
    ]);

    // 設定を登録
    $wp_customize->add_setting( 'hero_image', [
        'default'           => '',
        'sanitize_callback' => 'absint',
    ]);

    // コントロール（画像アップローダー）を追加
    $wp_customize->add_control( new WP_Customize_Media_Control(
        $wp_customize,
        'hero_image',
        [
            'label'     => 'ヒーロー画像',
            'section'   => 'mytheme_hero',
            'mime_type' => 'image',
        ]
    ));
}
add_action( 'customize_register', 'mytheme_customize_register' );