<?php

class C5AB_appointment extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = true;
    public  $_skip_title = true;
    public $_options = array();

    function __construct() {

        $id_base = 'appointment-widget';
        $this->_shortcode_name = 'c5ab_appointment';
        $name = 'Appointment Forms';
        $desc = 'Add Appointment Forms Box';
        $classes = '';

        $this->self_construct($name, $id_base, $desc, $classes);
    }



    function shortcode($atts, $content) {

        $data = '<div class="code125-appointment  code125-appointment-'.$atts['layout'].'">';

        if ($atts['title']!= '') {
            $data .= '<h3>'.$atts['title'].'</h3>';
        }
        if ($content!='') {
            $data .= '<div class="code125-appointment-content">'. wpautop( $content) .'</div>';
        }

        $form = do_shortcode( '[contact-form-7 id="'.$atts['form'].'"]' );
        $form = str_replace( '<p>'   ,'', $form);
        $form = str_replace( '</p>'  ,'', $form);
        $form = str_replace( '<br/>' ,'', $form);
        $form = str_replace( '<br>'  ,'', $form);
        $form = strip_tags($form, '<label><div><input><select><textarea><option><form>');


        $data .= $form . '</div>';
        return $data;
    }

    function custom_css() {



    }

    function options() {

        $args = array(
            'post_type' => 'wpcf7_contact_form',
            'posts_per_page' => -1
        );
        // The Query
        $the_query = new WP_Query( $args );

        // The Loop
        if ( $the_query->have_posts() ) {

            $this->_options =array(
                array(
                    'label' => 'Title',
                    'id' => 'title',
                    'type' => 'text',
                    'desc' => 'Appointment Box Title',
                    'std' => '',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'class' => ''
                ),
                array(
                    'label' => 'Description',
                    'id' => 'content',
                    'type' => 'wp_editor',
                    'desc' => '',
                    'std' => '',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'class' => ''
                ),
                array(
				    'label' => 'Layout',
				    'id' => 'layout',
				    'type' => 'select',
				    'desc' => 'Appointment Box layout.',
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
                    'label' => 'Choose form',
                    'id' => 'form',
                    'type' => 'custom-post-type-select',
                    'desc' => 'Choose form to be shown here',
                    'std' => '',
                    'rows' => '',
                    'post_type' => 'wpcf7_contact_form',
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
                    'desc' => 'The Contact form needs <a href="https://wordpress.org/plugins/contact-form-7/" target="_blank">Contact Form 7</a> to be installed, Kindly install it then create your form and you can choose it here.',
                    'std' => '',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'class' => ''
                ),

            );
        }
        wp_reset_postdata();


    }
}
