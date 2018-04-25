<?php

class C5AB_testimonials extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = true;
    public $_options = array();
    public  $_skip_title = true;
	public  $_cache_output = true;

    function __construct() {

        $id_base = 'testimonials-widget';
        $this->_shortcode_name = 'c5ab_testimonials';
        $name = 'Testimonials';
        $desc = 'Add Testimonials area.';
        $classes = '';

        $this->self_construct($name, $id_base, $desc, $classes);
    }

    function shortcode($atts, $content) {

        $return = '';

        if ($atts['layout'] == 'layout-1') {
            $return = '<div class="code125-testimonial-single code125-testimonial-layout-1 clearifx">';

            $return .= '<div class="testimonial-content clearfix">' . wpautop( $content ) . '</div>';
            $return .= '<div class="testimonial-meta">';

            if ($atts['image'] != '') {

                $image_size = c5ab_generate_image_size(60, 60, true);
                $image_data = $this->get_image($image_size , $atts['image']);

                $srcset = ($image_data[1] != '') ? 'srcset="'.$image_data[0].' 1x, '.$image_data[1].' 2x"' : '';
                $return .= '<img src="'.$image_data[0].'" class="testimonial-author" alt="'.$atts['title'].'" '.$srcset.' />';
            }

            $return .= '<h3 class="testimonial-name">'.$atts['title'].'</h3>';
            if ($atts['subtitle']!='') {
                $return .= '<p class="testimonial-subtitle">'.$atts['subtitle'].'</p>';
            }
            $return .= '</div>';
            $return .= '</div>';
        }elseif ($atts['layout'] == 'layout-2') {
            $return = '<div class="code125-testimonial-single code125-testimonial-layout-2 clearifx">';

            if ($atts['image'] != '') {

                $image_size = c5ab_generate_image_size(160, 160, true);
                $image_data = $this->get_image($image_size , $atts['image']);

                $srcset = ($image_data[1] != '') ? 'srcset="'.$image_data[0].' 1x, '.$image_data[1].' 2x"' : '';
                $return .= '<img src="'.$image_data[0].'" class="testimonial-author" alt="'.$atts['title'].'" '.$srcset.' />';
            }

            $return .= '<div class="testimonial-content clearfix">' . wpautop( $content ) . '</div>';
            $return .= '<div class="testimonial-meta">';
            $return .= '<h3 class="testimonial-name">'.$atts['title'].'</h3>';
            if ($atts['subtitle']!='') {
                $return .= '<p class="testimonial-subtitle">'.$atts['subtitle'].'</p>';
            }
            $return .= '</div>';
            $return .= '</div>';
        }elseif ($atts['layout'] == 'layout-3') {
            $return = '<div class="code125-testimonial-single code125-testimonial-layout-3 clearifx">';

            if ($atts['image'] != '') {

                $image_size = c5ab_generate_image_size(60, 60, true);
                $image_data = $this->get_image($image_size , $atts['image']);

                $srcset = ($image_data[1] != '') ? 'srcset="'.$image_data[0].' 1x, '.$image_data[1].' 2x"' : '';
                $return .= '<img src="'.$image_data[0].'" class="testimonial-author" alt="'.$atts['title'].'" '.$srcset.' />';
            }

            $return .= '<div class="testimonial-content clearfix">' . wpautop( $content ) . '</div>';
            $return .= '<div class="testimonial-meta">';
            $return .= '<h3 class="testimonial-name">'.$atts['title'].'</h3>';
            if ($atts['subtitle']!='') {
                $return .= '<p class="testimonial-subtitle">'.$atts['subtitle'].'</p>';
            }
            $return .= '</div>';
            $return .= '</div>';
        }elseif ($atts['layout'] == 'layout-4') {
            $return = '<div class="code125-testimonial-single code125-testimonial-layout-4 clearifx">';

            $return .= '<div class="testimonial-content clearfix">' . wpautop( $content ) . '</div>';

            if ($atts['image'] != '') {

                $image_size = c5ab_generate_image_size(60, 60, true);
                $image_data = $this->get_image($image_size , $atts['image']);

                $srcset = ($image_data[1] != '') ? 'srcset="'.$image_data[0].' 1x, '.$image_data[1].' 2x"' : '';
                $return .= '<img src="'.$image_data[0].'" class="testimonial-author" alt="'.$atts['title'].'" '.$srcset.' />';
            }


            $return .= '<div class="testimonial-meta">';
            $return .= '<h3 class="testimonial-name">'.$atts['title'].'</h3>';
            if ($atts['subtitle']!='') {
                $return .= '<p class="testimonial-subtitle">'.$atts['subtitle'].'</p>';
            }
            $return .= '</div>';
            $return .= '</div>';
        }elseif ($atts['layout'] == 'layout-5') {
            $return = '<div class="code125-testimonial-single code125-testimonial-layout-5 clearifx">';

            if ($atts['image'] != '') {

                $image_size = c5ab_generate_image_size(240, 240, true);
                $image_data = $this->get_image($image_size , $atts['image']);

                $srcset = ($image_data[1] != '') ? 'srcset="'.$image_data[0].' 1x, '.$image_data[1].' 2x"' : '';
                $return .= '<div class="testimonial-author-wrap"><img src="'.$image_data[0].'" class="testimonial-author" alt="'.$atts['title'].'" '.$srcset.' /></div>';
            }

            $return .= '<div class="testimonial-content clearfix">' . wpautop( $content ) . '</div>';

            $return .= '<div class="testimonial-meta">';
            $return .= '<h3 class="testimonial-name">'.$atts['title'].'</h3>';
            if ($atts['subtitle']!='') {
                $return .= '<p class="testimonial-subtitle">'.$atts['subtitle'].'</p>';
            }
            $return .= '</div>';
            $return .= '</div>';
        }elseif ($atts['layout'] == 'layout-6') {
            $return = '<div class="code125-testimonial-single code125-testimonial-layout-6 clearifx">';

            $return .= '<div class="testimonial-content clearfix">' . wpautop( $content ) . '</div>';
            $return .= '<div class="testimonial-meta">';
            $return .= '<h3 class="testimonial-name">'.$atts['title'].'</h3>';
            $return .= '</div>';
            $return .= '</div>';
        }elseif ($atts['layout'] == 'layout-7') {
            $return = '<div class="code125-testimonial-single code125-testimonial-layout-7 clearifx">';

            if ($atts['image'] != '') {

                $image_size = c5ab_generate_image_size(50, 50, true);
                $image_data = $this->get_image($image_size , $atts['image']);

                $srcset = ($image_data[1] != '') ? 'srcset="'.$image_data[0].' 1x, '.$image_data[1].' 2x"' : '';
                $return .= '<img src="'.$image_data[0].'" class="testimonial-author" alt="'.$atts['title'].'" '.$srcset.' />';
            }

            $return .= '<div class="testimonial-content clearfix">' . wpautop( $content ) . '</div>';
            $return .= '</div>';
        }elseif ($atts['layout'] == 'layout-8') {
            $return = '<div class="code125-testimonial-single code125-testimonial-layout-8 clearifx">';

            if ($atts['image'] != '') {

                $image_size = c5ab_generate_image_size(60, 60, true);
                $image_data = $this->get_image($image_size , $atts['image']);

                $srcset = ($image_data[1] != '') ? 'srcset="'.$image_data[0].' 1x, '.$image_data[1].' 2x"' : '';
                $return .= '<img src="'.$image_data[0].'" class="testimonial-author" alt="'.$atts['title'].'" '.$srcset.' />';
            }

            $return .= '<div class="testimonial-content clearfix">' . wpautop( $content ) . '</div>';

            $return .= '<div class="testimonial-meta">';
            $return .= '<h3 class="testimonial-name">'.$atts['title'].'</h3>';
            if ($atts['subtitle']!='') {
                $return .= '<p class="testimonial-subtitle">'.$atts['subtitle'].'</p>';
            }
            $return .= '</div>';
            $return .= '</div>';
        }

        return $return;
    }

    public function get_image($image_size , $url)
    {
        $src = $url;
        $src_2x = '';
        $attachment_id = c5ab_get_attachment_id_from_src($url);
        if ($attachment_id != '') {
            $image_attributes = c5_wp_get_attachment_image_src($attachment_id , $image_size , false );
            if ($image_attributes) {
                $src = $image_attributes[0];
                $src_2x = $image_attributes[3];
            }
        }
        return array($src, $src_2x);
    }

    function options() {
        $layouts  = array(
            'layout-1' => 'Layout 1',
            'layout-2' => 'Layout 2',
            'layout-3' => 'Layout 3',
            'layout-4' => 'Layout 4',
            'layout-5' => 'Layout 5',
            'layout-6' => 'Layout 6',
            'layout-7' => 'Layout 7',
            'layout-8' => 'Layout 8',
         );
        $choices = array();
        foreach ($layouts as $key => $label) {
            $choices[] = array(
                'src' => C5_OPTIONS_IMG_URL . 'testimonials/' . $key . '.png',
                'src_2x' => C5_OPTIONS_IMG_URL . 'testimonials/' . $key . '@2x.png',
                'label' => $label,
                'value' => $key
            );
        }

		$this->_options =array(

            array(
                'label' => 'Choose testimonials layout',
                'id' => 'layout',
                'type' => 'radio-image',
                'desc' => '',
                'choices' => $choices,
                'std' => 'layout-1',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
            ),
            array(
                'label' => 'Name',
                'id' => 'title',
                'type' => 'text',
                'desc' => '',
                'std' => 'Jonathan Steve',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Subtitle',
                'id' => 'subtitle',
                'type' => 'text',
                'desc' => '',
                'std' => 'Patient',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Testimonial',
                'id' => 'content',
                'type' => 'wp-editor',
                'desc' => '',
                'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras at diam nec neque laoreet malesuada.',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Testimonial Image',
                'id' => 'image',
                'type' => 'upload',
                'desc' => '',
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
