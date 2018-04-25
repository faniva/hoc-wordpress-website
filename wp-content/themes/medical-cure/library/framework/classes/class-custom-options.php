<?php
/**
*
*/
class C5_FW_CUSTOM_OPION
{

    function __construct()
    {

    }
    public function get_value($option, $status)
    {
        $value = '';

        if(class_exists( 'WooCommerce' )){
            if(is_woocommerce() || is_checkout() || is_cart() ){

                $page_id = c5_wc_get_current_page();

                if($page_id){
                    $value = get_post_meta( $page_id , $option, true);
                    if ($value!='') {
                        return $value;
                    }
                }
            }

        }

        if (is_category() || is_tax() || is_tag()) {
            $obj = get_queried_object();
            $term_id = $obj->term_id;
            $tax = $obj->taxonomy;

            $value = get_option('c5_term_meta_' . $tax . '_' . $term_id . '_' . $option);
        }elseif (is_author()) {
            $obj = get_queried_object();

            $value = get_the_author_meta('c5_term_meta_user_'.$option, $obj->ID);
        }elseif( is_single() ) {
            global $post;
            if ($status == 'on_category') {
                $tax = c5_get_post_tax($post->ID);
                $term_id = $this->get_dominaiting_category($post->ID, $tax);
                $value = get_option('c5_term_meta_' . $tax . '_' . $term_id . '_' . $option);
            }else {
                $value = get_post_meta( $post->ID , $option, true);
            }
        }elseif (is_page()) {
            global $post;
            $value = get_post_meta( $post->ID , $option, true);
        }
        return $value;
    }
    public function get_custom_value($option)
    {
        $value = 'off';
        if(class_exists( 'WooCommerce' )){
            if(is_woocommerce() || is_checkout() || is_cart() ){

                $page_id = c5_wc_get_current_page();

                if($page_id){
                    $value = get_post_meta( $page_id , $option, true);
                    if ($value =='on') {
                        return $value;
                    }
                }
            }

        }
        if (is_category() || is_tax() || is_tag()) {
            $obj = get_queried_object();
            $term_id = $obj->term_id;
            $tax = $obj->taxonomy;

            $value = get_option('c5_term_meta_' . $tax . '_' . $term_id . '_' . $option);
            if ($value == 'on') {
                return 'on';
            }
        }elseif (is_author()) {
            $obj = get_queried_object();

            $value = get_the_author_meta('c5_term_meta_user_'.$option, $obj->ID);
            if ($value == 'on') {
                return 'on';
            }
        }elseif( is_single()) {
            global $post;
            $post_id = $post->ID;

            $value = get_post_meta( $post_id , $option, true);
            if ($value == 'on') {
                return 'on';
            }
            $type = get_post_type($post->ID);
            $use_parent = 'off';

            if ($type == 'post') {
                $use_parent = ot_get_option('posts_styling');
            } else {
                $post_type_id = $this->get_cpt(get_post_type($post_id));
                if($post_type_id){
                    $use_parent = get_post_meta($post_type_id, 'posts_styling' , true) ;
                }
            }
            $test_skin = get_post_meta($post_id, 'skin_default' , true);
            if ($use_parent == 'on' && !$this->is_valid_skin($test_skin)) {
                $tax = c5_get_post_tax($post_id);
                if ($tax != '') {
                    $term_id = $this->get_dominaiting_category($post_id, $tax);
                    if ($term_id != '') {
                        $value = get_option('c5_term_meta_' . $tax . '_' . $term_id . '_' . $option);
                        if ($value == 'on') {
                            return 'on_category';
                        }
                    }
                }
            }
        }elseif(is_page()){
            global $post;
            $post_id = $post->ID;

            $value = get_post_meta( $post_id , $option, true);
            if ($value == 'on') {
                return 'on';
            }
        }
        return $value;
    }

    function get_dominaiting_category($post_id, $tax){

        $category_follow = get_post_meta( $post_id , 'category_follow', true);
        if ($category_follow != '') {
            return $category_follow;
        }
        $terms = wp_get_post_terms($post_id, $tax);
        if (count($terms) != 0) {
            foreach ($terms as $term) {
                return $term->term_id;
            }
        }
        return '';
    }
    function get_option($option){
        global $c5_fw_options;
        if (empty($c5_fw_options)) {
            $c5_fw_options = array();
        }

        if (isset($c5_fw_options[$option]) && $c5_fw_options[$option] != '') {
            return $c5_fw_options[$option];
        }

        global $c5_appearance_options;
        if (empty($c5_appearance_options)) {
            $c5_appearance_options = array();
            $c5_appearance_options = apply_filters( 'c5_appearance_options', $c5_appearance_options );
        }
        if (in_array($option, $c5_appearance_options)) {
            $status = $this->get_custom_value('use_custom_colors');
            if($status == 'on' || $status == 'on_category'){
                $c5_fw_options[$option] =  $this->get_value($option,$status);
                return $c5_fw_options[$option];
            }
        }

        global $c5_layout_options;
        if (empty($c5_layout_options)) {
            $c5_layout_options = array();
            $c5_layout_options = apply_filters( 'c5_layout_options', $c5_layout_options );
        }


        if (in_array($option, $c5_layout_options)) {

            $status = $this->get_custom_value('use_custom_layout');
            if($status == 'on' || $status == 'on_category'){

                $c5_fw_options[$option] =  $this->get_value($option,$status);
                return $c5_fw_options[$option];
            }
        }
        return '';
    }

    public function is_valid_skin($id)
    {
        $found = $this->is_valid($id, 'skin');

        return $found;
    }


    public function is_valid($id, $post_type)
    {
        if ($id == '') {
            return false;
        }
        $found = false;
        $skin_query = new WP_Query( 'p=' . $id . '&post_type='.$post_type );

        // The Loop
        if ( $skin_query->have_posts() ) {
            $found = true;
        }
        wp_reset_postdata();

        return $found;
    }

    function get_cpt($slug) {
        $args = array(
            'post_type' => 'cpt',
            'meta_key' => 'slug',
            'meta_value' => $slug
        );
        $id = false;
        $the_query = new WP_Query( $args );
        // The Loop
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $id = get_the_ID();
            }
        }
        wp_reset_postdata();
        return $id;
    }
}

function c5_fw_get_custom_option($option)
{
    $obj = new C5_FW_CUSTOM_OPION();
    return $obj->get_option($option);

}

?>
