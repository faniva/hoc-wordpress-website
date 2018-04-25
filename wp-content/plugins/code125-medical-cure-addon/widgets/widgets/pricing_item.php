<?php

class C5AB_pricing_item extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = false;
	public  $_skip_title = true;
	public  $_cache_output = true;
	public  $_options =array();

	function __construct() {

		$id_base = 'pricing-item-column-widget';
		$this->_shortcode_name = 'c5ab_pricing_item';
		$name = 'Pricing Items';
		$desc = 'Add Pricing Items.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}



	function shortcode($atts,$content) {

		$return = '';

		if (isset($atts['pricing-items']) && is_array($atts['pricing-items'])) {
			$tabs = '';
			foreach ($atts['pricing-items'] as $tab) {
				$tabs .= '<li><p class="title clearfix"><span class="text">'.$tab['title'].'</span><span class="price">'.$tab['price'].'</span></p>';
				if ($tab['subtitle']!='') {
					$tabs .= '<p class="subtitle">'.$tab['subtitle'].'</p>';
				}
				$tabs .= '</li>';
			}

			$return = '<div class="code125-pricing-items clearfix">';
			$return .= '<ul>' . $tabs .'</ul>';
			$return .= '</div>';

		}
		return $return;
	}



	function options() {

		$this->_options =array(

			array(
				'label' => 'Add Pricing Item',
				'id' => 'pricing-items',
				'type' => 'list-item',
				'desc' => 'Add Pricing Item.',
				'settings' => array(
					array(
						'label' => 'Subtitle',
						'id' => 'subtitle',
						'type' => 'text',
						'desc' => 'Subtitle.',
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
