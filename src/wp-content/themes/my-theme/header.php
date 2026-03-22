<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="l-header">
    <div class="l-header__inner">
        <div class="l-header__logo">
            <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
        </div>
        <nav class="l-header__nav">
            <?php wp_nav_menu(array(
                'theme_location' => 'header-menu',
                'menu_class'     => 'l-header__nav-list',
                'link_class'     => 'l-header__nav-link',
            )); ?>
        </nav>
    </div>
</header>