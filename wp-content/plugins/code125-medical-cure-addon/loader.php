<?php
/*
Plugin Name: Code125 Medical Cure Addon
Plugin URI: https://code125.com
Description: Code125 Medical Cure theme Addon.
Version: 1.1.0
Author: Code125
Author URI: http://themeforest.net/user/Code125
License: GPL3
License URI: http://www.gnu.org/licenses/gpl.html
*/

define('C5_MC_ROOT', plugin_dir_path( __FILE__ ) );
define('C5_MC_URL', plugin_dir_url( __FILE__ ) );

add_filter( 'code125_images_path', 'code125_images_path_function' );
 function code125_images_path_function()
{
    return plugin_dir_url( __FILE__ ) . '/images/';
}

define('C5_OPTIONS_IMG_URL', plugin_dir_url( __FILE__ ) . 'images/' );


add_filter( 'code125_external_import_loaded', '__return_true' );
add_filter('widget_text', 'do_shortcode');


require_once(C5_MC_ROOT . 'banners-cpt/class-cpt.php' );
require_once(C5_MC_ROOT . 'footer/class-cpt.php' );
require_once(C5_MC_ROOT . 'staff-cpt/loader.php' );
require_once(C5_MC_ROOT . 'medical-font/class-font-medical.php' );
require_once(C5_MC_ROOT . 'twitteroauth.php');
require_once(C5_MC_ROOT . 'import/loader.php' );
require_once(C5_MC_ROOT . 'templates/all-templates.php' );
require_once(C5_MC_ROOT . 'widgets/loader.php' );

 ?>
