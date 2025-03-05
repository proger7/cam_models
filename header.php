<?php
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="custom-header">
    <div class="header-container">
        <div class="logo-container">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php endif; ?>
        </div>
        <div class="cta-container">
            <a href="#signup" class="cta-button">Join Now</a>
        </div>
    </div>
</header>
<nav class="custom-nav">
    <div class="menu-container">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'container' => false,
            'menu_class' => 'custom-menu'
        ));
        ?>
    </div>
</nav>
<?php wp_footer(); ?>
</body>
</html>