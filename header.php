<?php
$selected_header = get_theme_mod('selected_header', 'saucydates');

$header_bg = get_theme_mod("custom_header_image_{$selected_header}_cdn", '') ?: get_theme_mod("custom_header_image_{$selected_header}", '');
$header_bg_mobile = get_theme_mod("custom_header_image_{$selected_header}_mobile_cdn", '') ?: get_theme_mod("custom_header_image_{$selected_header}_mobile", '');

if (empty($header_bg)) {
    $header_bg = get_stylesheet_directory_uri() . "/images/{$selected_header}/background-adult-dating.jpg";
}

if (empty($header_bg_mobile)) {
    $header_bg_mobile = $header_bg;
}

$header_file = get_stylesheet_directory() . "/headers/header-{$selected_header}.php";
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .custom-header {
            background-image: url('<?php echo esc_url($header_bg); ?>') !important;
            background-size: cover;
            background-position: center;
        }
        
        @media (max-width: 768px) {
            .custom-header {
                background-image: url('<?php echo esc_url($header_bg_mobile); ?>') !important;
            }
        }
    </style>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php if (file_exists($header_file)) { include $header_file; } ?>
<?php wp_footer(); ?>
</body>
</html>
