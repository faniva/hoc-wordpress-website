<?php
/*
Plugin Name: Code125 Custom Post Types
Plugin URI: https://code125.com
Description: Code125 Custom Post Types.
Version: 1.1.1
Author: Code125
Author URI: http://themeforest.net/user/Code125
License: GPL3
License URI: http://www.gnu.org/licenses/gpl.html
*/
define('C5_ACPT_ROOT', plugin_dir_path( __FILE__ ) );
define('C5_ACPT_URL', plugin_dir_url( __FILE__ ) );


$classes = array(
	'cpt',
	'register'
);

foreach ($classes as $file ) {
	require_once(C5_ACPT_ROOT . 'class-'.$file.'.php' );
}
?>
