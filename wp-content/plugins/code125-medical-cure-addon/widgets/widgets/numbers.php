<?php

class C5AB_number extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_skip_title = true;
	public  $_cache_output = true;
	public  $_options =array();


	function __construct() {

		$id_base = 'numbers-info-widget';
		$this->_shortcode_name = 'c5ab_number';
		$name = 'Animating Numbers';
		$desc = 'Animating Numbers information';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}


	function shortcode($atts,$content) {

		$id = $this->get_unique_id();
		$data = '<div class="c5-infographics code125-infographics-'.$atts['layout'].'">';
		if ($atts['icon']!= '' && $atts['icon']!='fa fa-none') {
			$data .= '<span class="c5-icon '.$atts['icon'].'"></span>';
		}
		$data .= '<h5 class="counter"><span class="number">'.$atts['number'].'</span>';
		if ($atts['plus']!='off') {
			$data .= '<span class="plus"><i class="flaticon-plus-symbol"></i>';
		}

		$data .= '</span></h5>';
		$data .= '<p>'.$atts['title'].'</p>';
		$data .= '</div>';


		return $data;
	}



	function options() {

		$layouts  = array(
			'layout-1' => 'Layout 1',
			'layout-2' => 'Layout 2',
		 );
		$choices = array();
		foreach ($layouts as $key => $label) {
			$choices[] = array(
				'src' => C5_OPTIONS_IMG_URL . 'numbers/' . $key . '.png',
				'src_2x' => C5_OPTIONS_IMG_URL . 'numbers/' . $key . '@2x.png',
				'label' => $label,
				'value' => $key
			);
		}

		$this->_options =array(
			array(
				'label' => 'Choose Numbers layout',
				'id' => 'layout',
				'type' => 'radio-image',
				'desc' => '',
				'choices' => $choices,
				'std' => 'layout-1',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => '',
			),
			array(
			    'label' => 'Show Plus beside the number',
			    'id' => 'plus',
			    'type' => 'on-off',
			    'desc' => 'Show Plus beside the number.',
			    'std' => 'on',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Title',
			    'id' => 'title',
			    'type' => 'text',
			    'desc' => 'Animating Number Text.',
			    'std' => 'Hospital Rooms',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			  'label'       => 'Icon',
			  'id'          => 'icon',
			  'type'        => 'icon-list',
			  'desc'        => '',
			  'std'         => 'fa fa-cloud',
			  'rows'        => '',
			  'post_type'   => '',
			  'taxonomy'    => '',
			  'class'       => 'c5ab_icons'
			),

			array(
			    'label' => 'Number',
			    'id' => 'number',
			    'type' => 'text',
			    'desc' => 'The Animating number, it should be intiger.',
			    'std' => '120',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),

		);
	}


}


 ?>
