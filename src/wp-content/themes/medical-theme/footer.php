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
                $footer_access_id = get_page_id_by_slug( 'access' );
                $footer_days = [
                    'mon' => '月', 'tue' => '火', 'wed' => '水', 'thu' => '木',
                    'fri' => '金', 'sat' => '土', 'sun' => '日・祝',
                ];
                $footer_rows = [];
                if ( $footer_access_id && function_exists( 'get_field' ) ) {
                    foreach ( $footer_days as $key => $label ) {
                        $am_s = get_field( "business_hours_{$key}_am_start", $footer_access_id );
                        $am_e = get_field( "business_hours_{$key}_am_end",   $footer_access_id );
                        $pm_s = get_field( "business_hours_{$key}_pm_start", $footer_access_id );
                        $pm_e = get_field( "business_hours_{$key}_pm_end",   $footer_access_id );
                        $closed = ! $am_s && ! $pm_s;
                        if ( $closed ) {
                            $time_str = '休診';
                        } else {
                            $parts = [];
                            if ( $am_s && $am_e ) $parts[] = "{$am_s}〜{$am_e}";
                            if ( $pm_s && $pm_e ) $parts[] = "{$pm_s}〜{$pm_e}";
                            $time_str = implode( ' / ', $parts ) ?: '–';
                        }
                        $footer_rows[] = [ 'day' => $label, 'time' => $time_str, 'closed' => $closed ];
                    }
                }
                if ( empty( $footer_rows ) ) {
                    $footer_rows = [
                        [ 'day' => '月', 'time' => '9:00〜12:30 / 14:00〜18:00', 'closed' => false ],
                        [ 'day' => '火', 'time' => '9:00〜12:30 / 14:00〜18:00', 'closed' => false ],
                        [ 'day' => '水', 'time' => '9:00〜12:30 / 14:00〜18:00', 'closed' => false ],
                        [ 'day' => '木', 'time' => '9:00〜12:30 / 14:00〜18:00', 'closed' => false ],
                        [ 'day' => '金', 'time' => '9:00〜12:30 / 14:00〜18:00', 'closed' => false ],
                        [ 'day' => '土', 'time' => '9:00〜13:00',               'closed' => false ],
                        [ 'day' => '日・祝', 'time' => '休診',                  'closed' => true  ],
                    ];
                }
                ?>
                <table class="text-sm w-full">
                    <?php foreach ( $footer_rows as $row ) : ?>
                        <tr class="border-b border-teal-800">
                            <td class="py-1 pr-3 font-medium w-12 <?php echo $row['closed'] ? 'text-red-300' : 'text-teal-300'; ?>"><?php echo esc_html( $row['day'] ); ?></td>
                            <td class="py-1 <?php echo $row['closed'] ? 'text-red-300' : 'text-teal-200'; ?>"><?php echo esc_html( $row['time'] ); ?></td>
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
