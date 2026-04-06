<?php
/**
 * ヘルパー関数
 * サイト共通で使用するユーティリティ関数
 */

/**
 * スラッグから固定ページIDを取得する
 * 「医院について」ページをマスタとして他ページから参照する際に使用する。
 *
 * @param string $slug ページスラッグ
 * @return int ページID（見つからない場合は0）
 */
function get_page_id_by_slug( string $slug ): int {
    $page = get_page_by_path( $slug );
    return $page ? (int) $page->ID : 0;
}

/**
 * 診療時間テーブルをHTMLで出力する
 * ACFの business_hours_[曜日]_[am/pm]_[start/end] フィールドを参照する。
 * am_start と pm_start が両方空の場合は「休診」と表示する。
 * ACFが未インストールの場合は何も出力しない。
 *
 * @param int|null $post_id 参照するページID（nullの場合は「診療時間・アクセス」ページを自動取得）
 * @return void
 */
function render_business_hours_table( ?int $post_id = null ): void {
    if ( ! function_exists( 'get_field' ) ) {
        return;
    }

    $days = [
        'mon' => '月',
        'tue' => '火',
        'wed' => '水',
        'thu' => '木',
        'fri' => '金',
        'sat' => '土',
        'sun' => '日・祝',
    ];

    // post_id未指定の場合は「診療時間・アクセス」ページを自動取得
    if ( $post_id === null ) {
        $post_id = get_page_id_by_slug( 'access' ) ?: null;
    }

    // フィールドが1つでも設定されているか確認
    $has_data = false;
    foreach ( array_keys( $days ) as $key ) {
        if ( get_field( "business_hours_{$key}_am_start", $post_id ) || get_field( "business_hours_{$key}_pm_start", $post_id ) ) {
            $has_data = true;
            break;
        }
    }
    if ( ! $has_data ) {
        return;
    }

    $rows = [];
    foreach ( $days as $key => $label ) {
        $am_start = (string) ( get_field( "business_hours_{$key}_am_start", $post_id ) ?: '' );
        $am_end   = (string) ( get_field( "business_hours_{$key}_am_end",   $post_id ) ?: '' );
        $pm_start = (string) ( get_field( "business_hours_{$key}_pm_start", $post_id ) ?: '' );
        $pm_end   = (string) ( get_field( "business_hours_{$key}_pm_end",   $post_id ) ?: '' );

        // 休診判定: 午前・午後ともに開始時間が空
        $is_closed = $am_start === '' && $pm_start === '';

        if ( $is_closed ) {
            $am_text = '休診';
            $pm_text = '休診';
        } else {
            $am_text = ( $am_start !== '' && $am_end !== '' ) ? "{$am_start}〜{$am_end}" : ( $am_start !== '' ? $am_start : '–' );
            $pm_text = ( $pm_start !== '' && $pm_end !== '' ) ? "{$pm_start}〜{$pm_end}" : ( $pm_start !== '' ? $pm_start : '–' );
        }

        $rows[] = [
            'label'     => $label,
            'am'        => $am_text,
            'pm'        => $pm_text,
            'is_closed' => $is_closed || $key === 'sun',
        ];
    }
    ?>
    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-sm">
            <thead>
                <tr class="bg-teal-700 text-white">
                    <th class="py-2 px-3 text-left rounded-tl-lg">曜日</th>
                    <th class="py-2 px-3 text-center">午前</th>
                    <th class="py-2 px-3 text-center rounded-tr-lg">午後</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach ( $rows as $row ) :
                    $row_class  = $row['is_closed'] ? 'bg-red-50' : 'even:bg-gray-50';
                    $text_class = $row['is_closed'] ? 'text-red-400' : 'text-gray-700';
                    ?>
                <tr class="<?php echo esc_attr( $row_class ); ?>">
                    <td class="py-2 px-3 font-medium <?php echo esc_attr( $text_class ); ?>"><?php echo esc_html( $row['label'] ); ?></td>
                    <td class="py-2 px-3 text-center <?php echo $row['is_closed'] ? 'text-red-400' : ( $row['am'] === '–' ? 'text-gray-400' : 'text-teal-700' ); ?>"><?php echo esc_html( $row['am'] ); ?></td>
                    <td class="py-2 px-3 text-center <?php echo $row['is_closed'] ? 'text-red-400' : ( $row['pm'] === '–' ? 'text-gray-400' : 'text-teal-700' ); ?>"><?php echo esc_html( $row['pm'] ); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}
