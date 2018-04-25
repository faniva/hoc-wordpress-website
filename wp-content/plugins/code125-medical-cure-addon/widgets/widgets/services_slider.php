<?php

class C5AB_services_slider extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = false;
    public $_options = array();
    public  $_skip_title = true;

    function __construct() {

        $id_base = 'services-slider-widget';
        $this->_shortcode_name = 'c5ab_services_slider';
        $name = 'Services Slider';
        $desc = 'Add Services Slider.';
        $classes = '';



        $this->self_construct($name, $id_base, $desc, $classes);
    }

    function shortcode($atts, $content) {

        $tabs = '';
        $panes = '';
        foreach ($atts['c5ab_service_slider_single'] as $tab) {

            $tabs .= '<div class="code125-service-slide-control"><span class="c5-icon ' . $tab['icon'] . '" ></span><span class="text">' . $tab['title'] . '</span></div>';
            $panes .= '<div class="code125-service-slide-content clearfix">' . $this->get_content($tab) . '</div>';

        }
        $tabs_id = $this->get_unique_id();
        $panes_id = $this->get_unique_id();
        $return = '<div class="code125-service-slides-wrap code125-service-slides-layout-1 clearfix"><div class="code125-service-slides-controls c5-tabs-'.$tabs_id.'">' . $tabs . '</div><div class="code125-service-slides-content c5-panes-'.$panes_id.'">' . $panes . '</div></div>' . "\n";

        $this->_js .= " $('.c5-panes-".$panes_id."').slick({
              slidesToShow: 1,
              slidesToScroll: 1,
              adaptiveHeight: true,
              arrows: false,
               " .$this->slick_direction()."
              fade: true,
              autoplay: true,
              autoplaySpeed: 3000,
              infinite: false,
              asNavFor: '.c5-tabs-".$tabs_id."'
            });
            $('.c5-tabs-".$tabs_id."').slick({
              slidesToShow: 4,
              slidesToScroll: 1,
               " .$this->slick_direction()."
              asNavFor: '.c5-panes-".$panes_id."',
              focusOnSelect: true,
              autoplay: true,
              autoplaySpeed: 3000,
              responsive: [
                    {
                      breakpoint: 768,
                      settings: {
                        slidesToShow: 3,
                      }
                    },
                    {
                      breakpoint: 480,
                      settings: {
                        slidesToShow: 2,
                      }
                    }
                  ]
            });";

        return $return;
    }

    public function get_content($tab)
    {
        return do_shortcode( '[c5ab_template id="'.$tab['banner'].'"]' );
    }




    function options() {

        $this->_options = array(
            array(
                'label' => 'Add Service Slide',
                'id' => 'c5ab_service_slider_single',
                'type' => 'list-item',
                'desc' => 'Add Service Slide to the slider.',
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
                        'label' => 'Choose Banner',
                        'id' => 'banner',
                        'type' => 'custom-post-type-select',
                        'desc' => 'Choose Banner',
                        'std' => '',
                        'rows' => '',
                        'post_type' => 'theme-banner',
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
