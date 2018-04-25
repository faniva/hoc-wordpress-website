<?php

class C5_cpt {

    function __construct() {
        $this->slug = 'cpt';
        $this->name = 'Add Post Type';
        $this->image = 'cpt';
        $this->supports = array( 'title' );
        add_action( 'init',  array($this, 'register_custom_posttype'));
        add_action('admin_init', array($this, 'meta_box'));

    }

    function register_custom_posttype() {
        $labels = array(
            'labels' => array(
                'name' =>  'Add Post Type',
                'singular_name' => 'Add Post Type',
                'all_items' => 'Post Types',
                'add_new' => 'Add Post Type' ,
                'add_new_item' => 'Add Post Type' ,
                'edit' => 'Edit', /* Edit Dialog */
                'edit_item' => 'Edit Post Type' ,
                'new_item' => 'Add Post Type',
                'view_item' => 'View Post Type' ,
                'search_items' => 'Search Post Types',
                'not_found' =>  'Nothing found in the Database.',
                'not_found_in_trash' => 'Nothing found in Trash',
                'parent_item_colon' => ''
            ),

            'description' => '',
            'public' => false,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'query_var' => true,
            'menu_position' => 30,
            'menu_icon' => '',
            'rewrite'	=> array( 'slug' => $this->slug,  'with_front' => false ),
            'has_archive' => $this->slug,
            'capability_type' => 'page',
            'hierarchical' => false,
            'supports' => $this->supports
        );
        register_post_type( $this->slug, $labels);
    }


    function meta_box() {

        $cpt_meta_basics = array(
            array(
                'label'       =>  'General',
                'id'          => 'general',
                'type'        => 'tab'
            ),
            array(
                'label' => 'Slug',
                'id' => 'slug',
                'type' => 'text',
                'desc' => 'Add Custom Post Type Slug.',
                'std' => 'book',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Name',
                'id' => 'name',
                'type' => 'text',
                'desc' => 'Add Custom Post Type Name & Menu label.',
                'std' => 'Books',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Singular Name',
                'id' => 'singular_name',
                'type' => 'text',
                'desc' => 'Add Custom Post Type Singular Name.',
                'std' => 'Book',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),

        );

        $meta_skins_layout = array(
            'id' => 'meta_skins',
            'title' => 'Custom Post Type Info',
            'desc' => '',
            'pages' => array('cpt'),
            'context' => 'normal',
            'priority' => 'low',
            'fields' => $cpt_meta_basics ,
            'std' => '',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => ''
        );



        $cpt_meta_basics[]=  array(
            'label'       =>  'Taxonomy',
            'id'          => 'taxonomy',
            'type'        => 'tab'
        );

        $cpt_meta_basics[]= array(
            'label' => 'Enable Taxonomy',
            'id' => 'enable_category',
            'type' => 'on_off',
            'desc' => 'Enable Category/Taxonomy',
            'std' => 'off',
        );
        $cpt_meta_basics[]= array(
            'label' => 'Category Name',
            'id' => 'category_name',
            'type' => 'text',
            'desc' => 'Add Category name"',
            'std' => 'Categories',
        );
        $cpt_meta_basics[]= array(
            'label' => 'Category Name (Singular)',
            'id' => 'category_name_singular',
            'type' => 'text',
            'desc' => 'Add Category name"',
            'std' => 'Category',
        );
        $cpt_meta_basics[]= array(
            'label' => 'Category slug',
            'id' => 'category',
            'type' => 'text',
            'desc' => 'Add Category to this custom post, add its slug here "this will be used in the url of the category page"',
            'std' => 'book_cat',
        );

        $posts_skin = array();
        $posts_skin = apply_filters( 'c5_fw_cpt_taxonomy', $posts_skin );

        $cpt_meta_basics = array_merge($cpt_meta_basics , $posts_skin);



        $page_templates = $this->get_templates_list();
        $cpt_meta_basics[] = array(
            'label' => 'Category Page template.',
            'id' => 'category_template',
            'type' => 'select',
            'desc' => 'Choose your Default Category Page template.',
            'choices'=> $page_templates,
            'std' => '',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
            'section' => 'default_templates'
        );
        $cpt_meta_basics[] = array(
            'label' => 'Enable Tags',
            'id' => 'enable_tags',
            'type' => 'on_off',
            'desc' => 'Add Tags to this post type',
            'std' => 'on',
        );
        if (class_exists('C5_theme_option_elements')) {
            $cpt_meta_basics[]=  array(
                'label'       =>  'Article',
                'id'          => 'article',
                'type'        => 'tab'
            );
            $theme_options_element = new C5_theme_option_elements();
            $cpt_meta_basics = array_merge($cpt_meta_basics , $theme_options_element->get_articles_options());




        }


        $meta_cpt_settings = array(
            'id' => 'meta_cpt_settings',
            'title' => 'Custom Post Type Settings',
            'desc' => '',
            'pages' => array('cpt'),
            'context' => 'normal',
            'priority' => 'low',
            'fields' => $cpt_meta_basics,
            'std' => '',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => ''
        );

        if (function_exists('ot_register_meta_box')) {
            ot_register_meta_box($meta_cpt_settings);
        }

    }
    function get_templates_list() {
        if (function_exists('c5_get_ab_templates')) {
            $templates = c5_get_ab_templates();
        }else{
            $templates = array();
        }

        $types_array = array();
        $types_array[] = array(
            'label'       => 'Default template',
            'value'       => ''
        );
        foreach ($templates as $key => $value) {
            $types_array[] = array(
                'label'       => $value,
                'value'       => $key
            );
        }
        return $types_array;

    }

}

$obj = new C5_cpt();

?>
