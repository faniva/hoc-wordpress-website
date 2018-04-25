<?php

class C5AB_gallery extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_skip_title = true;
	public  $_cache_output = true;
	public  $_options =array();


	function __construct() {

		$id_base = 'gallery-widget';
		$this->_shortcode_name = 'c5ab_gallery';
		$name = 'Gallery';
		$desc = 'Add Gallery Box.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}

	public function shortcode($atts, $content)
	{
		$layout = isset($atts['layout']) && $atts['layout'] != '' ? $atts['layout'] : 'layout-1';
		if ($layout == 'layout-1') {
			return $this->layout_1($atts);
		}else{
			return $this->layout_2($atts);
		}
 	}
	public function layout_2($atts)
	{
		$id = $this->generate_unique_id();
		$width = $GLOBALS['c5_content_width'];

		$return = '<div class="code125-gallery code125-gallery-layout-2 code125-gallery-'.$id.'">';

		$images = explode(',' , $atts['gallery']);
		$image_size = c5ab_generate_image_size( $width, 9999, false);

		foreach ($images as $attachment_id) {
			$return .= $this->get_image($image_size , $attachment_id , 'code125-gallery-post-slide');
		}
		$return .= '</div>';
		$this->_js .= "
		$('.code125-gallery-".$id."').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			adaptiveHeight: true,
			 " .$this->slick_direction()."
			fade: true,
			autoplay: true,
			autoplaySpeed: 4000,
		});". "\n";

		$this->_js .= "
		$('.code125-gallery-".$id."').magnificPopup({
			delegate: '.code125-gallery-item',
			type: 'image',
			tLoading: 'Loading image #%curr%...',
			mainClass: 'mfp-img-mobile',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0,1]
			},
			image: {
				tError: '<a href=\"%url%\">The image #%curr%</a> could not be loaded.',
			}
		});";

		return $return;
	}
	function layout_1($atts) {


		$id = $this->generate_unique_id();
		$total_width = $GLOBALS['c5_content_width'];

		$big = $total_width/20;
		$small = $total_width/40;
		if ($total_width < 500) {
			$big = $total_width/10;
			$small = $total_width/10;
		}



		$return = '<div class="code125-gallery code125-gallery-'.$id.'"><div class="code125-grid-sizer"></div>';
		$return .= '<style>';
		$return .= '.code125-gallery-'.$id.' .code125-gallery-post-big{
		        width: '.$big.'rem;
		        height: '.$big.'rem;
		    }';
		$return .= '.code125-gallery-'.$id.' .code125-gallery-post-wide{
		        width: '.$big.'rem;
		        height: '.$small.'rem;
		    }';
		$return .= '.code125-gallery-'.$id.' .code125-gallery-post-tall{
		        width: '.$small.'rem;
		        height: '.$big.'rem;
		    }';
		$return .= '.code125-gallery-'.$id.' .code125-gallery-post-small{
		        width: '.$small.'rem;
		        height: '.$small.'rem;
		    }';
		$return .= '.code125-gallery-'.$id.' .code125-grid-sizer{
		        width: '.$small.'rem;
		    }';


		$return .= '</style>';

		$images = explode(',' , $atts['gallery']);
		$big_image = $this->generate_image_size( $big, $big, true);
		$wide_image = $this->generate_image_size( $big, $small, true);
		$tall_image = $this->generate_image_size( $small, $big, true);
		$small_image = $this->generate_image_size( $small, $small, true);
		$counter = 0;
		$total = count($images);
		foreach ($images as $attachment_id) {
			if ($counter == 0) {
				$return .= $this->get_image($big_image , $attachment_id , 'code125-gallery-post-big');
			}elseif ($counter == 1) {
					$return .= $this->get_image($wide_image , $attachment_id , 'code125-gallery-post-wide');
			}else{
				$return .= $this->get_image($small_image , $attachment_id , 'code125-gallery-post-small');
			}
			$counter++;
		}

		$return  .= '</div>';

		$this->_js .= "
		$('.code125-gallery-".$id."').masonry({
			itemSelector: '.code125-gallery-item',
			columnWidth: '.code125-grid-sizer',
			percentPosition: true
		});" . "\n";

		$this->_js .= "
		$('.code125-gallery-".$id."').magnificPopup({
			delegate: '.code125-gallery-item',
			type: 'image',
			tLoading: 'Loading image #%curr%...',
			mainClass: 'mfp-img-mobile',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0,1]
			},
			image: {
				tError: '<a href=\"%url%\">The image #%curr%</a> could not be loaded.',
			}
		});";

		return $return;
	}

	public function generate_image_size($width='' , $height= '' , $crop = true)
	{
		return c5ab_generate_image_size( round(10*$width), round(10*$height), $crop);
	}

	public function get_image($image_size , $attachment_id , $class='')
	{

		$image_attributes = c5_wp_get_attachment_image_src($attachment_id , $image_size , false );

		if ($image_attributes) {
			$src = $image_attributes[0];
			$src_2x = $image_attributes[3];
			$full = c5ab_generate_image_size( 1170, 9999, false);
			$image_full = c5_wp_get_attachment_image_src($attachment_id , $full , false );
			$id = $this->get_unique_id();

			$metadata = wp_get_attachment_metadata( $attachment_id);
			$title = get_the_title($attachment_id);

			$image = '<div class="code125-gallery-item code125-gallery-item-'.$id.' '.$class.'" href="'.$image_full[0].'" title="'.$title.'" style="min-height: '.$image_attributes[2].'px;"><div class="code125-gallery-wrap"><div class="code125-gallery-image"></div><span class="title">'.$title.'</span></div>';
			$image .= '<style>'.$this->background_css('.code125-gallery-item-'.$id .' .code125-gallery-image' , array($src , $src_2x)).'</style>';
			$image .= '</div>';
			return $image;
		}
	}

	function background_css( $element ,  $image_data ){
		$css = '';

		$css .= $element . '{background-image:url(\'' . $image_data[0] . '\');}';
		if (isset($image_data[1]) && $image_data[1]!= '') {
			$css .= ' @media
			only screen and (-webkit-min-device-pixel-ratio: 2),
			only screen and (   min--moz-device-pixel-ratio: 2),
			only screen and (     -o-min-device-pixel-ratio: 2/1),
			only screen and (        min-device-pixel-ratio: 2),
			only screen and (                min-resolution: 192dpi),
			only screen and (                min-resolution: 2dppx) { ';
			$css .= $element . '{background-image:url(\'' . $image_data[1] . '\');}';
			$css .= '}';
		}


		return $css;
	}



	function options() {

		$this->_options =array(
			array(
                'label' => 'Layout',
                'id' => 'layout',
                'type' => 'select',
                'desc' => 'Contact Info Layout.',
                'std' => 'layout-1',
                'choices' => array(
                    array(
                        'label' => 'Layout 1',
                        'value' => 'layout-1'
                    ),
                    array(
                        'label' => 'Layout 2',
                        'value' => 'layout-2'
                    ),
                ),
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
			array(
				'label' => 'Gallery',
				'id' => 'gallery',
				'type' => 'gallery',
				'desc' => 'Gallery Images.',
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
