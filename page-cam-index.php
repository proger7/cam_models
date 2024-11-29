<?php
/**
 * Template Name: Cam Index Layout
 */

get_header();
?>

<div class="cam-index-layout">
    <div class="container">
        <?php

        $tag = get_post_meta(get_the_ID(), 'cam_tag', true);

        if ($tag) {
            echo '<h2>' . esc_html($tag) . '</h2>';
            echo '<div id="cam-models">';
            do_action('render_cam_models', $tag);
            echo '</div>';
        } else {
            echo '<p>Please set a tag in the custom fields.</p>';
        }
        ?>
    </div>
</div>

<?php get_footer(); ?>
