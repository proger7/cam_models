<header id="imagecontainer" class="custom-header">
    <div id="midmenu">
        <?php wp_nav_menu(array(
            'theme_location' => 'primary',
            'container' => false,
            'menu_class' => 'sdc-nav-menu'
        )); ?>
    </div>
    <div id="signupboxdesktopcontainer">
        <div id="signupboxdesktop" class="signup-container">
            <div class="mobile-header">
                <div id="join" class="menu-toggle">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/saucydates/mobilemenu-white.svg" class="mobilemenu" alt="Menu">
                </div>
            </div>
            <nav id="mobile-menu" class="mobile-nav">
                <div class="mobile-menu-header">
                    <span class="close-menu">&times;</span>
                </div>
                <?php wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'mobile-menu-list'
                )); ?>
            </nav>
            <div class="startbox">
                <div class="signup-content">
                    <h2 class="signup-title">Sign up here</h2>
                    <form method="post" action="https://saucydates.com/signup/">
                        <button type="submit" class="startbutton3">Register for free</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
