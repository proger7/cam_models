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

        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
    }

    public function enqueue_styles() {
        if (is_active_widget(false, false, $this->id_base, true)) {
            wp_enqueue_style('tags-widget-style', get_stylesheet_directory_uri() . '/css/tags-widget.css');
        }
    }

    public function widget($args, $instance) {
        $tags = [
            "anal", "bdsm", "asian", "big ass", "blond", "african", "asmr"
        ];

        echo $args['before_widget'];
        ?>
        <div class="tags-sidebar">
            <div class="tags-list" id="tagsList">
                <?php foreach (array_slice($tags, 0, 5) as $tag): ?>
                    <a class="tag" href="#" data-tag="<?php echo ltrim($tag, '#'); ?>"><?php echo $tag; ?></a>
                <?php endforeach; ?>
            </div>
            <button class="more-btn" id="moreBtn">More...</button>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const tagsList = document.getElementById("tagsList");
                const moreBtn = document.getElementById("moreBtn");
                const tags = <?php echo json_encode($tags); ?>;
                let visibleCount = 5;

                const renderTags = () => {
                    tagsList.innerHTML = "";
                    tags.slice(0, visibleCount).forEach(tag => {
                        const tagElement = document.createElement("a");
                        tagElement.className = "tag";
                        tagElement.href = "#";
                        tagElement.textContent = tag;
                        tagElement.dataset.tag = tag.replace("#", "");
                        tagsList.appendChild(tagElement);
                    });
                    moreBtn.style.display = visibleCount >= tags.length ? "none" : "block";
                };

                moreBtn.addEventListener("click", () => {
                    visibleCount += 5;
                    renderTags();
                });

                tagsList.addEventListener("click", (event) => {
                    if (event.target.classList.contains("tag")) {
                        event.preventDefault();
                        const selectedTag = event.target.dataset.tag;
                        const url = new URL(window.location);
                        url.searchParams.set("q", selectedTag);
                        window.location = url;
                    }
                });

                renderTags();
            });
        </script>
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
