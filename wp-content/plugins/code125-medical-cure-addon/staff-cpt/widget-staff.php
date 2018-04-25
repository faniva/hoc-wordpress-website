<?php

class C5AB_staff extends C5_Widget {


    public  $_shortcode_name;
    public  $_shortcode_bool = true;
    public  $_options =array();

    public $temp_width;

    function __construct() {

        $id_base = 'staff-widget';
        $this->_shortcode_name = 'c5_staff';
        $name = 'Staff';
        $desc = 'Show the staff added in Post Type "Staff".';
        $classes = '';

        $this->self_construct($name, $id_base , $desc , $classes);

    }


    function shortcode($atts,$content) {



        $args = array( );
        $args['post__in'] = explode(',', $atts['posts']);
        $args['ignore_sticky_posts'] = true;
        $args['orderby'] = 'post__in';
        $args['post_type'] = 'staff';
        $column_span = false;
        $count = 3;
        $class= '';
        if (strpos($atts['layout'], 'column') !== false) {
            $column_span = true;
        }else{
            $class= 'code125-staff-carousel';
        }

        $atts['layout'] = str_replace('columns','',$atts['layout']);
        $atts['layout'] = str_replace('column','',$atts['layout']);
        $atts['layout'] = str_replace('carousel','',$atts['layout']);
        $atts['layout'] = str_replace('-','',$atts['layout']);
        $count = is_numeric($atts['layout']) ? $atts['layout'] : 3 ;
        $span = 12 / $count;

        $this->temp_width = $GLOBALS['c5_content_width'];

		if ($count > 1 && $GLOBALS['c5_content_width'] > 481) {
			$GLOBALS['c5_content_width'] = round($GLOBALS['c5_content_width']/$count);
		}
        // The Query
        $the_query = new WP_Query( $args );
        $id = $this->get_unique_id();

        // The Loop
        if ( $the_query->have_posts() ) {
            $return = '<div class="code125-staff-common '.$class.' clearfix code125-staff-'.$id.'">';
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $current_post = $the_query->current_post;
                if ($column_span && $current_post%$count == 0) {
                    $return .= '<div class="row">';
                }
                if ($column_span) {
                    $return .= '<div class="col-sm-'.$span.'">';
                }
                switch ($atts['design']) {
                    case 'layout-1':
                    $return .= $this->staff_layout_1($atts);
                    break;
                    case 'layout-2':
                    $return .= $this->staff_layout_2($atts);
                    break;
                    case 'layout-3':
                    $return .= $this->staff_layout_3($atts);
                    break;
                    case 'layout-4':
                    $return .= $this->sidebar($atts);
                    break;
                }
                if ($column_span) {
                    $return .= '</div>';
                }
                if ($column_span) {
                    if ($current_post%$count == ($count - 1)) {
                        $return .= '</div>';
                    }else {
        				if ($current_post  == ($the_query->found_posts -1)) {
        					$return .=  '</div>';
        				}
        			}
                }
            }
            $return .= '</div>';
        }else {
            $return = '';
        }
        $GLOBALS['c5_content_width'] = $this->temp_width;

