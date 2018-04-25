<?php

class C5AB_authors_info extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_skip_title = true;
	public  $_options =array();


	function __construct() {

		$id_base = 'authors_info-widget';
		$this->_shortcode_name = 'c5ab_authors_info';
		$name = 'Authors Info';
		$desc = 'Authors Info Box.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}


	function shortcode($atts,$content) {

		if($atts['author_id'] == ''){
			$user_ID = get_the_author_meta('ID');
		}else {
			$user_ID = $atts['author_id'] ;
		}

		if ( c5_in_sidebar() && is_author() ) {
			$obj = get_queried_object();
			if ($user_ID = $obj->ID) {
				return '';
			}
		}

		$data = '';

		$user = get_userdata($user_ID);

		$description = $user->description;

		$social_icons = array();

		$facebook = get_user_meta($user_ID, 'c5_term_meta_user_facebook',true);
		if ($facebook!='') {
			$social_icons['fa fa-facebook'] = 'http://www.facebook.com/'.$facebook;
		}
		$twitter = get_user_meta($user_ID, 'c5_term_meta_user_twitter',true);
		if ($twitter!='') {
			$social_icons['fa fa-twitter'] = 'http://www.twitter.com/'.$twitter;
		}
		$google_plus = get_user_meta($user_ID, 'c5_term_meta_user_google_plus',true);
		if ($google_plus!='') {
			$social_icons['fa fa-google-plus'] = $google_plus;
		}
		$linkedin = get_user_meta($user_ID, 'c5_term_meta_user_linkedin',true);
		if ($linkedin!='') {
			$social_icons['fa fa-linkedin'] = $linkedin;
		}
		$dribbble = get_user_meta($user_ID, 'c5_term_meta_user_dribbble',true);
		if ($dribbble!='') {
			$social_icons['fa fa-dribbble'] = $dribbble;
		}
		$behance = get_user_meta($user_ID, 'c5_term_meta_user_behance',true);
		if ($behance!='') {
			$social_icons['fa fa-behance'] = $behance;
		}
		$pinterest = get_user_meta($user_ID, 'c5_term_meta_user_pinterest',true);
		if ($pinterest!='') {
			$social_icons['fa fa-pinterest'] = $pinterest;
		}
		if ($user->user_email!='') {
			$social_icons['fa fa-envelope'] = 'mailto:' . $user->user_email;
		}
		if ($user->user_url!='') {
			$social_icons['fa fa-link'] = $user->user_url;
		}


		$cover = get_user_meta($user_ID, 'c5_term_meta_user_cover',true);
		$class = "no-cover";
		$has_cover = false;
		if ($cover!='') {
			$class = 'has-cover';
			$has_cover = true;
		}

		if ($GLOBALS['c5_content_width']<400) {
			$class .= ' c5-small-screen';
		}


		$data .= '<div class="c5-author-info c5-author-info-'. $user_ID .' '. $class .' clearfix">
			<div class="c5-author-cover"></div>';

		if ( $has_cover && class_exists('C5_post') ) {

			$image_data = c5_generate_image($GLOBALS['c5_content_width'], 250, $cover, true);
			$src = $image_data['src'];
			$src_2x = $image_data['src_2x'];
			if (is_ssl()) {
				$src = str_replace('http://', 'https://', $src);
				$src_2x = str_replace('http://', 'https://', $src_2x);
			}
			$post_obj = new C5_post();
			$css = $post_obj->background_css('.c5-author-info-'.$user_ID.' .c5-author-cover', array($src , $src_2x));

			$data .= '<style>'.$css.'</style>';
		}
		$data .= '<div class="c5-author-information">
				<div class="c5-author-image"><a href="'.get_author_posts_url($user_ID).'">' . get_avatar($user_ID, 200) . '</a></div>
				<div class="c5-author-data">
					<h1 class="heading1"><a href="'.get_author_posts_url($user_ID).'">'. $user->display_name .'</a></h1>';

		if (!empty($social_icons)) {
			$data .=  '<ul class="c5-author-social">';
			foreach ($social_icons as $icon => $link) {
				$data .=  '<li><a href="'.$link.'" target="_blank"><span class="'.$icon.'"></span></a></li>';
			}
			$data .=  '</ul>';
		}
		$data .= '</div> </div>';
		if ($user->description!='') {
			$description = $user->description;
			if (function_exists('icl_translate')) {
				$description =icl_translate('Authors', 'description_'.$user->ID, $user->description);
			}

			$data .=  '<div class="clearfix"></div><div class="c5-author-desc"><p>'.$description.'</p></div>';
			}
		$data .= '</div>';

		return $data;

	}


	function custom_css() {

	}

	function options() {
		$array = array();
		        $array[] = array(
		            'label' => 'Current Article Authors',
		            'value' => ''
		        );
		        $blogusers = get_users();
		        foreach ($blogusers as $user) {
		            if (count_user_posts($user->ID) > 0) {
		                $array[] = array(
		                    'label' => $user->display_name,
		                    'value' => $user->ID
		                );
		            }
		        }

		$this->_options =array(

			array(
			    'label' => 'Author',
			    'id' => 'author_id',
			    'type' => 'select',
			    'desc' => 'Choose the Author',
			    'std' => '',
			    'choices' => $array,
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			)

		);
	}

	function css() {

	}

}


 ?>
