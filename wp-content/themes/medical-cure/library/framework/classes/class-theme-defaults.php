<?php

class C5_THEME_DEFAULTS
{

    function __construct()
    {

    }

    public function print_theme_options_array()
    {
        $options =  array();
        $c5_theme_defaults = array();
        $options = apply_filters( 'c5_theme_options', $options );
        foreach ($options as $option) {
            if ( isset($option['id']) && isset($option['std'] )) {
                $c5_theme_defaults[$option['id']]  = $option['std'];
            }
        }
        var_export($c5_theme_defaults);
    }

    public function get_theme_defaults()
    {
        $options =  array();
        $options = apply_filters( 'c5_theme_defaults', $options );
        return $options;
    }

    public function get_option_default($option='')
    {
        $options =  $this->get_theme_defaults();
        if (isset($options[$option])) {
            return $options[$option];
        }
        return '';
    }
}

$obj = new C5_THEME_DEFAULTS();


?>
