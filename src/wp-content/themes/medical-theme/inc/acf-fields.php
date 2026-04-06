<?php
/**
 * ACF フィールドグループの登録
 * ACF（Advanced Custom Fields）プラグインが有効な場合のみ実行。
 *
 * 設計方針（SSOT）:
 *   - クリニック基本情報・診療時間は「医院について」ページをマスタとして登録する。
 *   - アクセスページ等は get_field($name, $about_id) で参照する。
 *   - 各フィールドグループは関連ページにのみ表示されるよう location を最適化。
 *     トップ: ヒーロー/セクション画像のみ
 *     医院について: 院長情報・クリニック基本情報・診療時間
 *     診療案内: 診療科目
 */
if ( ! function_exists( 'acf_add_local_field_group' ) ) {
    return;
}

// ─────────────────────────────────────────────
// カスタムロケーションルール: page_slug（ページスラッグ判定）
// ACF標準にはスラッグ指定がないため独自ルールを追加
// ─────────────────────────────────────────────
add_filter( 'acf/location/rule_types', function ( $choices ) {
    $choices['Page']['page_slug'] = 'ページスラッグ';
    return $choices;
} );

add_filter( 'acf/location/rule_values/page_slug', function ( $choices ) {
    $pages = get_pages( [ 'post_status' => 'any' ] );
    foreach ( $pages as $page ) {
        $choices[ $page->post_name ] = $page->post_title . ' (' . $page->post_name . ')';
    }
    return $choices;
} );

add_filter( 'acf/location/rule_match/page_slug', function ( $match, $rule, $options ) {
    $post_id = isset( $options['post_id'] ) ? (int) $options['post_id'] : 0;
    if ( ! $post_id ) {
        return false;
    }
    $post = get_post( $post_id );
    if ( ! $post ) {
        return false;
    }
    $slug_matches = ( $post->post_name === $rule['value'] );
    return $rule['operator'] === '==' ? $slug_matches : ! $slug_matches;
}, 10, 3 );

// ─────────────────────────────────────────────
// 1. ページ共通設定（全ページ）
//    ページヘッダー背景画像
// ─────────────────────────────────────────────
acf_add_local_field_group( [
    'key'    => 'group_page_settings',
    'title'  => 'ページ設定',
    'fields' => [
        [
            'key'           => 'field_page_header_image',
            'label'         => 'ページヘッダー背景画像',
            'name'          => 'page_header_image',
            'type'          => 'image',
            'return_format' => 'url',
            'preview_size'  => 'medium',
            'instructions'  => '設定しない場合はデフォルトの背景色で表示されます。',
        ],
    ],
    'location' => [
        [
            [ 'param' => 'post_type', 'operator' => '==', 'value' => 'page' ],
            [ 'param' => 'page_type', 'operator' => '!=', 'value' => 'front_page' ],
        ],
    ],
    'menu_order' => 0,
    'position'   => 'normal',
] );

// ─────────────────────────────────────────────
// 2. トップページ設定（フロントページのみ）
//    ヒーロー背景画像 / クリニックについてセクション画像
// ─────────────────────────────────────────────
acf_add_local_field_group( [
    'key'    => 'group_front_page',
    'title'  => 'トップページ設定',
    'fields' => [
        [
            'key'           => 'field_hero_background_image',
            'label'         => 'ヒーロー背景画像',
            'name'          => 'hero_background_image',
            'type'          => 'image',
            'return_format' => 'url',
            'preview_size'  => 'medium',
            'instructions'  => '設定しない場合は背景色のみで表示されます。',
        ],
        [
            'key'           => 'field_about_section_image',
            'label'         => 'クリニックについて セクション画像',
            'name'          => 'about_section_image',
            'type'          => 'image',
            'return_format' => 'url',
            'preview_size'  => 'medium',
            'instructions'  => '設定しない場合はプレースホルダーが表示されます。',
        ],
    ],
    'location' => [
        [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ],
    ],
    'menu_order' => 0,
    'position'   => 'normal',
] );

