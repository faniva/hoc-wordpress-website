<?php

class C5AB_instagram extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	public  $wpiwdomain  = '';

	function __construct() {

		$id_base = 'instagram-widget';
		$this->_shortcode_name = 'c5ab_instagram';
		$name = 'Instagram Photo Stream';
		$desc = 'Embed Instagram Photo Stream.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}

	function scrape_instagram($username, $slice = 9) {

		if (false === ($instagram = get_transient('instagram-photos-'.sanitize_title_with_dashes($username)))) {

			$remote = wp_remote_get('http://instagram.com/'.trim($username));

			if (is_wp_error($remote))
			return new WP_Error('site_down', __('Unable to communicate with Instagram.', 'medical-cure'));

			if ( 200 != wp_remote_retrieve_response_code( $remote ) )
			return new WP_Error('invalid_response', __('Instagram did not return a 200.', 'medical-cure'));

			$shards = explode('window._sharedData = ', $remote['body']);
			$insta_json = explode(';</script>', $shards[1]);
			$insta_array = json_decode($insta_json[0], TRUE);
			//				print_r($insta_array);
			if (!$insta_array)
			return new WP_Error('bad_json', __('Instagram has returned invalid data.', 'medical-cure'));

			$images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];

			$instagram = array();
			foreach ($images as $image) {
				$instagram[] = array(
					'link' 			=> $image['display_src'],
					'url' 			=> 'httsp://www.instagram.com/' . $image['code'],
				);
			}

			$instagram = base64_encode( serialize( $instagram ) );
			set_transient('instagram-photos-'.sanitize_title_with_dashes($username), $instagram, apply_filters('null_instagram_cache_time', HOUR_IN_SECONDS*2));
		}

		$instagram = unserialize( base64_decode( $instagram ) );

		return array_slice($instagram, 0, $slice);
	}


	function shortcode($atts,$content) {

		if ( !c5_is_allow_url_fopen_enabled()) {
			return c5_check_allow_url_fopen_html();
		}


		$username = $atts['username'];
		$count = $atts['count'];
		$data = '';
		$size = 'large';
		if ($username != '') {


			$images_array = $this->scrape_instagram($username, $count);
			$counter = 0;
			if ( is_wp_error($images_array) ) {
				echo $images_array->get_error_message();
			} else {
				$slider_id = $this->get_unique_id();
				$data .= '<div class="code125-instagram-slider-wrap clearfix">';
				$data .= '<a href="https://www.instagram.com/'.$username.'" target="_blank" class="code125-follow-button">'.esc_html__('Follow on Instagram','medical-cure').'</a>';
				$data .='<div class="c5ab-instagram-slider slider-'.$slider_id.'">';

				foreach ($images_array as $image) {
					$data .='<div class="c5ab-instagram-slide"><a href="'.esc_url($image['url']).'" target="_blank"><img src="'.$image['link'].'"  alt="" /></a></div>';
					$counter++;
					if($counter == $atts['count']){
						break;
					}
				}
				$data .='</div>';
				$data .='</div>';



				$this->_js .= '
				$(\'.slider-'.$slider_id.'\' ).slick({
					'.$this->slick_direction().'
					\'adaptiveHeight\' : true,
					\'autoplay\': true,
				});'. "\n";

			}

		}


		return $data;
	}



	function options() {

		$this->_options =array(
			array(
				'label' => 'Instagram Username',
				'id' => 'username',
				'type' => 'text',
				'desc' => 'instagram Username, ex:facebook ',
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
				'desc' => 'Instagram images count to pull.',
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
