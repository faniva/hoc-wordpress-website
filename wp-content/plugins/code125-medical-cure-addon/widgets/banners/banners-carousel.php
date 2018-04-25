<?php

class C5AB_banners_carousel extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = true;
    public $_options = array();
    public  $_skip_title = true;

    function __construct() {

        $id_base = 'banner-carousel-widget';
        $this->_shortcode_name = 'c5ab_banners_carousel';
        $name = 'Banners Carousel';
        $desc = 'Add Banners Carousel.';
        $classes = '';

        if (!isset($GLOBALS['c5ab_banners_carousel_js_bool'])) {
			add_action('wp_footer', array($this, 'custom_js'), 300);
			$GLOBALS['c5ab_banners_carousel_js_bool'] = true;
		}

        $this->self_construct($name, $id_base, $desc, $classes);
    }

    function shortcode($atts, $content) {
        if (!isset($GLOBALS['c5ab_banners_carousel_js'])) {
			$GLOBALS['c5ab_banners_carousel_js'] = '';
		}

        if ($GLOBALS['c5_content_width'] < 400) {
            $count = 1;
        }elseif($GLOBALS['c5_content_width'] < 800) {
            if ($atts['column'] == '4') {
                $count = 3;
            }else{
                $count = 2;
            }
        }else{
            $count = $atts['column'];
        }
        $test_width = $GLOBALS['c5_content_width'];
        if ($count > 1) {
            $GLOBALS['c5_content_width'] = round($GLOBALS['c5_content_width']/$count);
        }

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
			if ($the_query->found_posts == 1) {
				$slider = false;
			}
			if ($slider) {
                $id = $this->get_unique_id();
				$return .= '<div class="code125-banners-carousel carousel-'.$id.'">';
			}


			while ( $the_query->have_posts() ) {
				$the_query->the_post();

				$return .= '<div class="code125-banners-carousel-single">' . do_shortcode('[c5ab_template id="'.get_the_ID().'"]') . '</div>';


			}
			if ($slider) {
				$return .= '</div>';
                $GLOBALS['c5ab_banners_carousel_js'] .= "
                    $('.carousel-".$id."').slick({
                      slidesToShow: ".$count.",
                      slidesToScroll: 1,
                      'nextArrow' : \"<button type='button' class='slick-next'><i class='fa fa-angle-right'></i></button>\",
                      'prevArrow' : \"<button type='button' class='slick-prev'><i class='fa fa-angle-left'></i></button>\",
                    });";
			}
		}else {
			$return = '';
		}

		/* Restore original Post Data */
		wp_reset_postdata();

        $GLOBALS['c5_content_width'] = $test_width;

        return $return;
    }

    public function get_content($tab)
    {

    }

    function custom_js() {
		?>
		<script  type="text/javascript">
		jQuery(document).ready(function($) {
			<?php
			if (isset($GLOBALS['c5ab_banners_carousel_js'])) {
				echo $GLOBALS['c5ab_banners_carousel_js'];
			}
			?>
		});
		</script>
		<?php
	}


    function options() {

        $this->_options = array(
            array(
			    'label' => 'Column Count',
			    'id' => 'column',
			    'type' => 'select',
			    'desc' => 'Choose Columns Count.',
			    'choices' => array(
			        array(
			            'label' => '4 Columns',
			            'value' => '4'
			        ),
                    array(
			            'label' => '3 Columns',
			            'value' => '3'
			        ),
                    array(
			            'label' => '2 Columns',
			            'value' => '2'
			        )
			    ),
			    'std' => 'layout-1',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
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
