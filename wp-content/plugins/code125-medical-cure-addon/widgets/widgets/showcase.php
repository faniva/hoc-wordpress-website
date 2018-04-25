<?php

class C5AB_showcase extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = false;
	public  $_skip_title = true;
	public  $_options =array();


	function __construct() {

		$id_base = 'showcase-widget';
		$name = 'Demo Showcase';
		$desc = 'Showcase for Projects or Achivments. Anything you want to feature that has a main image, title and link';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}


	function shortcode($atts,$content) {

			$current_width = $GLOBALS['c5_content_width'];
			$image_size = c5ab_generate_image_size($current_width, '9999' , false);
		    $img_id = c5ab_get_attachment_id_from_src($atts['url']);
		    if($img_id!=''){
		    	$image_url = c5_wp_get_attachment_image_src($img_id, $image_size);
		    }else {
	    		$image_url = array(
	    			$atts['url'],'','',''
	    		);
	    	}
		    if($image_url[1]== '' ){
		    	$image_url[1] = 'auto';
		    }
		    if($image_url[2]== ''){
		    	$image_url[2] = 'auto';
		    }
			$src_set = '';
			if($image_url[3] != ''){
				$src_set = 'srcset="'.$image_url[0].' 1x,'.$image_url[3].' 2x"';
			}

			$data = '<div class="code125-showcase clearfix">';
			if($atts['link']!=''){
				$data .= '<a class="url" href="'.$atts['link'].'" target="_blank"></a>';
			}
			$data .= '<img src="' . $image_url[0] . '" width="' . $image_url[1] . '" height="' . $image_url[2] . '" '.$src_set.' alt="'.$atts['caption'].'" />';
			if($atts['caption']!=''){
				$data .= '<p class="caption">'.$atts['caption'].'</p>';
			}
			$data .= '</div>';

		    return $data;

	}


	function custom_css() {

	}

	function options() {

		$this->_options =array(
			array(
			    'label' => 'Caption',
			    'id' => 'caption',
			    'type' => 'text',
			    'desc' => 'Add Caption to the image.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Image',
			    'id' => 'url',
			    'type' => 'upload',
			    'desc' => 'Upload your Image.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Link',
			    'id' => 'link',
			    'type' => 'text',
			    'desc' => 'Add a url if you want to the image to be clickable.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			)
		);
	}

}


 ?>
