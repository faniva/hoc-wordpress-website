<?php

class C5AB_html_element extends C5_Widget {

    public $_shortcode_name;
    public  $_skip_title = true;
	public  $_cache_output = true;
    public $_shortcode_bool = false;
    public $_options = array();

    function __construct() {

        $id_base = 'html-element-widget-widget';
        $this->_shortcode_name = 'c5ab_html_element';
        $name = 'HTML Element';
        $desc = 'Add HTML Element.';
        $classes = '';

        $this->self_construct($name, $id_base, $desc, $classes);

    }



    function shortcode($atts, $content) {



        $id = $this->get_unique_id();

        $tag = $atts['tag'];
        $class = 'code125-html-element-'. $id .' ';
        $class .= !empty($atts['c5ab_html_element_single']) ? 'code125-animated-text-wrap code125-animated-text-'.$id : '';
        $span = !empty($atts['c5ab_html_element_single']) ? ' <span class="code125-animated-text"></span>' : '';



        $return = code125_format_title($atts['text'], $atts['tag'], $class , $span);


        if (isset( $atts['margins'] )) {
            $obj = new Code125_Background_Implementation();
            if (is_array($atts['margins'])) {
                $margin = $atts['margins'];
            }else{
                $margin = unserialize(base64_decode($atts['margins']));
            }
            $margin_final = array();
            foreach ($margin as $key => $value) {
                $margin_final['desktop-' . $key] = $value;
            }
            $css = $obj->generate_css_spacing($margin_final ,  $atts['tag'] . '.code125-html-element-'. $id , false);
            if ($css!='') {
               echo '<style>'.$css.'</style>';
            }


        }


        if (!empty($atts['c5ab_html_element_single'])) {
            $strings = '[';
            foreach ($atts['c5ab_html_element_single'] as $tab) {
                $strings .= '"'.$tab['title'].'", ';
            }
            $strings .= ']';
            $this->_js .= '$(".code125-animated-text-'.$id.' span.code125-animated-text").typed({
                strings: '.$strings.',
                typeSpeed: 0,
                loop: true,
                backDelay: 1000,
            });'. "\n";
        }
        return $return;
    }



    function options() {


        $this->_options = array(
            array(
                'label' => 'HTML Content',
                'id' => 'text',
                'type' => 'extended-title',
                'desc' => 'HTML Tag content',
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
			            'label' => 'Heading 5',
			            'value' => 'h5'
			        ),
                    array(
			            'label' => 'Heading 6',
			            'value' => 'h6'
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
                'label' => 'Margins',
                'id' => 'margins',
                'type' => 'spacing',
                'desc' => 'Set Margins for this html tag.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => ''
            ),
            array(
                'label' => 'Add Animated text',
                'id' => 'c5ab_html_element_single',
                'type' => 'list-item',
                'desc' => 'Add Animated text.',
                'settings' => array(
                    array(
                        'label' => '',
                        'id' => 'text',
                        'type' => 'textblock',
                        'desc' => '',
                        'std' => '',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => ''
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
