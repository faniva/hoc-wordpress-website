<?php

/**
*
*/
class C5_theme_import
{

    function __construct() {
        add_filter( 'c5_theme_name',  array($this, 'set_theme_name') );
        add_filter( 'c5_theme_videos_url',  array($this, 'set_theme_videos_url') );
        add_filter( 'c5_theme_docs_url',  array($this, 'set_theme_docs_url') );
        add_filter( 'c5_theme_purchase_url',  array($this, 'set_theme_purchase_url') );
        add_filter( 'c5_import_categories_url',  array($this, 'set_categories_url') );
        add_filter( 'c5_import_demo_data',  array($this, 'set_demo_urls') );
        add_filter( 'c5_import_menu_locations',  array($this, 'set_menu_locations') );
        add_filter( 'c5_quick_setup_sections',  array($this, 'c5_quick_setup_sections') );
        add_filter( 'c5_quick_setup_options',  array($this, 'c5_quick_setup_options') );

        add_filter( 'code125-activation-category-filter', '__return_false' );

        add_filter( 'c5_theme_ticket_url',  array($this, 'c5_theme_ticket_url') );
        add_filter( 'c5_about_theme',  array($this, 'c5_about_theme') );


        add_filter( 'c5cbg_default_color_suggestion',  array($this, 'c5cbg_default_color_suggestion') );
        add_filter( 'c5cbg_default_color_2_suggestions',  array($this, 'c5cbg_default_color_2_suggestions') );
        add_filter( 'c5cbg_default_color_3_suggestions',  array($this, 'c5cbg_default_color_3_suggestions') );


        // add_action('code125-after-demo-import' , array($this, 'after_demo_import'));

    }
    public function after_demo_import($slug = 'main-demo')
    {
        echo '<p>Updating Pages ...</p>';
        $obj = new C5AB_Pages_Templates();
        $args = array(
        	'post_type'   => 'page',
            'posts_per_page' => -1
        );
        $page_query = new WP_Query( $args );

        // The Loop
        if ( $page_query->have_posts() ) {
        	while ( $page_query->have_posts() ) {
        		$page_query->the_post();

                $post_id = get_the_ID();
                $title = get_the_title();
                $title = strtolower($title);
                $title = str_replace(' ', '-', $title);
                $url = $slug . '-'. $title;
                print_r($url . "\n");
            	$template = $obj->get_template_data($url);
                print_r($template);
                print_r("\n");
                update_post_meta( $post_id,'c5ab_data', $template);
        	}
        }
        /* Restore original Post Data */
        wp_reset_postdata();

    }
    public function c5cbg_default_color_suggestion()
    {
        return ot_get_option('primary_color' ,'#0065b3');
    }


    public function c5_about_theme($value='')
    {
        $description = '<p>Medical Cure is a Premium Medical Purpose WordPress Theme handcrafted for building elegant and up-to-date website.</p>  ';

        return $description;
    }
    function c5_theme_ticket_url(){
        $value = 'https://code125.com/out/medical-cure-support/';
        return $value;
    }


    public function set_theme_name($value='')
    {
        $value = 'Medical Cure';
        return $value;
    }
    public function set_theme_videos_url($value='')
    {
        $value = 'https://www.youtube.com/user/Code125Channel';
        return $value;
    }



    public function set_theme_docs_url($value='')
    {
        $value = 'https://docs.code125.com/medical-cure/';
        return $value;
    }
    public function set_theme_purchase_url($value='')
    {
        $value = 'https://code125.com/out/medical-cure/';
        return $value;
    }
    public function set_categories_url($value='')
    {
        $value = 'https://preview.code125.com/medical-cure/categories.txt';
        return $value;
    }
    public function set_menu_locations($menus)
    {
        $menus['main-nav'] = 'Main Menu';
        $menus['footer-nav'] = 'Footer';

        return $menus;
    }


    public function set_demo_urls($options)
    {

        $base_url = 'https://s3-us-west-2.amazonaws.com/code125/medical-cure/';

        if (apply_filters( 'code125-full-demo', false )) {
            $xml_url = $base_url . 'demo.xml';
        }else{
            $xml_url = $base_url . 'demo-stripped.xml';
        }

        $demos = array(
            'main-demo' => array(
                'label' => 'Main Demo',
                'slug' => 'main-demo',
                'xml' => $xml_url,
                'theme-options' => $base_url . 'theme-options.txt',
                'widgets' => $base_url . 'widgets.json',
                'img' => $base_url . 'demo-imgs/main-demo.png',
                'homepage' => 'Homepage',
                'demo_url' => 'https://medical-cure.code125.com/main-demo/'
            ),
            'clinic-demo' => array(
                'label' => 'Clinic Demo',
                'slug' => 'clinic-demo',
                'xml' => $base_url . 'clinic.xml',
                'theme-options' => $base_url . 'clinic-options.txt',
                'widgets' => $base_url . 'clinic-widgets.json',
                'img' => $base_url . 'demo-imgs/main-demo.png',
                'homepage' => 'Home',
                'demo_url' => 'https://medical-cure.code125.com/clinic/'
            ),
        );

        foreach ($demos as $key => $demo) {
            $options[$key] =  $demo;
        }

        return $options;
    }


