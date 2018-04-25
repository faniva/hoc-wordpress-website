<?php


define('C5_STAFF_CPT_ROOT', C5_MC_ROOT . 'staff-cpt/');
define('C5_STAFF_CPT_URL', C5_MC_URL . 'staff-cpt/');


require_once(C5_STAFF_CPT_ROOT . 'class-cpt.php' );
require_once(C5_STAFF_CPT_ROOT . 'meta-box.php' );


add_filter('c5ab_external_widgets', 'c5_staff_widgets' );
function c5_staff_widgets($widgets)
{
	$files = array(
        'widget-staff' => 'C5AB_staff',
		'widget-featured-staff' => 'C5AB_featured_staff',
	);

	/* require the files */
	foreach ( $files as $file => $widget_class ) {
		add_filter('c5ab_widget_skip_'.$file,'__return_true');
		$widgets[] = array(
			'path' => C5_STAFF_CPT_ROOT . $file .'.php',
			'class' => $widget_class
		);
	}
	return $widgets;
}

?>
