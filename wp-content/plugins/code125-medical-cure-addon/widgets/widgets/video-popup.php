<?php

class C5AB_video_popup extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_skip_title = true;
	public  $_cache_output = true;
	public  $_options =array();


	function __construct() {

		$id_base = 'video_popup-widget';
		$this->_shortcode_name = 'c5ab_video_popup';
		$name = 'Video Popup';
		$desc = 'Add Image with a video popup.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);
	}


	function shortcode($atts,$content) {

		$return = '<div class="code125-video-popup clearfix">';
		if ($atts['image'] != '') {
			$image_size = c5ab_generate_image_size($GLOBALS['c5_content_width'], 9999, false);
			$image_data = $this->get_image($image_size , $atts['image']);
			$srcset = $image_data[1] != '' ? 'srcset="'.$image_data[0].' 1x,'.$image_data[1].' 2x"' : '';
			$return .= '<img src="'.$image_data[0].'" class="code125-image-plceholder" '.$srcset.' alt="Click to Play Video" />';
		}

		$return .= '<p class="code125-video-button-popup " data-url="'.$atts['video'].'"><span class="fa fa-play"></span></p>';

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
			    'label' => 'Image',
			    'id' => 'image',
			    'type' => 'upload',
			    'desc' => 'Video thumbnail image.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Video URL',
			    'id' => 'video',
			    'type' => 'text',
			    'desc' => 'Add Video URL ... you can add a Youtube, Vimeo, Dailymotion URL and it will be automaticlly detected, or you can add external video url and it will be added to a player.',
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
