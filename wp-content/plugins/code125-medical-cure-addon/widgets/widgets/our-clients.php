<?php

class C5AB_clients extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = false;
    public $_options = array();

    function __construct() {

        $id_base = 'clients-widget';
        $this->_shortcode_name = 'c5ab_clients';
        $name = 'Our Clients';
        $desc = 'Our clients section.';
        $classes = '';

        $this->self_construct($name, $id_base, $desc, $classes);
    }


    function shortcode($atts, $content) {


        $id = $this->generate_unique_id();
        $return = '<div class="code125-clients code125-clients-'.$id.' code125-clients-slider" >';
        foreach ($atts['c5ab_client'] as $tab) {


            $return .= '<div class="c5-client-single" >';

            if ($tab['url'] != '') {
                $return .= '<a href="'.$tab['url'].'">';
            }else{
                $return .= '<a class="code125-client-image-magnify" href="'.$tab['logo'].'">';

            }
            $image_size = c5ab_generate_image_size(180, 9999, false);
            $image_data = $this->get_image($image_size , $tab['logo']);
            // print_r($image_data);
            $srcset = $image_data[1] != '' ? 'srcset="'.$image_data[0].' 1x,'.$image_data[1].' 2x" ' : '';
            $src = $image_data[0] != '' ? $image_data[0] : $tab['logo'];
            $return .= '<img src="'.$src.'" '.$srcset.' alt="'.$tab['title'].'" />';

            $return .= '</a>';

            $return .= '</div>';

        }
        $return .= '</div>';

        $this->_js .= "
		$('.code125-clients-".$id."').magnificPopup({
			delegate: '.code125-client-image-magnify',
			type: 'image',
			tLoading: 'Loading image #%curr%...',
			mainClass: 'mfp-img-mobile',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0,1]
			},
			image: {
				tError: '<a href=\"%url%\">The image #%curr%</a> could not be loaded.',
			}
		});";

        return $return;
    }

    public function get_image($image_size , $url)
    {
        $src = $url;
        $src_2x = '';
        $attachment_id = c5ab_get_attachment_id_from_src($url);
        if ($attachment_id != '') {
            $image_attributes = c5_wp_get_attachment_image_src($attachment_id , $image_size , false );
            if (isset( $image_attributes[3]) ) {
                $src = $image_attributes[0];
                $src_2x = $image_attributes[3];
            }
        }
        return array($src, $src_2x);
    }


    function get_unique_id() {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < 5; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }




    function options() {


        $this->_options = array(
            array(
                'label' => 'Add Client',
                'id' => 'c5ab_client',
                'type' => 'list-item',
                'desc' => 'Add Client to the Clients section.',
                'settings' => array(
                    array(
                        'label' => 'Client Logo',
                        'id' => 'logo',
                        'type' => 'upload',
                        'desc' => 'Upload the client logo',
                        'std' => '',
                        'rows' => '8',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => '',
                    ),
                    array(
                        'label' => 'Client url',
                        'id' => 'url',
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
