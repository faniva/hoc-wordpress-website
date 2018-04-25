<?php

class C5_STAFF_CPT {
    function __construct() {

    }
    function hook() {
        add_action( 'init', array($this , 'register_post_type') );
        add_filter('c5_metadata_post_types_exlude' , array($this , 'meta_box'));

    }

    public function meta_box($post_types)
    {
        if (!is_array($post_types)) {
            $post_types = array('staff');
        }else{
            $post_types[] = 'staff';
        }
        return $post_types;
    }

    function register_post_type() {
        $labels = array(
            'name'               => __( 'Staff', 'code125' ),
            'singular_name'      => __( 'Staff', 'code125' ),
            'menu_name'          => __( 'Staff', 'code125' ),
            'name_admin_bar'     => __( 'Staff', 'code125' ),
            'add_new'            => __( 'Add New', 'code125' ),
            'add_new_item'       => __( 'Add New Staff', 'code125' ),
            'new_item'           => __( 'New Staff', 'code125' ),
            'edit_item'          => __( 'Edit Staff', 'code125' ),
            'view_item'          => __( 'View Staff', 'code125' ),
            'all_items'          => __( 'All Staff', 'code125' ),
            'search_items'       => __( 'Search Staff', 'code125' ),
            'parent_item_colon'  => __( 'Parent Staff:', 'code125' ),
            'not_found'          => __( 'No Staff found.', 'code125' ),
            'not_found_in_trash' => __( 'No Staff found in Trash.', 'code125' )
        );

        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'staff' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor',  'thumbnail')
        );

        register_post_type( 'staff', $args );

    }

}
$obj = new C5_STAFF_CPT();
$obj->hook();

?>
