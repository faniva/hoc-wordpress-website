<?php

class C5AB_services_carousel extends C5_Widget {

  public $_shortcode_name;
  public $_shortcode_bool = false;
  public $_options = array();
  public $_skip_title = true;

  function __construct() {

    $id_base = 'services-carousel-widget';
    $this->_shortcode_name = 'c5ab_services_carousel';
    $name = 'Services Carousel';
    $desc = 'Add Services Carousel.';
    $classes = '';



    $this->self_construct($name, $id_base, $desc, $classes);
  }

  function shortcode($atts, $content) {


    $tabs = '';
    $panes = '';
    $obj = new C5AB_service_column();

    foreach ($atts['service_column'] as $tab) {
      $tabs .= $obj->shortcode($tab,$tab['sub_content']);
    }
    $slider_id = $this->get_unique_id();
    $return = '<div class="code125-service-carousel-wrap code125-service-'.$slider_id.' clearfix">' . $tabs . '</div>' . "\n";
    $margin = isset($atts['margin']) ? $atts['margin'] : 30;
    if ($margin!=30) {
      $return .= '<style>';
      $return .= '.code125-service-carousel-wrap.code125-service-'.$slider_id.' .code125-service-common{ margin-right: '.$margin.'px;}';
      $return .= '.code125-service-carousel-wrap{ margin-right: -'.$margin.'px}';
      $return .= '</style>';
    }


    $this->_js .= "
    $('.code125-service-".$slider_id."').slick({
      slidesToShow: ". $atts['layout'] . ",
      slidesToScroll: 1,
      dots: true,
      arrows: false,
      " .$this->slick_direction()."
      " .($atts['infinate'] != 'on' ? 'infinite: false,' : ''). "
      focusOnSelect: true,
      autoplay: true,
      autoplaySpeed: 3000,
      responsive: [
        {
          breakpoint: 1030,
          settings: {
            slidesToShow: " . min($atts['layout'], 3) .",
          }
        },
        {
          breakpoint: 770,
          settings: {
            slidesToShow: " . min($atts['layout'], 2) .",
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
          }
        }
      ]
    });";

    return $return;
  }




  function options() {

    $obj = new C5AB_service_column();
    $obj->options();
    $list_items = $obj->_options;
    foreach ($list_items as $key => $value) {
      if ($value['id'] == 'content') {
        $list_items[$key]['id'] = 'sub_content';
        $list_items[$key]['type'] = 'textarea-simple';
      }
    }

    $this->_options = array(
      array(
        'label' => 'Number of carousel to show',
        'id' => 'layout',
        'type' => 'select',
        'desc' => 'Number of carousel to show.',
        'choices' => array(
          array(
            'label' => '4 columns',
            'value' => '4'
          ),
          array(
            'label' => '3 columns',
            'value' => '3'
          ),
          array(
            'label' => '2 columns',
            'value' => '2'
          ),
          array(
            'label' => '1 column',
            'value' => '1'
          )
        ),
        'std' => '4',
        'rows' => '',
        'post_type' => '',
        'taxonomy' => '',
        'class' => '',
      ),
      array(
        'label' => 'Infinate Loop',
        'id' => 'infinate',
        'type' => 'on_off',
        'desc' => 'Enable Infinate Loop for this carousel.',
        'std' => 'off',
        'rows' => '',
        'post_type' => '',
        'taxonomy' => '',
        'class' => '',
      ),
      array(
          'label' => 'Margin',
          'id' => 'margin',
          'type' => 'numeric-slider',
          'desc' => 'Margin between items.',
          'min_max_step' => '0,120,1',
          'std' => '30',
          'rows' => '',
          'post_type' => '',
          'taxonomy' => '',
          'class' => ''
      ),
      array(
        'label' => 'Add Service Column',
        'id' => 'service_column',
        'type' => 'list-item',
        'desc' => '',
        'settings' => $list_items,
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
