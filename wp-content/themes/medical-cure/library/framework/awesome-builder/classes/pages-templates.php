<?php

/**
 *
 */
class C5AB_Pages_Templates extends C5PB_BASE {

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
        <h2 class="c5ab-title"><?php  esc_html_e('Choose Page Template to import', 'medical-cure') ?></h2>
        <p class="c5ab-theme-template-desc"><?php  esc_html_e('Click on any of the following templates to be added into your page.', 'medical-cure') ?></p>
        <div class="c5ab-page-templates-row clearfix">
        <?php
        $templates = apply_filters( 'c5_get_all_page_templates', array() );

        foreach ($templates as $template) {

            $base_url = apply_filters( 'c5_page_templates_base_url', '' );
            if ($base_url!= '') {
                $title = $template;
                echo '<div class="c5ab-page-template col-sm-3" data-id="'.$template.'">';
                echo '<span class="c5ab-theme-template-bg" ><p>'.$title.'</p><img src="'.$base_url . 'images/pages/' . $template.'.png" class="page-template" width="300" alt="'.$title.'" /></span>';
                echo '</div>';
            }

        }
        ?>
        </div>
        <?php

    }


    public function get_content()
    {
        // name of transient in database
		$transName = 'code125-page-templates';

		// get cached fonts
		$content = get_transient( $transName );

		// check for transient. If none, then get all fonts from API
		// if( $content === false ) {
        if(true){
			// get all fonts from API json content
			$url =  'https://s3-us-west-2.amazonaws.com/code125/medical-cure/page-templates/page-templates.json';
			$templates = wp_remote_get( $url, array('sslverify' => false) );

			// check if it is not a valid request
			if( is_wp_error( $templates ) ) {

				return;

			} else {

				$content = json_decode($templates['body'], true);
				set_transient($transName, $content, DAY_IN_SECONDS);

			}

		}

		return $content;
    }

    public function ge_url_content($url)
    {
        $templates = wp_remote_get( $url, array('sslverify' => false) );

        // check if it is not a valid request
        if( is_wp_error( $templates ) ) {
            print_r($templates);
            return;
        } else {
            return json_decode($templates['body'], true);
        }
    }

    public function get_template_data($filename = '')
    {
        $base_url = apply_filters( 'c5_page_templates_base_url', '' );
        if ($base_url!= '') {
            $url  = $base_url . 'content/pages/' . $filename . '.json';

            $content = $this->ge_url_content($url);

            if (!is_wp_error( $content )) {
                $obj = new C5AB_Theme_Templates();
                $response = $obj->validate_template_data($content);
                return $response;
            }
        }
        return;
    }

    public function get_template($filename='')
    {
        $url = 'https://s3-us-west-2.amazonaws.com/code125/medical-cure/page-templates/content/' . $filename.'.json';


        $templates = wp_remote_get( $url, array('sslverify' => false) );

        // check if it is not a valid request
        if( is_wp_error( $templates ) ) {

            return;

        } else {

            $content = json_decode($templates['body']);
            return $content;

        }
    }


}


?>