        if (!$column_span) {
            $this->_js .= "
	            $('.code125-staff-".$id."').slick({
	              slidesToShow: ".$count.",
	              slidesToScroll: 1,
	              dots: true,
	              arrows: false,
	              infinite: false,
	              focusOnSelect: true,
	              autoplay: true,
	              autoplaySpeed: 3000,
                  ".$this->slick_direction()."
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



        /* Restore original Post Data */
        wp_reset_postdata();

        return $return;
    }


    public function phone($atts)
    {
        if ($atts['phone'] != '') {
            return '<p class="phone"><span class="fa fa-phone"></span> '.$atts['phone'].'</p>';
        }
        return '';
    }

    public function link_start($atts)
    {
        $atts['enable_link'] = isset($atts['enable_link']) ? $atts['enable_link'] : 'on';
        if ($atts['enable_link'] == 'off') {
            return '';
        }
        return '<a href="'.get_permalink().'">';
    }
    public function link_end($atts)
    {
        $atts['enable_link'] = isset($atts['enable_link']) ? $atts['enable_link'] : 'on';
        if ($atts['enable_link'] == 'off') {
            return '';
        }
        return '</a>';
    }

    public function staff_layout_2($atts)
    {
        $return = '<div class="c5-staff c5-staff-cards"><div class="c5-staff-member">';
        $image_size = c5ab_generate_image_size($GLOBALS['c5_content_width'], 9999, false);
        $attachment_id = get_post_thumbnail_id();
        $src= '';
        $src_2x = '';
        $image_attributes = c5_wp_get_attachment_image_src($attachment_id , $image_size , false );
        if ($image_attributes) {
            $src = $image_attributes[0];
            $src_2x = $image_attributes[3];
        }
        if ($src!='') {

            $src_set = $src .' 1x';
            if ($src_2x != '') {
                $src_set .= ', '.$src_2x. ' 2x';
            }
            $id = $this->get_unique_id();
            $return .= '<figure class="c5-staff-member-img">'.$this->link_start($atts).'<div class="c5-img img-'.$id.'"></div>'.$this->link_end($atts).'</figure>';
            $element = '.img-'.$id;
            $return .= '<style>';
            $return .= $element . '{background-image:url(\'' . $src . '\');}';
    		if ($src_2x!= '') {
    			$return .= ' @media
    			only screen and (-webkit-min-device-pixel-ratio: 2),
    			only screen and (   min--moz-device-pixel-ratio: 2),
    			only screen and (     -o-min-device-pixel-ratio: 2/1),
    			only screen and (        min-device-pixel-ratio: 2),
    			only screen and (                min-resolution: 192dpi),
    			only screen and (                min-resolution: 2dppx) { ';
    			$return .= $element . '{background-image:url(\'' . $src_2x . '\');}';
    			$return .= '}';
    		}
            $return .= '</style>';


        }

        $return .= '<div class="c5-staff-info">';
        $department = get_post_meta(get_the_ID() , 'departement' , true);
        $departement_link = get_post_meta(get_the_ID() , 'departement_link' , true);
        if ($department != '') {
            $return .= '<span><a href="'.$departement_link.'" class="c5-staff-department">' . $department . '</a></span>';
        }
        $return .= '<h4><a href="'.get_permalink().'">'.get_the_title().'</a></h4>';
        $subtitle = get_post_meta(get_the_ID() , 'subtitle' , true);
        if ($subtitle != '') {
            $return .= '<p>'.$subtitle.'</p>';
        }


        $social_profile = get_post_meta(get_the_ID() , 'social_profile' , true);
        $return .= '<div class="c5-staff-social"><ul>';
        foreach ($social_profile as $single_info) {

            if ($single_info['icon'] != '') {
                $return .=  '<li><a href="'. $single_info['link'] .'" title="'. $single_info['title'] .'"><span class="'. $single_info['icon'] .'"></span></a></li>';
            }

        }
        $return .= '</ul></div>';

        $return .= $this->phone($atts);

        $return .=  '</div>';

        $return .= '</div></div>';

        return $return;
    }
    public function staff_layout_1($atts)
    {
        $return = '<div class="c5-staff-layout-elegant-simplified">';

        $image_size = c5ab_generate_image_size($GLOBALS['c5_content_width'], 9999, false);
        $attachment_id = get_post_thumbnail_id();
        $src= '';
        $src_2x = '';
        $image_attributes = c5_wp_get_attachment_image_src($attachment_id , $image_size , false );
        if ($image_attributes) {
            $src = $image_attributes[0];
            $src_2x = $image_attributes[3];
        }
        if ($src!='') {
            $src_set = $src .' 1x';
            if ($src_2x != '') {
                $src_set .= ', '.$src_2x. ' 2x';
            }
            $return .= '<figure class="c5-staff-member-img">'.$this->link_start($atts);
            $return .= '<img src="'.$src.'" srcset="'.$src_set.'" alt="'.get_the_title().'" />';
            $return .= $this->link_end($atts).'</figure>';
        }

        $return .= '<div class="c5-staff-info">';

        $return .= '<h4><a href="'.get_permalink().'">'.get_the_title().'</a></h4>';

        $department = get_post_meta(get_the_ID() , 'departement' , true);
        $departement_link = get_post_meta(get_the_ID() , 'departement_link' , true);

        if ($department != '') {
            $return .= '<a href="'.$departement_link.'" class="c5-staff-department">' . $department . '</a>';
        }

        $social_profile = get_post_meta(get_the_ID() , 'social_profile' , true);
        $return .= '<div class="c5-staff-social"><ul>';
        foreach ($social_profile as $single_info) {
            if ($single_info['icon'] != '') {
                $return .=  '<li><a href="'. $single_info['link'] .'" title="'. $single_info['title'] .'"><span class="'. $single_info['icon'] .'"></span></a></li>';
            }
        }
        $return .= '</ul></div>';

        $return .= '</div>';
        $return .= $this->phone($atts);
        $return .= '</div>';

        return $return;
    }

    public function staff_layout_3($atts)
    {
        $return = '<div class="c5-staff-layout-elegant">';
        $image_size = c5ab_generate_image_size($GLOBALS['c5_content_width'], 9999, false);
        $attachment_id = get_post_thumbnail_id();
        $src= '';
        $src_2x = '';
        $image_attributes = c5_wp_get_attachment_image_src($attachment_id , $image_size , false );
        if ($image_attributes) {
            $src = $image_attributes[0];
            $src_2x = $image_attributes[3];
        }
        if ($src!='') {

            $src_set = $src .' 1x';
            if ($src_2x != '') {
                $src_set .= ', '.$src_2x. ' 2x';
            }
            $return .= '<figure class="c5-staff-member-img">'.$this->link_start($atts);
            $return .= '<img src="'.$src.'" srcset="'.$src_set.'" alt="'.get_the_title().'" />';
            $return .= $this->link_end($atts).'</figure>';

        }
        $return .= '<div class="c5-staff-info">';

        $return .= '<h4><a href="'.get_permalink().'">'.get_the_title().'</a></h4>';
        $subtitle = get_post_meta(get_the_ID() , 'subtitle' , true);
        if ($subtitle != '') {
            $return .= '<p>'.$subtitle.'</p>';
        }


        $department = get_post_meta(get_the_ID() , 'departement' , true);
        $departement_link = get_post_meta(get_the_ID() , 'departement_link' , true);
        if ($department != '') {
            $return .= '<a href="'.$departement_link.'" class="c5-staff-department">' . $department . '</a>';
        }

        $social_profile = get_post_meta(get_the_ID() , 'social_profile' , true);
        $return .= '<div class="c5-staff-social"><ul>';
        foreach ($social_profile as $single_info) {

            if ($single_info['icon'] != '') {
                $return .=  '<li><a href="'. $single_info['link'] .'" title="'. $single_info['title'] .'"><span class="'. $single_info['icon'] .'"></span></a></li>';
            }

        }
        $return .= '</ul></div>';

        $return .= '</div>';
        $return .= $this->phone($atts);
        $return .= '</div>';
        return $return;
    }
    public function sidebar($atts)
    {
        $return = '<div class="code125-staff-sidear">';
        $image_size = c5ab_generate_image_size($GLOBALS['c5_content_width'], 9999, false);
        $attachment_id = get_post_thumbnail_id();
        $src= '';
        $src_2x = '';
        $image_attributes = c5_wp_get_attachment_image_src($attachment_id , $image_size , false );
        if ($image_attributes) {
            $src = $image_attributes[0];
            $src_2x = $image_attributes[3];
        }
        if ($src!='') {

            $src_set = $src .' 1x';
            if ($src_2x != '') {
                $src_set .= ', '.$src_2x. ' 2x';
            }
            $return .= '<figure class="c5-staff-member-img">'.$this->link_start($atts);
            $return .= '<img src="'.$src.'" srcset="'.$src_set.'" alt="'.get_the_title().'" />';
            $return .= $this->link_end($atts).'</figure>';
        }
        $return .= '<div class="staff-info"><h4><a href="'.get_permalink().'">'.get_the_title().'</a></h4>';
        $department = get_post_meta(get_the_ID() , 'departement' , true);
        $departement_link = get_post_meta(get_the_ID() , 'departement_link' , true);
        if ($department != '') {
            $return .= '<span><a href="'.$departement_link.'" class="c5-staff-department">' . $department . '</a></span>';
        }

        $return .= '</div>';
        $return .= $this->phone($atts);
        $return .= '</div>';

        return $return;
    }
    function custom_css() {

    }

    function custom_js() {

    }



    function options() {
        $layouts  = array(
            'layout-1' => 'Layout 1',
            'layout-2' => 'Layout 2',
            'layout-3' => 'layout 3',
            'layout-4' => 'layout 4',
         );
        $choices = array();
        foreach ($layouts as $key => $label) {
            $choices[] = array(
                'src' => C5_OPTIONS_IMG_URL . 'staff/' . $key . '.png',
                'src_2x' => C5_OPTIONS_IMG_URL . 'staff/' . $key . '@2x.png',
                'label' => $label,
                'value' => $key
            );
        }

        $this->_options =array(
            array(
                'label' => 'Staff Layout',
                'id' => 'layout',
                'type' => 'select',
                'desc' => 'Choose staff design layout.',
                'std' => '3-columns',
                'choices' => array(
                    array(
                        'label' => '1 Column',
                        'value' => '1-column'
                    ),
                    array(
                        'label' => '2 Columns',
                        'value' => '2-columns'
                    ),
                    array(
                        'label' => '3 Columns',
                        'value' => '3-columns'
                    ),
                    array(
                        'label' => '4 Columns',
                        'value' => '4-columns'
                    ),
                    array(
                        'label' => '1 Column Carousel',
                        'value' => '1-carousel'
                    ),
                    array(
                        'label' => '2 Columns Carousel',
                        'value' => '2-carousel'
                    ),
                    array(
                        'label' => '3 Columns Carousel',
                        'value' => '3-carousel'
                    ),
                    array(
                        'label' => '4 Columns Carousel',
                        'value' => '4-carousel'
                    ),
                ),
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
			    'label' => 'Staff Design',
			    'id' => 'design',
			    'type' => 'radio-image',
			    'desc' => '',
			    'choices' => $choices,
			    'std' => 'layout-1',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
            array(
			    'label' => 'Enable Staff Page link',
			    'id' => 'enable_link',
			    'type' => 'on-off',
			    'desc' => 'Enable Staff Page link',
			    'std' => 'on',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
            array(
                'label' => 'Phone',
                'id' => 'phone',
                'type' => 'text',
                'desc' => 'Add Phone Number.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Add / Rearrange the staff members',
                'id' => 'posts',
                'type' => 'posts-search',
                'desc' => 'Add / Rearrange the staff members.',
                'std' => '',
                'rows' => '',
                'post_type' => 'staff',
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
