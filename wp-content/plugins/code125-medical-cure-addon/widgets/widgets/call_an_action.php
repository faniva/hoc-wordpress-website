<?php

class C5AB_call_an_action extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_skip_title = true;
	public  $_cache_output = true;
	public  $_options =array();


	function __construct() {

		$id_base = 'call-an-action-widget';
		$this->_shortcode_name = 'c5ab_call_an_action';
		$name = 'Call an action';
		$desc = 'Call an action Box.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}


	function shortcode($atts,$content) {

		$data = '<div class="c5-call-to-action"><div class="text-center"><h3>'.$atts['title'].'</h3><p>'.$atts['subtitle'].'</p>';

		if ($atts['button_text']!='') {
			$data .='<a href="'.$atts['link'].'" class="btn c5-btn-theme"><span class="">'.$atts['button_icon'].'</span> '.$atts['button_text'].' </a>';
		}

		$data .= '</div></div>';
		return $data;
	}


	function custom_css() {

	}

	function options() {

		$this->_options =array(

			array(
			    'label' => 'Title',
			    'id' => 'title',
			    'type' => 'text',
			    'desc' => 'Call an action title.',
			    'std' => 'Are you ready to perform full checkup?',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Subtitle',
			    'id' => 'subtitle',
			    'type' => 'text',
			    'desc' => 'Call an action content "It will be wrapped in p html tag".',
			    'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras at diam nec neque laoreet malesuada.',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Button Link',
			    'id' => 'link',
			    'type' => 'text',
			    'desc' => 'Service Column Button Link.',
			    'std' => '#',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Button Text',
			    'id' => 'button_text',
			    'type' => 'text',
			    'desc' => 'Service Column Button Text.',
			    'std' => 'Book Appointment',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Button Icon',
			    'id' => 'button_icon',
			    'type' => 'icon-list',
			    'desc' => 'Service Column Button Icon.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),

		);
	}
}


 ?>
