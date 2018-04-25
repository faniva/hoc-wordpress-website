<?php

define('C5_IMPORT_ROOT', C5_MC_ROOT . 'import/');
define('C5_IMPORT_URL', C5_MC_URL . 'import/');


define('C5_SETUP_WIZARD' , apply_filters( 'code125-importer-slug', 'c5-setup-wizard' ));

require_once(C5_IMPORT_ROOT . 'theme-activation.php' );
require_once(C5_IMPORT_ROOT . 'auto-widgets-import.php' );


function c5_one_click_styles() {

	wp_enqueue_script( C5_SETUP_WIZARD, C5_IMPORT_URL. 'import-script.js', array( 'jquery', 'jquery-blockui' ) , '1.0.0', true );
}

add_action( 'admin_enqueue_scripts', 'c5_one_click_styles' );



 ?>
