<?php
// ACF フィールドグループをコードで登録
// 管理画面の ACF → フィールドグループ に自動表示されます

add_action('acf/init', function() {

    // スキルカテゴリの定義（key => ラベル）
    $skill_categories = array(
        'skill_lang'      => '言語',
        'skill_fw'        => 'FW・ライブラリ',
        'skill_ui'        => 'UI',
        'skill_api'       => 'API',
        'skill_orm'       => 'ORM',
        'skill_cms'       => 'CMS',
        'skill_task'      => 'タスク管理',
        'skill_comm'      => 'コミュニケーション',
        'skill_ai'        => 'AIツール',
        'skill_other'     => 'その他',
    );

    $fields = array();
    foreach ($skill_categories as $key => $label) {
        $fields[] = array(
            'key'          => 'field_' . $key,
            'label'        => $label,
            'name'         => $key,
            'type'         => 'text',
            'instructions' => 'カンマ区切りで入力（例: React, Vue, Next.js）',
        );
    }

    // ─────────────────────────────────────
    // Profile ページ用フィールド
    // ─────────────────────────────────────
    acf_add_local_field_group(array(
        'key'    => 'group_profile',
        'title'  => 'Profile フィールド',
        'fields' => $fields,
        'location' => array(
            array(
                array(
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'page-profile.php',
                ),
            ),
        ),
    ));

    // ─────────────────────────────────────
    // Application カスタム投稿タイプ用フィールド
    // ─────────────────────────────────────
    acf_add_local_field_group(array(
        'key'    => 'group_application',
        'title'  => 'Application フィールド',
        'fields' => array(
            array(
                'key'          => 'field_app_technologies',
                'label'        => '使用技術',
                'name'         => 'technologies',
                'type'         => 'text',
                'instructions' => 'カンマ分割りで入力（例: React, TypeScript, Node.js）',
            ),
            array(
                'key'          => 'field_app_app_url',
                'label'        => 'アプリ URL',
                'name'         => 'app_url',
                'type'         => 'url',
            ),
            array(
                'key'          => 'field_app_github_url',
                'label'        => 'GitHub URL',
                'name'         => 'github_url',
                'type'         => 'url',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'application',
                ),
            ),
        ),
    ));

});
