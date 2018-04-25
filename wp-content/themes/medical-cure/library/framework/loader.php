<?php
/**
 * Code125 framework
 * Version 1.2.1
 */
define('C5_FW_ROOT', C5_ROOT . 'library/framework/');
define('C5_FW_URL', C5_URI . 'library/framework/');




$pages = array(
	'C5_SLUG_THEME_OPTIONS' => 'c5-theme-options',
	'C5_SLUG_SUPPORT' => 'c5-support',
	'C5_SLUG_SYSTEM_STATUS' => 'c5-system-status',
	'C5_SLUG_DEMOS_INSTALL' => 'c5-install-demos',
	'C5_SLUG_QUICK_SETUP' => 'c5-install-demos&tab=quicksetup',
	'C5_SLUG_IMPORT_EXPORT' => 'c5-export-settings',
	'C5_SLUG_ABOUT' => 'c5-about',
	'C5_SLUG_LICENSE' => 'c5-theme-license',
	'C5_SLUG_PLUGINS' => 'c5-plugins',
	'C5_SETUP_WIZARD' => 'c5-setup-wizard'
);
foreach ($pages as $key => $value) {
	if (!defined($key)) {
		define($key , $value );
	}
}

add_filter( 'ot_show_pages', '__return_false' );

add_filter( 'code125_theme_stylesheets_conc', '__return_true' );


add_action( 'admin_enqueue_scripts', 'c5_fw_admin_styling' );
function c5_fw_admin_styling(){
	wp_enqueue_style( 'c5-admin-font', C5_FW_URL . 'font/code125.css', false, '1.0.0' );
	wp_enqueue_style( 'code125-framework-admin', C5_FW_URL . 'css/framework-admin.css', false, '1.0.0' );

	wp_register_script( 'jquery-blockui', C5_FW_URL . 'js/jquery.blockUI.js', array( 'jquery' ), '2.70', true );

	wp_enqueue_script( 'code125-setup-wizard', C5_FW_URL. 'js/setup-wizard.js', array( 'jquery', 'jquery-blockui' ) , '1.0.0', true );

	wp_localize_script( 'code125-setup-wizard', 'envato_setup_params', array(
		'tgm_plugin_nonce' => array(
			'update'  => wp_create_nonce( 'tgmpa-update' ),
			'install' => wp_create_nonce( 'tgmpa-install' ),
		),
		'tgm_bulk_url'     => admin_url( 'themes.php?page=tgmpa-install-plugins' ),
		'ajaxurl'          => admin_url( 'admin-ajax.php' ),
		'wpnonce'          => wp_create_nonce( 'envato_setup_nonce' ),
		'verify_text'      => esc_html__('...verifying', 'medical-cure'),
		)
	);
}


function c5_fw_frontend_styling() {
	if (is_admin_bar_showing() ) {
		wp_enqueue_style( 'c5-admin-font', C5_FW_URL . 'font/code125.css', false, '1.0.0' );
	}
}
add_action( 'wp_enqueue_scripts', 'c5_fw_frontend_styling' );
/**
 * Defining Awesome Builder integration parameters.
 */
add_filter( 'c5ab_theme_mode', '__return_true' );
add_filter( 'c5ab_root_path' ,  'c5ab_root_path');
function c5ab_root_path($root) {
	$root = C5_FW_ROOT . 'awesome-builder/';
	return $root;
}
add_filter( 'c5ab_uri_path' ,  'c5ab_uri_path');
function c5ab_uri_path($uri) {
	$uri = C5_FW_URL . 'awesome-builder/';
	return $uri;
}



require_once(C5_FW_ROOT . 'awesome-builder/loader.php' );
require_once(C5_FW_ROOT . 'option-tree/ot-loader.php' );
require_once(C5_FW_ROOT . 'formatting/loader.php' );
require_once(C5_FW_ROOT . 'theme-options/class-theme-options.php' );
require_once(C5_FW_ROOT . 'tgm/class-tgm-plugin-activation.php' );
require_once(C5_FW_ROOT . 'tgm/plugins.php' );

$files = array(
	'check',
	'arqam',
	'functions'
);


foreach ($files as $file ) {
	require_once(C5_FW_ROOT . 'files/'.$file.'.php' );
}

$classes = array(
	'meta-box',
	'archive',
	'fonts',
	'custom-options',
	'article-options',
	'theme-defaults',
	'notices'
);

foreach ($classes as $file ) {
	require_once(C5_FW_ROOT . 'classes/class-'.$file.'.php' );
}
$classes = array(
	'admin-panel',
	'support',
	'about',
	'import-plugins',
	'system-status',
	'setup-wizard',
	'quick-setup',
);
foreach ($classes as $file ) {
	require_once(C5_FW_ROOT . 'panel/class-'.$file.'.php' );
}


add_action('admin_init','c5_theme_activation_redirection');

function c5_theme_activation_redirection() {
	global $pagenow;
	 if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' )
	 {
	      wp_redirect( admin_url( 'admin.php?page='.C5_SETUP_WIZARD.'&activated=true' ) );
	      exit;
	 }
}



?>
