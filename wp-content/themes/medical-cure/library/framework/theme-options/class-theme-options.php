<?php

class C5_build_theme_options{


    function __construct() {

    }

    function hook_theme_options() {
        add_action('admin_init', array($this, 'build_theme_options'), 1);
    }

    function build_options() {
        $options =  array();
        $options = apply_filters( 'c5_theme_options', $options );
        return $options;
    }

    function build_sections() {
        $sections =  array();
        $sections = apply_filters( 'c5_theme_sections', $sections );
        usort($sections, array($this, 'section_order'));
        return $sections;
    }
    public function section_order($a, $b)
    {
        if (!isset($a['order'])) {
            $a['order'] = 9999;
        }
        if (!isset($b['order'])) {
            $b['order'] = 9999;
        }
        return ($a['order'] < $b['order']) ? -1 : 1;
    }

    function build_theme_options() {
        $sections = $this->build_sections();
        $options = $this->build_options();

        /**
        * Get a copy of the saved settings array.
        */
        $saved_settings = get_option('option_tree_settings', array());

        /**
        * Create a custom settings array that we pass to
        * the OptionTree Settings API Class.
        */
        $custom_settings = array(
            'contextual_help' => array(),
            'sections' => $sections,
            'settings' => $options
        );


        $c5_theme_defaults = array();
        foreach ($options as $option) {
            if (!empty($option) && isset($option['id']) ) {
                $c5_theme_defaults[$option['id']]  = $option['std'];
            }
        }
        update_option( 'c5_theme_defaults', $c5_theme_defaults );



        /* allow settings to be filtered before saving */
        $custom_settings = apply_filters('option_tree_settings_args', $custom_settings);

        /* settings are not the same update the DB */
        if ($saved_settings !== $custom_settings) {
            update_option('option_tree_settings', $custom_settings);
        }
    }
}
$obj = new C5_build_theme_options();
$obj->hook_theme_options();
?>
