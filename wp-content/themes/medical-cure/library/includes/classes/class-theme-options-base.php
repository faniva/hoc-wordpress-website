<?php

class C5_theme_option_base {

    public $_sections = array();
    public $_options = array();

    function __construct() {

    }

    function add_options($options, $option) {
        $options = array_merge($options, $option);
        return $options;
    }
    function get_font_size_array($name, $id, $default, $section = '') {
        $return = array(
            'label' => $name . ' font size',
            'id' => $id,
            'type' => 'numeric-slider',
            'desc' => 'Select the font size for ' . $name . ' in pixels.',
            'std' => $default,
            'min_max_step' => '10,100,1',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
            'section' => $section
        );


        return $return;
    }

	function get_menu_position_images() {
		$layout_array = array(
			'top',
			'side',
		);
		$layout_options = array(
		);

		foreach ($layout_array as $value) {
			$array = array(
			    'src' => C5_INCLUDES_URI. 'images/menu/'.$value.'.gif',
			    'label' => '',
			    'value' => $value
			);
			 array_push($layout_options, $array);
		}
		return $layout_options;
	}

    function get_skin_array($name, $id, $section = '') {
        $return = array(
        'label' => $name . ' Skin',
        'id' => $id,
        'type' => 'custom-post-type-select',
        'desc' => 'Choose The default Skin for '.$name.'.',
        'std' => '',
        'rows' => '',
        'post_type' => 'skin',
        'taxonomy' => '',
        'class' => '',
        'section' => $section
        );


        return $return;
    }

    function get_template_array($name, $id, $section = '') {

        $page_templates = $this->get_templates_list();


        $return = array(
        'label' => $name . ' template',
        'id' => $id,
        'type' => 'select',
        'desc' => 'Choose The default template for '.$name.'.',
        'choices' => $page_templates,
        'std' => '',
        'rows' => '',
        'taxonomy' => '',
        'class' => '',
        'section' => $section
        );


        return $return;
    }
    function get_logo_position_images() {
    	$layout_array = array(
    		'logo-left',
    		'logo-right',
    		//'logo-center-top',
    		//'logo-center-bottom',
    		'logo-custom',
    	);
    	$layout_options = array(
    	);

    	foreach ($layout_array as $value) {
    		$array = array(
    		    'src' => C5_INCLUDES_URI. 'images/logo-align/'.$value.'.png',
    		    'label' => '',
    		    'value' => $value
    		);
    		 array_push($layout_options, $array);
    	}
    	return $layout_options;
    }
    function get_content($id , $label , $std,$section = '') {
    	return array(
    	    'label' => $label,
    	    'id' => $id,
    	    'type' => 'textarea-simple',
    	    'desc' => '<span class="c5ab_launch_generator button c5ab_another_editor">[ ] Insert shortcode</span>',
    	    'std' => $std,
    	    'rows' => '',
    	    'post_type' => '',
    	    'taxonomy' => '',
    	    'class' => '',
    	    'section' => $section
    	);
    }

    function get_current_menus() {
        /** Menu Locations* */
        $themes = get_registered_nav_menus();
        $menu_new = array();

        foreach ($themes as $key => $value) {
            $menu_new[] = array(
                'label' => $value,
                'value' => $key
            );
        }

        return $menu_new;
    }

	function get_templates_list() {
        if (function_exists('c5_get_ab_templates')) {
            $templates = c5_get_ab_templates();
        }else{
            $templates = array();
        }

		$types_array = array();
		$types_array[] = array(
			'label'       => 'Default template',
			'value'       => ''
		);
		foreach ($templates as $key => $value) {
			$types_array[] = array(
				'label'       => $value,
				'value'       => $key
			);
		}
		return $types_array;

	}


	function get_meta_options(){

		return ot_get_option('meta_data');

	}


	function get_meta_option($option) {
		return ot_get_option($option);
	}





}

?>
