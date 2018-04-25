<?php
/**
*   version 1.1
*/
class C5_LOGO
{
    public $default_logo_height = '30';
    public $default_logo_margin = '27';
    public $enable_floating = true;
    public $default_floating_logo_height = '30';
    public $default_floating_logo_margin = '19';
    public $default_logo_font_size = '27';
    public $default_floating_logo_font_size = '27';

    function __construct()
    {

    }
    public function hook()
    {
        add_filter('c5_logo_theme_options' , array($this, 'theme_options'));
        add_action( 'after_setup_theme', array($this, 'add_theme_support') , 16 );

        add_action('c5_main_logo' , array($this, 'get_current_logo'));
        add_action('c5_floating_logo' , array($this, 'get_floating_logo'));
    }
    public function add_theme_support()
    {
        add_theme_support( 'custom-logo' , array(

            'flex-width' => true,
            )
        );
    }
    function get_current_logo() {

        if (function_exists('icl_t') && apply_filters('code125_enable_translation' , true )) {
            $logo_id = icl_t( 'Customizer', 'custom_logo', get_theme_mod( 'custom_logo' ) );
        }else{
            $logo_id = get_theme_mod( 'custom_logo' );
        }

        if ($logo_id == '') {
            $logo_url = ot_get_option('logo');
            if ($logo_url == 'http://C5_THEME_LOGO_URL') {
                $logo_url = '';
            }
            $logo_id = c5ab_get_attachment_id_from_src($logo_url);
            set_theme_mod('custom_logo' , $logo_id);
            c5_set_option('logo', '');
        }

        if (wp_attachment_is_image($logo_id)) {

            $image_size = c5ab_generate_image_size(9999 , ot_get_option('logo_height', $this->default_logo_height ) , false );
            $image_attributes = c5_wp_get_attachment_image_src( $logo_id , $image_size);
            if (is_array($image_attributes)) {
                $src = $image_attributes[0];
                $src_2x = $image_attributes[3];

                $top_margin = ot_get_option('logo_margin',$this->default_logo_margin );
                $home_url = $this->homeurl();

                $data = $this->logo_markup($top_margin, $home_url , $src, $src_2x , $image_attributes[1] , $image_attributes[2]);
                echo $data;
            }
        }else{
            $default_logo = apply_filters( 'c5_default_logo', false );
            if ($default_logo) {
                $src = C5_URI . 'library/images/logo.png';
                $src_2x = C5_URI . 'library/images/logo-2x.png';

                $top_margin = ot_get_option('logo_margin',$this->default_logo_margin);
                $home_url = $this->homeurl();

                $data = $this->logo_markup($top_margin, $home_url , $src, $src_2x );
                echo $data;
            }else{
                $top_margin = ot_get_option('logo_margin',$this->default_logo_margin);
                $text_size = ot_get_option('logo_text_size' , $this->default_logo_font_size);
                $home_url = $this->homeurl();

                $data = '<div class="site-branding">';
                $data .= '<h1 class="site-title" style="margin-top:'.$top_margin.'px;  font-size:'.$text_size.'px"><a href="'.$home_url.'" rel="home">'.get_bloginfo('name').'</a></h1>';
                $subtitle = get_bloginfo('description');
                if ($subtitle!='') {
                    $data .= '<p class="site-description" style="margin-bottom:'.$top_margin.'px;">'.$subtitle.'</p>';
                }
                $data .= '</div>';
                echo $data;
            }
        }

    }

    function get_floating_logo() {

        if (function_exists('icl_t')) {
            $logo_url = icl_t( 'Customizer', 'floating_logo', ot_get_option('floating_logo') );
        }else{
            $logo_url = ot_get_option('floating_logo');
        }
        if ($logo_url == 'http://C5_THEME_LOGO_URL') {
            $logo_url = '';
        }
        $logo_id = c5ab_get_attachment_id_from_src($logo_url);
        if ($logo_id == '') {
            if (function_exists('icl_t')) {
                $logo_id = icl_t( 'Customizer', 'custom_logo', get_theme_mod( 'custom_logo' ) );
            }else{
                $logo_id = get_theme_mod( 'custom_logo' );
            }
        }


        if (wp_attachment_is_image($logo_id)) {
            $image_size = c5ab_generate_image_size(9999 , ot_get_option('floating_logo_height', $this->default_floating_logo_height) , false );
            $image_attributes = c5_wp_get_attachment_image_src( $logo_id , $image_size);
            if (is_array($image_attributes)) {
                $src = $image_attributes[0];
                $src_2x = $image_attributes[3];

                $home_url = $this->homeurl();
                $top_margin = '';

                $data = $this->logo_markup($top_margin, $home_url , $src, $src_2x,$image_attributes[1] , $image_attributes[2]);
                echo $data;
            }
        }else{
            $default_logo = apply_filters( 'c5_default_logo', false );
            if ($default_logo) {
                $src = C5_URI . 'library/images/logo-floating.png';
                $src_2x = C5_URI . 'library/images/logo-floating-2x.png';

                $home_url = $this->homeurl();
                $top_margin= '';

                $data = $this->logo_markup($top_margin, $home_url , $src, $src_2x);
                echo $data;
            }else{
                $home_url = $this->homeurl();
                $text_size = ot_get_option('floating_logo_text_size' , $this->default_floating_logo_font_size);

                $data = '<div class="site-branding">';
                $data .= '<h1 class="site-title" style="font-size:'.$text_size.'px"><a href="'.$home_url.'" rel="home">'.get_bloginfo('name').'</a></h1>';
                $subtitle = get_bloginfo('description');
                $data .= '</div>';
                echo $data;
            }
        }

    }

