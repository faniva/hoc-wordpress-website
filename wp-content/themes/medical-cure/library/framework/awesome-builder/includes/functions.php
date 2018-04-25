<?php
function c5_update_ab_templates() {
	$templates = array();

	$premade_templates = c5_get_premade_templates();

	foreach ($premade_templates as $id => $name) {
		$templates[$id] = ' [template] ' . $name;
	}

	$array = c5ab_get_option('post_types');
	if(is_array($array)){
		foreach($array as $type){
			$args = array(
				'post_type'=> $type,
				'posts_per_page'    => -1,
			);
			// The Query
			$the_query = new WP_Query( $args );
			$return = '';
			// The Loop
			if ( $the_query->have_posts() ) {
			   while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$template = get_post_meta(get_the_ID(), 'c5ab_data', true);
				    if( is_array(@code125_decode( $template) ) ){
				    	$templates[ get_the_ID() ] = get_the_title();
				    }
				}
			}
			/* Restore original Post Data */
			wp_reset_postdata();
		}
	}

	asort($templates);

	update_option('c5ab_templates' , $templates);

}

function c5_get_ab_templates() {
	$templates = get_option('c5ab_templates');
	if(!is_array($templates)){
		c5_update_ab_templates();
		$templates = get_option('c5ab_templates');
	}
	return $templates;

}



if ( ! function_exists( 'ot_type_textarea_readonly' ) ) {

  function ot_type_textarea_readonly( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* verify a description */
    $has_desc = $field_desc ? true : false;

    /* format setting outer wrapper */
    echo '<div class="format-setting type-tax-search ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';

     /* description */
     echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';

	echo '<textarea class="c5ab-row-export" readonly>'.$field_std.'</textarea>';

    echo '</div>';
  }
}


if (! function_exists( 'c5_is_mobile' )) {
	function c5_is_mobile(){
		$device = new C5AB_Mobile_Detect();
		if( $device->isMobile() && !$device->isTablet() ){
			return true;
		}
		return false;
	}
}

if (! function_exists( 'c5_is_tablet' )) {
	function c5_is_tablet(){
		$device = new C5AB_Mobile_Detect();
		if(  $device->isTablet() ){
			return true;
		}
		return false;
	}
}

if (! function_exists( 'c5_is_desktop' )) {
	function c5_is_desktop(){
		$device = new C5AB_Mobile_Detect();
		if( !$device->isMobile()){
			return true;
		}
		return false;
	}
}


if (! function_exists( 'c5_get_mobile_content_width' )) {
	function c5_get_mobile_content_width(){
		return apply_filters( 'c5_mobile_content_width', 300 );
	}
}

if (! function_exists( 'c5_get_tablet_content_width' )) {
	function c5_get_tablet_content_width(){
		return apply_filters( 'c5_tablet_content_width', 768 );
	}
}

if (! function_exists( 'c5_get_desktop_full_width' )) {
	function c5_get_desktop_full_width(){
		return apply_filters( 'c5_desktop_full_width', 1170 );
	}
}

if (! function_exists( 'c5_get_default_margin' )) {
	function c5_get_default_margin(){
		return apply_filters( 'c5_default_margin', 30 );
	}
}


if (!function_exists('c5_check_mobile_width')) {
	function c5_check_mobile_width() {
		if( c5_is_tablet() ){
			$GLOBALS['c5_content_width'] = c5_get_tablet_content_width();
			return;
		}

		if( c5_is_mobile() ){
			$GLOBALS['c5_content_width'] = c5_get_mobile_content_width();
			return;
		}
	}
}

if (!function_exists('code125_do_shortcode')) {
	 function code125_do_shortcode($class ='' , $instance)
	{
		if (class_exists($class)) {
			$obj = new $class();
			return $obj->build_shortcode( $instance);
		}
	}
}

if (!function_exists('code125_encode')) {
	function code125_encode($value)
   {
	   if (is_array($value)) {
		   $func = 'base' . '64_' . 'enc' . 'ode';
		   return $func( serialize($value));
	   }else {
		   return $value;
	   }
   }
}

if (!function_exists('code125_decode')) {
	function code125_decode($value)
   {
	   $func = 'base' . '64_' . 'dec' . 'ode';
	   return unserialize($func( $value));
   }
}


 ?>
