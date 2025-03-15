<header id="home_top" class="custom-header">
    <div class="container">
        <div class="row">
            <div id="woman_and_form" class="col-md-12 col-xs-12">
                <br clear="all">
                <div id="form_holder" class="col-md-5 col-xs-12 col-md-offset-6">
                    <h1>Sign up here</h1>
                    <div class="signup">
                        <a class="signup-button" href='https://www.verynaughty.co.uk/adultdating/register.php'>Register for free</a>
                    </div>
                </div>
                <br clear="all">
                <br>
            </div>
        </div>
    </div>
</header>

<div id="home_nav">
    <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed menu-toggle" data-toggle="collapse" data-target="#main-nav">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="main-nav">
                <div class="mobile-menu-header">
                    <span class="close-menu">&times;</span>
                </div>
                <?php wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'nav navbar-nav',
                )); ?>
            </div>
        </div>
    </nav>
</div>

<style>
    #home_top {
        background-image: url('<?php echo esc_url($header_bg); ?>');
        background-size: cover;
        background-position: center;
    }

    @media (max-width: 768px) {
        #home_top {
            background-image: url('<?php echo esc_url($header_bg_mobile); ?>') !important;
        }

        #woman_and_form {
            background-image: none !important;
        }
    }
</style>
