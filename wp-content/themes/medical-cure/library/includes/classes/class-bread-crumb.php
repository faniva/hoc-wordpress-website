<?php

class C5_bread_crumb {

    function __construct() {

    }

    function title() {
        if(class_exists( 'WooCommerce' )){
            if(is_woocommerce() || is_checkout() || is_cart() ){

                $page_id = c5_wc_get_current_page();
                if($page_id){
                    return get_the_title($page_id);
                }
            }

        }
        if ( is_post_type_archive() ) {
            return post_type_archive_title('' , false);
        }

        if(is_single() || is_page() ){
            if (class_exists('WooCommerce')) {
                $page_id = c5_wc_get_current_page();
            }else{
                $page_id = get_the_ID();
            }
            return get_the_title($page_id);
        }elseif (is_category() || is_tag() || is_tax() ) {
            $obj = get_queried_object();
            $term_id = $obj->term_id;
            $tax = $obj->taxonomy;

            $icon = get_option( 'c5_term_meta_' . $tax .'_'. $term_id .'_icon' );
            $title = '';
            if ($icon!='') {
                $title .= '<span class="'.$icon.'"></span> ';
            }
            $tax = get_taxonomy($obj->taxonomy);
            $title .=  $obj->name;
            return $title;
        } elseif (is_search()) {
            return  __('Search results for: ','medical-cure') . $_GET['s'];
        } elseif (is_day()) {
            return  __('Day: ','medical-cure') . get_the_time('j');
        } elseif (is_month()) {
            return  __('Month: ','medical-cure') . get_the_time('F');
        } elseif (is_year()) {
            return  __('Year: ','medical-cure') . get_the_time('Y');
        } elseif (is_author()) {
            $obj = get_queried_object();
            $user = get_userdata($obj->ID);
            return $user->display_name;
        }elseif(is_404()){
            return  __('Error 404','medical-cure');
        }
    }

    function description() {
        $description = '';
        if(is_page()){
            if (class_exists('WooCommerce')) {
                $page_id = c5_wc_get_current_page();
            }else{
                $page_id = get_the_ID();
            }
            $description = get_post_meta($page_id, 'subtitle', true);
        }elseif(is_single()){
            $post_type = get_post_type();
            if ($post_type == 'staff') {
                $description = get_post_meta(get_the_ID(), 'subtitle', true);
            }elseif($post_type == 'product'){

            }else{
                $description = $this->metadata();
            }
        }elseif (is_category() || is_tag() || is_tax() ) {
            $obj = get_queried_object();
            $tax = get_taxonomy($obj->taxonomy);
            $description =  $obj->description;
        } elseif (is_author()) {
            $obj = get_queried_object();
            $user = get_userdata($obj->ID);
            $description .= $this->author_social_icons();
            $description .= $user->description;

        }
        if ($description!='') {
            return '<p class="description">'.$description.'</p>';
        }
        return '';
    }
    public function author_image()
    {
        $data = '';
        if (is_author()) {
            $obj = get_queried_object();
            $data = '<div class="c5-author-image">' . get_avatar($obj->ID, 100) . '</div>';
        }
        return $data;
    }
    public function metadata()
    {
        $data = '';
        global $post;
        setup_postdata($post);

        $post_obj = new C5_post();
        $settings_obj = new C5_theme_options();
        $atts = array();
        $atts['meta_data'] = $settings_obj->get_meta_option('article_meta_data');
        $atts['c5_date_format'] = $settings_obj->get_meta_option('article_date_format');

        $data = $post_obj->get_metadata($atts);

        wp_reset_postdata();
        return $data;

    }
    public function author_social_icons()
    {
        $obj = get_queried_object();
        $user = get_userdata($obj->ID);
        $user_ID = $obj->ID;

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
        $data = '';
        if (!empty($social_icons)) {
            $data .=  '<ul class="c5-author-social">';
            foreach ($social_icons as $icon => $link) {
                $data .=  '<li><a href="'.esc_url($link).'" target="_blank"><span class="'.$icon.'"></span></a></li>';
            }
            $data .=  '</ul>';
        }
        return $data;
    }

    function icon() {
        $icon = '';
        if (is_category() || is_tag() || is_tax() ) {
            $obj = get_queried_object();

            $icon = get_option('c5_term_meta_' . $obj->taxonomy . '_' . $obj->term_id . '_icon');
            if ($icon == '') {
                $icon = 'fa-tag';
            }
        } elseif (is_search()) {
            $icon = 'fa-search';
        } elseif (is_day()) {
            $icon = 'fa-calendar';
        } elseif (is_month()) {
            $icon = 'fa-calendar';
        } elseif (is_year()) {
            $icon = 'fa-calendar';
        } elseif (is_author()) {
            $icon = 'fa-user';
        }
        if ($icon != '') {
            return '<span class="fa '.$icon.'"></span>';
        }
        return '';
    }

