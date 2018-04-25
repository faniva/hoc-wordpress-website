<?php

class C5_post_base extends C5_Post_Query {
	function handle_atts($atts) {

		$default_atts = array(
			'post_type' => 'post',
			'posts' => '',
			'posts_per_page' => '10',
			'offset' => '0',
			'follow' => 'off',
			'paging' => 'off',
			'orderby' => 'date',
			'order' => 'DESC',
		);
		foreach ($default_atts as $key => $value) {
			if (!isset($atts[$key])) {
				$atts[$key] = $default_atts[$key];
			}
		}
		$args = array();


		$tax_queries = array();
		if ($atts['posts'] != '') {
			$args['post__in'] = explode(',', $atts['posts']);
			$args['ignore_sticky_posts'] = true;
			$args['orderby'] = 'post__in';
			$args['post_type'] = 'any';
			$args['posts_per_page'] = -1;
			return $args;
		} else {
			$post_types = array();

			$author_id = array();
			$post_type_args = explode(',', $atts['post_type']);
			if (!empty($post_type_args)) {
				foreach ($post_type_args as $post_type_value) {
					$info = explode('#', $post_type_value);
					$post_types[] = $info[0];
					if (isset($info[2])) {
						if ($info[1] == 'author') {
							$author_id[] = $info[2];
						} else {
							$tax_queries[] = array(
								'taxonomy' => $info[1],
								'field' => 'id',
								'terms' => $info[2]
							);
						}
					}
				}
				$args['post_type'] = $post_types;

				if (!empty($author__in)) {
					$args['author__in'] = $author__in;
				}
			}
		}

		if (is_front_page()) {
			$frontpage_id = get_option('page_on_front');
			$main_news = get_post_meta($frontpage_id, 'main_news', true);
			if ($main_news != '') {
				$args['post__not_in'] = array($main_news);
			}
		} elseif (is_single()) {
			global $post;
			$args['post__not_in'] = array($post->ID);
		}
		if (!empty($tax_queries)) {
			$args['tax_query'] = $tax_queries;
		}

		if ($atts['follow'] == 'on'  && !is_single() ) {
			if (is_front_page() ||  is_home() || !is_page() ) {
				global $wp_query;
				$args = $wp_query->query_vars;
				$args['ignore_sticky_posts'] = 0;
			}
		}


		$args['posts_per_page'] = $atts['posts_per_page'];


		if ($atts['paging'] == 'on') {
			if (get_query_var('paged')) {
				$paged = get_query_var('paged');
			} elseif (get_query_var('page')) {
				$paged = get_query_var('page');
			} else {
				$paged = 1;
			}
		} else {
			$paged = 1;
		}
		// $args['offset'] = 0;
		$args['paged'] = $paged;
		if ($paged == 1) {
			$args['offset'] = $atts['offset'];
		}


		//orderby
		$order_custom = array(
			'votes_count',
			'rating_average',
			'votes_count',
			'rating_average',
			'post_views_count',
			'c5_hourly_views',
			'c5_daily_views',
			'c5_weekly_views',
			'c5_total_share',
			'c5_hourly_shares',
			'c5_daily_shares',
			'c5_weekly_shares',
		);

		if (!in_array($atts['orderby'], $order_custom)) {
			$args['orderby'] = $atts['orderby'];
		} else {
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = $atts['orderby'];
		}


		$args['order'] = $atts['order'];

		return $args;
	}

	function get_pagination($atts, $the_query) {
		if ($atts['paging'] == 'off') {
			return;
		}

		$bignum = 999999999;
		if ($the_query->max_num_pages <= 1)
		return;

		$data = '<div class="clearfix"></div><nav class="c5-post-pagination">';

		if (get_query_var('paged')) {
			$paged = get_query_var('paged');
		} elseif (get_query_var('page')) {
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}

		$prev_text = '<span class="num fa fa-angle-left"></span>';
		$next_text = '<span class="num fa fa-angle-right"></span>';
		if (is_rtl()) {
			$prev_text = '<span class="num fa fa-angle-right"></span>';
			$next_text = '<span class="num fa fa-angle-left"></span>';
		}

		$output = paginate_links(array(
			'base' => str_replace($bignum, '%#%', esc_url(get_pagenum_link($bignum))),
			'format' => '',
			'current' => $paged,
			'total' => $the_query->max_num_pages,
			'prev_text' => $prev_text,
			'next_text' => $next_text,
			'type' => 'list',
			'end_size' => 3,
			'mid_size' => 3,
			'before_page_number' => '<span class="num">',
			'after_page_number' => '</span>'
		));

		$data .= $output;
		$data .= '</nav>';


		return $data;
	}

