<?php

class C5AB_featured_staff extends C5_Widget {


    public  $_shortcode_name;
    public  $_shortcode_bool = true;
    public  $_options =array();

    function __construct() {

        $id_base = 'featured-staff-widget';
        $this->_shortcode_name = 'c5_featured_staff';
        $name = 'Featured Staff';
        $desc = 'Show a Featured Staff "Usually in Sidebar".';
        $classes = '';

        $this->self_construct($name, $id_base , $desc , $classes);

    }


    function shortcode($atts,$content) {



        $args = array( );
        $args['post__in'] = explode(',', $atts['posts']);
        $args['ignore_sticky_posts'] = true;
        $args['orderby'] = 'post__in';
        $args['post_type'] = 'staff';

        // The Query
        $the_query = new WP_Query( $args );
        $return = '';
        // The Loop
        if ( $the_query->have_posts() ) {

            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $current_post = $the_query->current_post;

                $return = '<div class="code125-staff-sidear">';
                $image_size = c5ab_generate_image_size(335, 9999, false);
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
                    $return .= '<figure class="c5-staff-member-img"><a href="'.get_permalink().'">';
                    $return .= '<img src="'.$src.'" srcset="'.$src_set.'" alt="'.get_the_title().'" />';
                    $return .= '</a></figure>';
                }
                $return .= '<div class="staff-info"><h4><a href="'.get_permalink().'">'.get_the_title().'</a></h4>';
                $department = get_post_meta(get_the_ID() , 'departement' , true);
                $departement_link = get_post_meta(get_the_ID() , 'departement_link' , true);
                if ($department != '') {
                    $return .= '<span><a href="'.$departement_link.'" class="c5-staff-department">' . $department . '</a></span>';
                }
                $return .= '</div>';
                if ($atts['phone']!='') {
                    $return .= '<p class="phone"><span class="fa fa-phone"></span> '.$atts['phone'].'</p>';
                }

            }
        }else {
            $return = '';
        }

        /* Restore original Post Data */
        wp_reset_postdata();

        return $return;
    }

    function custom_css() {

    }

    function custom_js() {

    }



    function options() {

        $this->_options =array(
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
            array(
                'label' => 'Phone Number',
                'id' => 'phone',
                'type' => 'text',
                'desc' => 'Add Phone Number.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
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
