<?php

class C5AB_image_comparison extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_skip_title = true;
	public  $_cache_output = true;
	public  $_options =array();


	function __construct() {

		$id_base = 'image_comparison-widget';
		$this->_shortcode_name = 'c5ab_image_comparison';
		$name = 'Image Comparison';
		$desc = 'Add Image Comparison Box (Before & After Effect).';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);
	}


	function shortcode($atts,$content) {

		$return = '<div class="code125-image-comparison">';
		if ($atts['before_label'] != '') {
			$return .= '<span class="before-label">'.$atts['before_label'].'</span>';
		}
		if ($atts['after_label'] != '') {
			$return .= '<span class="after-label">'.$atts['after_label'].'</span>';
		}
		$return .= '<div class="cocoen ">';

		if ($atts['before']!='') {
			$image_size = c5ab_generate_image_size($GLOBALS['c5_content_width'], 9999, false);
			$image_data = $this->get_image($image_size , $atts['before']);
			$srcset = ($image_data[1] != '') ? 'srcset="'.$image_data[0].' 1x,'.$image_data[1].' 2x"' : '';

			$return .= '<img src="'.$image_data[0].'" class="before-image" '.$srcset.' />';
		}
		if ($atts['after']!='') {
			$image_size = c5ab_generate_image_size($GLOBALS['c5_content_width'], 9999, false);
			$image_data = $this->get_image($image_size , $atts['after']);
			$srcset = ($image_data[1] != '') ? 'srcset="'.$image_data[0].' 1x,'.$image_data[1].' 2x"' : '';

			$return .= '<img src="'.$image_data[0].'" class="after-image" '.$srcset.' />';
		}
		$return .= '</div>';
		$return .= '</div>';


		return $return;
	}

	public function get_image($image_size , $url)
	{
		$src = $url;
		$src_2x = '';
		$attachment_id = c5ab_get_attachment_id_from_src($url);
		if ($attachment_id != '') {
			$image_attributes = c5_wp_get_attachment_image_src($attachment_id , $image_size , false );
			if ($image_attributes) {
				$src = $image_attributes[0];
				$src_2x = $image_attributes[3];
			}
		}
		return array($src, $src_2x);
	}

	function custom_css() {

	}

	function options() {

		$this->_options =array(

			array(
			    'label' => 'Before Image',
			    'id' => 'before',
			    'type' => 'upload',
			    'desc' => 'Before Image.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Before label',
			    'id' => 'before_label',
			    'type' => 'text',
			    'desc' => 'Before Image Label.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'After Image',
			    'id' => 'after',
			    'type' => 'upload',
			    'desc' => 'After Image.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'After label',
			    'id' => 'after_label',
			    'type' => 'text',
			    'desc' => 'After Image Label.',
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
