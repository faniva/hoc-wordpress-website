<?php

/**
 *
 */
class C5AB_Theme_Templates extends C5PB_BASE {

    function __construct()
    {
        # code...
    }
    public function render()
    {

        ?>
        <div class="c5ab-header-screens">
		 	<span class="c5ab-screen-control c5ab-close-screen ">x</span>
		 </div>
        <h2 class="c5ab-title"><?php  esc_html_e('Ready to use content blocks', 'medical-cure') ?></h2>
        <p class="c5ab-theme-template-desc"><?php  esc_html_e('Click on any of the following templates to be added into your page. Build the page with the content that suits you the most.', 'medical-cure') ?></p>

        <?php
        $elements = apply_filters( 'c5_get_all_elements', array() );
        // print_r($response);
        foreach ($elements as $element) {
            $info = explode('/' , $element);
            $filename = $info[1];
            $type = $info[0];

            $base_url = apply_filters( 'c5_page_templates_base_url', '' );
            if ($base_url!= '') {

                echo '<div class="c5ab-theme-template " data-id="'.$filename.'" data-type="'.$type.'" style="background-image: url(\''.$base_url . 'images/elements/' . $element.'.png\')">';
                echo '<p class="collection"><span>'.$type.'</span></p>';
                echo '</div>';

            }

        }

    }

    public function templates_loader()
    {

        $args =array(
            'product' => 'medical-cure',
            'grant_type' => 'templates'
        );

        $response = $this->connect($args);
        return $response;
    }

    public function ge_url_content($url)
    {
        $templates = wp_remote_get( $url, array('sslverify' => false) );

        // check if it is not a valid request
        if( is_wp_error( $templates ) ) {
            return;
        } else {
            return json_decode($templates['body'], true);
        }
    }

    public function get_template_data($filename = '')
    {
        $base_url = apply_filters( 'c5_page_templates_base_url', '' );
        if ($base_url!= '') {
            $url  = $base_url . 'content/elements/' . $filename . '.json';
            $content = $this->ge_url_content($url);
            $response = $this->validate_template_data($content['content']);

            return $response;
        }

    }

    public function validate_image($url)
    {
        if (!apply_filters( 'code125-full-demo', false )) {
            $url = 'https://s3-us-west-2.amazonaws.com/code125/medical-cure/placeholder.jpg';
        }

        $attachment_id = c5ab_get_attachment_id_from_src( $url );
        if (!$attachment_id) {
            $attachment_id = c5ab_get_attachment_id_from_file_name(basename($url));
        }
        if (!$attachment_id) {
            $attachment_id = $this->upload_image( $url , ''  );
        }
        if ($attachment_id) {

            $image_data = wp_get_attachment_image_src( $attachment_id, 'full');
            if (!is_wp_error( $image_data )) {
                $url = $image_data[0];
            }
        }
        return $url;
    }

    public function recursive_validation($row)
    {
        $parent = $row['id'];
        if (isset($row['settings']['custom_background'])) {
            $background =  $this->decode( $row['settings']['custom_background'] );
            if (isset($background['code125-background-image']) && $background['code125-background-image'] != '') {
                $background['code125-background-image']= $this->validate_image($background['code125-background-image']);
                $row['settings']['custom_background'] = $this->encode($background);
            }
        }

        if (isset($row['content']) ) {
            if ($row['type'] == 'element') {

                if ($this->is_image($row['helper_text'])) {
                    $row['helper_text'] =  $this->validate_image($row['helper_text']);
                }
                $row['content'] = $this->validate_content($row['content']);
            }else {
                foreach ($row['content'] as $key => $inner_row) {
                    $newID = $this->generate_unique_id();
                    $row['id'] = $newID;
                    $row['parent'] = $parent;
                    $row['content'][$key] = $this->recursive_validation($inner_row);
                }
            }

        }
        return $row;

    }
    public function validate_content($content)
    {
        foreach ($content as $key => $value) {
            if(is_array($value)){
                $content[$key] =  $this->validate_content($value);
            }elseif( is_array(@$this->decode( $value) ) ){
                $content[$key] =  $this->validate_content($this->decode( $value));
            }else{
                if ($this->is_image($value)) {
                    $content[$key] =  $this->validate_image($value);
                }
            }

        }
        return $content;
    }

    public function is_image($value)
    {

        if (substr($value, 0, 4) == 'http') {
             $imgExts = array(".gif", ".jpg", ".jpeg", ".png", ".tiff", ".tif" , ".svg");
             foreach ($imgExts as $extension) {
                 if (strpos(basename($value), $extension) !== false) {
                    return true;
                }
            }
        }
        return false;
    }

    public function validate_template_data($response)
    {

        if( is_array(@$this->decode( $response) ) ){
    		$template_array = $this->decode( $response) ;
            if (isset($template_array['type']) &&  $template_array['type'] = 'row') {
                $template_array = array($template_array);
            }
            foreach ($template_array as $key => $row) {
                $newID = $this->generate_unique_id();
                $row['id'] = $newID;
                $template_array[$key] = $this->recursive_validation($row);

            }
            return $this->encode($template_array);
        }
        return $response;

    }
    function upload_image( $photo_name , $postid  ) {
		if( !class_exists( 'WP_Http' ) )
		include_once( ABSPATH . WPINC. '/class-http.php' );

		$photo = new WP_Http();
		$photo = $photo->request( $photo_name );
		if (is_wp_error($photo)) {
			//			print_r($photo);
			return false;
		}
		if( $photo['response']['code'] != 200 )
		return false;

		$attachment = wp_upload_bits(  basename( $photo_name ) , null, $photo['body'], date("Y-m", strtotime( $photo['headers']['last-modified'] ) ) );

		if( !empty( $attachment['error'] ) )
		return false;

		$filetype = wp_check_filetype( basename( $attachment['file'] ), null );

		$postinfo = array(
			'post_mime_type'	=> $filetype['type'],
			'post_title'		=> preg_replace( '/\.[^.]+$/', '', basename( $photo_name ) ),
			'post_content'		=> '',
			'post_status'		=> 'inherit',
		);
		$filename = $attachment['file'];
		$attach_id = wp_insert_attachment( $postinfo, $filename, $postid );

		if( !function_exists( 'wp_generate_attachment_data' ) )
		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
		wp_update_attachment_metadata( $attach_id,  $attach_data );
		return $attach_id;
	}

    function generate_unique_id() {
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < 6; $i++) {
		    $randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}


    public function connect($args) {
        $url = 'https://templates.code125.com/wp-json/authenticate/v1/templates';

        $theme = wp_get_theme();

        if( $theme->parent() ){
            $current_theme_name	=	$theme->parent()->get('Name');
            $current_theme_version	=	$theme->parent()->get('Version');
        }
        else{
            $current_theme_name	=	$theme->get('Name');
            $current_theme_version	=	$theme->get('Version');
        }

        $args['url'] = esc_url( home_url('/') );
        $args['theme'] = $current_theme_name;
        $args['version'] = $current_theme_version;


		$response = wp_remote_post( $url, array(
			'method' => 'POST',
			'timeout' => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array(),
			'body' => $args,
			'cookies' => array()
		    )
		);

        if ( is_wp_error( $response ) ) {
           $error_message = $response->get_error_message();
           return  "Something went wrong: $error_message";
        }

        $response =  json_decode( $response['body'], true );
        return $response;
    }



}


?>
