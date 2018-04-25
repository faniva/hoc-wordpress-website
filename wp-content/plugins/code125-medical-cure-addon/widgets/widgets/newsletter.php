<?php

class C5AB_newsletter extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_skip_title = true;
	public  $_options =array();


	function __construct() {

		$id_base = 'newsletter-widget';
		$this->_shortcode_name = 'c5ab_newsletter';
		$name = 'Newsletter Subscription';
		$desc = 'Newsletter Subscription ';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}


	function shortcode($atts,$content) {

		$content_html = '';

		if($atts['form']!=''){

			$shortcode = do_shortcode( '[mc4wp_form id="'.$atts['form'].'"]' );
			$id = $this->generate_unique_id();
			$shortcode = str_replace('type="submit"', 'type="submit" class="code125-newsletter-button btn-'.$id.'"' , $shortcode);
			$content_html .= '<div class="code125-newsletter-wrap code125-newsletter-layout-'.$atts['layout'].'">';

			if ($atts['title']!='') {
				$content_html .= '<h3><span class="fa fa-envelope"></span> '.$atts['title'].'</h3>';
			}
			if ($atts['description']!='') {
				$content_html .= '<p>'.$atts['description'].'</p>';
			}

			$content_html .= $shortcode . '</div>';

		}
		return $content_html;


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
				    'label' => 'Layout',
				    'id' => 'layout',
				    'type' => 'select',
				    'desc' => 'Newsletter design layout.',
				    'std' => 'horizontal',
	                'choices' => array(
	                    array(
	                        'label' => 'Horizontal',
	                        'value' => 'horizontal'
	                    ),
	                    array(
	                        'label' => 'Vertical',
	                        'value' => 'vertical'
	                    ),
						array(
	                        'label' => 'Sidebar',
	                        'value' => 'sidebar'
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
					'desc' => 'Newsletter title',
					'std' => '',
					'rows' => '',
					'post_type' => '',
					'taxonomy' => '',
					'class' => ''
				),
				array(
					'label' => 'Description',
					'id' => 'description',
					'type' => 'text',
					'desc' => 'Newsletter Description',
					'std' => '',
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