    public function c5_quick_setup_sections($sections)
    {
        $sections = array(
            array(
                'title' => 'Welcome',
                'id' => 'welcome',
                'desc'=> '<p class="about-description">Thank You for Purcharsing our products, we created this quick setup wizard to help you to set most of the common tasks during your theme installtion, to minimize the time you look in the docs and video tutorials on how to setup your website.</p><p class="about-description">We hope that we will give you a real assistant here.</p>'
            ),
            array(
                'title' => 'Add Your Logo',
                'id' => 'logo',
                'desc'=> '<p class="about-description">Upload Your Website logo, make sure that you upload the biggest size of the logo in jpeg/png format and set the height and we will handle it for you.</p>'
            ),
            array(
                'title' => 'Set Header Layout',
                'id' => 'header',
                'desc'=> '<p class="about-description">Choose your website header layout.</p>'
            ),
            array(
                'title' => 'Set Your Color',
                'id' => 'color',
                'desc'=> '<p class="about-description">Choose the main color for your website, choose the best color that represent your website and brand.</p>'
            ),

            array(
                'title' => 'Set Your Fonts',
                'id' => 'fonts',
                'desc'=> '<p class="about-description">Choose the fonts that will apply to your website, you can choose 2 different fonts to be applied on your headings and your content</p>'
            ),
            array(
                'title' => 'Set Default Blog Layout',
                'id' => 'blog',
                'desc'=> '<p class="about-description">Choose the default blog type for your website, this will affect homepage, category, tag, author and search pages.</p>'
            ),



        );
        return $sections;
    }

    public function c5_quick_setup_options($options='')
    {
        $fonts_obj = new C5_font();
        $google_fonts = $fonts_obj->get_select_array();

        $layouts  = array(
            'layout_1' => 'Layout 1',
            'layout_2' => 'Layout 2',
            'layout_3' => 'layout 3',
            'layout_4' => 'Layout 4',
            'layout_5' => 'layout 5',
         );
        $choices = array();
        foreach ($layouts as $key => $label) {
            $choices[] = array(
                'src' => C5_LOCAL_OPTIONS_IMG_URL . 'header/' . $key . '.png',
                'src_2x' => C5_LOCAL_OPTIONS_IMG_URL . 'header/' . $key . '@2x.png',
                'label' => $label,
                'value' => $key
            );
        }


        $layouts  = array(
			'blog-1' => 'Layout 1',
            'blog-2' => 'Layout 2',
            'blog-3' => 'Layout 3',
			'blog-4' => 'Layout 4',
         );
        $blog_choices = array();
        foreach ($layouts as $key => $label) {
            $blog_choices[] = array(
                'src' => C5_LOCAL_OPTIONS_IMG_URL . 'blog/' . $key . '.png',
                'src_2x' => C5_LOCAL_OPTIONS_IMG_URL . 'blog/' . $key . '@2x.png',
                'label' => $label,
                'value' => $key
            );
        }


        $options = array(
            array(
                'id'          => 'welcome_text',
                'label'       => 'Build your website in few steps!',
                'desc'        => '<p class="about-description">Most of our customers want to build their website in very easy way and don\'t want to read or watch a lot of documentation/video tutorials and thus we created this question based wizard to make it super easy to you.</p>',
                'std'         => '',
                'type'        => 'textblock',
                'section'     => 'welcome',
                'class' => '',
            ),
            array(
                'label' => 'Website Logo',
                'id' => 'logo',
                'type' => 'upload',
                'desc' => 'Upload the main logo for your website, Upload as the logo as big as you can, you choose its size below',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => 'logo'
            ),
            array(
                'label' => 'Logo Height',
                'id' => 'logo_height',
                'type' => 'numeric-slider',
                'desc' => 'Slide to select your Logo Height in <strong>pixels</strong>. "We will calculate the width automaticly based on the height"',
                'std' => '30',
                'min_max_step' => '10,300,1',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => 'logo'
            ),
            array(
                'label' => 'What is your website color?',
                'id' => 'primary_color',
                'type' => 'colorpicker',
                'desc' => 'Pick a the main color for the theme (default: #005bd3 ).',
                'std' => '#005bd3',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => 'color'
            ),
            array(
                'label' => 'Header Layout',
                'id' => 'header_layout',
                'type' => 'radio-image',
                'desc' => '',
                'choices' => $choices,
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => 'header'
            ),
            array(
                'label' => 'Primary Heading Font',
                'id' => 'heading_font',
                'type' => 'select',
                'desc' => 'Select your Header font from the available fonts, Fonts are provided via Google Fonts API',
                'choices' => $google_fonts,
                'std' => 'Poppins#latin#googlefont',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => 'fonts'
            ),
            array(
                'label' => 'Body Font',
                'id' => 'body_font',
                'type' => 'select',
                'desc' => 'Select your body "Default" font from the available fonts, Fonts are provided via Google Fonts API',
                'choices' => $google_fonts,
                'std' => 'Muli#latin#googlefont',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => 'fonts'
            ),

            array(
                'label' => 'Default Blog Layout',
                'id' => 'default_blog_layout',
                'type' => 'radio-image',
                'desc' => '',
                'choices' => $blog_choices,
                'std' => 'blog-1',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class'=>'c5-blog-layout',
                'section' => 'blog'
            ),


        );
        return $options;
    }

}
$import_obj = new C5_theme_import();

?>
