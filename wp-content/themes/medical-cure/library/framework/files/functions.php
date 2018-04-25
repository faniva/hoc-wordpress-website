<?php

function c5_get_post_tax($id) {
    $post_type = get_post_type($id);
    $taxonomies=get_taxonomies();
    $skip = array(
        'post_tag',
        'nav_menu',
        'link_category',
        'post_format'
    );
    foreach ($taxonomies as $tax) {
        if(!in_array($tax , $skip) ){
            $tax_obj = get_taxonomy( $tax );
            if($tax_obj->object_type[0] == $post_type){
                return $tax;
            }
        }
    }

}

function c5_options_overwrite($options) {
	global $c5_overwrite_options;
	$c5_overwrite_options = $options;
//	global $c5_overwrite;
//	foreach ($options as $key => $value) {
//		$c5_overwrite = $value;
//		add_filter('c5_overwrite_' . $key, function() { global $c5_overwrite; return $c5_overwrite; });
//	}
}


function c5_set_option( $option_id, $option_value ) {

    // Get the option ID.
    $options_id = ot_options_id();

    // Get the options array.
    $options = get_option( $options_id );

    // Update the options array.
    if ( isset( $options[$option_id] ) ) {
      $options[$option_id] = $option_value;
      update_option( $options_id, $options );
    }
}


add_action( 'wp_head', 'c5_development_admin_bar_css' );

function c5_development_admin_bar_css()
{
    if (is_admin_bar_showing() ) {
        ?>
        <style>
        .toplevel_page_c5-about .dashicons-admin-generic:before{
            font-family: 'code125';
            content: '\e800';
            line-height: auto;
            height: auto;
            font-size: 17px;
            margin-right: 5px;
            margin-left: 5px;
        }
        </style>
        <?php
    }
}


function code125_generate_unique_id() {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < 6; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}


?>
