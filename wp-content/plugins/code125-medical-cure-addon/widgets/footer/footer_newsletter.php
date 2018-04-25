<?php

class C5AB_footer_newsletter extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_skip_title = true;
	public  $_options =array();


	function __construct() {

		$id_base = 'footer-newsletter-widget';
		$this->_shortcode_name = 'c5ab_footer_newsletter';
		$name = 'Footer Newsletter';
		$desc = 'Footer Newsletter';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}


	function shortcode($atts,$content) {
		$return = '<section class="code125-newsletter-wrap code125-footer-newsletter">';

		if($atts['title']!=''){
			$return .= '<h3>'.$atts['title'].'</h3>';
		}

		if($atts['desc']!=''){
			$return .= '<p>'.$atts['desc'].'</p>';
		}

		if($atts['form']!=''){
			$return .= do_shortcode( '[mc4wp_form id="'.$atts['form'].'"]' );
		}
		$return .= '</section>';
		return $return;

	}


	function custom_css() {

	}

	function options() {
		if (function_exists('mc4wp_get_forms')) {
			$forms = mc4wp_get_forms();
			$all_forms = array();
			foreach ($forms as $form) {
				$select = array(
					'label' => $form->name,
					'value' => $form->ID
				);
				$all_forms[] = $select;
			}

			$this->_options =array(
				array(
					'label' => 'Title',
					'id' => 'title',
					'type' => 'text',
					'desc' => 'Newsletters Title',
					'std' => 'Newsletters',
					'rows' => '',
					'post_type' => '',
					'taxonomy' => '',
					'class' => ''
				),
				array(
					'label' => 'Description',
					'id' => 'desc',
					'type' => 'text',
					'desc' => 'Description',
					'std' => 'Get trusted advice from the doctors at Medical Cure and Stay up-to-date on the latest developments in health.',
					'rows' => '',
					'post_type' => '',
					'taxonomy' => '',
					'class' => ''
				),
				array(
					'label' => 'Choose form',
					'id' => 'form',
					'type' => 'select',
					'desc' => 'Choose form to be shown here',
					'std' => '',
					'choices' => $all_forms,
					'rows' => '',
					'post_type' => '',
					'taxonomy' => '',
					'class' => ''
				),

			);

		}else{
			$this->_options =array(
				array(
	                'label' => 'Important Note',
	                'id' => 'note',
	                'type' => 'textblock-titled',
	                'desc' => 'The subscribe form needs <a href="https://wordpress.org/plugins/mailchimp-for-wp/" target="_blank">MailChimp for WordPress</a> to be installed, Kindly install it then create your form and you can choose it here.',
	                'std' => '',
	                'rows' => '',
	                'post_type' => '',
	                'taxonomy' => '',
	                'class' => ''
	            ),

			);
		}

	}

	function css() {

	}

}


?>
