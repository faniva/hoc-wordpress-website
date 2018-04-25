<?php

class C5_post extends C5_post_base{

    function __construct() {

    }

    function hook() {

    }


    function get_post_blog_1($atts) {

        $return = '';

        ob_start();
        post_class('code125-blog-post-common c5-blog-layout-1 clearfix');
        $class = ob_get_clean();

        $return .= '<article '.$class.'>';
        $return .= '<div class="code125-featured-media-wrap">';
        $image_size = c5ab_generate_image_size($GLOBALS['c5_content_width'], max(0.7*$GLOBALS['c5_content_width'] , 200), true);
        $return .= $this->get_featured_image($image_size);
        $return .=  $this->get_meta_categories();
        $return .= '</div>';

        $return .= '<div class="c5-data clearfix">';
        if (isset($atts['meta_data'])) {
            $atts['meta_data'] = str_replace('category_on', 'category_off', $atts['meta_data']);
        }
        $return .= $this->get_metadata($atts);

        $return .= '<header class="entry-header"><h3 class="entry-title"><a href="'.get_permalink().'" rel="bookmark" title="'.get_the_title().'">'.get_the_title().'</a></h3></header>';

        // $atts['meta_data'] = str_replace('category_on','category_off', $atts['meta_data']);
        // $return .= $this->get_metadata($atts);


        $return .= '<div class="c5-text-box">'. $this->get_the_excerpt_max_charlength(100) .'</div>';

        $return .= '</div>';

        $return .= '</article>';

        return $return;
    }

    function get_post_blog_2($atts) {

        $return = '';

        ob_start();
        post_class('code125-blog-post-common c5-blog-layout-2 clearfix');
        $class = ob_get_clean();

        $return .= '<article '.$class.'>';
        $image_size = c5ab_generate_image_size($GLOBALS['c5_content_width'], max(0.7*$GLOBALS['c5_content_width'] , 200), true);
        $return .= $this->get_featured_image($image_size);


        $return .= '<div class="c5-data clearfix">';
        $return .=  $this->get_meta_categories();

        $return .= '<header class="entry-header"><h3 class="entry-title"><a href="'.get_permalink().'" rel="bookmark" title="'.get_the_title().'">'.get_the_title().'</a></h3></header>';

        // $atts['meta_data'] = str_replace('category_on','category_off', $atts['meta_data']);
        // $return .= $this->get_metadata($atts);


        $return .= '<div class="c5-text-box">'. $this->get_the_excerpt_max_charlength(100) .'</div>';
        $return .= '</div>';

        // $return .= '<span class="c5-plus-hover"><span class="fa fa-plus"></span></span>';

        $return .= '</article>';

        return $return;
    }
    function get_post_blog_3($atts) {

        $return = '';
        $thumbnail  = !has_post_thumbnail() ? ' has-no-thumbnail' : '';
        ob_start();
        post_class('code125-blog-post-common c5-blog-layout-3 '.$thumbnail.' clearfix');
        $class = ob_get_clean();

        $return .= '<article '.$class.'>';
        $test_width = $GLOBALS['c5_content_width'];
        $GLOBALS['c5_content_width'] = round($GLOBALS['c5_content_width']/2);

        $image_size = c5ab_generate_image_size($GLOBALS['c5_content_width'], 9999, false);
        $return .= $this->get_featured_image($image_size);


        $return .= '<div class="c5-data clearfix">';
        $return .=  $this->get_meta_categories();

        $return .= '<header class="entry-header"><h3 class="entry-title"><a href="'.get_permalink().'" rel="bookmark" title="'.get_the_title().'">'.get_the_title().'</a></h3></header>';

        $return .= '<div class="c5-text-box">'. $this->get_the_excerpt_max_charlength(200) .'</div>';
        $return .= '</div>';


        $atts['meta_data'] = str_replace('category_on','category_off', $atts['meta_data']);
        $return .= $this->get_metadata($atts);

        

        $return .= '</article>';
        $GLOBALS['c5_content_width'] = $test_width;

        return $return;
    }
    function get_post_blog_4($atts) {

        $return = '';

        ob_start();
        post_class('code125-blog-post-common c5-blog-layout-4 clearfix');
        $class = ob_get_clean();

        $return .= '<article '.$class.'>';
        $image_size = c5ab_generate_image_size($GLOBALS['c5_content_width'], max(0.7*$GLOBALS['c5_content_width'] , 200), true);
        $return .= $this->get_featured_image($image_size);



        $return .= '<div class="c5-data clearfix">';
        $return .= $this->get_metadata($atts);

        $return .= '<header class="entry-header"><h3 class="entry-title"><a href="'.get_permalink().'" rel="bookmark" title="'.get_the_title().'">'.get_the_title().'</a></h3></header>';

        $return .= '<div class="c5-text-box">'. $this->get_the_excerpt_max_charlength(100) .'</div>';
        $return .= '</div>';

        $return .= '</article>';

        return $return;
    }

