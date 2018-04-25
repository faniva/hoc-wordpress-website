<?php

class C5AB_posts extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();

	public $temp_width;

	function __construct() {

		$id_base = 'posts-widget';
		$this->_shortcode_name = 'c5ab_posts';
		$name = 'Posts ';
		$desc = 'Add Posts Feed to your page.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}


	function shortcode($atts,$content) {
		if (!class_exists('C5_post')) {
			return '';
		}

		$device = new C5AB_Mobile_Detect();

		if( $device->isMobile() && !$device->isTablet() ){
			if( $atts['render_type'] == 'slider-3'  || $atts['render_type'] == 'slider-4' ){
				$atts['render_type'] = 'slider_2';
			}
		}

		$allow_pagination = array(
			'blog-thmub',
			'blog-1',
			'blog-2',
			'blog-3',
			'blog-4',
		);
		if ( !in_array( $atts['render_type'], $allow_pagination )) {
			$atts['paging'] = 'off';
		}


		$post_obj = new C5_post();

		$args = $post_obj->handle_atts($atts);


		$slider_id = $this->get_unique_id();
		$atts['ID'] = $slider_id;

		// The Query
		$the_query = new WP_Query( $args );
		$return = '';
		// The Loop
		if ( $the_query->have_posts() ) {

			$return .= '<div class="c5ab_posts_'.$atts['render_type'].'  c5ab_blog_' . $slider_id . ' c5-posts-title"  ><div class="c5-load-wrap">';
			$return .= $post_obj->get_title($atts);


			if( $atts['render_type'] == 'category-1' ){
				$atts['paging'] = 'off';
			}

			$all_posts = array();

			if ($GLOBALS['c5_content_width'] < 400) {
				$count = 1;
			}elseif($GLOBALS['c5_content_width'] < 900) {
				$count = 2;
			}else{
				$count = 3;
			}

			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				switch ($atts['render_type']) {
					case 'slider':
					$return .= $post_obj->get_post_slide($atts);
					break;

					case 'category-1':
					$current_post = $the_query->current_post;
					$post_count = $the_query->post_count;
					if($current_post == 0){
						$return .= '<div class="row"><div class="col-sm-6">';
						$return .= $post_obj->get_post_thumb_tall($atts);
						$return .= '</div><div class="col-sm-6" >';
					}else {
						$return .= $post_obj->get_post_thumb($atts);
					}
					if($current_post == ( $post_count - 1) ){
						$return .= '</div></div>' ;
					}
					break;
					case 'blog-thumb';
					$return .= $post_obj->get_post_thumb($atts);
					break;
					case 'blog-1';
					$return .= $post_obj->before_layout($the_query , $count );
					$return .=  $post_obj->get_post_blog_1($atts );
					$return .= $post_obj->after_layout($the_query , $count );
					break;
					case  'blog-2':

					$return .= $post_obj->before_layout($the_query , $count );
					$return .=  $post_obj->get_post_blog_2($atts );
					$return .= $post_obj->after_layout($the_query , $count );
					break;
					case  'blog-3':
					$return .=  $post_obj->get_post_blog_3($atts );
					break;
					case  'blog-4':

					$return .= $post_obj->before_layout($the_query , $count );
					$return .= $post_obj->get_post_blog_4($atts );
					$return .= $post_obj->after_layout($the_query , $count );
					break;

					case 'carousel-1':
					$post_obj->before_width( $count );
					$return .=  $post_obj->get_post_blog_1($atts );
					$post_obj->after_width();
					break;

					case 'carousel-2':
					$post_obj->before_width( $count );
					$return .=  $post_obj->get_post_blog_2($atts );
					$post_obj->after_width();
					break;

					case 'carousel-thumb':
					$post_obj->before_width( $count );
					$return .=  $post_obj->get_post_thumb($atts );
					$post_obj->after_width();
					break;


				}

			}

			$return .=  '</div>';
			$return .= $post_obj->get_pagination($atts, $the_query);
			$return .=  '</div>';




		}else {
			$return = '<article id="post-not-found" class="hentry clearfix">
			<header class="article-header">
			<h1>'. __('No Articles to show!', 'medical-cure') .'</h1>
			</header>
			<section class="entry-content">
			<p>'. __('No articles found to show on this page.', 'medical-cure').'</p>
			</section>
			</article>';
		}

		/* Restore original Post Data */
		wp_reset_postdata();


		if( $atts['render_type'] == 'slider' ){
			$this->_js .= '
			var responsive_viewport = $(window).width();
			var slider_width = responsive_viewport;


			$(\'.c5ab_blog_' . $slider_id . ' .c5-load-wrap\' ).slick({
				'.$this->slick_direction().'
				\'adaptiveHeight\' : true,
				\'autoplay\': true,
			});'. "\n";
		}

		$carousel = array(
			'carousel-thumb',
			'carousel-1',
			'carousel-2',
		);
		if ( in_array( $atts['render_type'], $carousel )) {
			$this->_js .= "
	            $('.c5ab_blog_".$slider_id." .c5-load-wrap').slick({
	              slidesToShow: ".$count.",
	              slidesToScroll: 1,
	              dots: true,
	              arrows: false,
				   " .$this->slick_direction()."
	              infinite: false,
	              focusOnSelect: true,
	              autoplay: true,
	              autoplaySpeed: 3000,
	              responsive: [
	                    {
	                      breakpoint: 768,
	                      settings: {
	                        slidesToShow: ".min($count, 2).",
	                      }
	                    },
	                    {
	                      breakpoint: 480,
	                      settings: {
	                        slidesToShow: 1,
	                      }
	                    }
	                  ]
	            });";
		}



		return $return;
	}









	function options() {
		if (!class_exists('C5_post')) {
			return '';
		}

		$post_obj = new C5_post();
		$this->_options =array(

			$post_obj->get_render_type_array('render_type' , 'blog-1'),
			$post_obj->get_follow_array('follow' , 'off'),
			$post_obj->get_posts_per_page_array('posts_per_page', '9'),
			$post_obj->get_posts_offset_array('offset' , '0'),
			array(
				'label' => 'Show Category/Author/Tag title',
				'id' => 'show_title',
				'type' => 'on_off',
				'desc' => 'Show title for the chosen Category/Author/Tag with link to the page.',
				'std' => 'off',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => ''
			),
			array(
				'label' => 'Post Type',
				'id' => 'post_type',
				'type' => 'post-type-select',
				'desc' => 'Add Different Parameters to show your posts, select by tag, category or author.',
				'std' => 'post',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => ''
			),

			$post_obj->get_orderby_array('orderby','date'),
			$post_obj->get_order_array('order','DESC'),
			array(
				'label' => 'Add Specific Articles',
				'id' => 'posts',
				'type' => 'posts-search',
				'desc' => 'Add Specific Articles to this query "Any other query will be ignored".',
				'std' => '',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => ''
			),
			$post_obj->get_show_paging_array('paging','off'),

			array(
				'label' => 'Reorder and Enable/Disable Meta Data',
				'id' => 'meta_data',
				'type' => 'meta-data',
				'desc' => 'Reorder and Enable/Disable the Meta data for you blog posts',
				'std' => 'author-image_on,author_on,time_on,category_on,comment_on,like_on',
				'choices' => array(
					array(
						'label'=>'Author',
						'icon'=>'fa fa-user',
						'value'=>'author',
						'default'=>'on'
					),
					array(
						'label'=>'Date',
						'icon'=>'fa fa-calendar-o',
						'value'=>'time',
						'default'=>'on'
					),
					array(
						'label'=>'Category',
						'icon'=>'fa fa-tags',
						'value'=>'category',
						'default'=>'on'
					),
					array(
						'label'=>'Comments',
						'icon'=>'fa fa-comment-o',
						'value'=>'comment',
						'default'=>'on'
					),
					array(
						'label'=>'Likes',
						'icon'=>'fa fa-heart-o',
						'value'=>'like',
						'default'=>'on'
					),
					array(
						'label'=>'Views',
						'icon'=>'fa fa-eye',
						'value'=>'views',
						'default'=>'on'
					),
					//			    	array(
					//			    		'label'=>'Social Share',
					//			    		'icon'=>'fa fa-share-alt',
					//			    		'value'=>'share',
					//			    		'default'=>'on'
					//			    	),
					array(
						'label'=>'Rating',
						'icon'=>'fa fa-star-o',
						'value'=>'rating',
						'default'=>'on'
					),

				),
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => ''
			),
			array(
				'label' => 'Date Format',
				'id' => 'c5_date_format',
				'type' => 'select',
				'desc' => 'Set The Date format "Normal date: 12th January, 2013" or "Ago date: 2 days ago"',
				'choices' => array(
					array(
						'label' => 'Date & Time',
						'value' => 'date_time'
					),
					array(
						'label' => 'Only Date',
						'value' => 'date'
					),
					array(
						'label' => 'Only Time',
						'value' => 'time'
					),
					array(
						'label' => 'Ago Format',
						'value' => 'ago'
					),
					array(
						'label' => 'Date then Ago Format',
						'value' => 'date_ago'
					),
				),
				'std' => 'date',
			)
		);
	}

	function admin_footer_js() {
		?>
		<script  type="text/javascript" id="c5_posts_apperance">
		jQuery(document).ready(function($) {
			C5AB_POSTS_SELECT_JS.init();
		});

		</script>
		<?php
	}


}
?>
