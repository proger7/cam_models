<?php
/**
 * Template Name: Cam Template
 */
get_header();

$tag = get_post_meta(get_the_ID(), 'cam_tag', true);
?>


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

<?php get_footer(); ?>