    function render_author_info() {
        $obj = get_queried_object();

        echo do_shortcode('[c5ab_authors_info author_id="'.$obj->ID.'"]');

    }

    function render_without_current() {
        echo $this->breadcrumb(0);
    }
    function render() {
        echo $this->breadcrumb(1);
    }

    function breadcrumb($showCurrent = 1) {

        $data = '';

        $showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show

        $delimiter = '';

        $home = ' <span class="code125-home">'.esc_html__('Home','medical-cure').'</span> '; // text for the 'Home' link
        $before = '<span class="current">'; // tag before the current crumb
        $after = '</span>'; // tag after the current crumb

        global $post;
        $homeLink = esc_url( home_url('/') );

        if (is_home() || is_front_page()) {

            if ($showOnHome == 1)
            $data .= '<div class="c5-breadcrumb-ul"><ul><li><a href="' . esc_url($homeLink) . '">' . $home . '</a></li></ul></div>';
        } else {

            $data .= '<div class="c5-breadcrumb-ul"><ul><li><a href="' . esc_url($homeLink) . '">' . $home . '</a> ' . $delimiter . '</li>';

            if (is_category()) {
                $thisCat = get_category(get_query_var('cat'), false);
                if ($thisCat->parent != 0)
                $data .= '<li>' . get_category_parents($thisCat->parent, TRUE, '') . '</li>';
                $data .= '<li>' . $before . __('Category: "', 'medical-cure') . single_cat_title('', false) . '"' . $after . '</li>';
            } elseif (is_search()) {
                $data .= '<li>' . $before . __('Search results for "', 'medical-cure') . get_search_query() . '"' . $after . '</li>' ;
            } elseif (is_day()) {
                $data .= '<li>' . '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . '</li>';
                $data .= '<li>' . '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . '</li>';
                $data .= '<li>' . $before . get_the_time('d') . $after . '</li>';
            } elseif (is_month()) {
                $data .= '<li>' . '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter  . '</li>';
                $data .= '<li>' . $before . get_the_time('F') . $after . '</li>';
            } elseif (is_year()) {
                $data .= '<li>' . $before . get_the_time('Y') . $after . '</li>';
            } elseif (is_single() && !is_attachment()) {
                if (get_post_type() != 'post') {
                    $post_type = get_post_type_object(get_post_type());
                    $slug = $post_type->rewrite;
                    $data .= '<li><a href="' . esc_url($homeLink) . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>' . '</li>';
                    if ($showCurrent == 1)
                    $data .= '<li>' .  $delimiter . ' ' . $before . get_the_title() . $after . '</li>';

                } else {
                    $cat = get_the_category();
                    $cat = $cat[0];
                    $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                    if ($showCurrent == 0)
                    $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
                    $data .= '<li>' . $cats . '</li>';
                    if ($showCurrent == 1){
                        $data .=  '<li>' . $before . get_the_title() . $after . '</li>';
                    }
                }
            } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
                $post_type = get_post_type_object(get_post_type());
                $data .= '<li>' . $before . $post_type->labels->singular_name . $after . '</li>';
            } elseif (is_attachment()) {

            } elseif (is_page() && !$post->post_parent) {
                if (class_exists('WooCommerce')) {
                    $page_id = c5_wc_get_current_page();
                }else{
                    $page_id = get_the_ID();
                }
                if ($showCurrent == 1)
                $data .= '<li>' . $before . get_the_title($page_id) . $after . '</li>';
            } elseif (is_page() && $post->post_parent) {
                $parent_id = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i++) {
                    $data .= '<li>' . $breadcrumbs[$i];
                    if ($i != count($breadcrumbs) - 1)
                    $data .= ' ' . $delimiter . ' ';

                    $data .= '</li>';
                }
                if ($showCurrent == 1)
                $data .= '<li>' .  $delimiter . ' ' . $before . get_the_title() . $after  . '</li>';
            } elseif (is_tag()) {
                $data .= '<li>' . $before . __('Tag "', 'medical-cure') . single_tag_title('', false) . '"' . $after . '</li>';
            } elseif (is_author()) {
                global $author;
                $userdata = get_userdata($author);
                $data .= '<li>' . $before . __('Posted by ', 'medical-cure') . $userdata->display_name . $after . '</li>';
            } elseif (is_404()) {
                $data .= '<li>' . $before . __('Error 404', 'medical-cure') . $after . '</li>';
            }

            if (get_query_var('paged')) {
                if (!is_single()){
                    $data .= '<li>' . ' ( ';
                    $data .= __('Page', 'medical-cure') . ' ' . get_query_var('paged');
                    $data .= ' )' . '</li>';
                }
            }

            $data .= '</ul></div>';
        }

        return $data;
    }

}
?>
