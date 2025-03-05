<header class="verynaughty-header">
    <div class="verynaughty-header-container">
        <div class="verynaughty-logo-container">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php endif; ?>
        </div>
        <div class="verynaughty-cta-container">
            <a href="#signup" class="verynaughty-cta-button">Join Now</a>
        </div>
    </div>
</header>
<nav class="verynaughty-nav">
    <div class="verynaughty-menu-container">
        <?php wp_nav_menu(array(
            'theme_location' => 'primary',
            'container' => false,
            'menu_class' => 'verynaughty-menu'
        )); ?>
    </div>
</nav>
