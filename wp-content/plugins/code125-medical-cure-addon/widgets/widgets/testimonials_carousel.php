<?php

class C5AB_testimonials_carousel extends C5_Widget {

  public $_shortcode_name;
  public $_shortcode_bool = false;
  public $_options = array();
  public  $_skip_title = true;
  public  $_cache_output = true;

  function __construct() {

    $id_base = 'testimonials_carousel-widget';
    $this->_shortcode_name = 'c5ab_testimonials_carousel';
    $name = 'Testimonials Carousel';
    $desc = 'Add Testimonials Carousel area.';
    $classes = '';

    $this->self_construct($name, $id_base, $desc, $classes);
  }

  function shortcode($atts, $content) {

    $tabs = '';
    $panes = '';
    $obj = new C5AB_testimonials();

    foreach ($atts['testimonials'] as $tab) {

      $tabs .= '<div class="code125-testimonials-carousel-single">' . $obj->shortcode( $tab , $tab['testimonial_content'] ) . '</div>';
    }
    $testimonials_id = $this->get_unique_id();
    $return = '<div class="code125-testimonials-carousel-wrap code125-testimonials-'.$testimonials_id.' clearfix">' . $tabs . '</div>' . "\n";

    $this->_js .= "
    $('.code125-testimonials-".$testimonials_id."').slick({
      slidesToShow: ". $atts['layout'] . ",
      dots: true,
      slidesToScroll: 1,
      arrows: false,
      " .$this->slick_direction()."
      autoplay: true,
      " .($atts['infinate'] != 'on' ? 'infinite: false,' : ''). "
      autoplaySpeed: 3000,
      responsive: [
        {
          breakpoint: 1024,
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
    $layouts  = array(
      'layout-1' => 'Layout 1',
      'layout-2' => 'Layout 2',
      'layout-3' => 'Layout 3',
      'layout-4' => 'Layout 4',
      'layout-5' => 'Layout 5',
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
        'label' => 'Add Testimonial',
        'id' => 'testimonials',
        'type' => 'list-item',
        'desc' => '',
        'settings' => array(
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
            'id' => 'testimonial_content',
            'type' => 'textarea-simple',
            'desc' => '',
            'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras at diam nec neque laoreet malesuada.',
            'rows' => '9',
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
