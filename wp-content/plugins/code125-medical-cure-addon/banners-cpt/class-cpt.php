<?php

class C5_BANNERS_CPT {
    function __construct() {

    }
    function hook() {
        add_action( 'init', array($this , 'register_post_type') );
        add_filter('c5ab_setting_post_types' , array($this , 'add_page_builder'));
        add_filter('c5_metadata_post_types_exlude' , array($this , 'meta_box'));

    }
    public function add_page_builder($options)
    {
        if (!is_array($options)) {
            $options = array('theme-banner');
        }else{
            $options[] = 'theme-banner';
        }
        return $options;
    }

    public function meta_box($post_types)
    {
        if (!is_array($post_types)) {
            $post_types = array('theme-banner');
        }else{
            $post_types[] = 'theme-banner';
        }
        return $post_types;
    }

    function register_post_type() {
        $labels = array(
            'name'               => __( 'Banners', 'code125' ),
            'singular_name'      => __( 'Banner', 'code125' ),
            'menu_name'          => __( 'Banners', 'code125' ),
            'name_admin_bar'     => __( 'Banner', 'code125' ),
            'add_new'            => __( 'Add New', 'code125' ),
            'add_new_item'       => __( 'Add New Banner', 'code125' ),
            'new_item'           => __( 'New Banner', 'code125' ),
            'edit_item'          => __( 'Edit Banner', 'code125' ),
            'view_item'          => __( 'View Banner', 'code125' ),
            'all_items'          => __( 'All Banners', 'code125' ),
            'search_items'       => __( 'Search Banners', 'code125' ),
            'parent_item_colon'  => __( 'Parent Banners:', 'code125' ),
            'not_found'          => __( 'No Banners found.', 'code125' ),
            'not_found_in_trash' => __( 'No Banners found in Trash.', 'code125' )
        );

        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'theme-banner' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title','editor')
        );

        register_post_type( 'theme-banner', $args );

    }

}
$obj = new C5_BANNERS_CPT();
$obj->hook();

?>
