<?php
function my_theme_enqueue_styles() {

    $parent_style = 'medical-cure'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/library/css/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

// Define the child theme ui
define('HOC_ROOT', get_stylesheet_directory() . '/');
define('HOC_URI', get_stylesheet_directory_uri() . '/');


add_action( 'after_setup_theme', 'setup_hoc_theme', 9 );


function setup_hoc_theme() {

    // Load the theme classes
    require_once(HOC_ROOT . '/library/includes/header/class-hoc-header.php');
    require_once(HOC_ROOT . '/library/includes/header/class-hoc-page-info.php');

}
