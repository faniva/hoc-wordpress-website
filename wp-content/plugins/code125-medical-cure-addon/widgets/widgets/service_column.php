<?php

class C5AB_service_column extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_skip_title = true;
	public  $_cache_output = true;
	public  $_options =array();

	public $servcie_id;


	function __construct() {

		$id_base = 'service-column-widget';
		$this->_shortcode_name = 'c5ab_service_column';
		$name = 'Service Column';
		$desc = 'Show your services in a decent way.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}


	function shortcode($atts,$content) {

		$id = $this->get_unique_id();
		$this->servcie_id = $id;
		$data = '';

		switch ($atts['layout']) {
			case 'elegant':

			$data = '<div class="'.$this->classes($atts).' c5-service-layout-elegant">';

			$data .= $this->get_icon($atts);
			$data .= $this->get_title($atts);
			$data .= $this->get_content($content);
			$data .= code125_format_button($atts['button'],'c5-btn-theme btn');
			$data .= $this->link($atts);

			if ($atts['color']!='') {
				$data .= '<style>';
				$data .= '.c5-service-'.$id.':hover { border-color : '.$atts['color'].'}';
				$data .= '.c5-service-'.$id.'.code125-service-common .c5-icon{ color : '.$atts['color'].'}';
				$data .= '.c5-service-'.$id.'.code125-service-common:hover .c5-icon{ color : '.$atts['color'].'}';
				$data .= '.c5-service-'.$id.'.code125-service-common .c5-icon svg{ fill : '.$atts['color'].'}';
				$data .= $this->button_css($id, $atts);
				$data .='</style>';
			}
			$data .= $this->plus($id , $atts);
			$data .='</div>';
			break;
			case 'plain':

			$data = '<div class="'.$this->classes($atts).'  c5-service-layout-plain "><div class="c5-content-wrap">';

			$data .= $this->get_icon($atts);
			$data .= $this->get_title($atts);
			$data .= $this->get_content($content);
			$data .= code125_format_button($atts['button'],'c5-btn-theme btn');
			$data .= '</div></div>';
			if ($atts['color']!='') {
				$data .= '<style>';
				$data .= '.c5-service-'.$id.'.code125-service-common .c5-icon{ color : '.$atts['color'].'}';

				$data .= '.c5-service-'.$id.'.code125-service-common .c5-icon.code125-icon-svg svg{fill: '.$atts['color'].'}';
				$data .= $this->button_css($id, $atts);
				$data .='</style>';
			}

			break;
			case 'gradient':


			$data = '<div class="'.$this->classes($atts).'  c5-service-layout-gradient c5-dark-background ">';

			if($atts['color'] !=''){
				$data .= '<style>';
				$data .= '.c5-service-'.$id.'.code125-service-common { background: '. $atts['color'] .' !important; }';
				$data .= '.c5-service-'.$id.'.code125-service-common:hover { color: '. $atts['color'] .'; }';
				$data .= '.c5-service-'.$id.'.code125-service-common:hover .c5-icon.code125-icon-svg svg{ fill: '. $atts['color'] .';}';

				$data .= '.c5-service-'.$id.'.code125-service-common.c5-service-layout-gradient:hover a.c5-btn-theme.btn:hover{ background: '. $atts['color'] .'; border-color: '. $atts['color'] .';}';

				$data .= '</style>';
			}

			$data .= '<div class="c5-content-wrap">';

			$data .= $this->get_icon($atts);
			$data .= $this->get_title($atts);
			$data .= $this->get_content($content);
			$data .= code125_format_button($atts['button'],'c5-btn-theme btn');

			$data .= '</div></div>';
			break;
			case 'mini':

			$data = '<div class="'.$this->classes($atts).'  c5-service-mini">';
			$data .= $this->link($atts);
			$data .= $this->get_icon($atts);
			$data .= $this->get_title($atts);
			$data .= $this->get_content($content);
			$data .= $this->plain_button($atts);

			if($atts['color'] !=''){
				$data .= '<style>';
				$data .= '.c5-service-'.$id.' .c5-icon{ color: '. $atts['color'] .'; }';
				$data .= '.c5-service-'.$id.' a.service-button{ color : '.$atts['color'].'}';
				$data .= '</style>';
			}
			$data .= '</div>';

			break;
			case 'image-based':
			case 'image-dark-colored':
			$data  = '<div class="'.$this->classes($atts).' c5-service-layout-'.$atts['layout'].' c5-department-layout-elegant c5-dark-background" style="min-height: '.$GLOBALS['c5_content_width'].'px" >';
			$data .= $this->image($id, $atts);
			$data .= $this->link($atts);
			$data .= '<div class="c5-department-overlay">';
			$data .= '<div class="c5-department-content">';

			$data .= $this->get_title($atts);
			$data .= $this->get_content($content);
			$data .= code125_format_button($atts['button'],'c5-btn-theme btn');
			$data .= '</div>';

			$data .= $this->link($atts);
			if ($atts['layout'] == 'image-based') {

				if ($atts['color']!='') {

					$obj_style = new Code125_Colors();
					$rgb = $obj_style->hex2rgb(esc_attr($atts['color']));
					$intital = 'rgba('.$rgb[0].', '.$rgb[1].', '.$rgb[2].', 0.5)';
					$hover = 'rgba('.$rgb[0].', '.$rgb[1].', '.$rgb[2].', 0.8)';

					$data .= '<style>';
					$data .= '.c5-department-'.$id.'.c5-department-layout-elegant .c5-department-overlay { background : '.$intital.'}';
					$data .= '.c5-department-'.$id.'.c5-department-layout-elegant .c5-department-overlay:hover { background : '.$hover.'}';

					$data .='</style>';
				}

			}
			$data .= '</div></div>';

			break;

			case 'department';
			$data = '<div class="'.$this->classes($atts).'  c5-department">';
			$data .= '<div class="c5-department-front">';

			$data .= $this->get_icon($atts);

			$data .= $this->get_title($atts);
			$data .= '</div>';
			$data .= '<div class="c5-department-back c5-dark-background">';

			$data .= $this->get_content($content);

			$data .= code125_format_button($atts['button'],'c5-btn-theme btn');

			if ($atts['color']!='') {
				$data .= '<style>';
				$data .= '.c5-department-'.$id.' .c5-icon{ color : '.$atts['color'].'}';

				$data .='.c5-department-'.$id.' .c5-department-back{ background: '.$atts['color'].'}';

				$data .= '.c5-department-'.$id.' .btn:hover{ background : #fff; border-color : '.$atts['color'].'; color: '.$atts['color'].'; }';
				$data .='</style>';
			}

			$data .= '</div></div>';
			break;

			case 'icon-based';
			$data = '<div class="'.$this->classes($atts).'  c5-service-icon-based code125-icon-'.$atts['icon_size'].'">';


			$data .= $this->get_icon($atts);

			$data .= $this->get_title($atts);
			$data .= $this->get_content($content);

			$data .= $this->plain_button($atts);

			if ($atts['color']!='') {
				$data .= '<style>';
				$data .= '.c5-service-'.$id.' .c5-icon{ color : '.$atts['color'].'}';
				$data .= '.c5-service-'.$id.' a.service-button{ color : '.$atts['color'].'}';

				$data .='</style>';
			}

			$data .= '</div>';
			break;

			case 'sidebar';

			$data = '<div class="'.$this->classes($atts).'  c5-service-sidebar-based"><div class="c5-service-color-wrap clearfix">';
			$data .= $this->get_icon($atts);

			$data .= $this->get_title($atts);
			$data .= $this->get_content($content);

			$data .= code125_format_button($atts['button'],'c5-btn-theme btn');

			$data .= $this->image($id, $atts);


			if ($atts['color']!='') {
				$data .= '<style>';

				$obj_style = new Code125_Colors();


				$bg = $obj_style->AdjustHSL($atts['color'] ,'1', '0.95' );
				$rgb = $obj_style->hex2rgb($bg);
				$intital = 'rgba('.$rgb[0].', '.$rgb[1].', '.$rgb[2].', 0.94)';
				$data .= '.c5-service-'.$id.' .c5-service-color-wrap{ background: '.$intital.'; }';

				$data .= '.c5-service-'.$id.' .c5-icon{ color : '.$atts['color'].'}';

				$data .= '.c5-service-'.$id.'.code125-service-common .c5-icon.code125-icon-svg svg{fill: '.$atts['color'].';}';

				$data .= $this->button_css_inverse($id, $atts);

				$data .='</style>';
			}

			$data .= '</div></div>';
			break;

			case 'contact-info';

			$class ='';
			if ($atts['icon']!= '' && $atts['icon']!='fa fa-none') {
				$class = ' has-icon ';
			}
			$data = '<div class="'.$this->classes($atts).' '.$class.'  c5-service-contact-info">';


			$data .= $this->get_icon($atts);

			$data .= $this->get_title($atts);
			$data .= $this->get_content($content);

			$data .= code125_format_button($atts['button'],'c5-btn-theme btn');

			if ($atts['color']!='' && $atts['icon']!= '' && $atts['icon']!='fa fa-none') {
				$data .= '<style>';

				$obj_style = new Code125_Colors();
				$bg = $obj_style->AdjustHSL($atts['color'] ,'1', '0.95' );

				$data .= '.c5-service-'.$id.' .c5-icon{ color : '.$atts['color'].' ; background: '.$bg.';}';

				$data .='</style>';
			}

			$data .= '</div>';

			break;

			case 'simple';

			$data = '<div class="'.$this->classes($atts).'  c5-service-mini c5-service-simple-layout">';

			$data .= $this->link($atts);
			$data .= $this->get_icon($atts);
			$data .= $this->get_title($atts);
			$data .= $this->get_content($content);
			$data .= $this->plain_button($atts);

			if($atts['color'] !=''){
				$data .= '<style>';
				$data .= '.c5-service-'.$id.' .c5-icon{ color: '. $atts['color'] .'; }';
				$data .= '.c5-service-'.$id.' a.service-button{ color : '.$atts['color'].'}';
				$data .= '.c5-service-'.$id.' .service-content .fa{ color : '.$atts['color'].' ;}';
				$data .= '</style>';
			}

			$data .= '</div>';

			break;
			case 'simple-bordered';

			$data = '<div class="'.$this->classes($atts).'  c5-service-simple-bordered">';

			$data .= $this->link($atts);

			$data .= $this->get_icon($atts);
			$data .= '<div class="service-content-wrap">';
			$data .= $this->get_title($atts);
			$data .= $this->get_content($content);
			$data .= '</div>';


			if ($atts['color']!='') {
				$data .= '<style>';
				$obj_style = new Code125_Colors();
				$bg = $obj_style->AdjustHSL($atts['color'] ,'1', '0.95' );
				$data .= '.c5-service-'.$id.' .c5-icon{ color : '.$atts['color'].' ;}';
				$data .= '.c5-service-'.$id.':hover { background : '.$bg.' ;}';

				$data .='</style>';
			}

			$data .= '</div>';

			break;

			case 'animated-hover';

			$data = '<div class="'.$this->classes($atts).'  c5-service-animated-hover">';
			$data .= $this->image($id, $atts);

			$data .= $this->link($atts);

			$data .= '<div class="title-front">';
			$data .= $this->get_icon($atts);
			$data .= $this->get_title($atts);
			$data .= '</div>';

			$data .= '<div class="title-back">';
			$data .= $this->get_icon($atts);
			$data .= $this->get_title($atts);
			$data .= $this->get_content($content);
			$data .= $this->plain_button($atts);
			$data .= '</div>';



			if ($atts['color']!='') {
				$data .= '<style>';
				$obj_style = new Code125_Colors();
				$rgb = $obj_style->hex2rgb(esc_attr($atts['color']));
				$intital = 'rgba('.$rgb[0].', '.$rgb[1].', '.$rgb[2].', 0.8)';
				$data .= '.c5-service-'.$id.'.c5-service-animated-hover .title-front, .c5-service-'.$id.'.c5-service-animated-hover .title-back{ background : '.$intital.' }';
				$data .='</style>';
			}

			$data .= '</div>';

			break;

			case 'simple-rounded';

			$data = '<div class="'.$this->classes($atts).'  c5-service-simple-rounded">';

			$data .= $this->link($atts);

			$data .= $this->get_icon($atts);

			$data .= $this->get_title($atts);

			if ($atts['color']!='') {
				$data .= '<style>';
				$obj_style = new Code125_Colors();
				$bg = $obj_style->AdjustHSL($atts['color'] ,'1', '0.95' );
				$data .= '.c5-service-'.$id.' .c5-icon{ background : '.$atts['color'].' ;}';
				$data .= '.c5-service-'.$id.':hover { background : '.$bg.' ;}';

				$data .='</style>';
			}

			$data .= '</div>';

			break;

			case 'plain-bordered';
			$data = '<div class="'.$this->classes($atts).'  c5-service-plain-bordered"><div class="service-single-wrap">';

			$data .= $this->get_icon($atts);

			$data .= $this->get_title($atts);

			$data .= $this->get_content($content);
			$data .= '</div>';
			$data .= $this->plain_button($atts);

			if ($atts['color']!='') {
				$data .= '<style>';
				$obj_style = new Code125_Colors();
				$bg = $obj_style->AdjustHSL($atts['color'] ,'1', '0.95' );
				$data .= '.c5-service-'.$id.' .c5-icon{ color : '.$atts['color'].' ;}';
				$data .= '.c5-service-'.$id.' a.service-button{ color : '.$atts['color'].' ;}';
				$data .= '.c5-service-'.$id.' a.service-button { background : '.$bg.' ;}';

				$data .='</style>';
			}

			$data .= '</div>';

			break;
			case 'image-simple';
			$data = '<div class="'.$this->classes($atts).'  c5-service-image-simple">';

			if ($atts['image']!='') {
				$image_size = c5ab_generate_image_size($GLOBALS['c5_content_width'], 9999, false);
				$image_data = $this->get_image($image_size , $atts['image']);
				$srcset = ($image_data[1] != '') ? 'srcset="'.$image_data[0].' 1x,'.$image_data[1].' 2x"' : '';

				$data .= '<img src="'.$image_data[0].'" class="service-image" '.$srcset.' />';
			}
			$data .= $this->get_title($atts);

			$data .= $this->get_content($content);

			$data .= $this->plain_button($atts);

			if ($atts['color']!='') {
				$data .= '<style>';
				$data .= '.c5-service-'.$id.' a.service-button:hover{ color : '.$atts['color'].' ;}';
				$data .='</style>';
			}

			$data .= '</div>';

			break;


			default:
			# code...
			break;
		}


		return $data;
	}

	public function get_icon($atts)
	{
		if ($atts['icon_image'] != '') {
			if (strpos($atts['icon_image'], '.svg') !== false) {
				$result = wp_remote_get( $atts['icon_image'] );
		        $file_contents = $result['body'];
				
				return '<span class="c5-icon icon-size-'.$atts['icon_size'].' code125-icon-svg">'.$file_contents.'</span>';
			}else{
				switch ($atts['icon_size']) {
					case 'small':
					$width = 30;
					break;
					case 'medium':
					$width = 48;
					break;
					case 'large':
					$width = 70;
					break;
					case 'xlarge':
					$width = 100;
					break;

					default:
					$width = 48;
					break;
				}
				$image_size = c5ab_generate_image_size($width, $width, true);
				$image_data = $this->get_image($image_size , $atts['icon_image']);
				$return =  '<span class="c5-icon icon-size-'.$atts['icon_size'].' code125-icon-svg">';
				$srcset = $image_data[1] != '' ? 'srcset="'.$image_data[0].' 1x,'.$image_data[1].' 2x"' : '';
				$return .= '<img src="'.$image_data[0].'" '.$srcset.' width="'.$width.'" height="'.$width.'" />';
				$return .='</span>';
				return $return;
			}

		}elseif ($atts['icon']!= '' && $atts['icon']!='fa fa-none') {
			return '<span class="c5-icon icon-size-'.$atts['icon_size'].' '.$atts['icon'].'"></span>';
		}
		return '';
	}
	public function get_title($atts)
	{
		if($atts['title']!=''){
			return '<h4>'.$atts['title'].'</h4>';
		}
		return '';
	}

	public function classes($atts)
	{
		$classes = array(
			'code125-service-common',
			'code125-service-alignment-'. $atts['alignment'],
			'c5-service-'.$this->servcie_id,
			'clearfix'
		);
		return implode(' ' , $classes);
	}

	public function get_content($content)
	{
		$content_html = wpautop($content);
		if ($content_html!= '') {
			return '<div class="service-content">' . $content_html  . '</div>';
		}
		return '';
	}

	public function plus($id , $atts)
	{
		$data = '<span class="c5-plus-hover"><span class="fa fa-plus"></span></span>';
		if ($atts['color']!='') {
			$data .= '<style>';
			$data .= '.c5-service-'.$id.' .c5-plus-hover:before{
				border-right-color: '.$atts['color'].';
				border-top-color: '.$atts['color'].';
			}';
			$data .= '</style>';
		}
		return $data;

	}
	public function image($id, $atts)
	{
		if ($atts['image']!='') {
			$image_size = c5ab_generate_image_size($GLOBALS['c5_content_width'], 9999, false);
			$image_data = $this->get_image($image_size , $atts['image']);
			$colors_object = new Code125_Colors();
			$css = $colors_object->image_background_css('.c5-service-'.$id , $image_data);
			$data = '<style>'.$css.'</style>';
			return $data;
		}
	}
	public function get_image($image_size , $url)
	{
		$src = $url;
		$src_2x = '';
		$attachment_id = c5ab_get_attachment_id_from_src($url);
		if ($attachment_id != '') {
			$image_attributes = c5_wp_get_attachment_image_src($attachment_id , $image_size , false );
			if ($image_attributes) {
				$src = $image_attributes[0];
				$src_2x = $image_attributes[3];
			}
		}
		return array($src, $src_2x);
	}
	public function link($atts)
	{
		if (is_array($atts['button'])) {
			$values = $atts['button'];
			$link = isset($values['link']) ? 'href="'.$values['link'].'"' : '';
		}elseif( is_array(@unserialize( base64_decode($atts['button']) )) ){
			$values =  unserialize( base64_decode($atts['button']) );
			$link = isset($values['link']) ? 'href="'.$values['link'].'"' : '';
		}else{
			$link = '';
		}
		if ($link!='') {
			$data ='<a '.$link.' class="c5-click-over"></a>';
			return $data;
		}
		return '';
	}

	public function button_css($id, $atts)
	{
		$data = '.c5-service-'.$id.' .btn{
			color : '.$atts['color'].';
			border-color : '.$atts['color'].';
			background: #fff;
		}';
		$data .= '.c5-service-'.$id.' .btn:hover{
			background : '.$atts['color'].';
			border-color : '.$atts['color'].';
			color: #fff;
		}';

		return $data;
	}
	public function button_css_inverse($id, $atts)
	{
		$data = '.c5-service-'.$id.' .btn{ background : '.$atts['color'].' !important; border-color : '.$atts['color'].' !important; }';
		$data .= '.c5-service-'.$id.' .btn:hover{ border-color : '.$atts['color'].' !important; color: '.$atts['color'].' !important; background: transparent !important; }';

		return $data;
	}
	public function plain_button($atts)
	{
		if (is_array($atts['button'])) {
			$values = $atts['button'];
		}elseif( is_array(@unserialize( base64_decode($atts['button']) )) ){
			$values =  unserialize( base64_decode($atts['button']) );

		}else{
			return '';
		}

		if (isset($values['link']) && $values['link'] != '') {
			$data ='<a href="'.$values['link'].'"  class="service-button">'.$values['text'];
			if ($values['icon'] != '' && $values['icon'] != 'fa fa-none') {
				$data .= '<span class="'.$values['icon'].'"></span>';
			}
			$data .= '</a>';
			return $data;
		}
	}

	function options() {
		$layouts  = array(
			'elegant' => 'Layout elegant',
			'plain' => 'Layout plain',
			'gradient' => 'Layout gradient',
			'department' => 'Department',
			'plain-bordered' => ' Plain Bordered',
			'sidebar' => 'Sidebar',
			'animated-hover' => 'Animated Hover',
			'image-based' => 'Image Based',
			'image-simple' => 'Image Simple',
			'icon-based' => 'Icon Based',
			'contact-info' => 'Contact Info',
			'simple-bordered' => ' Simple Bordered',
			'simple-rounded' => 'Simple Rounded',
			'image-dark-colored' => 'Image Dark',

		);
		$choices = array();
		foreach ($layouts as $key => $label) {
			$choices[] = array(
				'src' => C5_OPTIONS_IMG_URL . 'services/' . $key . '.png',
				'src_2x' => C5_OPTIONS_IMG_URL . 'services/' . $key . '@2x.png',
				'label' => $label,
				'value' => $key
			);
		}

		$this->_options =array(
			array(
				'label' => 'Choose Service column layout',
				'id' => 'layout',
				'type' => 'radio-image',
				'desc' => '',
				'choices' => $choices,
				'std' => 'elegant',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => '',
			),
			array(
				'label' => 'Title',
				'id' => 'title',
				'type' => 'text',
				'desc' => 'Service Column title.',
				'std' => 'Service Column',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => ''
			),

			array(
				'label'       => 'Icon',
				'id'          => 'icon',
				'type'        => 'icon-list',
				'desc'        => 'Choose the icon for the service column',
				'std'         => 'fa fa-cloud',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'class'       => 'c5ab_icons'
			),
			array(
				'label'       => 'Icon svg and image',
				'id'          => 'icon_image',
				'type'        => 'upload',
				'desc'        => 'Use this option to upload a custom icon. You can upload image or SVG',
				'std'         => '',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'class'       => ''
			),
			array(
				'label' => 'Icon Size',
				'id' => 'icon_size',
				'type' => 'select',
				'desc' => 'Service Icon Size',
				'std' => 'medium',
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
						'label' => 'Large',
						'value' => 'large'
					),
					array(
						'label' => 'XLarge',
						'value' => 'xlarge'
					),
				),
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => ''
			),
			array(
				'label' => 'Text alignment',
				'id' => 'alignment',
				'type' => 'select',
				'desc' => 'Service Icon Size',
				'std' => 'default',
				'choices' => array(
					array(
						'label' => 'Default (Left or Right in RTL Websites)',
						'value' => 'default'
					),
					array(
						'label' => 'Center',
						'value' => 'center'
					),
				),
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => ''
			),
			array(
				'label' => 'Content',
				'id' => 'content',
				'type' => 'wp_editor',
				'desc' => '',
				'std' => '',
				'rows' => '9',
				'post_type' => '',
				'taxonomy' => '',
				'class' => ''
			),
			array(
				'label'       => 'Image Background',
				'id'          => 'image',
				'type'        => 'upload',
				'desc'        => 'Use this option in the serivce column type "Image Based"',
				'std'         => '',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'class'       => ''
			),
			array(
				'label' => 'Button',
				'id' => 'button',
				'type' => 'button',
				'desc' => 'Service Column Button.',
				'std' => '',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => ''
			),
			array(
				'label' => 'Accent Color',
				'id' => 'color',
				'type' => 'colorpicker',
				'desc' => 'Service Column Button Accent Color.',
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
