<?php


class C5_author_settings extends C5_theme_option_elements {

	function hook() {
		add_filter( 'c5_author_options', array($this, 'set_options') );
	}

	function set_options() {

		$options = array();

		$options[]= array(
			'label' => 'Facebook Username',
			'id' => 'facebook',
			'type' => 'text',
			'desc' => 'Facebook Username',
			'std' => '',
			'class' => ''
		);
		$options[]= array(
			'label' => 'Twitter Username',
			'id' => 'twitter',
			'type' => 'text',
			'desc' => 'Twitter Username',
			'std' => '',
			'class' => ''
		);
		$options[]= array(
			'label' => 'Google Plus Link',
			'id' => 'google_plus',
			'type' => 'text',
			'desc' => 'Google Plus Link',
			'std' => '',
			'class' => ''
		);
		$options[]= array(
			'label' => 'LinkedIn Profile Link',
			'id' => 'linkedin',
			'type' => 'text',
			'desc' => 'LinkedIn Profile Link',
			'std' => '',
			'class' => ''
		);

		$options[]= array(
			'label' => 'Dribbble Profile Link',
			'id' => 'dribbble',
			'type' => 'text',
			'desc' => 'Dribbble Profile Link',
			'std' => '',
			'class' => ''
		);
		$options[]= array(
			'label' => 'Behance Profile Link',
			'id' => 'behance',
			'type' => 'text',
			'desc' => 'Behance Profile Link',
			'std' => '',
			'class' => ''
		);
		$options[]= array(
			'label' => 'Pinterest Profile Link',
			'id' => 'pinterest',
			'type' => 'text',
			'desc' => 'Pinterest Profile Link',
			'std' => '',
			'class' => ''
		);
		$options[]= array(
			'label' => 'Author Cover Photo',
			'id' => 'cover',
			'type' => 'upload',
			'desc' => 'Author Cover Photo',
			'std' => '',
			'class' => ''
		);
		$options[] =  array(
			'label' => 'Author Content template',
			'id' => 'template',
			'type' => 'select',
			'desc' => 'Choose The custom template for this category ',
			'choices' => $this->get_templates_list(),
			'std' => '',
			'rows' => '',
			'taxonomy' => '',
			'class' => ''
		);
		if (!C5_SIMPLE_OPTION) {
			$options[] = array(
				'label' => 'Choose Custom Skin',
				'id' => 'skin_default',
				'type' => 'custom-post-type-select',
				'desc' => 'Choose Custom Skin, leave it for default skin.',
				'std' => '',
				'rows' => '',
				'post_type' => 'skin',
				'taxonomy' => '',
				'class' => ''
			);
		}

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

$authors_term_obj = new C5_author_settings();
$authors_term_obj->hook();
?>
