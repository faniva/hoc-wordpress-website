<?php

class C5AB_toggle extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_skip_title = true;
	public  $_cache_output = true;
	public  $_options =array();


	function __construct() {

		$id_base = 'toggle-widget';
		$this->_shortcode_name = 'c5ab_toggle';
		$name = 'Accordion';
		$desc = 'Accordion (Toggle) Element.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}


	function shortcode($atts,$content) {

		$data = '<div class="c5-toggle-single"><div class="c5-toggle-tab"><span class="c5-tabs-plus-minus"><i class="fa fa-plus"></i><i class="fa fa-minus"></i></span><span class="c5-icon '.$atts['icon'].'" data-id="qfldW"></span><span class="text">'.$atts['title'].'</span></div><div class="c5-pane ">'.wpautop($content).'</div></div>';
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
			    'desc' => 'Toggle title.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Icon',
			    'id' => 'icon',
			    'type' => 'icon-list',
			    'desc' => 'Toggle Icon".',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Content',
			    'id' => 'content',
			    'type' => 'wp-editor',
			    'desc' => 'Toggle Content.',
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
