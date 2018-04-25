<?php

class C5AB_slider extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = false;
	public  $_options =array();

	function __construct() {

		$id_base = 'slider-widget';
		$this->_shortcode_name = 'c5ab_slider';
		$name = 'Slider';
		$desc = 'Add Slider.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);

	}



	function shortcode($atts,$content) {



		$style_obj = new Code125_Colors();


		if (is_array($atts['c5ab_slide'])) {

		    	$slider = '';
		    	$counter = 1;
		    	$image_size = c5ab_generate_image_size($atts['width'], $atts['height'], true);
		    	foreach ($atts['c5ab_slide'] as $tab) {

		    	   $img_id = c5ab_get_attachment_id_from_src($tab['image']);
		    	   $image_url = c5_wp_get_attachment_image_src($img_id, $image_size);
		    	   $id_slide = $this->get_unique_id();

		    	   if($tab['type'] == 'top-left' || $tab['type'] == 'center-left'  || $tab['type'] == 'bottom-left' ){
		    	   		$float = 'left';
		    	   }elseif($tab['type'] == 'top-center' || $tab['type'] == 'center-center'  || $tab['type'] == 'bottom-center' ){
		    	   		$float = 'center';
		    	   }else {
	    	   			$float = 'right';
	    	   	   }
	    	   	   if($tab['style'] == 'light'){
	    	   	   		$color = $style_obj->hexDarker($tab['color'], 40);
	    	   	   }else {
	    	   	   		$color = $tab['color'];
	    	   	   }
		    	   $button_sc = '[c5ab_button text="'. $tab['button_title'] .'" link="'.$tab['button_link'].'" float="'.$float.'" button_text_color="'.$color.'" button_text_hover_color="#f8f8f8" button_bg_color="#f8f8f8" button_bg_hover_color="'.$color.'" ]';

		    	   $slider .= '<li id="'.$id_slide.'" class="'.$tab['style'].' c5ab-slide-'.$counter.'">';



		    	   if($tab['type'] == 'none'){
		    	   		$slider .= '<img src="' . $image_url[0] . '" width="' . $image_url[1] . '" height="' . $image_url[2] . '" alt="" srcset="'.$image_url[0].' 1x,'.$image_url[3].' 2x" />';
		    	   }elseif( $tab['type'] == 'video' ){
		    	   		$width = round(16*$atts['height']/9);
		    	   		$slider .= '<div class="c5ab-iframe" style="background:url(\''.$image_url[0].'\');background-size:100%;background-repeat:no-repeat;">' . do_shortcode( '[c5ab_center][c5ab_video url="'.$tab['title'].'" width="'.$width.'" height="'.$atts['height'].'"][/c5ab_center]' ) . '</div>';
		    	   }else {
		    	   		$slider .= '<img src="' . $image_url[0] . '" width="' . $image_url[1] . '" height="' . $image_url[2] . '" alt=""  srcset="'.$image_url[0].' 1x,'.$image_url[3].' 2x"  />';
		    	   		$slider .= '<div class="content '.$tab['type'].'"><div class="sub-content clearfix"><p class="title">'.$tab['title'].'</p><p>'.$tab['content'].'</p>'.do_shortcode($button_sc).'</div></div>';
		    	   }
		    	   $slider .= '</li>';

		    	   $slider .= '<style>.c5ab_slider ul li#'.$id_slide.' .content .sub-content{ background: ' . $tab['color'] .';}</style>';

		    	   $counter++;

		    	}
				$slider_id = $this->get_unique_id();
		    	$return = '<div class="c5ab_slider  c5ab_slider_' . $slider_id . '"><ul class="c5ab_slides clearfix">' . $slider . '</ul></div>' . "\n";

		    	$this->_js .= '$(\'.c5ab_slider_' . $slider_id . '\').slick();';




		    }
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
		$colors = $this->get_main_colors();

		$slider_align = array(
			'top-left',
			'top-center',
			'top-right',

//			'center-left',
//			'center-center',
//			'center-right',

			'bottom-left',
			'bottom-center',
			'bottom-right',

			'video',
			'none',
		);
		$slider_align_array = array();
		foreach ($slider_align as $value) {
			$slider_align_array[] = array(
			    'src' => C5BP_EXTRA_URI.'image/slider/'.$value.'.png',
			    'label' => '',
			    'value' => $value
			);
		}

		$this->_options =array(
			array(
			    'label' => 'Slider Width in Pixels',
			    'id' => 'width',
			    'type' => 'text',
			    'desc' => 'Add Slider Width, 1170px is default',
			    'std' => '1170',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => 'Slider Height in Pixels',
			    'id' => 'height',
			    'type' => 'text',
			    'desc' => 'Add Slider Width, 400px is default',
			    'std' => '400',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => 'Add Slide',
			    'id' => 'c5ab_slide',
			    'type' => 'list-item',
			    'desc' => 'Add tab to the slider box.',
			    'settings' => array(
			        array(
			            'label' => 'Content',
			            'id' => 'content',
			            'type' => 'textarea-simple',
			            'desc' => 'Slide Content',
			            'std' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ',
			            'rows' => '',
			            'post_type' => '',
			            'taxonomy' => '',
			            'class' => '',
			        ),
			        array(
			            'label' => 'Image',
			            'id' => 'image',
			            'type' => 'upload',
			            'desc' => 'Add Image as a background for the slide',
			            'std' => '',
			            'rows' => '',
			            'post_type' => '',
			            'taxonomy' => '',
			            'class' => '',
			        ),
			        array(
			            'label' => 'Button Title',
			            'id' => 'button_title',
			            'type' => 'text',
			            'desc' => 'Add Button Title, Leave it blank to disable it',
			            'std' => 'Read More!',
			            'rows' => '',
			            'post_type' => '',
			            'taxonomy' => '',
			            'class' => '',
			        ),
			        array(
			            'label' => 'Button Link',
			            'id' => 'button_link',
			            'type' => 'text',
			            'desc' => 'Add Button Link.',
			            'std' => '#',
			            'rows' => '',
			            'post_type' => '',
			            'taxonomy' => '',
			            'class' => '',
			        ),
			        array(
			            'label' => 'Slide Background Color',
			            'id' => 'color',
			            'type' => 'colorpicker',
			            'desc' => 'Add Slide Background Color',
			            'std' => $colors['primary'],
			            'rows' => '',
			            'post_type' => '',
			            'taxonomy' => '',
			            'class' => '',
			        ),
			        array(
			          'label'       => 'Slider Info Position',
			          'id'          => 'type',
			          'type'        => 'radio-image',
			          'desc'        => 'Choose Slider Info Position.',
			          'choices' => $slider_align_array,
			          'std'         => 'center-left',
			          'rows'        => '',
			          'post_type'   => '',
			          'taxonomy'    => ''
			        ),
			        array(
			            'label' => 'Slider Box Background',
			            'id' => 'style',
			            'type' => 'select',
			            'desc' => 'Slider Box Background.',
			            'choices' => array(
			            	array(
			            		'label' => 'Light',
			            		'value' => 'light'
			            	),
			            	array(
			            		'label' => 'Dark',
			            		'value' => 'dark'
			            	)
			            ),
			            'std' => 'dark',
			            'rows' => '',
			            'post_type' => '',
			            'taxonomy' => '',
			            'class' => '',
			        )
			    ),
			    'std' => '',
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
		.c5ab_slider {
			margin-bottom:60px;
			position: relative;
			display:block;
		}
		.c5ab_slider ul{
			margin: 0px 0px;
			padding: 0px;;
		}
		.c5ab_slider ul li{
			display: block;
			position: relative;
		}
		.c5ab_slider ul li .content{
			display: block;
			position: absolute;
			max-width:400px;
			width: 100%;

		}
		.c5ab_slider ul li .content .sub-content{
			padding: 30px;
		}
		.c5ab_slider ul li .content.top-center,
		.c5ab_slider ul li .content.bottom-center{
			display: block;
			position: absolute;
			left: 50%;
			width: 200px;
		}
		.c5ab_slider ul li .content.top-right,
		.c5ab_slider ul li .content.bottom-right{
			right: 30px;
		}
		.c5ab_slider ul li .content.top-left,
		.c5ab_slider ul li .content.bottom-left{
			left: 30px;
		}
		.c5ab_slider ul li .content.top-left,
		.c5ab_slider ul li .content.top-right,
		.c5ab_slider ul li .content.top-center{
			top: 30px;
		}
		.c5ab_slider ul li .content.bottom-left,
		.c5ab_slider ul li .content.bottom-right,
		.c5ab_slider ul li .content.bottom-center{
			bottom: 30px;
		}
		.c5ab_slider ul li .content.top-center .sub-content,
		.c5ab_slider ul li .content.bottom-center .sub-content{
			display: block;
			position: absolute;
			left: -200px;
			text-align:center;
		}
		.c5ab_slider ul li.dark{
			color: white;
		}
		.c5ab_slider ul li .content p.title{
			margin: 0px 0px 15px;
			font-weight:100;
			font-size:40px;
			line-height: 1;
		}
		.c5ab_slider ul li .content p{
			font-size:14px;
			font-weight:300;
		}
		.c5ab_slider .flex-control-nav{
			bottom: -30px;
		}


	</style>
	<?php
	}

}


 ?>
