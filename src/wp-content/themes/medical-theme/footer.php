<footer class="bg-teal-900 text-white mt-20">
    <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <!-- クリニック情報 -->
            <div>
                <h3 class="font-bold text-lg mb-4"><?php bloginfo('name'); ?></h3>
                <p class="text-teal-200 text-sm leading-relaxed"><?php bloginfo('description'); ?></p>
            </div>

            <!-- メニュー -->
            <div>
                <h3 class="font-bold text-sm uppercase tracking-wider mb-4 text-teal-300">Menu</h3>
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer-menu',
                    'container'      => false,
                    'menu_class'     => 'space-y-2',
                    'link_class'     => 'text-teal-200 hover:text-white text-sm transition-colors',
                ]);
                ?>
            </div>

            <!-- 診療時間 -->
            <div>
                <h3 class="font-bold text-sm uppercase tracking-wider mb-4 text-teal-300">Hours</h3>
                <?php
                $footer_about_id = get_page_id_by_slug( 'about' );
                $days_short = [
                    'mon' => '月〜金', 'tue' => null, 'wed' => null, 'thu' => null, 'fri' => null,
                    'sat' => '土',
                    'sun' => '日・祝',
                ];
                $aggregated = []; // 月〜金を1行にまとめる
                if ( $footer_about_id && function_exists( 'get_field' ) ) {
                    $weekday_am = get_field( 'business_hours_mon_am_start', $footer_about_id );
                    $weekday_pm = get_field( 'business_hours_mon_pm_start', $footer_about_id );
                    $weekday_am_end = get_field( 'business_hours_mon_am_end', $footer_about_id );
                    $weekday_pm_end = get_field( 'business_hours_mon_pm_end', $footer_about_id );
                    if ( $weekday_am || $weekday_pm ) {
                        $am_str = ( $weekday_am && $weekday_am_end ) ? "{$weekday_am}〜{$weekday_am_end}" : '–';
                        $pm_str = ( $weekday_pm && $weekday_pm_end ) ? "{$weekday_pm}〜{$weekday_pm_end}" : '–';
                        $aggregated[] = [ 'day' => '月〜金', 'time' => implode( ' / ', array_filter( [ $am_str !== '–' ? $am_str : null, $pm_str !== '–' ? $pm_str : null ] ) ) ?: '–', 'closed' => false ];
                    }
                    foreach ( [ 'sat' => '土', 'sun' => '日・祝' ] as $key => $label ) {
                        $am_s = get_field( "business_hours_{$key}_am_start", $footer_about_id );
                        $am_e = get_field( "business_hours_{$key}_am_end",   $footer_about_id );
                        $pm_s = get_field( "business_hours_{$key}_pm_start", $footer_about_id );
                        $pm_e = get_field( "business_hours_{$key}_pm_end",   $footer_about_id );
                        $closed = ! $am_s && ! $pm_s;
                        if ( $closed ) {
                            $aggregated[] = [ 'day' => $label, 'time' => '休診', 'closed' => true ];
                        } else {
                            $am_str = ( $am_s && $am_e ) ? "{$am_s}〜{$am_e}" : null;
                            $pm_str = ( $pm_s && $pm_e ) ? "{$pm_s}〜{$pm_e}" : null;
                            $aggregated[] = [ 'day' => $label, 'time' => implode( ' / ', array_filter( [ $am_str, $pm_str ] ) ) ?: '–', 'closed' => false ];
                        }
                    }
                }
                if ( empty( $aggregated ) ) {
                    // フォールバック
                    $aggregated = [
                        [ 'day' => '月〜金', 'time' => '9:00 – 18:00', 'closed' => false ],
                        [ 'day' => '土',     'time' => '9:00 – 13:00', 'closed' => false ],
                        [ 'day' => '日・祝', 'time' => '休診',         'closed' => true  ],
                    ];
                }
                ?>
                <table class="text-sm text-teal-200 w-full">
                    <?php foreach ( $aggregated as $row ) : ?>
                        <tr class="<?php echo $row['closed'] ? 'text-red-300' : ''; ?>">
                            <td class="pr-4 py-0.5"><?php echo esc_html( $row['day'] ); ?></td>
                            <td><?php echo esc_html( $row['time'] ); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

        <div class="border-t border-teal-700 pt-6 text-center">
            <p class="text-teal-300 text-sm">
                &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.
            </p>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
