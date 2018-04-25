<?php

class C5AB_pricing_list extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = false;
	public  $_skip_title = true;
	public  $_cache_output = true;
	public  $_options =array();

	function __construct() {

		$id_base = 'pricing-list-column-widget';
		$this->_shortcode_name = 'c5ab_pricing_list';
		$name = 'Pricing List Column';
		$desc = 'Add Pricing List Column.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}


	function shortcode($atts,$content) {

		$return = '';

		if (isset($atts['c5ab_pricing_list_element']) && is_array($atts['c5ab_pricing_list_element'])) {
			$tabs = '';
			foreach ($atts['c5ab_pricing_list_element'] as $tab) {
				$tabs .= '<li>' . $tab['content'] . ' <span class="price">' . $tab['price'] . '</span></li>';
			}

			$return = '<div class="code125-pricing-list-wrap clearfix">';
			$return .= '<div class="code125-pricing-list-title">';
			if ($atts['title']!='') {
				$return .= '<h3>' . $atts['title'] . '</h3>';
			}
			if ($atts['subtitle']!='') {
				$return .= '<p>' . $atts['subtitle'] . '</p>';
			}
			$return .= '</div>';

			$return .= '<div class="code125-pricing-list-elements"><ul>' . $tabs .'</ul>';

			$return .= code125_format_button($atts['button'] , 'btn inverse center pricing-list-button');

			$return .= '</div></div>';

		}
		return $return;
	}



	function options() {

		$this->_options =array(
			array(
				'label' => 'Title',
				'id' => 'title',
				'type' => 'text',
				'desc' => 'Pricing List Title',
				'std' => '',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => '',
			),
			array(
				'label' => 'Subtitle',
				'id' => 'subtitle',
				'type' => 'text',
				'desc' => 'Pricing List Subtitle',
				'std' => '',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => '',
			),
			array(
				'label' => 'Button Details',
				'id' => 'button',
				'type' => 'button',
				'desc' => 'Button Details.',
				'std' => '',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => '',
			),
			array(
				'label' => 'Add Pricing Element',
				'id' => 'c5ab_pricing_list_element',
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
						'label' => 'Price',
						'id' => 'price',
						'type' => 'text',
						'desc' => '',
						'std' => '',
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

		);
	}


}


?>
