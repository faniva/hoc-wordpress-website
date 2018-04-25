<?php

class C5AB_button extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_skip_title = true;
	public  $_cache_output = true;
	public  $_options =array();


	function __construct() {

		$id_base = 'button-widget';
		$this->_shortcode_name = 'c5ab_button';
		$name = 'Button';
		$desc = 'Add a Button.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);
	}


	function shortcode($atts,$content) {

		$id = $this->get_unique_id();
		$style_obj = new Code125_Colors();

		$class = array(
			'btn',
			'btn-'.$id ,
			$atts['button_class'],
			$atts['float'],
			$atts['size'],
			$atts['shape'],
			$atts['color'],
			$atts['layout']
		);
		if ($atts['popup'] == 'on') {
			$class[] = 'code125-video-button-popup';
		}
		$class = implode(' ', $class);
		$data = code125_format_button($atts['button'], $class);

		$css= '';
		if ($atts['button_text_color'] != '') {
			$css .= 'a.btn.btn-'.$id .'{color: '.$atts['button_text_color'].' !important;}';
		}
		if ($atts['button_border_color'] != '') {
			$css .= 'a.btn.btn-'.$id .'{border-color: '.$atts['button_border_color'].' !important;}';
		}
		if ($css != '') {
			$data .= '<style>'.$css.'</style>';
		}


		return $data;
	}


	function custom_css() {

	}

	function options() {
		$layouts  = array(
            'normal' => 'Layout Normal',
            'inverse' => 'Layout Inverse',
         );
        $choices = array();
        foreach ($layouts as $key => $label) {
            $choices[] = array(
                'src' => C5_OPTIONS_IMG_URL . 'buttons/' . $key . '.png',
                'src_2x' => C5_OPTIONS_IMG_URL . 'buttons/' . $key . '@2x.png',
                'label' => $label,
                'value' => $key
            );
        }
		$this->_options =array(

			array(
			    'label' => 'Button info',
			    'id' => 'button',
			    'type' => 'button',
			    'desc' => 'Button main info.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Button text color',
			    'id' => 'button_text_color',
			    'type' => 'colorpicker',
			    'desc' => 'Button text color.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Button border color',
			    'id' => 'button_border_color',
			    'type' => 'colorpicker',
			    'desc' => 'Button border color.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Button Size',
			    'id' => 'size',
			    'type' => 'select',
			    'desc' => 'Choose button float.',
			    'choices' => array(
			        array(
			            'label' => 'Small',
			            'value' => 'small'
			        ),
			        array(
			            'label' => 'Medium',
			            'value' => 'medium'
			        ),
					array(
			            'label' => 'large',
			            'value' => 'large'
			        ),
			    ),
			    'std' => 'medium',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => 'Button layout',
			    'id' => 'layout',
			    'type' => 'radio-image',
			    'desc' => '',
			    'choices' => $choices,
			    'std' => 'normal',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => 'Button Shape',
			    'id' => 'shape',
			    'type' => 'select',
			    'desc' => 'Choose button float.',
			    'choices' => array(
			        array(
			            'label' => 'Normal',
			            'value' => ''
			        ),
			        array(
			            'label' => 'Rounded',
			            'value' => 'rounded'
			        ),
			    ),
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => 'Button Color',
			    'id' => 'color',
			    'type' => 'select',
			    'desc' => 'Choose button Color.',
			    'choices' => array(
			        array(
			            'label' => 'Theme Color',
			            'value' => 'c5-btn-theme'
			        ),
			        array(
			            'label' => 'Blue',
			            'value' => 'c5-btn-blue'
			        ),
					array(
			            'label' => 'Red',
			            'value' => 'c5-btn-red'
			        ),
					array(
			            'label' => 'Green',
			            'value' => 'c5-btn-green'
			        ),
					array(
			            'label' => 'Orange',
			            'value' => 'c5-btn-orange'
			        ),
					array(
			            'label' => 'Yellow',
			            'value' => 'c5-btn-yellow'
			        ),
			    ),
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => 'Button Class',
			    'id' => 'button_class',
			    'type' => 'text',
			    'desc' => 'Service Column Button Text.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Float',
			    'id' => 'float',
			    'type' => 'select',
			    'desc' => 'Choose button float.',
			    'choices' => array(
			        array(
			            'label' => 'Left',
			            'value' => 'left'
			        ),
			        array(
			            'label' => 'Center',
			            'value' => 'center'
			        ),
			        array(
			            'label' => 'Right',
			            'value' => 'right'
			        )
			    ),
			    'std' => 'center',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => 'Video Popup?',
			    'id' => 'popup',
			    'type' => 'on_off',
			    'desc' => 'Enable this option to open the video link in a popup in the window instead of redirecting to the link.',
			    'std' => 'off',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),



		);
	}


}


 ?>