	function get_meta_social_count() {

		$count = get_post_meta(get_the_ID(), 'c5_total_share', true);
		if ($count == '') {
			$count = 0;
		}

		$output = '<span class="fa fa-share-alt"></span><span class="c5-social-count">' . $this->custom_number_format($count) . '</span>';
		return $output;
	}

	function get_meta_rating() {

		$meta_reviews = get_post_meta(get_the_ID(), 'meta_reviews', true);
		$total_count = 0;
		$rating = 0;
		if (is_array($meta_reviews)) {
			foreach ($meta_reviews as $review) {
				$rating = $rating + $review['rating'];
				$total_count++;
			}
		}
		if ($total_count > 0) {
			$count = round($rating / $total_count);
			$output = '<div class="c5-rating-view-wrap">' . c5_review_stars($count);



			$output .= '</div>';
			return $output;
		} else {
			return '';
		}
	}

	function get_meta_views_count() {

		$count = get_post_meta(get_the_ID(), 'post_views_count', true);
		if ($count == '') {
			$count = 0;
		}

		$output = '<span class="fa fa-eye"></span><span class="c5-views">' . $this->custom_number_format($count) . '</span>';
		return $output;
	}

	function get_meta_likes_count() {
		$vote_count = get_post_meta(get_the_ID(), "votes_count", true);
		if ($vote_count == '') {
			$vote_count = 0;
		}

		$output = '<span class="c5-post-like" data-post_id="' . get_the_ID() . '" title="' . __('like', 'medical-cure') . '"><span class="fa fa-heart-o"></span><span class="count">' . $this->custom_number_format($vote_count) . '</span></span>';

		return $output;
	}

	function get_meta_comment_count() {
		$count = get_comments_number(get_the_ID());

		$fb_count = get_post_meta(get_the_ID(), 'c5_fb_comments_count', true);

		if ($fb_count == '') {
			$fb_count = 0;
		}
		$comment = $count + $fb_count;

		//        if ($comment == 0) {
		//        	$comment = __('No comments', 'medical-cure');
		//        }elseif ($comment == 1) {
		//        	$comment = __('One comment', 'medical-cure');
		//        }else {
		//        	$comment = $comment .' '. __('comments', 'medical-cure');
		//        }

		return $comment ;
	}

	function get_meta_date($choice) {
		$data = '';
		if ($choice == 'date_time') {
			$date = get_the_time(get_option('date_format') . ' ' . get_option('time_format'));
		} elseif ($choice == 'date') {
			$date = get_the_time(get_option('date_format'));
		} elseif ($choice == 'time') {
			$date = get_the_time(get_option('time_format'));
		} elseif ($choice == 'ago') {
			$date = sprintf(__('%s ago', 'medical-cure'), human_time_diff(get_the_time('U'), current_time('timestamp')));
		}elseif ($choice == 'date_ago') {
			$date = get_the_time(get_option('date_format')) . ', ' .sprintf(__('%s ago', 'medical-cure'), human_time_diff(get_the_time('U'), current_time('timestamp')));
		} else {
			return '';
		}

		if (strlen(get_the_title()) == 0) {
            $return = '<a href="'.get_permalink().'"><time class="value updated" datetime="' . get_the_time('Y-m-d') . '">' . $date . '</time></a>';
        }else{
			$return = '<time class="value updated" datetime="' . get_the_time('Y-m-d') . '">' . $date . '</time>';
		}

		return $return;
	}