// ─────────────────────────────────────────────
// 3. 院長情報（「医院について」ページのみ）
//    院長画像・氏名・専門科目・挨拶文
// ─────────────────────────────────────────────
acf_add_local_field_group( [
    'key'    => 'group_director',
    'title'  => '院長情報（医院についてページ用）',
    'fields' => [
        [
            'key'           => 'field_director_image',
            'label'         => '院長画像',
            'name'          => '院長画像',
            'type'          => 'image',
            'return_format' => 'url',
            'preview_size'  => 'medium',
        ],
        [
            'key'          => 'field_director_name',
            'label'        => '院長氏名',
            'name'         => 'director_name',
            'type'         => 'text',
            'placeholder'  => '例：山田 太郎',
        ],
        [
            'key'         => 'field_director_specialty',
            'label'       => '専門科目',
            'name'        => 'director_specialty',
            'type'        => 'text',
            'placeholder' => '例：内科・小児科',
        ],
        [
            'key'          => 'field_director_message',
            'label'        => '院長挨拶文',
            'name'         => 'director_message',
            'type'         => 'textarea',
            'rows'         => 6,
            'instructions' => '改行は自動的に<br>に変換されます。',
        ],
    ],
    'location' => [
        [ [ 'param' => 'page_slug', 'operator' => '==', 'value' => 'about' ] ],
    ],
    'menu_order' => 10,
    'position'   => 'normal',
] );

// ─────────────────────────────────────────────
// 4. クリニック基本情報（「医院について」ページをSSOT）
//    住所・電話・最寄り駅 — アクセスページ等は get_field($name, $about_id) で参照
// ─────────────────────────────────────────────
acf_add_local_field_group( [
    'key'    => 'group_clinic_info',
    'title'  => 'クリニック基本情報（医院についてページのみ入力）',
    'fields' => [
        [
            'key'         => 'field_clinic_address',
            'label'       => '住所',
            'name'        => 'clinic_address',
            'type'        => 'text',
            'placeholder' => '例：〒000-0000 都道府県市区町村番地',
        ],
        [
            'key'         => 'field_clinic_phone',
            'label'       => '電話番号',
            'name'        => 'clinic_phone',
            'type'        => 'text',
            'placeholder' => '例：000-000-0000',
        ],
        [
            'key'         => 'field_clinic_nearest_station',
            'label'       => '最寄り駅',
            'name'        => 'clinic_nearest_station',
            'type'        => 'text',
            'placeholder' => '例：○○線「○○駅」徒歩5分',
        ],
    ],
    'location' => [
        [ [ 'param' => 'page_slug', 'operator' => '==', 'value' => 'about' ] ],
    ],
    'menu_order' => 20,
    'position'   => 'normal',
] );

// ─────────────────────────────────────────────
// 5. 診療時間（「医院について」ページをSSOT）
//    フィールド名規則: business_hours_[曜日]_[am|pm]_[start|end]
//    曜日: mon / tue / wed / thu / fri / sat / sun
//    開始時間を入力した場合は終了時間も必須（acf/validate_save_post で検証）
// ─────────────────────────────────────────────
$days_hours = [
    'mon' => '月曜日',
    'tue' => '火曜日',
    'wed' => '水曜日',
    'thu' => '木曜日',
    'fri' => '金曜日',
    'sat' => '土曜日',
    'sun' => '日曜日・祝日',
];

$hours_fields = [];
foreach ( $days_hours as $key => $label ) {
    $hours_fields[] = [
        'key'          => "field_bh_{$key}_tab",
        'label'        => $label,
        'name'         => '',
        'type'         => 'tab',
        'placement'    => 'top',
    ];
    foreach ( [ 'am' => '午前', 'pm' => '午後' ] as $period => $period_label ) {
        $hours_fields[] = [
            'key'          => "field_bh_{$key}_{$period}_start",
            'label'        => "{$period_label} 開始",
            'name'         => "business_hours_{$key}_{$period}_start",
            'type'         => 'time_picker',
            'display_format' => 'H:i',
            'return_format'  => 'H:i',
            'instructions' => '休診の場合は空欄のままにしてください。',
        ];
        $hours_fields[] = [
            'key'          => "field_bh_{$key}_{$period}_end",
            'label'        => "{$period_label} 終了",
            'name'         => "business_hours_{$key}_{$period}_end",
            'type'         => 'time_picker',
            'display_format' => 'H:i',
            'return_format'  => 'H:i',
            'instructions' => '開始時間を入力した場合は必須です。',
        ];
    }
}

