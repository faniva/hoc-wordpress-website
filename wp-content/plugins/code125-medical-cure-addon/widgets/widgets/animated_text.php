<?php

class C5AB_animated_texts extends C5_Widget {

    public $_shortcode_name;
    public  $_skip_title = true;
	public  $_cache_output = true;
    public $_shortcode_bool = true;
    public $_options = array();

    function __construct() {

        $id_base = 'animated-text-widget-widget';
        $this->_shortcode_name = 'c5ab_animated_text';
        $name = 'Animated Text';
        $desc = 'Add Animated Text.';
        $classes = '';

        $this->self_construct($name, $id_base, $desc, $classes);

    }


    function shortcode($atts, $content) {
        $id = $this->get_unique_id();

        $tag = $atts['tag'];
        $return = '<'.$tag . ' class="code125-animated-text-wrap code125-animated-text-'.$id.'">'.$atts['text'].' <span class="code125-animated-text"></span></'.$tag.'>';

        $strings = '[';
        foreach ($atts['c5ab_animated_text_single'] as $tab) {
            $strings .= '"'.$tab['title'].'", ';
        }
        $strings .= ']';
        $this->_js .= '$(".code125-animated-text-'.$id.' span.code125-animated-text").typed({
            strings: '.$strings.',
            typeSpeed: 0,
            loop: true,
            backDelay: 1000,
        });'. "\n";

        return $return;
    }

    function get_unique_id() {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < 5; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }




    function options() {


        $this->_options = array(
            array(
                'label' => 'Non Animated text',
                'id' => 'text',
                'type' => 'text',
                'desc' => '',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => ''
            ),
            array(
			    'label' => 'HTML Tag',
			    'id' => 'tag',
			    'type' => 'select',
			    'desc' => 'Choose HTML Tag.',
			    'choices' => array(
			        array(
			            'label' => 'Heading 1',
			            'value' => 'h1'
			        ),
                    array(
			            'label' => 'Heading 2',
			            'value' => 'h2'
			        ),
                    array(
			            'label' => 'Heading 3',
			            'value' => 'h3'
			        ),
                    array(
			            'label' => 'Heading 4',
			            'value' => 'h4'
			        ),
                    array(
			            'label' => 'Paragraph',
			            'value' => 'p'
			        ),
			    ),
			    'std' => 'h2',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
            array(
                'label' => 'Add Animated text',
                'id' => 'c5ab_animated_text_single',
                'type' => 'list-item',
                'desc' => 'Add Animated text.',
                'settings' => array(

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
