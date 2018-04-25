<?php
function c5_get_width_class() {
	return 'c5-main-width-wrap';
}
function c5_get_width_class_option($option) {

	return 'c5-main-width-wrap';
}

function c5_get_header_width_class() {

	return 'c5-main-width-wrap';
}

function c5_get_page_width() {
	global $c5_theme_data;

	$device = new C5AB_Mobile_Detect();
	if( $device->isTablet() ){

		$GLOBALS['c5_content_width'] = 645;
		return;
	}

	if( $device->isMobile() && !$device->isTablet() ){
		$GLOBALS['c5_content_width'] = 300;
		return;
	}

	switch ($c5_theme_data['page_width']) {
		case 'full':
			return 1170;
			break;
		default:
			return 780;
			break;
	}
}



 ?>
