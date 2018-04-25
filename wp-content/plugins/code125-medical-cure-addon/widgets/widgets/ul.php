<?php

class C5AB_ul extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_skip_title = true;
	public  $_cache_output = true;
	public  $_options =array();

	function __construct() {

		$id_base = 'ul-widget';
		$this->_shortcode_name = 'c5ab_ul';
		$name = 'UL "Unordered List"';
		$desc = 'Add UL "Unordered List".';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);

	}


	function shortcode($atts,$content) {

		    $ul = '';
				

		    foreach ($atts['c5ab_li'] as $tab) {
		        $id= $this->get_unique_id();
                $tag_open = $tab['link'] != '' ? '<a href="'.$tab['link'].'">' : '';
                $tag_close = $tab['link'] != '' ? '</a>' : '';
		    	$ul .=  '<li class="c5ab_custom_li_'.$id.'">'.$tag_open.'<span class="c5-ul-icon '.$tab['icon'].'" title="' . $tab['title'] . '"></span>' . $tab['title'] .  $tag_close . '</li>';
                if ($tab['color']!='') {
                    $ul .= '<style>.c5ab_custom_li_'.$id.' .c5-ul-icon{ color:'.$tab['color'].'}</style>';
                }
		    }
            $return = '<div class="code125-custom-ul clearfix">';
            if ($atts['title']!='') {
                $return .= '<h3>'. $atts['title'] . '</h3>';
            }
		    $return .= '<ul class="c5ab_custom_ul clearfix">' . $ul . '</ul>';
            $return .= '</div>';


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
	function custom_css() {

	}




	function options() {

		$this->_options =array(
            array(
               'label'       => 'Title',
               'id'          => 'title',
               'type'        => 'text',
               'desc'        => ' ',
               'std'         => '',
               'rows'        => '',
               'post_type'   => '',
               'taxonomy'    => '',
               'class'       => ''
             ),
			array(
			    'label' => 'Add li',
			    'id' => 'c5ab_li',
			    'type' => 'list-item',
			    'desc' => 'Add li to the ul box.',
			    'settings' => array(
			        array(
			           'label'       => 'Icon',
			           'id'          => 'icon',
			           'type'        => 'icon-list',
			           'desc'        => '',
			           'std'         => 'fa fa-facebook',
			           'rows'        => '',
			           'post_type'   => '',
			           'taxonomy'    => '',
			           'class'       => 'c5ab_icons'
			         ),
			        array(
			            'label' => 'Color',
			            'id' => 'color',
			            'type' => 'colorpicker',
			            'desc' => '',
			            'std' => '',
			            'rows' => '',
			            'post_type' => '',
			            'taxonomy' => '',
			            'class' => '',
			        ),
                    array(
			           'label'       => 'Link',
			           'id'          => 'link',
			           'type'        => 'text',
			           'desc'        => '',
			           'std'         => '',
			           'rows'        => '',
			           'post_type'   => '',
			           'taxonomy'    => '',
			           'class'       => ''
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
