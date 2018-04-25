<?php

class C5AB_audio extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();


	function __construct() {

		$id_base = 'audio-widget';
		$this->_shortcode_name = 'c5ab_audio';
		$name = 'Audio';
		$desc = 'Embed a Audio file "Sound Cloud or HTML5 Audio".';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);

	}

	function get_shortcode($url) {
		if (strpos($url, 'soundcloud.com') !== false) {
		    return '[embed ' . $url . ']';
		  }else {
		  	return '[audio src="'.$url.'"]';
		  }
	}


	function shortcode($atts,$content) {

		$shortcode = $this->get_shortcode( $atts['url'] );

		return '<div class="c5ab-audio">'.do_shortcode($shortcode).'</div>';
	}


	function custom_css() {

	}

	function options() {

		$this->_options =array(
			array(
			    'label' => 'Audio URL',
			    'id' => 'url',
			    'type' => 'text',
			    'desc' => 'Add Audio URL ... you can add a Soundcloud URL and it will be automaticlly detected, or you can add external audio url and it will be added to a player.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			)
		);
	}




	function css() {
	?>
	<style>
		.c5ab-audio, .c5ab-audio iframe{
			width: 100%;
		}
	</style>
	<?php
	}

}


 ?>