acf_add_local_field_group( [
    'key'    => 'group_business_hours',
    'title'  => '診療時間（医院についてページのみ入力）',
    'fields' => $hours_fields,
    'location' => [
        [ [ 'param' => 'page_slug', 'operator' => '==', 'value' => 'about' ] ],
    ],
    'menu_order' => 30,
    'position'   => 'normal',
] );

// ─────────────────────────────────────────────
// 6. 診療案内（「診療案内」ページ用）
//    5つの診療科目を ACF フィールドで管理
//    トップページと page-services.php の両方で参照する
// ─────────────────────────────────────────────
$service_fields = [];
for ( $i = 1; $i <= 16; $i++ ) {
    $num = str_pad( $i, 2, '0', STR_PAD_LEFT );
    $service_fields[] = [
        'key'   => "field_svc_{$num}_tab",
        'label' => "診療科目 {$num}",
        'name'  => '',
        'type'  => 'tab',
        'placement' => 'top',
    ];
    $service_fields[] = [
        'key'         => "field_svc_{$num}_title",
        'label'       => 'タイトル',
        'name'        => "service_{$num}_title",
        'type'        => 'text',
        'placeholder' => '例：内科',
    ];
    $service_fields[] = [
        'key'         => "field_svc_{$num}_description",
        'label'       => '説明',
        'name'        => "service_{$num}_description",
        'type'        => 'textarea',
        'rows'        => 3,
        'placeholder' => '例：風邪・発熱・生活習慣病など',
    ];
    $service_fields[] = [
        'key'           => "field_svc_{$num}_image",
        'label'         => '画像',
        'name'          => "service_{$num}_image",
        'type'          => 'image',
        'return_format' => 'url',
        'preview_size'  => 'medium',
        'instructions'  => '未設定の場合はプレースホルダーが表示されます。',
    ];
}

acf_add_local_field_group( [
    'key'    => 'group_services',
    'title'  => '診療案内（診療案内ページのみ入力）',
    'fields' => $service_fields,
    'location' => [
        [ [ 'param' => 'page_slug', 'operator' => '==', 'value' => 'services' ] ],
    ],
    'menu_order' => 40,
    'position'   => 'normal',
] );

// ─────────────────────────────────────────────
// バリデーション: 診療時間の開始〜終了ペア検証
//   開始時間を入力した場合は終了時間も必須
// ─────────────────────────────────────────────
add_action( 'acf/validate_save_post', function () {
    $acf_data = isset( $_POST['acf'] ) ? $_POST['acf'] : []; // phpcs:ignore WordPress.Security.NonceVerification
    $days    = [ 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun' ];
    $periods = [ 'am', 'pm' ];

    foreach ( $days as $day ) {
        foreach ( $periods as $period ) {
            $start_key = "field_bh_{$day}_{$period}_start";
            $end_key   = "field_bh_{$day}_{$period}_end";
            $start     = isset( $acf_data[ $start_key ] ) ? trim( $acf_data[ $start_key ] ) : '';
            $end       = isset( $acf_data[ $end_key ] )   ? trim( $acf_data[ $end_key ] )   : '';

            if ( $start !== '' && $end === '' ) {
                $day_labels   = [ 'mon' => '月', 'tue' => '火', 'wed' => '水', 'thu' => '木', 'fri' => '金', 'sat' => '土', 'sun' => '日' ];
                $period_label = $period === 'am' ? '午前' : '午後';
                acf_add_validation_error(
                    $end_key,
                    "{$day_labels[$day]}曜日 {$period_label}の終了時間は必須です（開始時間が入力されています）。"
                );
            }
        }
    }
} );
