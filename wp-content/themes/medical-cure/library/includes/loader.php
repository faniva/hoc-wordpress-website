<?php


define('C5_INCLUDE_ROOT', C5_ROOT . 'library/includes/');
define('C5_INCLUDES_URI', C5_URI . 'library/includes/');


require_once(C5_INCLUDE_ROOT . 'footer/loader.php' );
require_once(C5_INCLUDE_ROOT . 'article/loader.php' );

$files = array(
	'functions',
	'like',
	'post-formats',
	'ajax'
);


if(class_exists( 'WooCommerce' )){
	$files[] =  'woocommerce';
}
foreach ($files as $file ) {
	require_once(C5_INCLUDE_ROOT . 'files/'.$file.'.php' );
}

$classes = array(
	'logo',
	'header-base',
	'header',
	'header-css',
	'page-info',
);

foreach ($classes as $file ) {
	require_once(C5_INCLUDE_ROOT . 'header/class-'.$file.'.php' );
}

$classes = array(

	'bread-crumb',
	'theme-options-base',
	'theme-options-elements',
	'theme-functions',
	'advanced-options',
	'post-query',
	'post-base',
	'post',
	'article',
	'menu',
	'author',
	'author-data',
	'category',
	'meta-boxes',
	'theme-options',
	'layout',
	'import',
	'tgm',
	'theme-defaults'
);

foreach ($classes as $file ) {
	require_once(C5_INCLUDE_ROOT . 'classes/class-'.$file.'.php' );
}



?>
