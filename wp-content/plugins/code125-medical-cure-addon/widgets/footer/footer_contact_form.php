<?php

class C5AB_footer_contact_form extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = true;
    public $_options = array();

    function __construct() {

        $id_base = 'footer_contact_form-widget';
        $this->_shortcode_name = 'c5ab_footer_contact_form';
        $name = 'Footer Contact us Form';
        $desc = 'Add Footer Contact us Form Box, this widget is designed to be used in Footer';
        $classes = '';

        $this->self_construct($name, $id_base, $desc, $classes);
    }



    function shortcode($atts, $content) {

        $data = '<form class="c5-contact-form c5-footer-contact-form large clearfix" method="post" action="'. home_url() .'">';

    	$data .=  '<input type="text" name="name" class="form-name element-block"  placeholder="'.$atts['name'].'" size="20" />';

    	$data .=  '<input type="text" name="email" class="form-email element-block" placeholder="'.$atts['your_email'].'" size="20" />';

    	$data .= '<textarea  placeholder="'.$atts['message'].'" name="message" class=" form-message element-block  " tabindex="4" aria-required="true"></textarea>';

    	$data .= '<input name="submit" class="submit form-submit c5-form-submit" type="submit" value="'.$atts['send'].'">';

        $data .= '<input type="hidden" name="recieve_email" class="recieve_email" value="'.$atts['email'].'" /><div class="clearfix"></div><div class="message_contact_true alert alert-success"><p>'.$atts['success'].'</p></div><div class="message_contact_false alert alert-warning"><p>'.$atts['fail'].'</p></div></form>';

        return $data;
	}

	function custom_css() {



    }

    function options() {



        $this->_options = array(
            array(
                'label' => 'Email to recieve',
                'id' => 'email',
                'type' => 'text',
                'desc' => 'Add Email to recieve.',
                'std' => '',
            ),
            array(
                'label' => 'Name Placeholder',
                'id' => 'name',
                'type' => 'text',
                'desc' => 'Add name placeholder.',
                'std' => 'Name',
            ),
            array(
                'label' => 'Email Placeholder Text',
                'id' => 'your_email',
                'type' => 'text',
                'desc' => 'Add Email  Placeholder text.',
                'std' => 'Email',
            ),
            array(
                'label' => 'Message Placeholder Text',
                'id' => 'message',
                'type' => 'text',
                'desc' => 'Add Message Placeholder Text.',
                'std' => 'Your message ...',
            ),
            array(
                'label' => 'Send Text',
                'id' => 'send',
                'type' => 'text',
                'desc' => 'Add your Send Button Text.',
                'std' => 'Send',
            ),
            array(
                'label' => 'Succesful Message Text',
                'id' => 'success',
                'type' => 'text',
                'desc' => 'Add your Succesful Message Text.',
                'std' => 'Your Message was sent, Thank you.',
            ),
            array(
                'label' => 'Failure Message Text',
                'id' => 'fail',
                'type' => 'text',
                'desc' => 'Add your Failure Message Text.',
                'std' => 'Your Message was not sent, Please try again.',
            ),

         );
    }




}

?>
