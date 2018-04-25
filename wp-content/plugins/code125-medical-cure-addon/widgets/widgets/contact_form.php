<?php

class C5AB_contact_form extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = true;
    public  $_skip_title = true;
    public $_options = array();

    function __construct() {

        $id_base = 'contact_form-widget';
        $this->_shortcode_name = 'c5ab_contact_form';
        $name = 'Contact us Form';
        $desc = 'Add Contact us Form Box';
        $classes = '';

        $this->self_construct($name, $id_base, $desc, $classes);
    }



    function shortcode($atts, $content) {

        $data = '<div class="c5-contacts-form">';
        if ($atts['title']!='') {
            $data .= '<h3>'.$atts['title'].'</h3>';
        }
        if ($content != '') {
            $data .= wpautop( $content );
        }
        $form = do_shortcode( '[contact-form-7 id="'.$atts['form'].'"]' );
        $form = str_replace('<p>','', $form);
        $form = str_replace('</p>','', $form);
        $form = str_replace('<br/>','', $form);
        $form = str_replace('<br>','', $form);

        // $form = strip_tags($form, '<label><div><input><select><textarea><option><form>');

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
                    'desc' => 'Title',
                    'std' => '',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'class' => ''
                ),
                array(
                    'label' => 'Content',
                    'id' => 'content',
                    'type' => 'wp-editor',
                    'desc' => '',
                    'std' => '',
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
