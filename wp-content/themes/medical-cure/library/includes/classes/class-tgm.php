<?php
/**
*
*/
class C5_TGM_PLUGINS
{

    function __construct(){
        add_filter( 'c5_fw_tgmpa', array($this, 'plugins') );
    }
    public function plugins($plugins)
    {
        $plugins[] = array(
		    'name'               => 'Code125 Medical Cure Addon',
		    'slug'               => 'code125-medical-cure-addon',
		    'source'             => 'https://s3-us-west-2.amazonaws.com/code125/plugins/code125-medical-cure-addon-1.1.0.zip',
		    'required'           => true,
		    'version'            => '1.1.0',
		    'force_activation'   => false,
		    'force_deactivation' => false,
		);
        $plugins[] = array(
		    'name'               => 'Slider Revolution',
		    'slug'               => 'revslider',
		    'source'             => 'https://s3-us-west-2.amazonaws.com/code125/plugins/revslider-5.4.7.2.zip',
		    'required'           => false,
		    'version'            => '5.4.7.2',
		    'force_activation'   => false,
		    'force_deactivation' => false,
		);
        $plugins[] = array(
	        'name'               => 'Contact Form 7',
	        'slug'               => 'contact-form-7',
	        'required'           => false,
	    );
        $plugins[] = array(
	        'name'               => 'MailChimp for WordPress',
	        'slug'               => 'mailchimp-for-wp',
	        'required'           => false,
	    );


        return $plugins;
    }
}
$obj = new C5_TGM_PLUGINS();
?>
