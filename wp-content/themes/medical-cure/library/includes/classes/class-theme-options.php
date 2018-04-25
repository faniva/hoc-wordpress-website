<?php

class C5_theme_option_build extends C5_theme_option_elements{


    function __construct() {

    }
    function hook_theme_options() {
        add_filter('c5_theme_sections', array($this, 'build_sections'), 1);
        add_filter('c5_theme_options', array($this, 'build_options'), 1);

        add_filter('c5_appearance_options' ,array($this, 'appearance_options'));
        add_filter('c5_layout_options', array($this, 'layout_options'));

    }
    function appearance_options($options){

        $all_options = $this->get_colors_options('');
        foreach ($all_options as $option) {
            $options[] = $option['id'];
        }
        return $options;
    }
    function layout_options($options){
        $all_options = $this->get_layout_options('');
        foreach ($all_options as $option) {
            $options[] = $option['id'];
        }
        return $options;
    }
    function build_sections ($sections) {
        if (!is_array($sections)) {
            $sections = array();
        }
        $sections[] = array(
            'title' => 'Website Logo',
            'id' => 'logo'
        );
        $sections[] = array(
            'title' => 'General',
            'id' => 'general_default'
        );

        $sections[] = array(
            'title' => 'Header ',
            'id' => 'header_settings'
        );
        $sections[] = array(
            'title' => 'Layout ',
            'id' => 'layout_settings'
        );
        $sections[] = array(
            'title' => 'Blog ',
            'id' => 'blog_settings'
        );

        $sections[] = array(
            'title' => 'Article',
            'id' => 'article'
        );

        $sections[] = array(
            'title' => 'Colors',
            'id' => 'color_settings'
        );

        $sections[] = array(
            'title' => 'Fonts',
            'id' => 'font_settings'
        );

        $sections[] = array(
            'title' => 'Default Templates',
            'id' => 'default_templates'
        );

        $sections[] = array(
            'title' => 'Social API',
            'id' => 'social'
        );

        $sections[] = array(
            'title' => 'Search',
            'id' => 'search'
        );

        $sections[] = array(
            'title' => 'Sidebars',
            'id' => 'sidebars'
        );

        $sections[] = array(
            'title' => 'Menu Locations',
            'id' => 'menus'
        );

        $sections[] = array(
            'title' => 'Custom Fonts ',
            'id' => 'fonts'
        );

        $sections[] = array(
            'title' => 'Footer ',
            'id' => 'footer'
        );
        $order = 1;
        foreach ($sections as $key => $section) {
            if (!isset($section['order'])) {
                $sections[$key]['order'] = $order;
            }
            $order++;
        }


        return $sections;

    }
    function build_options($options) {

        if (!is_array($options)) {
            $options = array();
        }

        $options = $this->add_options( $options, $this->get_logo_options('logo') );
        $options = $this->add_options( $options, $this->get_default_options('general_default') );

        $options = $this->add_options( $options, $this->get_default_blog('blog_settings') );
        $options = $this->add_options( $options, $this->get_layout_options('layout_settings') );

        $options = $this->add_options( $options, $this->get_header_options('header_settings') );

        $options = $this->add_options( $options, $this->get_colors_options('color_settings') );
        $options = $this->add_options( $options, $this->get_fonts_options('font_settings') );

        $options = $this->add_options( $options, $this->get_templates_options('default_templates') );
        $options = $this->add_options( $options, $this->get_social_options('social') );
        $options = $this->add_options( $options, $this->get_articles_options('article') );
        $options = $this->add_options( $options, $this->get_search_options('search') );
        $options = $this->add_options( $options, $this->get_sidebars_options('sidebars') );
        $options = $this->add_options( $options, $this->get_menu_locations_options('menus') );
        $options = $this->add_options( $options, $this->get_custom_fonts_options('fonts') );

        $options = $this->add_options( $options, $this->get_footer_options('footer') );


        return $options;


    }
}
$theme_options = new C5_theme_option_build();
$theme_options->hook_theme_options();

?>
