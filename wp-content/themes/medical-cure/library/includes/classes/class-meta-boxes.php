<?php

class C5_meta_boxes extends C5_theme_option_elements {

    function __construct() {
        add_filter( 'c5_fw_meta_box_post' , array($this, 'meta_box_post'));
        add_filter( 'c5_fw_meta_box_rest' , array($this, 'meta_box_post'));
        add_filter( 'c5_fw_meta_box_page' , array($this, 'meta_box_page'));

    }

    public function meta_box_post($options)
    {
        $options[] =array(
            'title' => 'Featured Media',
            'options' => $this->featured_media(),
            'order' => 1
        );

        $options[] = array(
            'title' => 'Appearance',
            'options' => $this->appearance(),
            'order' => 3
        );


        $options[] = array(
            'title' => 'Layout',
            'options' => $this->layout(),
            'order' => 4
        );

        $categories = $this->dominating_categories();
        if(!empty($categories)){
            $options[] = array(
                'title' => 'Dominating Category',
                'options' => $categories,
                'order' => 5
            );
        }

        return $options;
    }

    public function meta_box_page($options)
    {
        $options[] =array(
            'title' => 'General',
            'options' => $this->general_page(),
            'order' => 1
        );
        $options[] = array(
            'title' => 'Slider area',
            'options' => $this->page_slider(),
            'order' => 1
        );
        $options[] = array(
            'title' => 'Appearance',
            'options' => $this->appearance(),
            'order' => 5
        );
        $options[] = array(
            'title' => 'Layout',
            'options' => $this->layout(),
            'order' => 6
        );
        return $options;
    }


    public function appearance()
    {
        $appearance_fields = array();
        $appearance_fields[] = array(
            'label' => 'Use Custom Color Settings',
            'id' => 'use_custom_colors',
            'type' => 'on_off',
            'desc' => 'Use Custom Color Settings.',
            'std' => 'off',
            'class' => ''
        );
        $appearance_fields = array_merge( $appearance_fields,  $this->get_colors_options() );

        return $appearance_fields;
    }

    public function layout()
    {
        $layout_fields = array();
        $layout_fields[] = array(
            'label' => 'Use Custom Layout Settings',
            'id' => 'use_custom_layout',
            'type' => 'on_off',
            'desc' => 'Use Custom Layout Settings.',
            'std' => 'off',
            'class' => ''
        );
        $layout_fields = array_merge( $layout_fields,  $this->get_layout_options() );

        return $layout_fields;
    }

    public function featured_media()
    {
        $options = array(
            array(
                'label' => 'Video / Audio / Facebook Status / Twitter Status url',
                'id' => 'meta_attachment',
                'type' => 'text',
                'desc' => 'Video url, we support "Youtube, Vimeo and Dailymotion" or Audio url we support "Audio and Soundcloud"',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Is this article in RTL Language',
                'id' => 'c5_rtl',
                'type' => 'on_off',
                'desc' => 'If you have LTR website and want to write an article in RTL, this button will keep the styling cool',
                'std' => 'off',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Custom Background for Article',
                'id' => 'custom_background',
                'type' => 'upload',
                'desc' => 'Upload a custom background to your article page.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Featured Image Color overlay ',
                'id' => 'custom_color_average',
                'type' => 'colorpicker',
                'desc' => 'Overwrite the automatic color overlay generated for the featured image',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
        );
        return $options;
    }

    public function dominating_categories()
    {
        $options = array();
        if (isset($_GET['post_type'])) {
            $post_type = $_GET['post_type'];
        } else {
            if (isset($_GET['post'])) {
                $id = $_GET['post'];
                $post_type = get_post_type($id);
            } else {
                $post_type = 'post';
            }
        }
        if ($post_type != 'page') {
            $tax = c5_get_tax_from_post_type($post_type);

            $options =  array(
                array(
                    'label' => 'Choose Dominating Category',
                    'id' => 'category_follow',
                    'type' => 'taxonomy-select',
                    'desc' => 'Choose Dominating Category for this post, the Article will follow this category in its styling settings.',
                    'std' => '',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => $tax,
                    'class' => ''
                )
            );
        }
        return $options;
    }


    public function general_page()
    {
        $layouts  = array(
            'default' => 'Default',
            'layout-1' => 'Layout 1',
            'layout-2' => 'Layout 2',
            'layout-3' => 'layout 3',
            'layout-4' => 'layout 4',
         );
        $choices = array();
        foreach ($layouts as $key => $label) {
            $choices[] = array(
                'src' => C5_LOCAL_OPTIONS_IMG_URL . 'page-info/' . $key . '.png',
                'src_2x' => C5_LOCAL_OPTIONS_IMG_URL . 'page-info/' . $key . '@2x.png',
                'label' => $label,
                'value' => $key
            );
        }

        $layouts  = array(
            'default' => 'Default',
            'layout_1' => 'Layout 1',
            'layout_2' => 'Layout 2',
            'layout_3' => 'layout 3',
            'layout_4' => 'Layout 4',
            'layout_5' => 'layout 5',
         );
        $header_choices = array();
        foreach ($layouts as $key => $label) {
            $header_choices[] = array(
                'src' => C5_LOCAL_OPTIONS_IMG_URL . 'header/' . $key . '.png',
                'src_2x' => C5_LOCAL_OPTIONS_IMG_URL . 'header/' . $key . '@2x.png',
                'label' => $label,
                'value' => $key
            );
        }



        $options = array(
            array(
                'label' => 'Enable Page Info Title',
                'id' => 'enable_breadcrumb',
                'type' => 'on_off',
                'desc' => 'Enable/Disable Breadcrumb (Page info) for this Page',
                'std' => 'on',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Page Subtitle',
                'id' => 'subtitle',
                'type' => 'text',
                'desc' => 'Add Page Subtitle to Page Info Section',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Page Info layout',
                'id' => 'page_info_layout',
                'type' => 'radio-image',
                'desc' => '',
                'choices' => $choices,
                'std' => 'default',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
            ),

            array(
                'label' => 'Page Header layout',
                'id' => 'header_layout',
                'type' => 'radio-image',
                'desc' => '',
                'choices' => $header_choices,
                'std' => 'default',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
            ),
            array(
                'label' => 'Login Required',
                'id' => 'login_required',
                'type' => 'on_off',
                'desc' => 'Make this page Login Required',
                'std' => 'off',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
        );
        return $options;
    }

    public function page_slider()
    {

        $options = array(
            array(
			    'label' => 'Create Slider, Use Banners  / Rearrange the banner slides',
			    'id' => 'banner_slides',
			    'type' => 'posts-search',
			    'desc' => 'Create Slider, Use Banners (Post Type) to create the banner designs you want. You can create a new banner here <a href="'.admin_url('post-new.php?post_type=theme-banner').'" target="_blank">here</a>. <br/><br/><strong>Note:</strong> Using this will automaticly disable the page info section "Where title and breadcrumbs are presented".',
			    'std' => '',
			    'rows' => '',
			    'post_type' => 'theme-banner',
			    'taxonomy' => '',
			    'class' => ''
			),
            array(
			    'label' => 'Custom top content',
			    'id' => 'custom_top_content',
			    'type' => 'textarea-simple',
			    'desc' => 'Use this section to alter the top content. Mostly you will be using shortcodes from external plugins like sliders plugin or any other content you want to present on the top area.  <br/><br/><strong>Note:</strong> Using this will automaticly disable the page info section "Where title and breadcrumbs are presented" and theme slider.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),

        );
        return $options;
    }



}
$meta_boxes = new C5_meta_boxes();
?>
