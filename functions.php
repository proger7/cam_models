<?php

function generatepress_child_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
}
add_action('wp_enqueue_scripts', 'generatepress_child_enqueue_styles');


function enqueue_cam_styles() {
    wp_enqueue_style('cam-styles', get_stylesheet_directory_uri() . '/cam-styles.css');
}
add_action('wp_enqueue_scripts', 'enqueue_cam_styles');


function render_cam_models($tag) {
    $script = <<<EOD
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modelsContainer = document.getElementById('cam-models');
            const tag = '{$tag}';

            const models = [
                { name: 'Model 1', tag: 'bdsm' },
                { name: 'Model 2', tag: 'bdsm' },
                { name: 'Model 3', tag: 'fetish' },
            ];

            const filteredModels = models.filter(model => model.tag === tag);

            filteredModels.forEach(model => {
                const div = document.createElement('div');
                div.className = 'model-tile';
                div.innerText = model.name;
                modelsContainer.appendChild(div);
            });
        });
    </script>
    EOD;

    echo $script;
}
add_action('render_cam_models', 'render_cam_models');