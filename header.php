<?php
$selected_header = get_theme_mod('selected_header', 'saucydates');
$header_file = get_stylesheet_directory() . "/headers/header-{$selected_header}.php";
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
if (file_exists($header_file)) {
    include $header_file;
}
?>
<?php wp_footer(); ?>
</body>
</html>