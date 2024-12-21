<?php
/*
 * Template Name: Cam Template
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$tag = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : get_post_meta(get_the_ID(), 'cam_tag', true);

get_header(); ?>

<div <?php generate_do_attr( 'content' ); ?>>
    <main <?php generate_do_attr( 'main' ); ?>>
        <div class="camTemplateItem__wrapper" style="width:100%">
            <div class="camTemplateItem__row" id="camContent"></div>
        </div>

        <script id="camContentTemplate" type="text/template">
            <div class="camTemplateItem__item-col">
                <a href="{{link}}" class="camTemplateItem">
                    <span class="camTemplateItem__image">
                        <img loading="lazy" src="{{image_url}}" alt="{{username}} webcam" class="camTemplateItem--image">
                    </span>
                    <span class="camTemplateItem__modelWrapper">
                        <span class="camTemplateItem__modelInfoWrapper">
                            <span class="camTemplateItem__modelInfo">
                                <h2 class="camTemplateItem__modelName">{{username}}</h2>
                            </span>
                            <span class="camTemplateItem__modelEthnicity">
                                <span class="camTemplateItem__name">{{age}}</span>
                                <span class="camTemplateItem__value"> Year old </span>
                                <span class="camTemplateItem__name">{{gender}}</span>
                            </span>
                        </span>
                    </span>
                </a>
            </div>
        </script>

        <script>
            var camApiConfig = {
                'sortOrder': '',
                'status': ['online'],
                'q': '<?php echo esc_js($tag); ?>',
                'gender': ['f', 'm'],
                'tags': '',
                'languages': '',
                'ethnicity': '',
                'hair': '',
                'age': '',
                'sites': [1],
                'divTarget': 'camContent',
                'divTemplate': 'camContentTemplate',
                'limitPerPage': 10,
                'allowPagination': true
            };
        </script>

        <?php
        do_action( 'generate_before_main_content' );

        if ( generate_has_default_loop() ) {
            while ( have_posts() ) :
                the_post();
                generate_do_template_part( 'page' );
            endwhile;
        }

        do_action( 'generate_after_main_content' );
        ?>
    </main>
</div>

<?php
do_action( 'generate_after_primary_content_area' );
generate_construct_sidebars();
get_footer();
