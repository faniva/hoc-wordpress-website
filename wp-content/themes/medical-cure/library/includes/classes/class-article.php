<?php

class C5_Article {

	function get_social_li($class = '', $num = 0, $text='', $link='') {
		$data = '<liclass="'.$class.'">';
		if($link!=''){
			$data .='<a href="'. esc_url($link) .'" rel="nofollow" target="_blank">';
		}
		if ($num!='') {
			$data .='<span class="num">'.$this->custom_number_format( $num ) .'</span>';
		}
		$data .='<span class="text">'.$text.'</span>';
		if($link!=''){
			$data .='</a>';
		}
		$data .='</li>';
		return $data;
	}
	function custom_number_format($n) {

	        $precision = 1;

	        if ($n < 1000) {
	            $n_format = round($n);
	        } else if ($n < 1000000) {
	            $n_format = round($n / 1000, $precision) . 'K';
	        } else {
	            $n_format = round($n / 1000000, $precision) . 'M';
	        }

	        return $n_format;
	    }

	function get_featured_media_without_photo() {
		$data = '';
        $width = $GLOBALS['c5_content_width'];
        $height = round($width * 9 / 16);

        $min_height = $height + 60;
        $format = get_post_format();
		$meta_attachment = get_post_meta(get_the_ID(), 'meta_attachment', true);
        if ($format == 'video') {
            $data .= do_shortcode('[c5ab_video url="' . $meta_attachment . '" width="100%" height="' . $height . '" ]');
        } elseif ($format == 'audio') {
            $data .= do_shortcode('[c5ab_audio url="' . $meta_attachment . '" ]');
        }else {
            if($meta_attachment!=''){
            	$link = explode('/', $meta_attachment);

            	if($link[2]=='twitter.com'){
            		$data .= do_shortcode('[c5ab_tweet link="'.$meta_attachment.'" ]');
            	}elseif($link[2]=='instagram.com'){
            		if($width == 700){
            			$width = 500;
            		}
            		$width = $GLOBALS['c5_content_width'];
            		$data .=   '<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-version="4" style="max-width:'.$width.'px;"><a href="'. esc_url($meta_attachment).'"  target="_top"></a></blockquote><script async defer src="//platform.instagram.com/en_US/embeds.js"></script>';

            		$GLOBALS['c5_content_width'] = $width;
            	}elseif($link[2]=='www.facebook.com'){
            		if($width == 700){
            			$width = 500;
            		}
            		$width = $GLOBALS['c5_content_width'];
            		$GLOBALS['c5_content_width'] = round($GLOBALS['c5_content_width']*0.7);

            		$data .=   do_shortcode('[c5ab_facebook_post url="'.$meta_attachment.'" width="'.$width.'"]');

            		$GLOBALS['c5_content_width'] = $width;
            	}

            }
        }
        $return = '';
		if ($data != '') {
			$return = '<div class="c5-featured-media-warp layout-2 clearfix">' . $data . '</div>';
		}
        echo $return;
	}
	function get_featured_media() {
	        $data = '';
	        $width = $GLOBALS['c5_content_width'];
	        $height = round($width * 9 / 16);

	        $min_height = $height + 60;
	        $format = get_post_format();
			$meta_attachment = get_post_meta(get_the_ID(), 'meta_attachment', true);
	        if ($format == 'video') {
				if ($meta_attachment!='') {
					$data .= do_shortcode('[c5ab_video url="' . $meta_attachment . '" width="100%" height="' . $height . '" ]');
				}
	        } elseif ($format == 'audio') {
				if ($meta_attachment!='') {
					$data .= do_shortcode('[c5ab_audio url="' . $meta_attachment . '" ]');
				}
	        }else {
	            if($meta_attachment!=''){
	            	$link = explode('/', $meta_attachment);

	            	if($link[2]=='twitter.com'){
	            		$data .= do_shortcode('[c5ab_tweet link="'.$meta_attachment.'" ]');
	            	}elseif($link[2]=='instagram.com'){
	            		$data .=   do_shortcode('[embed url="'.$meta_attachment.'"]');
	            	}elseif($link[2]=='www.facebook.com'){
	            		if($width == 700){
	            			$width = 500;
	            		}
	            		$width = $GLOBALS['c5_content_width'];
	            		$GLOBALS['c5_content_width'] = round($GLOBALS['c5_content_width']*0.7);
	            		$data .=   do_shortcode('[c5ab_facebook_post url="'.$meta_attachment.'" width="'.$width.'"]');

	            		$GLOBALS['c5_content_width'] = $width;
	            	}

	            }else {
	            	$image_size = c5ab_generate_image_size($width, $height, true);

	            	$data .=  $this->get_featured_image( $image_size , '');
	            }
	        }

	        return $data;
	    }

