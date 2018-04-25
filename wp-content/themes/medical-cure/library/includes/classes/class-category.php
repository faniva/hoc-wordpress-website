<?php
class C5_category_settings extends C5_theme_option_elements {

	function hook() {
		add_filter( 'c5_terms_options', array( $this, 'set_options') );
	}

	function set_options() {

		$options = array();


		$options[] =  array(
			'label' => 'Category Content template',
			'id' => 'template',
			'type' => 'select',
			'desc' => 'Choose The custom template for this category ',
			'choices' => $this->get_templates_list(),
			'std' => '',
			'rows' => '',
			'taxonomy' => '',
			'class' => ''
		);

		$options[] = array(
			'label' => 'Category Cover',
			'id' => 'custom_cover',
			'type' => 'upload',
			'desc' => 'Upload Category cover.',
			'std' => '',
			'class' => ''
		);

		$options[] =  $this->get_icons_options() ;

		$options[] = array(
			'label' => 'Use Custom Color Settings',
			'id' => 'use_custom_colors',
			'type' => 'on_off',
			'desc' => 'Enable to set a custom color. You can set the color below.',
			'std' => 'off',
			'class' => ''
		);

		$options = array_merge($options , $this->get_colors_options() );

		$options[]= array(
			'label' => 'Use Custom Layout Settings',
			'id' => 'use_custom_layout',
			'type' => 'on_off',
			'desc' => 'Enable to set a custom layout. You can set the layout settings below.',
			'std' => 'off',
			'class' => ''
		);
		$options = array_merge($options , $this->get_layout_options() );



		return $options;

	}

}

$categories_term_obj = new C5_category_settings();
$categories_term_obj->hook();
?>
