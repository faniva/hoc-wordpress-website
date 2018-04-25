<?php

class C5AB_space extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();


	function __construct() {

		$id_base = 'space-widget';
		$this->_shortcode_name = 'c5ab_space';
		$name = 'Space';
		$desc = 'Space Box.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}


	function shortcode($atts,$content) {


		$data = '<div class="c5ab_space" style="height:'.$atts['height'].'px"></div>';
		return $data;
	}


	function custom_css() {

	}

	function options() {
		$this->_options =array(

			array(
			    'label' => 'Height',
			    'id' => 'height',
			    'type' => 'text',
			    'desc' => 'Height in pixels, Default: 30.',
			    'std' => '30',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),

		);
	}

	function css() {
		?>
		<style>
		.c5ab_space{
			display: block;
			height: 30px;
			width: 100%;
		}
		</style>
		<?php
	}

}


 ?>
