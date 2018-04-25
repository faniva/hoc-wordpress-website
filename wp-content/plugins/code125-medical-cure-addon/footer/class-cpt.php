<?php

class CODE125_FOOTER_CPT {
    function __construct() {

    }
    function hook() {
        add_action( 'init', array($this , 'register_post_type') );
        add_filter('c5ab_setting_post_types' , array($this , 'add_page_builder'));

    }
    public function add_page_builder($options)
    {
        if (!is_array($options)) {
            $options = array('theme-footer');
        }else{
            $options[] = 'theme-footer';
        }
        return $options;
    }


    function register_post_type() {
        $labels = array(
            'name'               => __( 'Footers', 'code125' ),
            'singular_name'      => __( 'Footer', 'code125' ),
            'menu_name'          => __( 'Footer', 'code125' ),
            'name_admin_bar'     => __( 'Footer', 'code125' ),
            'add_new'            => __( 'Add New', 'code125' ),
            'add_new_item'       => __( 'Add New Footer', 'code125' ),
            'new_item'           => __( 'New Footer', 'code125' ),
            'edit_item'          => __( 'Edit Footer', 'code125' ),
            'view_item'          => __( 'View Footer', 'code125' ),
            'all_items'          => __( 'All Footers', 'code125' ),
            'search_items'       => __( 'Search Footers', 'code125' ),
            'parent_item_colon'  => __( 'Parent Footers:', 'code125' ),
            'not_found'          => __( 'No Footers found.', 'code125' ),
            'not_found_in_trash' => __( 'No Footers found in Trash.', 'code125' )
        );

        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'theme-footer' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title','editor')
        );

        register_post_type( 'theme-footer', $args );

    }

}
$obj = new CODE125_FOOTER_CPT();
$obj->hook();

?>