    public function logo_markup($top_margin, $home_url , $src, $src_2x, $width = '' , $height = '')
    {
        $style = $top_margin != '' ? 'style="margin-top:' . $top_margin . 'px"' : '';
        $img_meta = '';
        $img_meta .= $width != '' ? ' width="'.$width.'" ' : '';
        $img_meta .= $height != '' ? ' height="'.$height.'" ' : '';

        $data = '<div class="c5-logo"  '.$style.'><a  href="' . $home_url . '" rel="nofollow"><img alt="Logo" src="' . $src. '" srcset="'.$src. ' 1x, '.$src_2x.' 2x" '.$img_meta.' /></a></div>';
        return $data;
    }
    public function homeurl()
    {
        return apply_filters('c5_logo_url' , esc_url( home_url('/') ) );
    }

    public function theme_options($section='')
    {
        $options = array();
        $options[] = array(
            'label' => 'Website Logo',
            'id' => 'logo',
            'type' => 'textblock-titled',
            'desc' => 'You can set your website logo through your customizer. <ul><li>- Go to the customizer <a href="'.admin_url('/customize.php?url=' . esc_url( home_url('/') ) ).'" target="_blank">here</a></li><li>- Open "Site Identity"</li><li>- Upload your logo</li><li>- Click "Save & Publish"</li></ul>Other meta settings for the logo and the floating logo can be set from the options below.',
            'std' => '',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
            'section' => $section
        );
        $options[] = array(
            'label' => 'Logo Height',
            'id' => 'logo_height',
            'type' => 'numeric-slider',
            'desc' => 'Slide to select your Logo Height in <strong>pixels</strong>. "We will calculate the width automaticly based on the height". Default: '.$this->default_logo_height.'px',
            'std' => $this->default_logo_height,
            'min_max_step' => '10,300,1',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
            'section' => $section
        );
        $options[] = array(
            'label' => 'Main Logo Top Margin',
            'id' => 'logo_margin',
            'type' => 'numeric-slider',
            'desc' => 'Top Margin for the logo for your website, Default:'.$this->default_logo_margin.'px.',
            'std' => $this->default_logo_margin,
            'min_max_step' => '0,300,1',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
            'section' => $section
        );
        $options[] = array(
            'label' => 'Text Logo font size',
            'id' => 'logo_text_size',
            'type' => 'numeric-slider',
            'desc' => 'Text Logo font size in pixels, Default: '.$this->default_logo_font_size.'px.',
            'std' => $this->default_logo_font_size,
            'min_max_step' => '14,100,1',
            'rows' => '',
            'post_type' => '',
            'taxonomy' => '',
            'class' => '',
            'section' => $section
        );
        if ($this->enable_floating) {

            $options[] = array(
                'label' => 'Floating Logo Height',
                'id' => 'floating_logo_height',
                'type' => 'numeric-slider',
                'desc' => 'Slide to select your Floating Logo Height in <strong>pixels</strong>. "We will calculate the width automaticly based on the height", Default: '.$this->default_floating_logo_height.'px',
                'std' => $this->default_floating_logo_height,
                'min_max_step' => '10,300,1',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            );
            $options[] = array(
                'label' => 'Floating text Logo font size',
                'id' => 'floating_logo_text_size',
                'type' => 'numeric-slider',
                'desc' => 'Floating text Logo font size in pixels, Default: '.$this->default_floating_logo_font_size.'px',
                'std' => $this->default_floating_logo_font_size,
                'min_max_step' => '14,100,1',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
                'section' => $section
            );
        }

        return $options;
    }
}
$obj = new C5_LOGO();
$obj->hook();

?>
