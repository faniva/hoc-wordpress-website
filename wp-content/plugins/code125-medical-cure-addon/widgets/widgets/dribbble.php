<?php

class C5AB_dribbble extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();


	function __construct() {

		$id_base = 'dribbble-widget';
		$this->_shortcode_name = 'c5ab_dribbble';
		$name = 'Dribbble Photo Stream';
		$desc = 'Embed Dribbble Photo Stream.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);

	}
	function get_the_shots($id = false, $number = 15){
		global $arq_options;
		if (isset($arq_options['social']['dribbble']['api'])) {
			$access_token = $arq_options['social']['dribbble']['api'];
		}else {
			return false;
		}
		if ($access_token=='') {
			return false;
		}
		if ( false === ( $images_array = get_transient( 'c5-dribbble-shots-'.$id ) ) ) {
		    // It wasn't there, so regenerate the data and save the transient
		    $images_array = array();
		    try {
		    	$data 	= @arq_remote_get("https://api.dribbble.com/v1/users/$id/shots?access_token=$access_token");
		    	foreach ($data as $image) {
		    		$images_array[] = array(
		    			'url'=> $image['html_url'],
		    			'image_url'=> $image['images']['normal'],
		    			'title'=>  $image['title']
		    		);
		    	}
		    } catch (Exception $e) {
		    	$result = 0;
		    }
		    set_transient( 'c5-dribbble-shots-'.$id , $images_array, 2 * HOUR_IN_SECONDS );
		}
		return $images_array;
	}

	function shortcode($atts,$content) {
		if ( !c5_is_allow_url_fopen_enabled()) {
			return c5_check_allow_url_fopen_html();
		}

		global $arq_options;
		if (isset($arq_options['social']['dribbble']['api'])) {
			$access_token = $arq_options['social']['dribbble']['api'];
		}else {
			return '';
		}
		if ($access_token=='') {
			return '';
		}

	    $username = $atts['username'];
		$count = $atts['count'];
		$data = '';
		$counter = 0;
		$size = 'thumbnail';
		if ($username != '') {


			$images_array = $this->get_the_shots($username, $count);

			if ( is_wp_error($images_array) ) {
			   echo $images_array->get_error_message();
			} else {
				$data .='<div class="c5ab-dribbble-slider"><ul class="c5ab-dribbble-slides clearfix">';
				foreach ($images_array as $image) {
					$data .='<li><a href="'.esc_url($image['url']).'" target="_blank"><img src="'.$image['image_url'].'"  alt="'.esc_attr($image['title']).'" title="'.esc_attr($image['title']).'"/></a></li>';
					$counter++;
					if($counter == $atts['count']){
						break;
					}
				}
				$data .='</ul></div>';
			}

		}


	    return $data;
	}


	function custom_css() {

	}

	function options() {

		$this->_options =array(
			array(
			    'label' => 'Dribbble Username',
			    'id' => 'username',
			    'type' => 'text',
			    'desc' => 'dribbble Username, ex:facebook ',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Count',
			    'id' => 'count',
			    'type' => 'text',
			    'desc' => 'Dribbble images count to pull.',
			    'std' => '9',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			)
		);
	}



}


 ?>
