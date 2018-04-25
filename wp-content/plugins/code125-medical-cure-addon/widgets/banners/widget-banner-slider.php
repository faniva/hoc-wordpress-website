<?php

class C5AB_banner_slider extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();

	function __construct() {

		$id_base = 'banner-slider-widget';
		$this->_shortcode_name = 'c5_banner_slider';
		$name = 'Banners Slider ';
		$desc = 'Add Banners Slider to your page.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);

	}


	function shortcode($atts,$content) {



		$args = array( );
		$args['post__in'] = explode(',', $atts['posts']);
		$args['ignore_sticky_posts'] = true;
		$args['orderby'] = 'post__in';
		$args['post_type'] = 'theme-banner';



		// The Query
		$the_query = new WP_Query( $args );
		$return = '';
		// The Loop
		if ( $the_query->have_posts() ) {
			$slider =true;
			$slider_id = $this->get_unique_id();
			if ($the_query->found_posts == 1) {
				$slider = false;

			}
			if ($slider) {
				$return .= '<div class="c5-main-slider slider-'.$slider_id.'">';
			}


			while ( $the_query->have_posts() ) {
				$the_query->the_post();

				$return .= '<div class="banner-slide">' . do_shortcode('[c5ab_template id="'.get_the_ID().'"]') . '</div>';


			}
			if ($slider) {
				$return .= '</div>';
			}

			$this->_js = " $('.slider-".$slider_id."').slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				adaptiveHeight: true,
				" .$this->slick_direction()."
				autoplay: true,
				autoplaySpeed: 7000,
			});";


		}else {
			$return = '';
		}



		/* Restore original Post Data */
		wp_reset_postdata();

		return $return;
	}



	function custom_css() {

	}



	function options() {

		$this->_options =array(
			array(
				'label' => 'Add / Rearrange the banner slides',
				'id' => 'posts',
				'type' => 'posts-search',
				'desc' => 'Add / Rearrange the banner slides.',
				'std' => '',
				'rows' => '',
				'post_type' => 'theme-banner',
				'taxonomy' => '',
				'class' => ''
			),
		);
	}

	function admin_footer_js() {
		?>
		<script  type="text/javascript" id="c5_slider_banner">
		jQuery(document).ready(function($) {

			C5AB_POSTS_SELECT_JS.init();

		});

		</script>
		<?php
	}


}




?>
