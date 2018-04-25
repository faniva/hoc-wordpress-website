<?php
class Code125_option_tree_background_type {

	function __construct() {

		define('C5_POST_TYPE_BG_ROOT', C5BP_ROOT .'includes/background-type/');
		define('C5_POST_TYPE_BG_URI', C5BP_URI .'includes/background-type/');


		add_action('admin_enqueue_scripts',array($this, 'hook_script_and_style'),999);

		include_once(C5_POST_TYPE_BG_ROOT . 'row-seperators.php');
		include_once(C5_POST_TYPE_BG_ROOT . 'background-type.php');

		include_once(C5_POST_TYPE_BG_ROOT . 'new-core-types.php');
		include_once(C5_POST_TYPE_BG_ROOT . 'class-background-implement.php');
		include_once(C5_POST_TYPE_BG_ROOT . 'ajax.php');
	}

	function hook_script_and_style() {
        wp_enqueue_script( 'c5-ot-type-bg-script-js', C5_POST_TYPE_BG_URI.'background-type.js', '1.0', false );

		wp_enqueue_style( 'c5-ot-type-bg-css', C5_POST_TYPE_BG_URI.'background-type.css' );


	}
}
$obj = new Code125_option_tree_background_type();
?>
