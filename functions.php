<?php

function enqueue_custom_jquery_for_cam_template() {
    if (is_page_template('page-cam-template.php')) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js', array(), null, true);
        wp_enqueue_script('jquery');
        wp_enqueue_script('cams-api', 'https://softwareapi.org/api/cams.php', array('jquery'), null, true);
        wp_enqueue_style('cam-template-styles', 'https://softwareapi.org/api/default.css');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_jquery_for_cam_template');

function add_cam_tag_meta_box() {
    add_meta_box('cam_tag_box', 'Cam Tag', 'render_cam_tag_meta_box', 'page', 'side', 'default');
}

function render_cam_tag_meta_box($post) {
    $value = get_post_meta($post->ID, 'cam_tag', true);
    echo '<label for="cam_tag">Tag:</label>';
    echo '<input type="text" id="cam_tag" name="cam_tag" value="' . esc_attr($value) . '" style="width:100%;">';
}

function save_cam_tag_meta_box($post_id) {
    if (isset($_POST['cam_tag'])) {
        update_post_meta($post_id, 'cam_tag', sanitize_text_field($_POST['cam_tag']));
    }
}

add_action('add_meta_boxes', 'add_cam_tag_meta_box');
add_action('save_post', 'save_cam_tag_meta_box');


function custom_popup_shortcode() {
    ob_start();
    ?>
    <div id="__nuxt">
        <div>
            <div data-v-1de1fe54="" class="wrapper">
                <div data-v-1de1fe54="" class="card">
                    <div data-v-1de1fe54="" class="header">
                        <div data-v-1de1fe54="" class="logo"></div>
                        <div data-v-1de1fe54="" class="close">
                            <div data-v-1de1fe54="" class="cross"></div>
                        </div>
                    </div>
                    <div data-v-c746ae59="" data-v-1de1fe54="" class="headline headline-wrapper">
                        <div data-v-c746ae59="" class="title">Best Worldwide</div>
                        <div data-v-c746ae59="" class="subtitle">Hookup Site!</div>
                        <div data-v-c746ae59="" class="flag">🌎</div>
                    </div>
                    <div data-v-1de1fe54="" class="emoji"></div>
                    <div data-v-1de1fe54="" class="description">
                        <p>Try <strong>Ashley Madison</strong> today!🔥</p>
                    </div>
                    <div data-v-1de1fe54="" class="photos"></div>
                    <a href="/redirect" target="_blank" data-v-1de1fe54="" class="btn_pink center">Find Match</a>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_popup', 'custom_popup_shortcode');

function custom_popup_styles() {
    wp_enqueue_style('custom-popup-style', get_stylesheet_directory_uri() . '/snipped.css');
}
add_action('wp_enqueue_scripts', 'custom_popup_styles');


function custom_popup_scripts() {
    wp_enqueue_script('custom-popup-script', get_stylesheet_directory_uri() . '/js/popup.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'custom_popup_scripts');



class Tags_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'tags_widget',
            'Tags Widget',
            array('description' => 'A widget to display a list of tags')
        );
    }

    public function widget($args, $instance) {
        $tags = ["anal", "bdsm", "asian", "big ass", "blond", "african", "asmr"];
        echo $args['before_widget'];
        ?>
        <div class="tags-sidebar">
            <div class="tags-list" id="tagsList">
                <?php foreach ($tags as $tag): ?>
                    <a class="tag" href="#" data-tag="<?php echo esc_attr($tag); ?>"><?php echo esc_html($tag); ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {}

    public function update($new_instance, $old_instance) {
        return $new_instance;
    }
}

function register_tags_widget() {
    register_widget('Tags_Widget');
}
add_action('widgets_init', 'register_tags_widget');

function enqueue_custom_scripts_for_cam_template() {
    if (is_page_template('page-cam-template.php')) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js', array(), null, true);
        wp_enqueue_script('jquery');

        wp_enqueue_script(
            'cams-api',
            'https://softwareapi.org/api/cams.php',
            array('jquery'),
            null,
            true
        );

        wp_enqueue_script(
            'custom-cam-template-script',
            get_stylesheet_directory_uri() . '/js/cam-template.js',
            array('jquery'),
            null,
            true
        );

        wp_localize_script('custom-cam-template-script', 'camApiConfig', array(
            'divTarget' => 'camContent',
        ));
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts_for_cam_template');

function tags_widget_enqueue_scripts() {
    wp_enqueue_script(
        'tags-widget-script',
        get_stylesheet_directory_uri() . '/js/tags-widget.js',
        array('jquery'),
        null,
        true
    );

    wp_localize_script('tags-widget-script', 'tagsWidgetAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));

    wp_enqueue_style(
        'tags-widget-style',
        get_stylesheet_directory_uri() . '/css/tags-widget.css',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'tags_widget_enqueue_scripts');

function tags_widget_fetch_data() {
    if (isset($_POST['q'])) {
        $tag = sanitize_text_field($_POST['q']);
        $data = fetch_cams_data_by_tag($tag);

        if (!empty($data)) {
            wp_send_json_success($data);
        } else {
            wp_send_json_error('No data found for the provided tag.');
        }
    } else {
        wp_send_json_error('Tag not provided.');
    }
}
add_action('wp_ajax_tags_widget_fetch_data', 'tags_widget_fetch_data');
add_action('wp_ajax_nopriv_tags_widget_fetch_data', 'tags_widget_fetch_data');

function fetch_cams_data_by_tag($tag) {
    $api_url = 'https://softwareapi.org/api/cams.php';
    $response = wp_remote_get(add_query_arg(array('q' => $tag), $api_url));

    if (is_wp_error($response)) {
        return false;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['error']) && $data['error'] === false && isset($data['data'])) {
        return $data['data'];
    }

    return false;
}

/* Profile shortcode */
function profile_card_shortcode($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'username' => '',
            'name' => '',
            'postcount' => '',
            'photoscount' => '',
            'videoscount' => '',
            'joindate' => '',
            'location' => '',
            'subprice' => '',
            'layout' => 'default',
        ),
        $atts,
        'profile_card'
    );

    $bio = $content ? wp_kses_post(str_replace(array("\n", "\r"), '', $content)) : '';
    $price = strtolower(trim($atts['subprice'])) === 'free' ? 'free' : '$' . esc_html($atts['subprice']);
    $username = esc_attr($atts['username']);
    $name = esc_html($atts['name']);

    ob_start();

    enqueue_profile_card_css($atts['layout']);
    enqueue_fontawesome();
    
    if ($atts['layout'] === 'horizontal') {
        ?>
        <div class="profile-card profile-card-horizontal">
            <img src="https://profile-grabber.b-cdn.net/profiles/<?php echo $username; ?>-avatar.jpg" alt="Profile Image">
            <div class="content">
                <h2><?php echo $name; ?></h2>
                <p class="username">@<?php echo $username; ?></p>
                <p><?php echo esc_html($atts['postcount']); ?> posts, <?php echo esc_html($atts['videoscount']); ?> videos, <?php echo esc_html($atts['photoscount']); ?> photos.</p>
                <p>Join Date: <?php echo esc_html($atts['joindate']); ?></p>
                <a href="https://onlyfans.com/<?php echo $username; ?>" class="button">Open OnlyFans</a>
            </div>
        </div>
        <?php
    } elseif ($atts['layout'] === 'tile1') {
        ?>

        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-0 snipcss0-1-1-4">
            <div class="col p-0 snipcss0-2-4-5" itemtype="https://schema.org/WPAdBlock">
                <a href="https://onlyfans.com/<?php echo esc_attr($username); ?>" class="text-decoration-none model-card-link snipcss0-3-5-6" target="_blank" rel="sponsored nofollow noreferrer noopener">
                    <div class="card h-100 shadow-sm hover-effect snipcss0-4-6-7 style-AdCkM" id="style-AdCkM">
                        <div class="snipcss0-5-7-8 style-iZFqQ" id="style-iZFqQ">
                            <img src="https://profile-grabber.b-cdn.net/profiles/<?php echo esc_attr($username); ?>-avatar.jpg" alt="<?php echo esc_attr($name); ?>" loading="lazy" class="snipcss0-6-8-9 style-klXDW" id="style-klXDW">
                            <div class="snipcss0-6-8-10 style-ldvMU" id="style-ldvMU">
                                <div class="snipcss0-7-10-11 style-UQIrp" id="style-UQIrp">
                                    <div class="snipcss0-8-11-12 style-nqdTO" id="style-nqdTO">
                                        <div class="snipcss0-9-12-13 style-XkFDK" id="style-XkFDK">
                                            <span class="card-title mb-0 d-block snipcss0-10-13-14 style-vtVWq" itemprop="name" id="style-vtVWq"> <?php echo esc_html($name); ?> </span>
                                            <div class="d-flex align-items-center mt-0 snipcss0-10-13-15 style-ljJqJ" id="style-ljJqJ">
                                                <span class="text-white-50 me-2 snipcss0-11-15-16 style-Xtohi" id="style-Xtohi">@<?php echo esc_html($username); ?></span>
                                            </div>
                                        </div>
                                        <div class="snipcss0-9-12-17 style-zgFtb" id="style-zgFtb">
                                            <span class="badge bg-light text-dark snipcss0-10-17-18"><?php echo !empty($price) ? esc_html($price) : 'Ad'; ?></span>
                                            <div class="mt-0 snipcss0-10-17-19 style-JA2kD" id="style-JA2kD">
                                                <span class="text-white-50 snipcss0-11-19-20">
                                                    <i class="fas fa-heart me-1 snipcss0-12-20-21"></i><?php echo number_format(rand(1000, 50000)); ?> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="snipcss0-7-10-22 style-XjQrH" id="style-XjQrH">
                                    <div class="mt-2 description-container snipcss0-8-22-23">
                                        <p class="card-text small text-white mb-0 description-text snipcss0-9-23-24" itemprop="text">
                                            <span class="description-short snipcss0-10-24-25"><?php echo esc_html(wp_trim_words($bio, 12, '...')); ?></span>
                                            <span class="description-full snipcss0-10-24-26 style-GlXSA" id="style-GlXSA"> <?php echo esc_html(wp_trim_words($bio, 20, '...')); ?> </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <?php
    } elseif ($atts['layout'] === 'tile2') {
        ?>
        <div class="row">
            <div class="col-md-4">
                <div class="creator-card-v3 ctad">
                    <div class="creator-picture">
                        <a class="creator-picture-link" href="<?php echo $profile_url; ?>" target="_blank">
                            <img alt="<?php echo $name; ?> OnlyFans picture" class="creator-img" src="https://profile-grabber.b-cdn.net/profiles/<?php echo esc_attr($username); ?>-avatar.jpg">
                        </a>
                    </div>
                    <a class="creator-info" href="<?php echo $profile_url; ?>" target="_blank">
                        <h5 class="creator-breadcrumbs">
                            <div class="text-black mr-1">Ad</div>
                            <span class="creator-username">@<?php echo $username; ?> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="verified-icon">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg></span>
                        </h5>
                        <h5 class="creator-name"> <?php echo $name; ?> </h5>
                    </a>
                    <div class="creator-bio"> <?php echo esc_html(wp_trim_words($bio, 20, '...')); ?> </div>
                    <div class="creator-stats">
                        <?php if (!empty($atts['subprice'])) : ?>
                            <div class="creator-stat">
                                <span class="stat-key">
                                    <svg class="icon icon--heroicon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path clip-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" fill-rule="evenodd"></path>
                                    </svg>
                                </span>
                                <b><a class="creator-free-trial" href="#" target="_blank">CLAIM FREE TRIAL</a></b>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($atts['postcount'])) : ?>
                            <div class="creator-stat">
                                <span class="stat-key">
                                    <svg class="icon icon--heroicon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path clip-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" fill-rule="evenodd"></path>
                                    </svg>
                                </span>
                                <b><?php echo esc_html($atts['postcount']); ?> posts</b>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($atts['videoscount'])) : ?>
                            <div class="creator-stat">
                                <span class="stat-key">
                                    <svg class="icon icon--heroicon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
                                    </svg>
                                </span>
                                <b><?php echo esc_html($atts['videoscount']); ?> videos</b>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($atts['photoscount'])) : ?>
                            <div class="creator-stat">
                                <span class="stat-key">
                                    <svg class="icon icon--heroicon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                    </svg>
                                </span>
                                <b><?php echo esc_html($atts['photoscount']); ?> photos</b>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
    } else {
        ?>
        <div class="profile-card">
            <div class="ribbon"><?php echo $price; ?></div>
            <img src="https://profile-grabber.b-cdn.net/profiles/<?php echo $username; ?>-avatar.jpg?width=475&height=400" alt="Profile Image">
            <div class="content">
                <h2><?php echo $name; ?></h2>
                <p class="username">@<?php echo $username; ?></p>
                <p><?php echo esc_html($atts['postcount']); ?> posts, <?php echo esc_html($atts['videoscount']); ?> videos, <?php echo esc_html($atts['photoscount']); ?> photos.</p>
                <p>Join Date: <?php echo esc_html($atts['joindate']); ?></p>
                <p class="bio-<?php echo esc_attr($atts['username']); ?>"><?php echo wp_trim_words($bio, 20, '...'); ?> <span id="more-button" class="show-more-<?php echo esc_attr($atts['username']); ?>">Read Bio</span></p>
                <a href="https://onlyfans.com/<?php echo esc_attr($atts['username']); ?>" class="button">Open OnlyFans</a>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const showMore = document.querySelector('.show-more-<?php echo esc_js($atts['username']); ?>');
                const bio = document.querySelector('.bio-<?php echo esc_js($atts['username']); ?>');
                const fullBio = <?php echo wp_json_encode($bio); ?>;

                if (showMore) {
                    showMore.addEventListener('click', function() {
                        bio.innerHTML = fullBio;
                        showMore.style.display = 'none';
                    });
                }
            });
        </script>
        <?php
    }
    
    return ob_get_clean();
}
add_shortcode('profile_card', 'profile_card_shortcode');


function enqueue_profile_card_css($style) {
    $css_file = get_stylesheet_directory_uri() . '/css/' . sanitize_file_name($style) . '.css';
    if (!wp_style_is('profile-card-css-' . $style, 'enqueued')) {
        wp_enqueue_style('profile-card-css-' . $style, $css_file, [], '1.1.0');
    }
}

add_action('wp_enqueue_scripts', 'enqueue_profile_card_css');


function enqueue_fontawesome() {
    wp_enqueue_style('font-awesome-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', array(), '6.0.0');
}
add_action('wp_enqueue_scripts', 'enqueue_fontawesome');