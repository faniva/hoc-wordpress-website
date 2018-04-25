<?php

class C5_theme_option_elements extends C5_theme_option_base{


    function __construct() {

    }






    function get_logo_options($section = '') {
        $options = apply_filters( 'c5_logo_theme_options', $section );

        return $options;
    }
    function get_shop_skin($section = '') {
        if(!class_exists( 'WooCommerce' )){
            return array();
        }


        $return = array(
            'label' => 'Choose The default Skin for Woocommerce Products',
            'id' => 'skin_default_shop',
            'type' => 'custom-post-type-select',
            'desc' => 'Choose The default Skin for Woocommerce Products.',
            'std' => '',
            'rows' => '',
            'post_type' => 'skin',
            'taxonomy' => '',
            'class' => '',
            'section' => $section
        );
        return $return;
    }
    function get_skins_options($section = '') {
        $options = array(
            $this->get_skin_array('Website', 'skin_default', $section),
            $this->get_skin_array('Pages', 'skin_default_page', $section),
            $this->get_shop_skin($section),
            $this->get_skin_array('Category', 'skin_default_category', $section),
            $this->get_skin_array('Tags', 'skin_default_tag', $section),
            $this->get_skin_array('Search Page', 'skin_default_search', $section),
            $this->get_skin_array('Archive Page "Year, Month"', 'skin_default_archive', $section),
            $this->get_skin_array('404 Page', 'skin_default_404', $section),
        );

        return $options;
    }

    function get_templates_options($section = '') {
        $options = array(
            $this->get_template_array('Website', 'default_template', $section),
            $this->get_template_array('Category Page', 'cat_template', $section),
            $this->get_template_array('Tag Page', 'tag_template', $section),
            $this->get_template_array('Author Page', 'author_template', $section),
            $this->get_template_array('Search Page', 'search_template', $section),
            $this->get_template_array('Archive Page "Year, Month"', 'archive_template', $section),
            $this->get_template_array('404 Page', '404_template', $section),
        );

        return $options;
    }

