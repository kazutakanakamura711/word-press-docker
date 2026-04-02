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
                <table class="text-sm text-teal-200 w-full">
                    <tr><td class="pr-4 py-0.5">月〜金</td><td>9:00 – 18:00</td></tr>
                    <tr><td class="pr-4 py-0.5">土</td><td>9:00 – 13:00</td></tr>
                    <tr><td class="pr-4 py-0.5 text-red-300">日・祝</td><td class="text-red-300">休診</td></tr>
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