	function get_title($atts) {

		if (isset($atts['c5_title']) && $atts['c5_title'] != '') {
			return '<h3 class="widget-title">'.$atts['c5_title'].'</h3>';
		}
		if ($atts['show_title'] != 'on') {
			return '';
		}
		$post_type = explode('#', $atts['post_type']);
		$code = '';
		if (count($post_type) == 3) {
			$term = get_term($post_type[2], $post_type[1]);

			$code = '[c5ab_title apperance="title-style-1" title="' . $term->name . '" font_size="20" font_weight="300" transform="normal" class="' . $post_type[1] . '-' . $post_type[2] . '" icon="' . c5_get_category_icon( $post_type[1] . '-' . $term->term_id) . '" link="' . get_term_link(intval($term->term_id), $post_type[1]) . '" id="" ]';
		}

		return do_shortcode($code);
	}

	function get_tax_class() {
		$cat_id = $this->get_dominaiting_category();
		$class = '';
		if ($cat_id) {
			$tax = c5_get_post_tax(get_the_ID());
			$class = $tax . '-' . $cat_id;
		}
		return $class;
	}
	function get_dominaiting_category() {
		$category_id = get_post_meta(get_the_ID(), 'category_follow', true);
		if ($category_id != '') {
			return $category_id;
		}

		$tax = c5_get_post_tax(get_the_ID());
		$terms = wp_get_post_terms(get_the_ID(), $tax);
		if (count($terms) != 0) {
			$category_id = $terms[0]->term_id;
			return $category_id;
		}
		return false;
	}

	function get_meta_author() {
		return '<span>'. esc_html__('Posted by: ' ,'medical-cure') .'</span> <a class="url fn" href="' . get_author_posts_url(get_the_author_meta('ID')) . '">' . get_the_author_meta('display_name') . '</a>';
	}

	function get_meta_categories() {
		$tax = c5_get_post_tax(get_the_ID());
		$terms = wp_get_post_terms(get_the_ID(), $tax);
		$data = '';
		if (count($terms) != 0) {
			foreach ($terms as $term) {
				$icon = c5_get_category_icon( $tax . '-' . $term->term_id);
				if ($icon) {
					$icon = '<span class="' . $icon . '"></span>';
				}
				$data .= '<a href="' . get_term_link(intval($term->term_id), $tax) . '" class="c5-meta-cat c5-category ' . $tax . '-' . $term->term_id . '">' . $icon . $term->name . '</a>';
			}
		}
		$data .= '';
		return $data;
	}



