<?php

class C5AB_pricing_table extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = false;
	public  $_skip_title = true;
	public  $_cache_output = true;
	public  $_options =array();

	function __construct() {

		$id_base = 'pricing-table-column-widget';
		$this->_shortcode_name = 'c5ab_pricing_table';
		$name = 'Pricing table Column';
		$desc = 'Add Pricing table Column.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}

	function shortcode($atts,$content) {

		$return = '';

		if (isset($atts['c5ab_pricing_element']) && is_array($atts['c5ab_pricing_element'])) {
			$tabs = '';
			foreach ($atts['c5ab_pricing_element'] as $tab) {
				$tabs .= '<li><span class="' . $tab['icon'] . '"></span> ' . $tab['content'] . '</li>';
			}

			$featured_class = '';
			$featured_html = '';
			$button_class = 'c5-btn-theme';
			if ($atts['featured']== 'on') {
				$featured_class = 'c5-best-price';
				$featured_html = '<div class="c5-best-badge">'.$atts['featured_text'].'<span></span></div>';
				$button_class = 'c5-btn-white';
			}

			if ($atts['layout'] == '2') {
				$button_class = 'c5-btn-theme';
				$return = '<div class="c5-plan-pkg"><div class="c5-plan-item">';
				if ($atts['image'] != '') {

					$image_size = c5ab_generate_image_size($GLOBALS['c5_content_width'] , 170, true);
					$attachment_id = c5ab_get_attachment_id_from_src($atts['image']);
					$src= '';
					$src_2x = '';
					$image_attributes = c5_wp_get_attachment_image_src($attachment_id , $image_size , false );
					if ($image_attributes) {
						$src = $image_attributes[0];
						$src_2x = $image_attributes[3];
					}
					if ($src!='') {

						$src_set = $src .' 1x';
						if ($src_2x != '') {
							$src_set .= ', '.$src_2x. ' 2x';
						}
						$return .= '<figure class="c5-item-img"><img src="'.$src.'" srcset="'.$src_set.'" alt="" class="img-responsive"></figure>';
					}

				}

				$return .= '<div class="c5-item-title"><h3>'.$atts['title'].'</h3><span>'.$atts['price_subtitle'].'</span></div>';

				$return .= '<div class="c5-item-price"><h4>'.$atts['price'].'</h4></div>';

				$return .= '<div class="c5-item-des"><ul>' . $tabs .'</ul></div>';
				if($atts['button_text'] != '' && $atts['button_link'] != '' ){
					$return .= '<div class="c5-item-btn"><a href="'.$atts['button_link'].'" class="btn '.$button_class.'">'. $atts['button_text'] .'</a></div>';

				}
				$return .= '</div></div>';
			}else{
				$return = '<div class="c5-table-prices"><div class="c5-table-prices-content"><div class="c5-table-item">';
				$return .= '<div class="'.$featured_class.'">';
				$return .= $featured_html;

				$return .= '<div class="c5-table-heading"><h4>'.$atts['title'].'</h4><p><strong>'.$atts['price'].'</strong>'.$atts['price_subtitle'].'</p></div>';

				$return .= '<div class="c5-table-details"><ul>' . $tabs .'</ul></div>';

				if($atts['button_text'] != '' && $atts['button_link'] != '' ){
					$return .= '<!-- table footer --><div class="c5-table-footer"><a href="'.$atts['button_link'].'" class="btn '.$button_class.'">'. $atts['button_text'] .'</a>
					</div><!-- ./table footer -->';
				}

				$return .= '</div></div></div></div>';
			}


		}
		return $return;
	}



	function options() {

		$this->_options =array(
			array(
				'label' => 'Featured Column ?',
				'id' => 'featured',
				'type' => 'on-off',
				'desc' => 'Is this column Featured?.',
				'std' => 'off',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => '',
			),
			array(
				'label' => 'Featured text',
				'id' => 'featured_text',
				'type' => 'text',
				'desc' => 'Featured text.',
				'std' => 'Best Value',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => '',
			),
			array(
				'label' => 'Featured Image',
				'id' => 'image',
				'type' => 'upload',
				'desc' => 'Featured Image.',
				'std' => '',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => '',
			),
			array(
				'label' => 'Layout',
				'id' => 'layout',
				'type' => 'select',
				'desc' => 'Service Column Layout',
				'std' => '1',
				'choices' => array(
					array(
						'label' => 'Layout 1',
						'value' => '1'
					),
					array(
						'label' => 'Layout 2',
						'value' => '2'
					),
				),
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => ''
			),
			array(
				'label' => 'Title',
				'id' => 'title',
				'type' => 'text',
				'desc' => 'Column Title.',
				'std' => 'Basic',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => '',
			),
			array(
				'label' => 'Price',
				'id' => 'price',
				'type' => 'text',
				'desc' => 'Column Price.',
				'std' => '19.99',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => '',
			),
			array(
				'label' => 'Price Subtitle',
				'id' => 'price_subtitle',
				'type' => 'text',
				'desc' => 'Column Price subtitle.',
				'std' => '$ /Per month',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => '',
			),
			array(
				'label' => 'Add Pricing Element',
				'id' => 'c5ab_pricing_element',
				'type' => 'list-item',
				'desc' => 'Add Pricing Element the Pricing Column.',
				'settings' => array(
					array(
						'label' => 'Content',
						'id' => 'content',
						'type' => 'textarea-simple',
						'desc' => 'Pricing Element Content.',
						'std' => '',
						'rows' => '',
						'post_type' => '',
						'taxonomy' => '',
						'class' => '',
					),
					array(
						'label' => 'Icon',
						'id' => 'icon',
						'type' => 'icon-list',
						'desc' => '',
						'std' => 'fa fa-check',
						'rows' => '',
						'post_type' => '',
						'taxonomy' => '',
						'class' => ''
					),
				),
				'std' => '',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => ''
			),
			array(
				'label' => 'Button Text',
				'id' => 'button_text',
				'type' => 'text',
				'desc' => 'Button text.',
				'std' => 'Request Plan',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => '',
			),
			array(
				'label' => 'Button Link',
				'id' => 'button_link',
				'type' => 'text',
				'desc' => 'Button link.',
				'std' => '#',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => '',
			),
		);
	}


}


?>
