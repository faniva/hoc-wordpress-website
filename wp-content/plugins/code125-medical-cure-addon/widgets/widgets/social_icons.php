<?php

class C5AB_social_icons extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = false;
    public $_options = array();
    public  $_skip_title = true;
	public  $_cache_output = true;

    function __construct() {

        $id_base = 'social-icons-widget';
        $this->_shortcode_name = 'c5ab_social_icons';
        $name = 'Social Icons';
        $desc = 'Add Social icons box .';
        $classes = '';

        $this->self_construct($name, $id_base, $desc, $classes);
    }

    function shortcode($atts, $content) {

        $tabs = '';
        if (isset($atts['c5ab_social_icon']) && is_array($atts['c5ab_social_icon'])) {
            switch ($atts['layout']) {
                case 'layout-1':

                    foreach ($atts['c5ab_social_icon'] as $tab) {
                        $id = $this->generate_unique_id();
                        $class = $this->prepare_class($tab['icon']);

                        $tabs .= '<li class="'.$class.'"><a class="c5-icon c5-icon-'.$id.' ' . $tab['icon'] . '" href="' . $tab['link'] . '" target="_blank" title="' . $tab['title'] . '"></a></li>';
                        if (isset($tab['color']) && $tab['color']!='') {
                            $tabs .= '<style>.c5-icon-'.$id.':hover{ background: '.$tab['color'].' !important; border-color: '.$tab['color'].' !important;}</style>';
                        }
                    }

                    break;
                case 'layout-2':

                    foreach ($atts['c5ab_social_icon'] as $tab) {
                        $id = $this->generate_unique_id();
                        $class = $this->prepare_class($tab['icon']);

                        $tabs .= '<li class="'.$class.' c5-icon-'.$id.'">';
                        if ($tab['link']!='') {
                            $tabs .= '<a href="' . $tab['link'] . '" target="_blank" >';
                        }
                        $tabs .= '<span class="c5-icon  ' . $tab['icon'] . '"></span>';
                        $tabs .=  $tab['title'];
                        if ($tab['link']!='') {
                            $tabs .= '</a>';
                        }
                        if (isset($tab['color']) && $tab['color']!='') {
                            $color_object = new Code125_Colors();
                            $bg=  $color_object->AdjustHSL($tab['color'] , '0.47', '0.95' );
                            $tabs .= '<style>.c5-icon-'.$id.' .c5-icon{color: '.$tab['color'].' !important; background: '.$bg.' !important;}';

                            $tabs .= '.c5-icon-'.$id.' a{ color: '.$tab['color'].' !important;}';

                            $tabs .= '.c5-icon-'.$id.':hover .c5-icon{color: '.$bg.' !important;} .c5-icon-'.$id.':hover .c5-icon{ background: '.$tab['color'].' !important;}</style>';
                        }
                        $tabs .= '</li>';

                    }


                    break;
                case 'layout-3':

                    foreach ($atts['c5ab_social_icon'] as $tab) {
                        $id = $this->generate_unique_id();
                        $class = $this->prepare_class($tab['icon']);
                        $tabs .= '<li class="'.$class.'"><a class="c5-icon-'.$id.' c5-icon ' . $tab['icon'] . '" href="' . $tab['link'] . '" target="_blank" title="' . $tab['title'] . '"></a></li>';

                        if (isset($tab['color']) && $tab['color']!='') {
                            $color_object = new Code125_Colors();
                            $bg=  $color_object->AdjustHSL($tab['color'] , '0.47', '0.95' );
                            $tabs .= '<style>.c5-icon-'.$id.'{color: '.$tab['color'].' !important;} .c5-icon-'.$id.'{ background: '.$bg.' !important;}';

                            $tabs .= '.c5-icon-'.$id.':hover{color: '.$bg.' !important;} .c5-icon-'.$id.':hover{ background: '.$tab['color'].' !important;}</style>';
                        }

                    }
                    break;

                case 'layout-4':
                    foreach ($atts['c5ab_social_icon'] as $tab) {
                        $id = $this->generate_unique_id();
                        $class = $this->prepare_class($tab['icon']);
                        $tabs .= '<li class="'.$class.' social-icon-'.$id.'"><a  href="' . $tab['link'] . '" target="_blank" title="' . $tab['title'] . '" ><span class="c5-icon ' . $tab['icon'] . '"  ></span> ' . $tab['title'] . '</a></li>';

                        if (isset($tab['color']) && $tab['color']!='') {
                            $color_object = new Code125_Colors();
                            $bg=  $color_object->AdjustHSL($tab['color'] , '0.47', '0.95' );
                            $tabs .= '<style>.social-icon-'.$id.' a{color: '.$tab['color'].' !important;} .social-icon-'.$id.'{ background: '.$bg.' !important;}';

                            $tabs .= '.social-icon-'.$id.':hover a{color: '.$bg.' !important;} .social-icon-'.$id.':hover{ background: '.$tab['color'].' !important;}</style>';
                        }
                    }
                    break;
                case 'layout-5':

                    foreach ($atts['c5ab_social_icon'] as $tab) {
                        $tabs .= '<li><a class="c5-icon ' . $tab['icon'] . '" href="' . $tab['link'] . '" target="_blank" title="' . $tab['title'] . '"></a></li>';

                    }
                    break;
                case 'layout-6':

                    foreach ($atts['c5ab_social_icon'] as $tab) {
                        $id = $this->generate_unique_id();
                        $class = $this->prepare_class($tab['icon']);
                        $tabs .= '<li class="'.$class.' c5-icon-'.$id.'">';
                        if ($tab['link']!='') {
                            $tabs .= '<a href="' . $tab['link'] . '" target="_blank" >';
                        }
                        $tabs .= '<span class="c5-icon  ' . $tab['icon'] . '"></span>';
                        $tabs .=  $tab['title'];
                        if ($tab['link']!='') {
                            $tabs .= '</a>';
                        }
                        if (isset($tab['color']) && $tab['color']!='') {
                            $color_object = new Code125_Colors();
                            $bg=  $color_object->AdjustHSL($tab['color'] , '0.47', '0.95' );
                            $tabs .= '<style>.c5-icon-'.$id.' .c5-icon{color: '.$tab['color'].' !important; background: '.$bg.' !important;}';

                            $tabs .= '.c5-icon-'.$id.' a{ color: '.$tab['color'].' !important;}';

                            $tabs .= '.c5-icon-'.$id.':hover .c5-icon{color: '.$bg.' !important;} .c5-icon-'.$id.':hover .c5-icon{ background: '.$tab['color'].' !important;}</style>';
                        }
                        $tabs .= '</li>';

                    }


                    break;

                default:

                break;
            }
            $return = '<div class="code125-social-links code125-social-links-'.$atts['layout'].'  ">';
            if($atts['title']!=''){
                $return .= '<h3>'.$atts['title'].'</h3>';
            }
            $return .= '<ul>' . $tabs . '</ul>';
            if ($atts['layout'] == 'layout-6') {
                $return .= code125_format_button( $atts['button'] , 'code125-social-button');
            }
            $return .= '</div>';
        }

        return $return;
    }

    public function prepare_class($value='')
    {
        $value = str_replace('fa fa-','',$value);
        $value = str_replace('flaticon-','',$value);
        $value = str_replace('socicon-','',$value);

        return $value;
    }

    function options() {
        $layouts  = array(
            'layout-1' => 'Layout 1',
            'layout-2' => 'Layout 2',
            'layout-3' => 'layout 3',
            'layout-4' => 'Layout 4',
            'layout-5' => 'Layout 5',
            'layout-6' => 'layout 6',
         );
        $choices = array();
        foreach ($layouts as $key => $label) {
            $choices[] = array(
                'src' => C5_OPTIONS_IMG_URL . 'social/' . $key . '.png',
                'src_2x' => C5_OPTIONS_IMG_URL . 'social/' . $key . '@2x.png',
                'label' => $label,
                'value' => $key
            );
        }
        $this->_options = array(
            array(
                'label' => 'Title',
                'id' => 'title',
                'type' => 'text',
                'desc' => 'Section Title.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
            ),
            array(
			    'label' => 'Choose Social Icons layout',
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
                'label' => 'Add Social Icon',
                'id' => 'c5ab_social_icon',
                'type' => 'list-item',
                'desc' => 'Add Social Icon to the box.',
                'settings' => array(
                    array(
                        'label' => 'Icon',
                        'id' => 'icon',
                        'type' => 'icon-list',
                        'desc' => '',
                        'std' => 'fa fa-facebook',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => 'c5ab_icons'
                    ),
                    array(
                        'label' => 'Link',
                        'id' => 'link',
                        'type' => 'text',
                        'desc' => 'Icon Url.',
                        'std' => '',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => '',
                    ),
                    array(
                        'label' => 'Color',
                        'id' => 'color',
                        'type' => 'colorpicker',
                        'desc' => 'Icon Color.',
                        'std' => '',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => '',
                    ),
                ),
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Button Info',
                'id' => 'button',
                'type' => 'button',
                'desc' => 'Button Info for Layout 6.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
            ),
        );
    }

}
?>
