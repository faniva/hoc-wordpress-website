<?php

class C5AB_footer_desc extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_skip_title = true;
	public  $_options =array();


	function __construct() {

		$id_base = 'footer-desc-widget';
		$this->_shortcode_name = 'c5ab_footer_desc';
		$name = 'Footer Logo & Description';
		$desc = 'Footer Logo & Description, this widget is designed to be used in Footer';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}


	function shortcode($atts,$content) {

		$image = '';


	    if ($atts['image'] != '') {

	    	$logo_url = $atts['image'];
	    	if ($logo_url == 'http://C5_THEME_WLOGO_URL') {
	    		$src = C5_URI . 'library/images/logo-white.png';
	    		$src_2x = C5_URI . 'library/images/logo-white-2x.png';
	    	}else {
	    		$logo_url = str_replace('CODE125_THEMEURL', get_stylesheet_directory_uri() . '/library/images/ads' , $logo_url );
	    		$image_data = c5_generate_image($atts['width'], 9999, $logo_url, false);
	    		$src = $image_data['src'];
	    		$src_2x = $image_data['src_2x'];
	    	}


	        $image = '<a href="'.home_url().'" target="_blank"><img src="'.$src.'" width="'.$atts['width'].'" alt="Footer Logo" srcset="'.$src.' 1x,'.$src_2x.' 2x" /></a><div class="clearfix"></div>';
	    }


		$html_content= '';
		if ($content != '') {
		    $html_content = '<p>'.$content.'</p>';
		}

	   $data = '<section class="c5-footer-widget c5-identity">'.$image . html_entity_decode( $html_content ).'</section>';

	    return $data;

	}


	function custom_css() {

	}

	function options() {


		$this->_options =array(
			array(
			    'label' => 'Image',
			    'id' => 'image',
			    'type' => 'upload',
			    'desc' => 'Upload footer image logo',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Image width',
			    'id' => 'width',
			    'type' => 'text',
			    'desc' => 'footer image width',
			    'std' => '180',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Description',
			    'id' => 'content',
			    'type' => 'textarea-simple',
			    'desc' => '',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
		);
	}

	function css() {

	}

}


 ?>
