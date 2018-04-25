<?php

class C5AB_wokring_hours extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = false;
    public $_options = array();
    public  $_skip_title = true;
	public  $_cache_output = true;

    function __construct() {

        $id_base = 'wokring-hours-widget';
        $this->_shortcode_name = 'c5ab_wokring_hours';
        $name = 'Wokring Hours';
        $desc = 'Add Wokring Hours box .';
        $classes = '';

        $this->self_construct($name, $id_base, $desc, $classes);
    }

    function shortcode($atts, $content) {

        if (is_array($atts['c5ab_wokring_hours_single'])) {
            $tabs = '';
            foreach ($atts['c5ab_wokring_hours_single'] as $tab) {
                $tabs .= '<div class="code125-wokring-hours-single clearfix">';
                $tabs .= '<p class="title">' .  $tab['title'] .'</p>';
                $tabs .= '<p class="time">'. $tab['time'] . '</p>';
                $tabs .= '</div>' ;
            }
            $return = '<div class="code125-wokring_hours-wrap clearfix">' . $tabs . '</div>' . "\n";
        }
        return $return;
    }

    function options() {

        $this->_options = array(
            array(
                'label' => 'Add Wokring Hours Element',
                'id' => 'c5ab_wokring_hours_single',
                'type' => 'list-item',
                'desc' => 'Add Wokring Hours Element to the wokring_hours.',
                'settings' => array(
                    array(
                        'label' => 'Working Hours',
                        'id' => 'time',
                        'type' => 'text',
                        'desc' => 'Working Hours',
                        'std' => '08:30 - 18:00',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => ''
                    ),
                ),
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
        );
    }


}
?>