    function get_default_options($section = '') {

        $layouts  = array(
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

        $post_types = array();

        $skip = array(
            'page',
            'attachment',
            'revision',
            'nav_menu_item',
            'custom_css',
            'customize_changeset',
            'oembed_cache',
            'cpt',
            'theme-banner',
            'theme-footer',
            'wpcf7_contact_form',
            'mc4wp-form',

        );
        $result = get_post_types(   );
        foreach ($result   as $post_type ) {
            if (!in_array($post_type , $skip)) {
                $post_types[] = array(
                    'value'       => $post_type,
                    'label'       => $post_type
                );
            }


        }
        $options = array(
            array(
                'label' => 'Default Page Info banner image',
                'id' => 'default_banner',
                'type' => 'upload',
                'desc' => '',
                'std' => '',
                'section' => $section
            ),
            array(
                'label' => 'Page Info Layout',
                'id' => 'page_info_layout',
                'type' => 'radio-image',
                'desc' => '',
                'choices' => $choices,
                'std' => 'layout-1',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'id'          => 'page_builder_post_types',
                'label'       => __('Enable Page Builder for post types', 'medical-cure'),
                'desc'        => __('Mark all the custom post types to enable page builder to.', 'medical-cure'),
                'std'         => '',
                'type'        => 'checkbox',
                'section'     => $section,
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'choices'     => $post_types
            ),
            array(
                'label' => 'Enable Preloading animation',
                'id' => 'preload',
                'type' => 'on_off',
                'desc' => 'Choose ON to Enable Preloading animation.',
                'std' => 'on',
                'section' => $section
            ),

            array(
                'label' => 'Enable Code125 Gallery Style',
                'id' => 'gallery_style',
                'type' => 'on_off',
                'desc' => 'Choose ON to enable Code125 Gallery Style. You will use this feature if you want to use a plugin that offers different gallery styling.',
                'std' => 'on',
                'section' => $section
            ),

            array(
                'label' => 'Custom CSS Code',
                'id' => 'custom_css',
                'type' => 'css',
                'desc' => 'Paste your custom css code.',
                'std' => '',
                'rows' => '10',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => 'Custom Javascript Code',
                'id' => 'custom_js',
                'type' => 'textarea-simple',
                'desc' => 'Paste your custom Javascript code.',
                'std' => '',
                'rows' => '10',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
        );

        return $options;
    }

    function get_header_options($section = '') {
        $options = array( );

        $layouts  = array(
            'layout_1' => 'Layout 1',
            'layout_2' => 'Layout 2',
            'layout_3' => 'layout 3',
            'layout_4' => 'Layout 4',
            'layout_5' => 'layout 5',
            'layout_6' => 'layout 6',
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

        $options [] =  array(
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
            'section' => $section
        );

        //Search bar
        $options [] = array(
            'label' => 'Enable Search Bar',
            'id' => 'search_on',
            'type' => 'on_off',
            'desc' => 'Choose to Show Search Bar or not.',
            'std' => 'on',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
            'section' => $section
        );
        //Search bar
        $options [] = array(
            'label' => 'Search Bar placeholder',
            'id' => 'search_placeholder',
            'type' => 'text',
            'desc' => 'Add the text that will appear as a placeholder for the search bar.',
            'std' => 'Search our website',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
            'section' => $section
        );


        //Header Text
        $options [] =  array(
            'label' => 'Header Info',
            'id' => 'header_info',
            'type' => 'list-item',
            'desc' => 'Info related to your business like Location, Phone Number and contact info',
            'settings' => array(
                array(
                    'label' => 'Subtitle',
                    'id' => 'subtitle',
                    'type' => 'text',
                    'desc' => 'Subtitle',
                    'choices' => '',
                    'std' => '',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'class' => ''
                ),
                array(
                    'label' => 'Link',
                    'id' => 'link',
                    'type' => 'text',
                    'desc' => 'Your Link',
                    'choices' => '',
                    'std' => '',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'class' => ''
                ),
                $this->get_icons_options('fa fa-phone'),
                array(
                    'label' => 'Link Type',
                    'id' => 'type',
                    'type' => 'select',
                    'desc' => '',
                    'choices' => array(
                        array(
                            'label' => 'normal link (URL)',
                            'value' => 'url',
                        ),
                        array(
                            'label' => 'Email',
                            'value' => 'email',
                        ),
                        array(
                            'label' => 'Phone',
                            'value' => 'phone',
                        ),
                        array(
                            'label' => 'Skype',
                            'value' => 'skype',
                        ),
                    ),
                    'std' => '',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'class' => '',
                )
            ),
            'std' => '',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
            'section' => $section
        );

        //Header Button
        $options [] = array(
            'label' => 'Header Button',
            'id' => 'header_btn',
            'type' => 'button',
            'desc' => 'Header Button.',
            'std' => '',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
            'section' => $section
        );

        //// social icons
        $options [] =  array(
            'label' => 'Social Icons',
            'id' => 'social_icons',
            'type' => 'list-item',
            'desc' => '',
            'settings' => array(
                array(
                    'label' => 'Link',
                    'id' => 'link',
                    'type' => 'text',
                    'desc' => 'Your Social Link',
                    'choices' => '',
                    'std' => '',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'class' => ''
                ),
                $this->get_icons_options('fa fa-facebook')
            ),
            'std' => '',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
            'section' => $section
        );

        //Floating Bar
        $options [] = array(
            'label' => 'Enable Floating Bar',
            'id' => 'floating_enable',
            'type' => 'on_off',
            'desc' => 'Choose to Show Floating Bar or not.',
            'std' => 'on',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
            'section' => $section
        );
        $options [] =  array(
            'label' => 'Floating Logo',
            'id' => 'floating_logo',
            'type' => 'upload',
            'desc' => 'Upload the Floating logo for your website, Upload as the logo as big as you can, you choose its size below',
            'std' => '',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
            'section' => $section
        );

        $options [] =  array(
            'label' => 'Floating Logo Height',
            'id' => 'floating_logo_height',
            'type' => 'numeric-slider',
            'desc' => 'Slide to select your Logo Height in <strong>pixels</strong>. "We will calculate the width automaticly based on the height"',
            'std' => '30',
            'min_max_step' => '10,300,1',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
            'section' => $section
        );

        $options [] = array(
            'label' => 'Floating Logo Top Margin',
            'id' => 'floating_logo_margin',
            'type' => 'numeric-slider',
            'desc' => 'Top Margin for the Floating logo for your website, Default:7px.',
            'std' => '12',
            'min_max_step' => '0,300,1',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
            'section' => $section
        );

        return $options;
    }

    function get_orderby_array($tag_id, $default = 'date',$section = '') {

        $orderby = array(
            'none' => 'None',
            'id' => 'Post ID',
            'author' => 'Author',
            'title' => 'Title',
            'date' => 'Date Created',
            'modified' => 'Date Modified',
            'parent' => 'Post/Page Parent ID',
            'rand' => 'Random',
            'comment_count' => 'Number of Comments',
            'menu_order' => 'Page Order',

            'votes_count' => 'Likes Count',
            'rating_average' => 'Rating Average',
            'post_views_count' => 'Views Count',
        );

        $array = array();
        foreach ($orderby as $key => $value) {
            $array[] = array(
                'label' => $value,
                'value' => $key
            );
        }

        $ret_array = array(
            'label' => 'Order By',
            'id' => $tag_id,
            'type' => 'Select',
            'desc' => 'Order by a certain parameter',
            'std' => $default,
            'choices' => $array,
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
            'section' => $section
        );
        return $ret_array;
    }


    function get_footer_options($section = '') {
        $options = array(

            array(
                'label' => 'Enable Footer',
                'id' => 'footer_enable',
                'type' => 'on_off',
                'desc' => '',
                'std' => 'on',
                'rows' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => 'Footer Source',
                'id' => 'footer_source',
                'type' => 'select',
                'desc' => 'Set Footer Source',
                'choices' => array(
                    array(
                        'label' => 'Widgets',
                        'value' => 'widgets'
                    ),
                    array(
                        'label' => 'Footer Custom Post Type',
                        'value' => 'cpt'
                    )
                ),
                'std' => 'widgets',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => 'Footer Template',
                'id' => 'footer_template',
                'type' => 'custom-post-type-select',
                'desc' => 'Choose The Footer template.',
                'std' => '',
                'rows' => '',
                'post_type' => 'theme-footer',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => 'Footer Background',
                'id' => 'footer_background',
                'type' => 'colorpicker',
                'desc' => 'Footer Background Color',
                'std' => '',
                'rows' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => 'Footer Layout',
                'id' => 'footer_layout',
                'type' => 'select',
                'desc' => 'Set Footer Layout',
                'choices' => array(
                    array(
                        'label' => '1/3 - 1/3 - 1/3',
                        'value' => '4-4-4'
                    ),
                    array(
                        'label' => '1/4 - 1/4 - 1/4 - 1/4',
                        'value' => '3-3-3-3'
                    ),
                    array(
                        'label' => '1/2 - 1/4 - 1/4',
                        'value' => '6-3-3'
                    ),
                    array(
                        'label' => '1/3 - 1/6 - 1/6 - 1/3',
                        'value' => '4-2-2-4'
                    )
                ),
                'std' => '4-4-4',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => 'Enable Copyrights Footer',
                'id' => 'footer_copyrights_enable',
                'type' => 'on_off',
                'desc' => '',
                'std' => 'on',
                'rows' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => 'Footer Copyright',
                'id' => 'footer_copyrights',
                'type' => 'textarea-simple',
                'desc' => '',
                'std' => '<p>2017 - Code125. All Rights Reserved. Designed & Developed by <a href="https://code125.com/out/medical-cure" target="_blank">Code125 Team</a></p>',
                'rows' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            )

        );
        return $options;
    }



    function get_colors_options($section = '') {
        $options = array(
            array(
                'label' => 'Primary Color',
                'id' => 'primary_color',
                'type' => 'colorpicker',
                'desc' => 'Pick a the main color for the theme (default: #005bd3 ).',
                'std' => '#005bd3',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => 'c5-color-settings',
                'section' => $section
            ),
            array(
                'label' => 'Main Background',
                'id' => 'background',
                'type' => 'background',
                'desc' => 'Set the main background for your webstie. (default: #f8f8f8)',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => 'c5-color-settings',
                'section' => $section
            ),
        );

        return $options;
    }

    function get_colors_style_options($section = '') {
        $options = array(
            array(
                'label' => 'Website Color Scheme',
                'id' => 'color_scheme',
                'type' => 'select',
                'desc' => 'Set the website color Scheme (Default: light).',
                'std' => 'light',
                'choices' => array(
                    array(
                        'label'=>'Light',
                        'value'=>'light',
                    ),
                    array(
                        'label'=>'Dark',
                        'value'=>'dark',
                    ),
                ),
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
        );

        return $options;
    }

    function get_fonts_options($section = '') {
        $fonts_obj = new C5_font();
        $google_fonts = $fonts_obj->get_select_array();
        $arabic_fonts = $fonts_obj->get_arabic_fonts();


        $options = array(
            array(
                'label' => 'Primary Heading Font',
                'id' => 'heading_font',
                'type' => 'select',
                'desc' => 'Select your Heading font from the available fonts, Fonts are provided via Google Fonts API',
                'choices' => $google_fonts,
                'std' => 'Poppins#latin#googlefont',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
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
                'section' => $section
            ),
            array(
                'label' => 'Primary Heading Font (RTL)',
                'id' => 'heading_font_rtl',
                'type' => 'select',
                'desc' => 'Select your RTL Heading font from the available fonts, Fonts are provided via Google Fonts API and Fontface API',
                'choices' => $arabic_fonts,
                'std' => 'bein#fontface#default',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => 'Body Font (RTL)',
                'id' => 'body_font_rtl',
                'type' => 'select',
                'desc' => 'Select your RTL body "Default" font from the available fonts, Fonts are provided via Google Fonts API and Fontface API',
                'choices' => $arabic_fonts,
                'std' => 'bein#fontface#default',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            $this->get_font_size_array('Body', 'body_fs', '14', $section ),
            $this->get_font_size_array('Menu', 'menu_fs', '14', $section ),
            array(
                'label' => 'Heading Font Weight',
                'id' => 'heading_font_weight',
                'type' => 'select',
                'desc' => 'Choose Default Heading Font Weight',
                'choices' => array(
                    array(
                        'label'=>'font-weight',
                        'value'=>'',
                    ),
                    array(
                        'label'=>'Lighter',
                        'value'=>'lighter',
                    ),
                    array(
                        'label'=>'Regular',
                        'value'=>'regular',
                    ),
                    array(
                        'label'=>'Bold',
                        'value'=>'bold',
                    ),
                    array(
                        'label'=>'Bolder',
                        'value'=>'bolder',
                    ),
                    array(
                        'label'=>'100',
                        'value'=>'100',
                    ),
                    array(
                        'label'=>'200',
                        'value'=>'200',
                    ),
                    array(
                        'label'=>'300',
                        'value'=>'300',
                    ),
                    array(
                        'label'=>'400',
                        'value'=>'400',
                    ),
                    array(
                        'label'=>'500',
                        'value'=>'500',
                    ),
                    array(
                        'label'=>'600',
                        'value'=>'600',
                    ),
                    array(
                        'label'=>'700',
                        'value'=>'700',
                    ),
                    array(
                        'label'=>'800',
                        'value'=>'800',
                    ),
                    array(
                        'label'=>'900',
                        'value'=>'900',
                    ),
                ),
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),



        );

        return $options;
    }

    function get_layout_options( $section = '') {


        global $wp_registered_sidebars;

        $sidebars = array();
        foreach ($wp_registered_sidebars as $sidebar_new) {
            $sidebars[] = array(
                'label' => $sidebar_new['name'],
                'value' => $sidebar_new['id']
            );
        }






        $options = array(
            array(
                'label' => 'Page Layout',
                'id' => 'page_width',
                'type' => 'select',
                'desc' => 'Choose Page Layout',
                'choices' => array(
                    array(
                        'label'=>'Full Width',
                        'value'=>'full',
                    ),
                    array(
                        'label'=>'Left Sidebar',
                        'value'=>'left',
                    ),
                    array(
                        'label'=>'Right Sidebar',
                        'value'=>'right',
                    ),
                ),
                'std' => 'right',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => 'c5-layout-control',
                'section' => $section
            ),
            array(
                'label' => 'Sidebar',
                'id' => 'big_sidebar',
                'type' => 'select',
                'desc' => 'Select the Big Page sidebar.',
                'choices' => $sidebars,
                'std' => 'sidebar',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => 'c5-layout-control',
                'section' => $section
            ),

        );

        return $options;
    }

    function get_default_blog($section = '') {

        $layouts  = array(
            'blog-1' => 'Layout 1',
            'blog-2' => 'Layout 2',
            'blog-3' => 'Layout 3',
            'blog-4' => 'Layout 4',
        );
        $choices = array();
        foreach ($layouts as $key => $label) {
            $choices[] = array(
                'src' => C5_LOCAL_OPTIONS_IMG_URL . 'blog/' . $key . '.png',
                'src_2x' => C5_LOCAL_OPTIONS_IMG_URL . 'blog/' . $key . '@2x.png',
                'label' => $label,
                'value' => $key
            );
        }

        $options = array(
            array(
                'label' => 'Default Blog Layout',
                'id' => 'default_blog_layout',
                'type' => 'radio-image',
                'desc' => '',
                'choices' => $choices,
                'std' => 'blog-1',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'section' => $section
            ),
            array(
                'label' => 'Reorder and Enable/Disable Meta Data',
                'id' => 'meta_data',
                'type' => 'meta-data',
                'desc' => 'Reorder and Enable/Disable the Meta data for you blog posts',
                'std' => 'author_off,time_on,category_off,comment_on,like_on',
                'choices' => array(
                    array(
                        'label'=>'Author',
                        'icon'=>'fa fa-user',
                        'value'=>'author',
                        'default'=>'on'
                    ),
                    array(
                        'label'=>'Date',
                        'icon'=>'fa fa-calendar-o',
                        'value'=>'time',
                        'default'=>'on'
                    ),
                    array(
                        'label'=>'Category',
                        'icon'=>'fa fa-tags',
                        'value'=>'category',
                        'default'=>'on'
                    ),
                    array(
                        'label'=>'Comments',
                        'icon'=>'fa fa-comment-o',
                        'value'=>'comment',
                        'default'=>'on'
                    ),
                    array(
                        'label'=>'Likes',
                        'icon'=>'fa fa-heart-o',
                        'value'=>'like',
                        'default'=>'on'
                    ),
                    array(
                        'label'=>'Views',
                        'icon'=>'fa fa-eye',
                        'value'=>'views',
                        'default'=>'on'
                    ),
                    array(
                        'label'=>'Rating',
                        'icon'=>'fa fa-star-o',
                        'value'=>'rating',
                        'default'=>'on'
                    ),

                ),
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => 'Date Format',
                'id' => 'c5_date_format',
                'type' => 'select',
                'desc' => 'Set The Date format "Normal date: 12th January, 2013" or "Ago date: 2 days ago"',
                'choices' => array(
                    array(
                        'label' => 'Date & Time',
                        'value' => 'date_time'
                    ),
                    array(
                        'label' => 'Only Date',
                        'value' => 'date'
                    ),
                    array(
                        'label' => 'Only Time',
                        'value' => 'time'
                    ),
                    array(
                        'label' => 'Ago Format',
                        'value' => 'ago'
                    ),
                    array(
                        'label' => 'Date then Ago Format',
                        'value' => 'date_ago'
                    ),
                ),
                'std' => 'date',
                'class' => '',
                'section' => $section
            )
        );
        return $options;
    }

    function get_sidebars_options($section = '') {


        $options = array(
            array(
                'label' => 'Sidebars',
                'id' => 'sidebars',
                'type' => 'list-item',
                'desc' => 'Add Unlimited Sidebars to your website.',
                'settings' => array(
                    array(
                        'label' => 'Slug',
                        'id' => 'slug',
                        'type' => 'text',
                        'desc' => 'Sidebar Slug "All lowercase and must be unique".',
                        'std' => '',
                    ),
                    array(
                        'label' => 'Description',
                        'id' => 'description',
                        'type' => 'textarea-simple',
                        'desc' => 'Sidebar Description.',
                        'std' => '',
                        'rows' => '5',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => ''
                    )
                ),
                'std' => '',
                'section' => $section
            ),
        );

        return $options;
    }

    function get_menu_locations_options($section = '') {


        $options = array(
            array(
                'label' => 'Menu Locations',
                'id' => 'menus',
                'type' => 'list-item',
                'desc' => 'Add Unlimited Menu Locations to your website.',
                'settings' => array(
                    array(
                        'label' => 'Location',
                        'id' => 'location',
                        'type' => 'text',
                        'desc' => 'Menu Location You will get the menu by that name. "No spaces"',
                        'std' => '',
                    )
                ),
                'std' => '',
                'section' => $section
            ),
        );

        return $options;
    }

    function get_custom_fonts_options($section = '') {
        $c5_font_obj = new C5_font();
        $options = $c5_font_obj->get_custom_fonts_options($section);
        return $options;
    }

    function get_search_options($section = '') {
        $args = array('show_ui' => true);
        $types_array = array();
        $output = 'objects'; // names or objects

        $post_types = get_post_types($args, $output);
        //print_r($post_types);
        $exlude_array = array(
            'attachment',
            'skin',
            'header',
            'footer'
        );
        foreach ($post_types as $key => $post_type) {

            if (!in_array($key, $exlude_array)) {
                $types_array[] = array(
                    'label' => $post_type->label,
                    'value' => $key
                );
            }
        }
        $options = array(
            array(
                'label' => 'Default Search Post Type',
                'id' => 'search_post',
                'type' => 'select',
                'desc' => 'Choose the post type you want to make the search based on.',
                'choices' => $types_array,
                'std' => 'post',
                'section' => $section
            ),
        );

        return $options;
    }

    function get_icons_options($default='fa fa-none') {

        $options = array(
            'label' => 'Icon',
            'id' => 'icon',
            'type' => 'icon-list',
            'desc' => '',
            'std' => $default,
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => ''
        );
        return $options;
    }

    function get_social_options($section = '') {



        $options = array(
            array(
                'label' => 'Google Maps API KEY',
                'id' => 'google_maps_api',
                'type' => 'text',
                'desc' => 'Google API KEY to use Google Maps, you can create one <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">here</a>.',
                'std' => '',
                'section' => $section
            ),
            array(
                'label' => 'Facebook App ID',
                'id' => 'facebook_ID',
                'type' => 'text',
                'desc' => 'Add Facebook App ID.',
                'std' => '',
                'section' => $section
            ),
            array(
                'label' => 'Facebook Language',
                'id' => 'facebook_language',
                'type' => 'text',
                'desc' => 'Please refer to this Document to get your language code <a href="https://www.facebook.com/translations/FacebookLocales.xml" target="_blank">Here</a>.',
                'std' => 'en_US',
                'section' => $section
            ),
            array(
                'label' => 'Twitter Consumer Key',
                'id' => 'consumerkey',
                'type' => 'text',
                'desc' => 'Add your twitter Consumer Key <a href="http://themepacific.com/how-to-generate-api-key-consumer-token-access-key-for-twitter-oauth/994/" >Click Here to learn about these keys</a>.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => 'Twitter Consumer Secret',
                'id' => 'consumersecret',
                'type' => 'text',
                'desc' => 'Add your twitter Consumer Secret.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => 'Twitter Access Token',
                'id' => 'accesstoken',
                'type' => 'text',
                'desc' => 'Add your twitter Access Token.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => 'Twitter Access Token Secret',
                'id' => 'accesstokensecret',
                'type' => 'text',
                'desc' => 'Add your twitter Access Token Secret.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),

        );

        return $options;
    }

    function get_articles_options($section = '') {

        global $wp_registered_sidebars;

        $sidebars = array();
        foreach ($wp_registered_sidebars as $sidebar_new) {
            $sidebars[] = array(
                'label' => $sidebar_new['name'],
                'value' => $sidebar_new['id']
            );
        }
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
        }else{
            $all_forms = array();
        }




        $options = array(
            array(
                'label' => esc_html__(  'Articles Sidebar', 'medical-cure'),
                'id' => 'article_sidebar',
                'type' => 'select',
                'desc' => 'Select the Articles sidebar.',
                'choices' => $sidebars,
                'std' => 'sidebar',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => 'c5-layout-control',
                'section' => $section
            ),
            array(
                'label' => esc_html__(  'Enable Article breadcrumb', 'medical-cure'),
                'id' => 'article_enable_breadcrumb',
                'type' => 'on_off',
                'desc' => esc_html__(  'Enable Article breadcrumb', 'medical-cure'),
                'std' => 'on',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => esc_html__(  'Enable Article Featured Media', 'medical-cure'),
                'id' => 'article_enable_featured_media',
                'type' => 'on_off',
                'desc' => esc_html__(  'Enable Article Featured Media', 'medical-cure'),
                'std' => 'on',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),

            array(
                'label' => esc_html__(  'Reorder and Enable/Disable Meta Data', 'medical-cure'),
                'id' => 'article_meta_data',
                'type' => 'meta-data',
                'desc' => 'Reorder and Enable/Disable the Meta data for you blog posts',
                'std' => 'category_on,author_on,time_on,comment_on,like_on,views_on,share_on',
                'choices' => array(
                    array(
                        'label'=> esc_html__( 'Category', 'medical-cure'),
                        'icon'=>'fa fa-tag',
                        'value'=>'category',
                        'default'=>'on'
                    ),
                    array(
                        'label'=> esc_html__( 'Author', 'medical-cure'),
                        'icon'=>'fa fa-user',
                        'value'=>'author',
                        'default'=>'on'
                    ),
                    array(
                        'label'=> esc_html__( 'Date', 'medical-cure'),
                        'icon'=>'fa fa-calendar-o',
                        'value'=>'time',
                        'default'=>'on'
                    ),
                    array(
                        'label'=> esc_html__( 'Comments', 'medical-cure'),
                        'icon'=>'fa fa-comment-o',
                        'value'=>'comment',
                        'default'=>'on'
                    ),
                    array(
                        'label'=> esc_html__( 'Likes', 'medical-cure'),
                        'icon'=>'fa fa-heart-o',
                        'value'=>'like',
                        'default'=>'on'
                    ),
                    array(
                        'label'=> esc_html__( 'Views', 'medical-cure'),
                        'icon'=>'fa fa-eye',
                        'value'=>'views',
                        'default'=>'on'
                    ),

                ),
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => esc_html__(  'Date Format', 'medical-cure'),
                'id' => 'article_date_format',
                'type' => 'select',
                'desc' => 'Set The Date format "Normal date: 12th January, 2013" or "Ago date: 2 days ago"',
                'choices' => array(
                    array(
                        'label' => esc_html__(  'Date & Time', 'medical-cure'),
                        'value' => 'date_time'
                    ),
                    array(
                        'label' => esc_html__(  'Only Date', 'medical-cure'),
                        'value' => 'date'
                    ),
                    array(
                        'label' => esc_html__(  'Only Time', 'medical-cure'),
                        'value' => 'time'
                    ),
                    array(
                        'label' => esc_html__(  'Ago Format', 'medical-cure'),
                        'value' => 'ago'
                    ),
                    array(
                        'label' => esc_html__(  'Date then Ago Format', 'medical-cure'),
                        'value' => 'date_ago'
                    ),
                ),
                'std' => 'date_ago',
                'section' => $section
            ),

            $this->get_font_size_array('Article Title', 'article_title_fs', '40', $section ),
            $this->get_font_size_array('Article Subtitle', 'article_subtitle_fs', '24', $section ),
            $this->get_font_size_array('Article Meta Data', 'article_meta_fs', '12', $section ),
            $this->get_font_size_array('Article Text size', 'article_text_fs', '16', $section ),

            array(
                'label' => esc_html__(  'Reorder and Enable/Disable Social Share Buttons', 'medical-cure'),
                'id' => 'article_social_media',
                'type' => 'meta-data',
                'desc' => 'Reorder and Enable/Disable Social Share Buttons for your blog posts, if you widh to remove them all, just turn all the eyes off',
                'std' => 'facebook_on,twitter_on,googleplus_on,linkedin_on',
                'choices' => array(
                    array(
                        'label'=> esc_html__( 'Facebook', 'medical-cure'),
                        'icon'=>'fa fa-facebook',
                        'value'=>'facebook',
                        'default'=>'on'
                    ),
                    array(
                        'label'=> esc_html__( 'Twitter', 'medical-cure'),
                        'icon'=>'fa fa-twitter',
                        'value'=>'twitter',
                        'default'=>'on'
                    ),
                    array(
                        'label'=> esc_html__( 'Google Plus', 'medical-cure'),
                        'icon'=>'fa fa-google-plus',
                        'value'=>'googleplus',
                        'default'=>'on'
                    ),
                    array(
                        'label'=> esc_html__( 'Linkedin', 'medical-cure'),
                        'icon'=>'fa fa-linkedin',
                        'value'=>'linkedin',
                        'default'=>'on'
                    ),

                ),
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            ),
            array(
                'label' => esc_html__(  'Before Article Section Content', 'medical-cure'),
                'id' => 'article_before',
                'type' => 'textarea-simple',
                'desc' => 'Add a content to show before each article',
                'std' => '',
                'section' => $section
            ),
            array(
                'label' => esc_html__(  'After Article Section Content', 'medical-cure'),
                'id' => 'article_after',
                'type' => 'textarea-simple',
                'desc' => 'Add a content to show after each article',
                'std' => '',
                'section' => $section
            ),
            array(
                'label' => esc_html__(  'Add A Disclaimer Article Content', 'medical-cure'),
                'id' => 'article_disclaimer',
                'type' => 'textarea-simple',
                'desc' => 'Add a disclaimer to show in article',
                'std' => '',
                'section' => $section
            ),
            array(
                'label' => esc_html__(  'Enable Next And Previous Article', 'medical-cure'),
                'id' => 'enable_article_next_prev',
                'type' => 'on_off',
                'desc' => '',
                'std' => 'on',
                'section' => $section
            ),
            array(
                'label' => esc_html__(  'Enable Sources Article', 'medical-cure'),
                'id' => 'enable_article_sources',
                'type' => 'on_off',
                'desc' => '',
                'std' => 'on',
                'section' => $section
            ),
            array(
                'label' => esc_html__(  'Enable Article Author Info', 'medical-cure'),
                'id' => 'enable_article_author',
                'type' => 'on_off',
                'desc' => '',
                'std' => 'on',
                'section' => $section
            ),
            array(
                'label' => esc_html__(  'Enable Facebook Comments', 'medical-cure'),
                'id' => 'enable_facebook',
                'type' => 'on_off',
                'desc' => '',
                'std' => 'on',
                'section' => $section
            ),
            array(
                'label' => esc_html__(  'Enable WordPress Comments', 'medical-cure'),
                'id' => 'enable_wp_comments',
                'type' => 'on_off',
                'desc' => '',
                'std' => 'on',
                'section' => $section
            ),
            array(
                'label' => esc_html__(  'Comments Section Order', 'medical-cure'),
                'id' => 'comments_order',
                'type' => 'select',
                'desc' => 'Select the Comments Order in your article, Default: Facebook - WP Comments',
                'choices' => array(
                    array(
                        'label' => esc_html__(  'Facebook - WP Comments', 'medical-cure'),
                        'value' => 'facebook_comments'
                    ),
                    array(
                        'label' => esc_html__(  'WP Comments - Facebook', 'medical-cure'),
                        'value' => 'comments_facebook'
                    )
                ),
                'std' => 'comments_facebook',
                'section' => $section
            ),
            array(
                'label' => esc_html__(  'Facebook Color', 'medical-cure'),
                'id' => 'facebook_color',
                'type' => 'select',
                'desc' => 'Select Facebook Color Mode. Default Light.',
                'choices' => array(
                    array(
                        'label' => esc_html__(  'Light', 'medical-cure'),
                        'value' => 'light'
                    ),
                    array(
                        'label' => esc_html__(  'Dark', 'medical-cure'),
                        'value' => 'dark'
                    )
                ),
                'std' => 'light',
                'section' => $section
            ),
            /*
            array(
            'label' => esc_html__(  'Enable Articles Subscribe', 'medical-cure'),
            'id' => 'enable_article_subscribe',
            'type' => 'on_off',
            'desc' => '',
            'std' => 'on',
            'section' => $section
        ),
        array(
        'label' => esc_html__(  'Articles Subscribe Title', 'medical-cure'),
        'id' => 'article_subscribe_title',
        'type' => 'text',
        'desc' => esc_html__(  'Add Articles Subscribe Title Text.', 'medical-cure'),
        'std' => '',
        'rows' => '',
        'post_type' => '',
        'taxonomy' => '',
        'class' => '',
        'section' => $section
    ),

    array(
    'label' => esc_html__(  'Articles Subscribe Description', 'medical-cure'),
    'id' => 'article_subscribe_desc',
    'type' => 'text',
    'desc' => esc_html__(  'Add Articles Subscribe Description Text.', 'medical-cure'),
    'std' => '',
    'rows' => '',
    'post_type' => '',
    'taxonomy' => '',
    'class' => '',
    'section' => $section
),

array(
'label' => esc_html__(  'Articles Subscribe Form', 'medical-cure'),
'id' => 'article_subscribe_form',
'type' => 'select',
'desc' => esc_html__(  'Select the Articles subscribe Form.', 'medical-cure'),
'choices' => $all_forms,
'std' => '',
'rows' => '',
'post_type' => '',
'taxonomy' => '',
'section' => $section
),
*/
);

return $options;
}

function get_styling_options() {
    $stylings_fields = array();

    if (!C5_SIMPLE_OPTION) {
        $stylings_fields[] = array(
            'label' => 'Choose Custom Skin',
            'id' => 'skin_default',
            'type' => 'custom-post-type-select',
            'desc' => 'Choose Custom Skin, leave it for default skin.',
            'std' => '',
            'rows' => '',
            'post_type' => 'skin',
            'taxonomy' => '',
            'class' => ''
        );
    }
    $stylings_fields[] = array(
        'label' => 'Use Custom Color Settings',
        'id' => 'use_custom_colors',
        'type' => 'on_off',
        'desc' => 'Use Custom Color Settings.',
        'std' => 'off',
        'class' => ''
    );
    $stylings_fields[] = array(
        'label' => 'Use Custom Layout Settings',
        'id' => 'use_custom_layout',
        'type' => 'on_off',
        'desc' => 'Use Custom Layout Settings.',
        'std' => 'off',
        'class' => ''
    );

    return $stylings_fields;
}

function get_skins_main_meta() {


    $options = array(
        array(
            'label' => 'Choose The default Header',
            'id' => 'header_default',
            'type' => 'custom-post-type-select',
            'desc' => 'Choose The  Header.',
            'std' => '',
            'rows' => '',
            'post_type' => 'header',
            'taxonomy' => '',
            'class' => ''
        ),
        array(
            'label' => 'Choose The default Footer',
            'id' => 'footer_default',
            'type' => 'custom-post-type-select',
            'desc' => 'Choose The Footer.',
            'std' => '',
            'rows' => '',
            'post_type' => 'footer',
            'taxonomy' => '',
            'class' => ''
        ),
        array(
            'label' => 'Custom CSS for this skin',
            'id' => 'custom_css',
            'type' => 'css',
            'desc' => 'Add Custom CSS for this skin.',
            'std' => '',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
        ),
        array(
            'label' => 'Custom js for this skin',
            'id' => 'custom_js',
            'type' => 'textarea-simple',
            'desc' => 'Add Custom js for this skin.',
            'std' => '',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
        )
    );

    return $options;
}

}

?>