		function get_featured_image($image_size , $html = '') {
	        $return = '';
	        $img_html = get_the_post_thumbnail(get_the_ID(), $image_size);
	        if ($img_html != '') {
	            $attachment_id = get_post_thumbnail_id( get_the_ID() );
	            $image_attributes = c5_wp_get_attachment_image_src( $attachment_id , $image_size);


	            $min_height = 100;
	            if( $image_attributes ){
	                $min_height = $image_attributes[2];
	            }
				$post_object = new C5_post();
	            $image_id = $post_object->get_unique_id();
	            $return .= '<div class="c5-img"><div id="image-'.$image_id.'" class="c5-thumb-hover   clearfix" style="min-height:'.$min_height.'px;">'.$html;

	            $css = $post_object->background_css( '#image-'.$image_id  , array($image_attributes[0] , $image_attributes[3] ));
	            $post_object->echo_css($css);

	            $return .= '<div class="img-wrap"><span class="line top-line"></span><span class="line bottom-line"></span><span class="line left-line"></span><span class="line right-line"></span></div>';

	            $return .= '</div></div>';
	        }

	        return $return;
	    }

	function read_next() {
		?>
		<div class="c5-post-pager">
		<?php
			$prev_post = get_previous_post();
			if (!empty( $prev_post )){
				$icon = 'left';
				if (is_rtl()) {
					$icon = 'right';
				}
				?>
				<div class="c5-bd-pager-left">
		            <a href="<?php echo get_permalink( $prev_post->ID ); ?>">
		                <span class="fa fa-angle-<?php echo $icon; ?>"></span>
		                <span><?php  esc_html_e('Previous Post', 'medical-cure'); ?></span>
		            </a>
		            <i><?php echo $prev_post->post_title; ?></i>
		        </div>
			<?php }

			$next_post = get_next_post();
			if (!empty( $next_post )){
				$icon = 'right';
				if (is_rtl()) {
					$icon = 'left';
				}
				?>
				<div class="c5-bd-pager-right">
		            <a href="<?php echo get_permalink( $next_post->ID ); ?>">
						<span><?php  esc_html_e('Next Post', 'medical-cure'); ?></span>
		                <span class="fa fa-angle-double-<?php echo $icon; ?>"></span>
		            </a>
		            <i><?php echo $next_post->post_title; ?></i>
		        </div>
		<?php } ?>
		</div>
		<?php
	}
	function social_share_buttons($value = '') {
		$meta_data = '';
		if ($value=='') {
			$value = 'facebook_on,twitter_on,googleplus_on,linkedin_on';
		}
		$raw_data = explode(',', $value );

		$valid_meta_data = array();
		if(!empty($raw_data)){
		    foreach ($raw_data as $meta_data) {
		    	$single_value = explode('_', $meta_data);
		    	if (isset($single_value[1])) {
		    		if ($single_value[1]=='on') {
			    		$valid_meta_data[] = $single_value[0];
			    	}
		    	}
		    }
		}


		if (!empty($valid_meta_data)) {
			$meta_data = '<div class="c5-post-share"><ul><li>'. __('Share this', 'medical-cure').'</li>';
			$current_data = '';
			foreach ($valid_meta_data as $single_data) {

				switch ($single_data) {
					case 'facebook':
						$current_data .= '<li><a class="c5-social facebook" href="http://www.facebook.com/sharer.php?u='. urlencode(get_permalink()) .'"><span class="fa fa-facebook"></span></a></li>';

						break;

					case 'twitter':
						$current_data .= '<li><a class="c5-social twitter" href="http://twitter.com/share?text=' . get_the_title()  .'"><span class="fa fa-twitter"></span></a></li>';

						break;
					case 'googleplus':
						$current_data .= '<li><a class="c5-social google" href="http://plus.google.com/share?url='. urlencode(get_permalink())  .'"><span class="fa fa-google-plus"></span></a></li>';

						break;
					case 'linkedin':
						//linkedin
						$post_obj = new C5_post();
						$url = 'http://www.linkedin.com/shareArticle?mini=true&url='. urlencode(get_permalink()) .'&title='.get_the_title().'&summary='.$post_obj->get_the_excerpt_max_charlength(300) ;

						$current_data .= '<li><a class="c5-social linkedin" href="'.esc_url($url).'"><span class="fa fa-linkedin"></span></a></li>';
						break;
					default:
						break;
				}
			}
			if ($current_data=='') {
				return '';
			}
			$meta_data .= $current_data . '</ul></div>';
			echo $meta_data;
		}
	}
    function related_posts() {
        $post_obj = new C5_post();
        global $post;



        $related_type = $this->get_meta_option('related_type');
        $post_count = 3;
        $span = 12 / $post_count;
        $args = array(
            'post__not_in' => array($post->ID),
            'posts_per_page' => $post_count, // Number of related posts that will be shown.
            'ignore_sticky_posts' => 1
        );
        if ($related_type == 'tags') {
            $tags = wp_get_post_tags($post->ID);

            if ($tags) {
                $tag_ids = array();
                foreach ($tags as $individual_tag) {
                    $tag_ids[] = $individual_tag->term_id;
                }
                $args['tag__in'] = $tag_ids;
            } else {
                $args['orderby'] = 'rand';
            }
        } elseif ($related_type == 'category') {
            $tax = c5_get_post_tax(get_the_ID());
            $cat = $post_obj->get_dominaiting_category();
            if ($tax = 'category') {
                $args['cat'] = $cat;
            } else {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => $tax,
                        'field' => 'id',
                        'terms' => $cat
                    )
                );
            }
        } else {
            $args['orderby'] = 'rand';
        }

        // The Query
        $the_query = new WP_Query($args);

        // The Loop
        if ($the_query->have_posts()) {
			echo '<div class="c5-related-wrap  clearfix"><div class="container">';

			echo '<div class="code125-heading code125-heading-layout-3  clearfix"><h3>' . __('Related Stories', 'medical-cure') . '</h3></div>';
            $return = '<div class="row">';
            while ($the_query->have_posts()) {
                $the_query->the_post();
				$width = $GLOBALS['c5_content_width'] ;
				$GLOBALS['c5_content_width'] = 360;
                $return .= '<div class="col-sm-' . $span . '">' . $post_obj->get_post_blog_1(array()) . '</div>';
				$GLOBALS['c5_content_width'] = $width;
            }
            $return .= '</div>';
            echo $return;
			echo '</div></div>';
        }
        wp_reset_postdata();

    }

    function comment_form() {
    	comments_template();


        $commenter = wp_get_current_commenter();
        $req = get_option('require_name_email');
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $fields = array(
            'author' => '<input id="author" name="author" class="element-block " type="text" value="' .
            esc_attr($commenter['comment_author']) . '" size="30" tabindex="1" ' . $aria_req . ' placeholder="' . __('Name:', 'medical-cure') . '"  />',
            'email' => '<input id="email" name="email" class="element-block" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" tabindex="2" ' . $aria_req . ' placeholder="' . __('Email:', 'medical-cure') . '" />' .
            '</label>',
            'url' => '<input id="url" name="url" type="text" class="element-block " value="' . esc_attr($commenter['comment_author_url']) . '" size="30" tabindex="3"  placeholder="' . __('Website:', 'medical-cure') . '" />' .
            '</label >'
        );



        $defaults = array(
            'fields' => apply_filters('comment_form_default_fields', $fields),
            'id_form' => 'commentform',
            'id_submit' => 'submit',
			'class_submit' => 'btn c5-btn-theme',
            'title_reply' => '<h3>' . __('Leave a Comment', 'medical-cure') . '</h3>' ,
            'comment_notes_after' => '',
            'title_reply_to' => __('Leave a Reply to %s', 'medical-cure'),
            'cancel_reply_link' => __('Cancel reply', 'medical-cure'),
            'label_submit' => __('Post comment', 'medical-cure'),
            'comment_field' => '<textarea id="comment"  placeholder="' . __('Message..', 'medical-cure') . '" name="comment" rows="10" class="element-block  " tabindex="4" aria-required="true"></textarea>',
            'comment_notes_before' => ''
        );
		echo '<div class="c5-add-comment"><div class="c5-bd-add-c-form">';
        comment_form($defaults);
		echo '</div></div>';
    }

    function facebook_comment_form() {
    	echo '<div class="c5-facebook-comments clearfix">';


    	$facebook_color = $this->get_meta_option('facebook_color');
    	$width = $GLOBALS['c5_content_width'] ;
    	?>
    	<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="<?php echo $width ?>" data-num-posts="5" data-colorscheme="<?php echo $facebook_color ?>"></div></div>
    	<?php
    }

    function article_author() {
    	global $post;
    	echo do_shortcode('[c5ab_authors_info author_id="'.$post->post_author.'"]');
    }

	function get_meta_option($option) {
		return ot_get_option($option);
	}

}
?>
