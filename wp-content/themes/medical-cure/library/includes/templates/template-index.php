<?php global $c5_theme_data;


$class = '';
if (ot_get_option('page_width') == 'full') {
	$class = 'container';
}
?>
<div id="main" class="clearfix <?= $class ?>">
	<div class="c5-main-width-wrap clearfix">
		<?php

		if ($c5_theme_data['template_id'] != '') {
			echo do_shortcode('[c5ab_template id="' . $c5_theme_data['template_id'] . '"]');
		} else {
			$blog_type = ot_get_option('default_blog_layout' , 'blog-3');
			$post_obj = new C5_post();
			global $wp_query;
			$count = $post_obj->get_count();
			$atts = array();
			$atts['meta_data'] = 'author_on,time_on,comment_off,category_on,like_off,views_off,rating_off';
			$atts['c5_date_format'] = 'date';
			$atts['paging'] = 'on';

			if (have_posts()) {
				while (have_posts()) : the_post();

				switch ($blog_type) {
					case 'blog-1';
					echo $post_obj->before_layout($wp_query , $count );
					echo $post_obj->get_post_blog_1($atts );
					echo $post_obj->after_layout($wp_query , $count );
					break;
					case  'blog-2':

					echo $post_obj->before_layout($wp_query , $count );
					echo $post_obj->get_post_blog_2($atts );
					echo $post_obj->after_layout($wp_query , $count );
					break;
					case  'blog-3':
					echo $post_obj->get_post_blog_3($atts );
					break;
					case  'blog-4':

					echo $post_obj->before_layout($wp_query , $count );
					echo $post_obj->get_post_blog_4($atts );
					echo $post_obj->after_layout($wp_query , $count );
					break;
				}


			endwhile;

			echo '<div class="clearfix"></div>';
			echo $post_obj->get_pagination($atts, $wp_query);

		}else {
			echo '<h3>'. esc_html__( 'No Articles Found', 'medical-cure' ) .'</h3>';
			echo '<p>'. esc_html__( 'No Articles were found to match the current query.', 'medical-cure' ) .'</p>';
		}
	}

	?>
</div>


</div>