	function get_authors_array($tag_id) {
		$array = array();
		$array[] = array(
			'label' => 'All Authors',
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

		$ret_array = array(
			'label' => 'Author',
			'id' => $tag_id,
			'type' => 'select',
			'desc' => 'Choose the Certain Authors',
			'std' => '',
			'choices' => $array,
			'rows' => '',
			'post_type' => '',
			'taxonomy' => '',
			'class' => '',
		);
		return $ret_array;
	}

	function get_tags_array($tag_id) {

		$ret_array = array(
			'label' => 'Tag Select',
			'id' => $tag_id,
			'type' => 'tag-select',
			'desc' => 'Choose the tag to follow or leave blank',
			'std' => '',
			'rows' => '',
			'post_type' => '',
			'taxonomy' => '',
			'class' => '',
		);
		return $ret_array;
	}

	function get_posts_input_array($tag_id) {

		$ret_array = array(
			'label' => 'Select Certain Posts',
			'id' => $tag_id,
			'type' => 'text',
			'desc' => 'Add Posts IDs seperated with comma ",", Example: 4,5,10',
			'std' => '',
			'rows' => '',
			'post_type' => '',
			'taxonomy' => '',
			'class' => '',
		);
		return $ret_array;
	}

	function get_posts_per_page_array($tag_id, $std) {
		$ret_array = array(
			'label' => 'Number of Articles to show',
			'id' => $tag_id,
			'type' => 'numeric-slider',
			'desc' => 'Slide to select the Number of Articles to show',
			'std' => $std,
			'min_max_step' => '1,50,1',
			'rows' => '',
			'post_type' => '',
			'taxonomy' => '',
			'class' => '',
		);
		return $ret_array;
	}

	function get_posts_offset_array($tag_id, $std) {
		$ret_array = array(
			'label' => 'Articles Offset',
			'id' => $tag_id,
			'type' => 'numeric-slider',
			'desc' => 'Slide to select the Number of Articles you want to offset off the query',
			'std' => $std,
			'min_max_step' => '0,50,1',
			'rows' => '',
			'post_type' => '',
			'taxonomy' => '',
			'class' => '',
		);
		return $ret_array;
	}

	function get_time_frame_array($tag_id, $default = '') {

		$time_frame = array(
			'all' => 'All the time',
			'_hour' => 'This hour',
			'_5min' => 'Now "5 minutes range"',
		);

		$array = array();
		foreach ($time_frame as $key => $value) {
			$array[] = array(
				'label' => $value,
				'value' => $key
			);
		}

		$ret_array = array(
			'label' => 'Select Timeframe',
			'id' => $tag_id,
			'type' => 'Select',
			'desc' => 'Select Timeframe to Show Articles in',
			'std' => $default,
			'choices' => $array,
			'rows' => '',
			'post_type' => '',
			'taxonomy' => '',
			'class' => '',
		);
		return $ret_array;
	}

	function get_orderby_array($tag_id, $default = 'date') {

		$orderby = array(
			'none' => 'None',
			'id' => 'Post ID',
			'author' => 'Author',
			'title' => 'Title',
			'date' => 'Date Created',
			'modified' => 'Date Modified',
			'parent' => 'Post/Page Parent ID',
			'rand' => 'Random',
			'comment_count' => 'Number of Comments',
			'menu_order' => 'Page Order',

			'votes_count' => 'Likes Count',
			'rating_average' => 'Rating Average',
			'post_views_count' => 'Views Count',
		);

		$array = array();
		foreach ($orderby as $key => $value) {
			$array[] = array(
				'label' => $value,
				'value' => $key
			);
		}

		$ret_array = array(
			'label' => 'Order By',
			'id' => $tag_id,
			'type' => 'Select',
			'desc' => 'Order by a certain parameter',
			'std' => $default,
			'choices' => $array,
			'rows' => '',
			'post_type' => '',
			'taxonomy' => '',
			'class' => '',
		);
		return $ret_array;
	}

	function get_order_array($tag_id, $default = 'DESC') {

		$order = array(
			'ASC' => 'Ascending',
			'DESC' => 'Descending'
		);

		$array = array();
		foreach ($order as $key => $value) {
			$array[] = array(
				'label' => $value,
				'value' => $key
			);
		}

		$ret_array = array(
			'label' => 'Order',
			'id' => $tag_id,
			'type' => 'Select',
			'desc' => 'Order Direction',
			'std' => $default,
			'choices' => $array,
			'rows' => '',
			'post_type' => '',
			'taxonomy' => '',
			'class' => '',
		);
		return $ret_array;
	}

	function get_follow_array($tag_id, $default = 'off') {


		$ret_array = array(
			'label' => 'Follow Current Page query',
			'id' => $tag_id,
			'type' => 'on_off',
			'desc' => 'Follow Current Page query, if you are in category page then the query will be about this category etc.',
			'std' => $default,
			'rows' => '',
			'post_type' => '',
			'taxonomy' => '',
			'class' => ''
		);
		return $ret_array;
	}

	function get_category_array($tag_id) {

		$all_category = array();


		$args = array(
			'public' => true
		);
		$taxonomies = get_taxonomies($args);
		$all_categories = array();
		foreach ($taxonomies as $key) {
			if (!( $key == 'post_tag' || $key == 'post_format' )) {
				$categories = get_terms($key);
				foreach ($categories as $category) {
					$taxonomy_data = get_taxonomy($category->taxonomy);
					foreach ($taxonomy_data->object_type as $post_type) {
						$obj = get_post_type_object($post_type);
						if ($category->parent != 0) {
							$parent_term = get_term($category->parent, $category->taxonomy);
							$parent = $parent_term->term_taxonomy_id;
						} else {
							$parent = 0;
						}

						$all_categories[$category->term_taxonomy_id . '_' . $post_type] = array(
							'id' => $category->term_id,
							'label' => $category->name,
							'parent' => $parent,
							'post_name' => $obj->label,
							'post_type' => $post_type,
							'taxonomy' => $category->taxonomy
						);
					}
				}
			}
		}


		// this array contains all the childs
		$new_terms = array();

		foreach ($all_categories as $key => $term) {
			if ($term['parent'] != 0) {
				$new_terms[$key] = $term;
			}
		}
		$posts_local = array();
		foreach ($all_categories as $term) {
			if (!isset($posts_local[$term['post_name']])) {
				$posts_local[$term['post_name']] = $term['post_name'];
				$all_category[$term['post_type']] = $term['post_name'] . ' -> All Categories';
			}
			if ($term['parent'] == 0) {
				$all_category[$term['post_type'] . '#' . $term['taxonomy'] . '#' . $term['id']] = $term['post_name'] . ' -> ' . $term['label'];
				foreach ($new_terms as $new_term) {
					if ($new_term['parent'] == $term['id']) {


						$all_category[$term['post_type'] . '#' . $term['taxonomy'] . '#' . $new_term['id']] = $term['post_name'] . ' -> ' . $term['label'] . ' -> ' . $new_term['label'];
					}
				}
			}
		}
		$return = array();
		foreach ($all_category as $key => $value) {
			$return[] = array(
				'label' => $value,
				'value' => $key
			);
		}


		$ret_array = array(
			'label' => 'Post Type & Category',
			'id' => $tag_id,
			'type' => 'Select',
			'desc' => 'Choose the Post type and Category',
			'std' => '',
			'choices' => $return,
			'rows' => '',
			'post_type' => '',
			'taxonomy' => '',
			'class' => '',
		);
		return $ret_array;
	}









	function get_show_paging_array($tag_id, $default = 'on') {


		$ret_array = array(
			'label' => 'Enable Paging',
			'id' => $tag_id,
			'type' => 'select',
			'desc' => 'Enable Paging.',
			'choices' => array(
				array(
					'label'=>'Pagination',
					'value'=>'on'
				),
				// array(
				// 	'label'=>'Ajax Loading',
				// 	'value'=>'ajax'
				// ),
				array(
					'label'=>'No Pagination',
					'value'=>'off'
				),
			),
			'std' => $default,
			'rows' => '',
			'post_type' => '',
			'taxonomy' => '',
			'class' => 'c5_show_paging'
		);
		return $ret_array;
	}





	function get_render_type_array($id, $default) {


		$layouts  = array(
			'slider' => 'Slider',
			'blog-1' => 'Layout 1',
            'blog-2' => 'Layout 2',
            'blog-3' => 'Layout 3',
			'blog-4' => 'Layout 4',
			'blog-thumb' => 'Thumbnails (Sidebar)',
			'carousel-1' => 'Carousel Layout 1',
            'carousel-2' => 'Carousel Layout 2',
            'carousel-thumb' => 'Carousel Layout Thumbnails',
         );
        $choices = array();
        foreach ($layouts as $key => $label) {
            $choices[] = array(
                'src' => C5_LOCAL_OPTIONS_IMG_URL . 'blog/' . $key . '.png',
                'src_2x' => C5_LOCAL_OPTIONS_IMG_URL . 'blog/' . $key . '@2x.png',
                'label' => $label,
                'value' => $key
            );
        }
		$return = array(
			'label' => 'Posts Apperance',
			'id' => $id,
			'type' => 'radio-image',
			'desc' => '',
			'choices' => $choices,
			'std' => $default,
			'rows' => '',
			'post_type' => '',
			'taxonomy' => ''
		);

		return $return;
	}


	function echo_css($css= ''){
		echo '<style>'.$css.'</style>';
	}

	function background_css( $element ,  $image_data ){
		$css = '';

		$css .= $element . '{background-image:url(\'' . $image_data[0] . '\');}';
		if (isset($image_data[1]) && $image_data[1]!= '') {
			$css .= ' @media
			only screen and (-webkit-min-device-pixel-ratio: 2),
			only screen and (   min--moz-device-pixel-ratio: 2),
			only screen and (     -o-min-device-pixel-ratio: 2/1),
			only screen and (        min-device-pixel-ratio: 2),
			only screen and (                min-resolution: 192dpi),
			only screen and (                min-resolution: 2dppx) { ';
			$css .= $element . '{background-image:url(\'' . $image_data[1] . '\');}';
			$css .= '}';
		}


		return $css;
	}

	function get_unique_id() {
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < 5; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
}

?>
