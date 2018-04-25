<?php

class C5_theme_layout extends C5_theme_option_elements {

    function __construct() {

    }

    function template_exist($id) {
        if($id != ''){
            return true;
        }
        return false;
    }

    function get_current_template_id() {

        if (is_category() || is_tax()) {
            $obj = get_queried_object();
            $term_id = $obj->term_id;
            $tax = $obj->taxonomy;

            $value = get_option('c5_term_meta_' . $tax . '_' . $term_id . '_' . 'template');
            if ($this->template_exist($value)) {
                return $value;
            }

            $value = ot_get_option('cat_template');
            if ($this->template_exist($value)) {
                return $value;
            }
        } elseif (is_tag()) {
            $obj = get_queried_object();
            $term_id = $obj->term_id;
            $tax = $obj->taxonomy;

            $value = get_option('c5_term_meta_' . $tax . '_' . $term_id . '_' . 'template');
            if ($this->template_exist($value)) {
                return $value;
            }
            $value = ot_get_option('tag_template');
            if ($this->template_exist($value)) {
                return $value;
            }

        } elseif (is_search()) {
            $value = ot_get_option('search_template');
            if ($this->template_exist($value)) {
                return $value;
            }
        } elseif (is_author()) {
            $obj = get_queried_object();

            $value = get_the_author_meta('c5_term_meta_user_template', $obj->ID);
            if ($this->template_exist($value)) {
                return $value;
            }

            $value = ot_get_option('author_template');
            if ($this->template_exist($value)) {
                return $value;
            }
        } elseif (is_404()) {
            $value = ot_get_option('404_template');
            if ($this->template_exist($value)) {
                return $value;
            }
        } elseif (is_archive()) {
            $value = ot_get_option('archive_template');
            if ($this->template_exist($value)) {
                return $value;
            }
        }


        $value = ot_get_option('default_template');

        return $value;
    }
    function get_update_value($post_id,$option) {
        if (is_category() || is_tax() || is_tag()) {
            $obj = get_queried_object();
            $term_id = $obj->term_id;
            $tax = $obj->taxonomy;

            $value = get_option('c5_term_meta_' . $tax . '_' . $term_id . '_' . $option);
        }elseif (is_author()) {
            $obj = get_queried_object();

            $value = get_the_author_meta('c5_term_meta_user_'.$option, $obj->ID);
        }else {
            $value = get_post_meta($post_id, $option, true);
        }
        return $value;
    }
    function update_color_values($post_id = '') {
        global $c5_skindata;
        foreach ($this->get_colors_options() as $option) {
            if($option['type'] == 'background'){
                $value = $this->get_update_value($post_id, $option['id']);

                if(is_array($value)){

                    if(
                    $value['background-color'] != '' ||
                    $value['background-repeat'] != '' ||
                    $value['background-attachment'] != '' ||
                    $value['background-position'] != '' ||
                    $value['background-size'] != '' ||
                    $value['background-image'] != ''
                    ){
                        $c5_skindata[ $option['id'] ] = $value;
                    }
                }
            }else {
                $c5_skindata[ $option['id'] ] = $this->get_update_value($post_id, $option['id']);
            }
        }
    }

    function update_layout_values($post_id = '') {
        global $c5_skindata;
        foreach ($this->get_layout_options() as $option) {
            $c5_skindata[ $option['id'] ] = esc_attr( $this->get_update_value($post_id, $option['id']) );
        }
    }


    function get_current_skin() {

        global $c5_skindata;
        if (!is_array($c5_skindata)) {
            $c5_skindata = array();
        }

        $defaults_obj = new C5_THEME_DEFAULTS();
        $c5_theme_defaults = $defaults_obj->get_theme_defaults();


        foreach ($c5_theme_defaults as $id => $default) {
            $c5_skindata[$id] = ot_get_option($id, $default);
        }

        if (class_exists('Woocommerce') && is_single()) {
            if (get_post_type( get_the_ID() ) == 'product') {
                $c5_skindata['big_sidebar'] = 'shop_sidebar';
            }
        }

        $template_id = $this->get_current_template_id();

        $c5_skindata['template_id'] = $template_id;

        $GLOBALS['c5-main-width'] = c5_get_page_width();

        c5_check_mobile_width();


    }


    function get_article_rtl_class() {
        $class = '';
        $c5_rtl = get_post_meta(get_the_ID() , 'c5_rtl' , true);
        if ($c5_rtl == 'on') {
            $class = 'rtl';
        }
        return $class;
    }

    function get_article_layout() {
        $article_layout = ot_get_option('article_layout');
        if ($article_layout == '') {
            $article_layout = 'layout_2';
        }
        return $article_layout;
    }
    function build_layout($source) {
        global $c5_skindata;

        $class = 'c5-sidebar-hidden';
        switch ($c5_skindata['page_width']) {
            case 'left':
            $GLOBALS['c5_content_width'] = 780;
            $class = 'c5-sidebar-active';
            break;
            case 'right':
            $GLOBALS['c5_content_width'] = 780;
            $class = 'c5-sidebar-active';
            break;
            case 'full':
            $GLOBALS['c5_content_width'] = 1170;
            break;
            default:
            $GLOBALS['c5_content_width'] = 780;
            break;
        }
        c5_check_mobile_width();
        if (is_404()) {
            $c5_skindata['page_width'] = 'full';
        }


        if ($c5_skindata['page_width'] == 'left' || $c5_skindata['page_width'] == 'right') {
            echo '<section class="c5-main-blog">';
            echo '<div class="container"><div class="row">';
        }


        if ($c5_skindata['page_width'] == 'left') {
            $this->get_sidebar($c5_skindata['big_sidebar']);
            echo '<main class="c5-main-blog-content c5-single-content code125-sticky-content">';
            $this->get_main_content($source);
            echo '</main>';

        }elseif ($c5_skindata['page_width'] == 'right') {
            echo '<main class="c5-main-blog-content c5-single-content code125-sticky-content">';
            $this->get_main_content($source);
            echo '</main>';
            $this->get_sidebar($c5_skindata['big_sidebar']);
        }else {
            $this->get_main_content($source);
        }

        if ($c5_skindata['page_width'] == 'left' || $c5_skindata['page_width'] == 'right') {
            echo '</div></div></section>';
        }

    }

    function get_sidebar($sidebar) {
        $test = $GLOBALS['c5_content_width'];
        $GLOBALS['c5_content_width'] = 300;
        $GLOBALS['c5_sidebar_active'] = true;
        ?>
        <aside id="sidebar-<?php echo $sidebar ?>" class="c5-sidebar c5-single-content sidebar widget-area code125-sticky-content clearfix">
            <?php
            if ( is_active_sidebar( $sidebar ) ){
                dynamic_sidebar( $sidebar );
            }
            ?>
        </aside>
        <?php
        $GLOBALS['c5_content_width'] = $test;
        $GLOBALS['c5_sidebar_active'] = false;
    }

    function get_main_content($source) {

        switch ($source) {
            case 'home':
            get_template_part( 'library/includes/templates/template-index');
            break;
            case 'page':
            get_template_part( 'library/includes/templates/template-page');
            break;
            case 'woocommerce':
            get_template_part( 'library/includes/templates/template-woocommerce');
            break;
            case 'single':
            get_template_part( 'library/includes/templates/template-single');
            break;
            case 'single-staff':
            get_template_part( 'library/includes/templates/template-single-staff');
            break;
            case '404':
            get_template_part( 'library/includes/templates/template-404');
            break;

        }


    }

}
?>