    public function get_post_slide($atts)
    {
        $return = '';

        ob_start();
        post_class('code125-blog-post-common c5-blog-layout-slide clearfix');
        $class = ob_get_clean();

        $return .= '<article '.$class.'>';
        $return .=  $this->get_meta_categories();

        $width = $GLOBALS['c5_content_width'];
        $height = 400;

        $image_size = c5ab_generate_image_size($width, $height, true);
        $return .= $this->get_featured_image($image_size);


        $return .= '<div class="c5-data clearfix">';
        $atts['meta_data'] = str_replace('category_on','category_off', $atts['meta_data']);
        $return .= $this->get_metadata($atts);

        $return .= '<header class="entry-header"><h3 class="entry-title"><a href="'.get_permalink().'" rel="bookmark" title="'.get_the_title().'">'.get_the_title().'</a></h3></header>';

        $return .= '</div>';




        $return .= '</article>';

        return $return;
    }


    function get_meta_slug_categories() {
        $tax = c5_get_post_tax(get_the_ID());
        $terms = wp_get_post_terms(get_the_ID(), $tax);
        $data = '';
        $counter = 1;
        if (count($terms) != 0) {
            foreach ($terms as $term) {
                $data .= '' .  $term->slug ;
                if ($counter != count($terms)) {
                    $data .= ' ';
                }
                $counter++;
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
            $image_id = $this->get_unique_id();
            $return .= '<div class="c5-img"><div id="image-'.$image_id.'" class="c5-thumb-hover   clearfix" style="min-height:'.$min_height.'px;">'.$html;

            $css = $this->background_css( '#image-'.$image_id  , array($image_attributes[0] , $image_attributes[3] ));
            $this->echo_css($css);

            $return .= '<div class="img-wrap"><a class="link" href="' . get_permalink() . '"><span class="line top-line"></span><span class="line bottom-line"></span><span class="line left-line"></span><span class="line right-line"></span></a></div>';

            $return .= '</div></div>';
        }

        return $return;
    }

    function get_post_titles($atts) {

        $return = '';

        $return .= '<article  class="c5ab_post_thumb element c5ab_posts_thumb_titles_single  clearfix">';
        if (is_rtl()) {
            $icon = 'fa fa-arrow-circle-o-left';
        } else {
            $icon = 'fa fa-arrow-circle-o-right';
        }

        $return .= '<span class="' . $icon . '"></span><a href="' . get_permalink() . '">' . get_the_title() . '</a>';

        $return .= '</article>';


        return $return;
    }
    function get_featured_media_without_photo() {
        $data = '';
        $width = $GLOBALS['c5_content_width'];
        $height = round($width * 0.4);
        if ($height< 240) {
            $height = 240;
        }


        $image_size = c5ab_generate_image_size($width, $height, true);
        $attachment_id = get_post_thumbnail_id();

        $unique_id = $this->get_unique_id();
        $min_height = $height;
        $format = get_post_format();

        if ($format == 'video') {
            $height = round( ($width-120) * 9 / 16);
            $meta_attachment = get_post_meta(get_the_ID(), 'meta_attachment', true);

            $data .=  do_shortcode('[c5ab_video url="' . $meta_attachment . '" width="100%" height="' . $height . '" ]');

        } elseif ($format == 'audio') {
            $meta_attachment = get_post_meta(get_the_ID(), 'meta_attachment', true);
            $data .= '<div id="media-'.$unique_id.'" class="c5-media-audio c5-media-common  clearfix"><div class="c5-media-common-inner">' . do_shortcode('[c5ab_audio url="' . $meta_attachment . '" ]') . '</div></div>';
        } else {
            $meta_attachment = get_post_meta(get_the_ID(), 'meta_attachment', true);
            if($meta_attachment!=''){
                $link = explode('/', $meta_attachment);
                if($link[2]=='twitter.com'){
                    $data .= '<div id="media-'.$unique_id.'" class="c5-media-twitter c5-media-common  clearfix"><div class="c5-media-common-inner">' . do_shortcode('[c5ab_tweet link="'.$meta_attachment.'" ]') . '</div></div>';
                }elseif($link[2]=='www.facebook.com'){
                    if($width == 700){
                        $width = 500;
                    }
                    $width = $GLOBALS['c5_content_width'];
                    $GLOBALS['c5_content_width'] = round($GLOBALS['c5_content_width']*0.7);
                    $data .=   '<div id="media-'.$unique_id.'" class="c5-media-facebook c5-media-common clearfix"><div class="c5-media-common-inner">' . do_shortcode('[c5ab_facebook_post url="'.$meta_attachment.'" width="'.$width.'"]') . '</div></div>';

                    $GLOBALS['c5_content_width'] = $width;
                }

            }

        }
        if($data !=''){
            $data ='<div class="clearfix">' . $data . '</div>';
        }

        return $data;
    }
    function get_featured_media() {
        $data = '';
        $width = $GLOBALS['c5_content_width'];
        $height = round($width * 0.4);
        if ($height< 240) {
            $height = 240;
        }


        $image_size = c5ab_generate_image_size($width, $height, true);
        $attachment_id = get_post_thumbnail_id();
        $src= '';
        $src_2x = '';
        $image_attributes = c5_wp_get_attachment_image_src($attachment_id , $image_size , false );
        if ($image_attributes) {
            $src = $image_attributes[0];
            $src_2x = $image_attributes[3];
        }
        $unique_id = $this->get_unique_id();

        $css = $this->background_css( '#media-'.$unique_id , array($src , $src_2x));
        $this->echo_css($css);

        $min_height = $height;
        $format = get_post_format();

        if ($format == 'gallery') {
            if (!is_single()) {
                $data.= '<div class="clearfix" style="min-height:' . $min_height . 'px;">' . get_post_gallery() . '</div>';
            }
        } elseif ($format == 'video') {
            $height = round( ($width-120) * 9 / 16);
            $meta_attachment = get_post_meta(get_the_ID(), 'meta_attachment', true);

            $data .=  do_shortcode('[c5ab_video url="' . $meta_attachment . '" width="100%" height="' . $height . '" ]');

        } elseif ($format == 'audio') {
            $meta_attachment = get_post_meta(get_the_ID(), 'meta_attachment', true);
            $data .= '<div id="media-'.$unique_id.'" class="c5-media-audio c5-media-common  clearfix"><div class="c5-media-common-inner">' . do_shortcode('[c5ab_audio url="' . $meta_attachment . '" ]') . '</div></div>';
        } elseif ($format == 'quote') {
            $quote = '';
            preg_match_all('/\<blockquote\>(.*?)\<\/blockquote\>/', get_the_content(),$matches);
            if(isset($matches[0][0])){
                $quote = $matches[0][0];
            }
            $data .= '<div id="media-'.$unique_id.'" class="c5-media-blockquote c5-media-common  clearfix"><div class="c5-media-common-inner"><div class="c5-quote"><span class="fa fa-quote-left"></span>' . $quote .'</div></div></div>';
        }else {
            $meta_attachment = get_post_meta(get_the_ID(), 'meta_attachment', true);
            if($meta_attachment!=''){
                $link = explode('/', $meta_attachment);
                if($link[2]=='twitter.com'){
                    $data .= '<div id="media-'.$unique_id.'" class="c5-media-twitter c5-media-common  clearfix"><div class="c5-media-common-inner">' . do_shortcode('[c5ab_tweet link="'.$meta_attachment.'" ]') . '</div></div>';
                }elseif($link[2]=='www.facebook.com'){
                    if($width == 700){
                        $width = 500;
                    }
                    $width = $GLOBALS['c5_content_width'];
                    $GLOBALS['c5_content_width'] = round($GLOBALS['c5_content_width']*0.7);
                    $data .=   '<div id="media-'.$unique_id.'" class="c5-media-facebook c5-media-common clearfix"><div class="c5-media-common-inner">' . do_shortcode('[c5ab_facebook_post url="'.$meta_attachment.'" width="'.$width.'"]') . '</div></div>';

                    $GLOBALS['c5_content_width'] = $width;
                }

            }else {
                $image_size = c5ab_generate_image_size($width, $height, true);

                $read_more = '';
                $data .=   $this->get_featured_image($image_size, $read_more);
            }
        }
        if($data !=''){
            $data ='<div class="clearfix">' . $data . '</div>';
        }

        return $data;
    }

    function get_post_thumb($atts) {
        $return = '';

        $class = $this->get_tax_class();


        $image_size = c5ab_generate_image_size(100, 75, true);
        $read_more = '';
        $img_html = $this->get_featured_image($image_size,$read_more);

        $classes = 'code125-blog-post-common c5-blog-layout-thumb clearfix';
        if ($img_html != '') {
            $classes .= ' has-thumb';
        }
        ob_start();
        post_class($classes);
        $class = ob_get_clean();



        $return .= '<article  '.$class.'>';

        $return .= $img_html;

        $return .= '<div class="content ">';

        $return .= '<h3 class=""><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3><div class="clearfix"></div>';

        $return .= $this->get_metadata($atts);
        $return .= '<div class="clearfix" ></div>';
        $return .= '</div></article>';

        return $return;
    }





    function has_thumbnail() {
        $attachment_id = get_post_thumbnail_id( get_the_ID() );
        if ($attachment_id == '') {
            return 'no_thumbnail';
        }else {
            return 'has_thumbnail';
        }
    }

    function show_meta($atts, $element) {
        if (isset($atts[$element]) && $atts[$element] != 'off') {
            return true;
        }
        return false;
    }


	function get_rtl_class() {
		$class = ' ';
		$c5_rtl = get_post_meta(get_the_ID() , 'c5_rtl' , true);
		if ($c5_rtl == 'on') {
			$class = ' rtl ';
		}
		return $class;
	}

    function get_metadata($atts){
        $meta_data = '';
        if (!isset($atts['meta_data'])) {
            return;
        }
        $raw_data = explode(',', $atts['meta_data'] );

        $valid_meta_data = array();
        if(!empty($raw_data)){
            foreach ($raw_data as $meta_data_single) {
                $single_value = explode('_', $meta_data_single);
                if (isset($single_value[1])) {
                    if ($single_value[1]=='on') {
                        $valid_meta_data[] = $single_value[0];
                    }
                }
            }
        }


        if (!empty($valid_meta_data)) {
            $meta_data = '<div class="c5-related-meta"><ul class="clearfix">';
            foreach ($valid_meta_data as $single_data) {
                $current_data = '';
                switch ($single_data) {
                    case 'category':

                    $current_data = $this->get_meta_categories();

                    break;

                    case 'author':
                    $current_data =  $this->get_meta_author();
                    break;
                    case 'comment':
                    $current_data =  '<a href="'.get_permalink().'#comments"><span class="fa fa-comments"></span>' . $this->get_meta_comment_count() . '</a>';

                    break;
                    case 'time':
                    $format = isset( $atts['c5_date_format']) ? $atts['c5_date_format'] : 'date' ;
                    if ($format == '') {
                        $format = 'date';
                    }
                    $current_data =  $this->get_meta_date($format);
                    break;
                    case 'tags':
                    if (has_tag()) {
                        ob_start();
                        the_tags('',', ' ,'');
                        $tags = ob_get_clean();
                        $current_data =   $tags;
                    }
                    break;

                    case 'like':

                    $str = __('Likes', 'medical-cure');

                    $current_data =  $this->get_meta_likes_count($str);
                    break;
                    case 'views':
                    $current_data =  $this->get_meta_views_count();
                    break;
                    case 'rating':
                    $current_data =  $this->get_meta_rating();
                    break;
                    case 'share':
                    //						$current_data =  $this->get_meta_social_count();
                    break;
                    default:
                    break;
                }
                if ($current_data!='') {
                    $meta_data .= '<li class="c5-meta-li-'.$single_data.' clearfix">'.$current_data.'</li>';
                }
            }
            $meta_data .= '</ul></div>';
        }




        return $meta_data;
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

    function get_read_more_button($permalink) {
        $button = '<a class="c5-read-more" href="'.$permalink.'">' . __('[ Read More ]', 'medical-cure') . '</a>';
        return $button;
    }

    function get_excerpt($atts, $charlength = 600) {
        return '<p class="c5-excerpt">' . $this->get_the_excerpt_max_charlength($charlength) . '</p>';

        return '';
    }

    function get_the_excerpt_max_charlength($charlength) {
        $excerpt = get_the_excerpt();
        $excerpt = strip_tags($excerpt);
        $data = '';
        $charlength++;

        if (mb_strlen($excerpt) > $charlength) {
            $subex = mb_substr($excerpt, 0, $charlength - 5);
            $exwords = explode(' ', $subex);
            $excut = - ( mb_strlen($exwords[count($exwords) - 1]) );
            if ($excut < 0) {
                $data .= mb_substr($subex, 0, $excut);
            } else {
                $data .= $subex;
            }
        } else {
            $data .= $excerpt;
        }

        return $data;
    }

    function get_post_featured($atts) {


        $return = '<div class="c5-post-featured"><div class="content">';

        $image_size = c5ab_generate_image_size(700, 9999, false);
        $attachment_id = get_post_thumbnail_id( get_the_ID() );
        $image_attributes = c5_wp_get_attachment_image_src( $attachment_id , $image_size);
        $return .= '<div id="featured-image-bg-'.get_the_ID().'" class="image-bg"></div>';


        $css = $this->background_css(  '#featured-image-bg-'.get_the_ID() , array($image_attributes[0], $image_attributes[3]));
        $this->echo_css($css);

        $return .= '<div class="row featured-top"><div class="col-sm-5">';
        $return .= '<div class="main-post">';

        $return .= $this->get_meta_categories();

        $return .= '<h1><a href="'.get_permalink().'">'.get_the_title().'</a></h1>';

        $atts['meta_data'] = str_replace('category_on', 'category_off', $atts['meta_data']);

        $return .= '<div class="clearfix" ></div>';

        $return .= $this->get_metadata($atts);
        $return .= '</div></div>';


        $return .= '<div class="col-sm-3"></div>';
        $return .= '<div class="col-sm-4"><div class="c5-slider-2-small-posts clearfix">';
        return $return;
    }

    function get_post_featured_small() {
        $return = '';

        $return .= '<div class="small-post">';
        $return .= $this->get_meta_categories();
        $return .= '<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';


        $return .= '</div>';

        return $return;
    }




}

$ajax_call = new C5_post();

$ajax_call->hook();
?>
