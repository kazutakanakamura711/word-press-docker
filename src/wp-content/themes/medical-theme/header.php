<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-white text-gray-800 font-sans'); ?>>

<header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-sm">
    <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
        <!-- ロゴ -->
        <div class="shrink-0">
            <a href="<?php echo home_url(); ?>" class="flex items-center gap-2 text-teal-700 font-bold text-xl no-underline">
                <span class="text-2xl">🏥</span>
                <span><?php bloginfo('name'); ?></span>
            </a>
        </div>

        <!-- PC ナビ -->
        <nav class="hidden md:flex items-center gap-6">
            <?php wp_nav_menu([
                'theme_location' => 'header-menu',
                'container' => false,
                'items_wrap' => '%3$s',
                'walker' => new Medical_Nav_Walker(),
            ]); ?>
        </nav>

        <!-- ハンバーガーボタン（スマホ） -->
        <button
            id="js-hamburger"
            class="md:hidden flex flex-col justify-center items-center w-10 h-10 gap-1.5 cursor-pointer"
            aria-label="メニューを開く"
            aria-expanded="false"
        >
            <span class="block w-6 h-0.5 bg-teal-700 transition-all duration-300 js-hamburger-line"></span>
            <span class="block w-6 h-0.5 bg-teal-700 transition-all duration-300 js-hamburger-line"></span>
            <span class="block w-6 h-0.5 bg-teal-700 transition-all duration-300 js-hamburger-line"></span>
        </button>
    </div>
</header>

<!-- スマホ用ドロワーメニュー -->
<div id="js-drawer" class="fixed inset-0 z-40 pointer-events-none">
    <!-- オーバーレイ -->
    <div id="js-overlay" class="absolute inset-0 bg-black/50 opacity-0 transition-opacity duration-300"></div>
    <!-- メニューパネル -->
    <nav id="js-drawer-panel" class="absolute top-0 right-0 h-full w-72 bg-white shadow-xl translate-x-full transition-transform duration-300 flex flex-col pt-20 px-6">
        <button id="js-drawer-close" class="absolute top-4 right-4 text-gray-500 text-3xl leading-none" aria-label="メニューを閉じる">&times;</button>
        <?php wp_nav_menu([
            'theme_location' => 'header-menu',
            'container' => false,
            'menu_class' => 'flex flex-col gap-4',
            'link_class' =>
                'block text-gray-700 hover:text-teal-700 text-lg py-2 border-b border-gray-100',
        ]); ?>
    </nav>
</div>

<!-- ヘッダー分のスペーサー -->
<div class="h-16"></div>

<!-- ナビメニュー用カスタムウォーカー（PC用） -->
<?php class Medical_Nav_Walker extends Walker_Nav_Menu
{
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0): void
    {
        $url = $item->url;
        $title = $item->title;
        $is_active = in_array('current-menu-item', (array) $item->classes, true);
        $classes = 'nav-link' . ($is_active ? ' nav-link--active' : '');
        $output .=
            '<a href="' .
            esc_url($url) .
            '" class="' .
            $classes .
            '">' .
            esc_html($title) .
            '</a>';
    }
}
