<?php

class C5AB_divider extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_skip_title = true;
	public  $_cache_output = true;
	public  $_options =array();


	function __construct() {

		$id_base = 'divider-widget';
		$this->_shortcode_name = 'c5ab_divider';
		$name = 'Divider';
		$desc = 'Divider Box.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}


	function shortcode($atts,$content) {

        $css = '';
        $css .= ($atts['margin_top'] != '' && $atts['margin_top'] != '0') ? 'margin-top:' . $atts['margin_top'] . 'px;' : '';
        $css .= ($atts['margin_bottom'] != '' && $atts['margin_bottom'] != '0') ? 'margin-bottom:' . $atts['margin_bottom'] . 'px;' : '';
        $style = $css != '' ? 'style="'.$css.'"' : '';

		$data = '<div class="code125-divider code125-divider-'.$atts['layout'].'" '.$style.'><span></span></div>';
		return $data;
	}


	function custom_css() {

	}

	function options() {
        $layouts  = array(
            'layout-1' => 'Layout Plain',
            'layout-2' => 'Layout Double Line',
            'layout-3' => 'layout Plain with Circle',
         );
        $choices = array();
        foreach ($layouts as $key => $label) {
            $choices[] = array(
                'src' => C5_OPTIONS_IMG_URL . 'divider/' . $key . '.png',
                'src_2x' => C5_OPTIONS_IMG_URL . 'divider/' . $key . '@2x.png',
                'label' => $label,
                'value' => $key
            );
        }

		$this->_options =array(
            array(
			    'label' => 'Choose Divider layout',
			    'id' => 'layout',
			    'type' => 'radio-image',
			    'desc' => '',
			    'choices' => $choices,
			    'std' => 'layout-1',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
            array(
			    'label' => 'Margin top',
			    'id' => 'margin_top',
			    'type' => 'numeric-slider',
			    'desc' => 'Margin top in pixels, Default: 0.',
                'min_max_step' => '0,150,1',
			    'std' => '0',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Margin bottom',
			    'id' => 'margin_bottom',
                'type' => 'numeric-slider',
			    'desc' => 'Margin bottom in pixels, Default: 0.',
                'min_max_step' => '0,150,1',
			    'std' => '0',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),

		);
	}

	function css() {
		?>
		<style>
		.c5ab_divider{
			display: block;
			height: 1px;
			background: #DDDDDD;
			width: 100%;
		}
		</style>
		<?php
	}

}


 ?>
