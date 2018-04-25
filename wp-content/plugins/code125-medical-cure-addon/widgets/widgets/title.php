<?php

class C5AB_title extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_skip_title = true;
	public  $_cache_output = true;
	public  $_options =array();


	function __construct() {

		$id_base = 'title-widget';
		$this->_shortcode_name = 'c5ab_title';
		$name = 'Title';
		$desc = 'Title for your website.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}


	function shortcode($atts,$content) {


		    $title_id = '';
		    if ($atts['id'] != '') {
		        $title_id = 'id="' . $atts['id'] . '"';
		    }

		    $id = $this->get_unique_id();

			//WPML comptbaility
		    if (function_exists('icl_translate') && apply_filters('code125_enable_translation' , true ) ) {
		    	$atts['title'] = icl_translate('Widgets', 'widget title', $atts['title']);
		    }


			$data = '<div '.$title_id.' class="code125-heading code125-heading-'.$atts['layout'].' c5ab-title-'.$id.'  '.$atts['class'].'  clearfix">';
			$data .= code125_format_title($atts['title'] , 'h3');

			if(isset($atts['subtitle'])){
				if ($atts['subtitle'] != '') {
					$data .= '<p>'.$atts['subtitle'].'</p>';
				}
			}
        	$data .= '</div>';
		    return $data;

	}


	function custom_css() {

	}

	function options() {
		$layouts  = array(
            'layout-1' => 'Layout Plain',
            'layout-2' => 'Layout Plain with Circle',
            'layout-3' => 'Colored thick line',
         );
        $choices = array();
        foreach ($layouts as $key => $label) {
            $choices[] = array(
                'src' => C5_OPTIONS_IMG_URL . 'title/' . $key . '.png',
                'src_2x' => C5_OPTIONS_IMG_URL . 'title/' . $key . '@2x.png',
                'label' => $label,
                'value' => $key
            );
        }



		$this->_options =array(
			array(
			    'label' => 'Choose Title layout',
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
			    'label' => 'Title',
			    'id' => 'title',
			    'type' => 'extended-title',
			    'desc' => 'Title.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Subtitle',
			    'id' => 'subtitle',
			    'type' => 'text',
			    'desc' => 'Subtitle.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Class',
			    'id' => 'class',
			    'type' => 'text',
			    'desc' => 'Class.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'ID',
			    'id' => 'id',
			    'type' => 'text',
			    'desc' => 'Add ID to the title.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),

		);
	}

	function css() {

	}

}


 ?>
