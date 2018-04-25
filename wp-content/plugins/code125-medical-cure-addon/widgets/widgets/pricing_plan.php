<?php

class C5AB_pricing_plan extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = false;
	public  $_skip_title = true;
	public  $_cache_output = true;
	public  $_options =array();

	function __construct() {

		$id_base = 'pricing-plan-column-widget';
		$this->_shortcode_name = 'c5ab_pricing_plan';
		$name = 'Pricing Plan Column';
		$desc = 'Add Pricing Plan Column.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}



	function shortcode($atts,$content) {

		$return = '';

		if (isset($atts['c5ab_pricing_plan_element']) && is_array($atts['c5ab_pricing_plan_element'])) {
			$tabs = '';
			foreach ($atts['c5ab_pricing_plan_element'] as $tab) {
				$tabs .= '<li><span class="c5-icon '.$tab['icon'].'"></span> ' . $tab['content'] . '</li>';
			}

			$return = '<div class="code125-pricing-plan-wrap clearfix">';
			$return .= '<div class="code125-pricing-plan-title">';
			if ($atts['title']!='') {
				$return .= '<h3>' . $atts['title'] . '</h3>';
			}
			if ($atts['subtitle']!='') {
				$return .= '<p class="subtitle">' . $atts['subtitle'] . '</p>';
			}
			if ($content != '' ){
				$return .= '<div class="content">' . wpautop( $content ) . '</div>';
			}
			if ($atts['price']!='') {
				$return .= '<p class="price">' . $atts['price'] . '</p>';
			}
			$return .= code125_format_button($atts['button'] , 'btn inverse center pricing-plan-button');

			$return .= '</div>';

			$return .= '<div class="code125-pricing-plan-elements"><ul>' . $tabs .'</ul></div>';


			$return .= '</div>';

		}
		return $return;
	}



	function options() {

		$this->_options =array(
			array(
				'label' => 'Title',
				'id' => 'title',
				'type' => 'text',
				'desc' => 'Pricing Plan Title',
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
				'desc' => 'Pricing Plan Subtitle',
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
				'desc' => 'Pricing Plan Price',
				'std' => '',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => '',
			),
			array(
				'label' => 'Description',
				'id' => 'content',
				'type' => 'wp-editor',
				'desc' => '',
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
				'id' => 'c5ab_pricing_plan_element',
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
