<?php

class C5AB_timeline extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = false;
    public $_options = array();
    public  $_skip_title = true;
	public  $_cache_output = true;

    function __construct() {

        $id_base = 'timeline-widget';
        $this->_shortcode_name = 'c5ab_timeline';
        $name = 'Timeline';
        $desc = 'Add Timeline box .';
        $classes = '';

        $this->self_construct($name, $id_base, $desc, $classes);
    }

    function shortcode($atts, $content) {
        if (is_array($atts['c5ab_timeline_single'])) {
            $tabs = '';
            foreach ($atts['c5ab_timeline_single'] as $tab) {
                $tabs .= '<div class="code125-timeline-single clearfix">';
                    $tabs .= '<div class="timeline-meta">';
                    $tabs .= '<p class="year">' .  $tab['year'] .'</p>';
                    $tabs .= '<p class="title">'. $tab['title'] . '</p>';
                    $tabs .= '</div>' ;

                    $tabs .= '<div class="timeline-seperator"><span class="fa fa-circle-o"></span></div>';

                    $tabs .= '<div class="timeline-content"><p>'.$tab['content'].'</p></div>';
                $tabs .= '</div>';

            }
            $return = '<div class="code125-timeline-wrap clearfix">' . $tabs . '</div>' . "\n";
        }
        return $return;
    }

    function options() {

        $this->_options = array(
            array(
                'label' => 'Add Timeline Element',
                'id' => 'c5ab_timeline_single',
                'type' => 'list-item',
                'desc' => 'Add Timeline Element to the timeline.',
                'settings' => array(
                    array(
                        'label' => 'Year',
                        'id' => 'year',
                        'type' => 'text',
                        'desc' => 'Timeline Element Year',
                        'std' => '2016',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => ''
                    ),
                    array(
                        'label' => 'Timeline Content',
                        'id' => 'content',
                        'type' => 'textarea-simple',
                        'desc' => 'Timeline Element Content.',
                        'std' => '',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => '',
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
