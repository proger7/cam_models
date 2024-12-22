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
