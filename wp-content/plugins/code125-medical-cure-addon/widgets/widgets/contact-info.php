<?php

class C5AB_contact_infos extends C5_Widget {

  public $_shortcode_name;
  public $_shortcode_bool = true;
  public $_options = array();
  public  $_skip_title = true;
  public  $_cache_output = true;

  function __construct() {

    $id_base = 'contact-info-widget';
    $this->_shortcode_name = 'c5ab_contact_infos';
    $name = 'Contact Info (with Map or Image)';
    $desc = 'Add Contact Info (with Map or Image) .';
    $classes = '';

    $this->self_construct($name, $id_base, $desc, $classes);
  }


  function shortcode($atts, $content) {

    $contact_info = '';
    $count = 0;

    if (is_array($atts['c5ab_contact_info'])) {
      $tabs = '';
      $count = count($atts['c5ab_contact_info']);
      foreach ($atts['c5ab_contact_info'] as $tab) {

        $tabs .= '<li class=""><span class="c5-icon ' . $tab['icon'] . '"></span><span class="title">' . $tab['title'] . '</span><span class="subtitle">' . $tab['subtitle'] . '</span></li>';

      }

      $contact_info = '<div class="code125-contact-infos-ul clearfix"><ul>' . $tabs . '</ul></div>' . "\n";
    }
    $height = 175 + $count*88;

    $api_key = ot_get_option('google_maps_api');

    $map = '<div class="code125-maps">' . do_shortcode( '[c5ab_google_maps long="'.$atts['long'].'" lat="'.$atts['lat'].'" zoom="'.$atts['zoom'].'" api="'.$api_key.'" height="'.$height.'"  ]' ) . '</div>';

    switch ($atts['layout']) {
      case 'layout-1':
      $return = '<div class="code125-contact-infos-common code125-contact-infos-layout-1">' . $map . '<div class="container"><div class="code125-contact-infos-content">' . $contact_info;
      if ($atts['description']!='') {
        $return .= '<p class="description">'.$atts['description'].'</p>';
      }
      if ($atts['social_icon']!='off') {
        $obj = new C5_header_base();
        $return .= $obj->get_social_icons('layout-5');
      }
      $return .= '</div></div></div>';
      break;

      case 'layout-2':
      $return = '<div class="code125-contact-infos-common code125-contact-infos-layout-2">' . $map . '<div class="code125-contact-infos-content">' . $contact_info;
      if ($atts['description']!='') {
        $return .= '<p class="description">'.$atts['description'].'</p>';
      }
      if ($atts['social_icon']!='off') {
        $obj = new C5_header_base();
        $return .= $obj->get_social_icons('layout-5');
      }
      $return .= '</div></div>';
      break;
      case 'layout-3':
      $image_size = c5ab_generate_image_size( ($GLOBALS['c5_content_width']/2), 9999, false);
      $image = $this->get_image($image_size , $atts['image']);

      $return = '<div class="code125-contact-infos-common code125-contact-infos-layout-3">' . $image . '<div class="code125-contact-infos-content">' . $contact_info;
      if ($atts['description']!='') {
        $return .= '<p class="description">'.$atts['description'].'</p>';
      }
      if ($atts['social_icon']!='off') {
        $obj = new C5_header_base();
        $return .= $obj->get_social_icons('layout-5');
      }
      $return .= '</div></div>';
      break;

      default:
      # code...
      break;
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
    $id = $this->get_unique_id();
    $data = '<div class="code125-image-'.$id.' code125-image"></div>';
    $data .= '<style>';
    $data .= $this->background_css( '.code125-image-'.$id ,  array($src, $src_2x) );
    $data .= '</style>';
    return $data;
  }
  function background_css( $element ,  $image_data ){
    $css = '';

    $css .= $element . '{background-image:url(\'' . $image_data[0] . '\');}';
    if (isset($image_data[1]) && $image_data[1]!= '') {
      $css .= ' @media
      only screen and (-webkit-min-device-pixel-ratio: 2),
      only screen and (   min--moz-device-pixel-ratio: 2),
      only screen and (     -o-min-device-pixel-ratio: 2/1),
      only screen and (        min-device-pixel-ratio: 2),
      only screen and (                min-resolution: 192dpi),
      only screen and (                min-resolution: 2dppx) { ';
        $css .= $element . '{background-image:url(\'' . $image_data[1] . '\');}';
        $css .= '}';
      }


      return $css;
    }

    function options() {

      $this->_options = array(
        array(
          'label' => 'Layout',
          'id' => 'layout',
          'type' => 'select',
          'desc' => 'Contact Info Layout.',
          'std' => 'layout-1',
          'choices' => array(
            array(
              'label' => 'Layout 1',
              'value' => 'layout-1'
            ),
            array(
              'label' => 'Layout 2',
              'value' => 'layout-2'
            ),
            array(
              'label' => 'Layout 3',
              'value' => 'layout-3'
            ),
          ),
          'rows' => '',
          'post_type' => '',
          'taxonomy' => '',
          'class' => ''
        ),
        array(
          'label' => 'Description',
          'id' => 'description',
          'type' => 'text',
          'desc' => 'Description.',
          'std' => '',
          'rows' => '',
          'post_type' => '',
          'taxonomy' => '',
          'class' => '',
        ),
        array(
          'label' => 'Enable Social Icons',
          'id' => 'social_icon',
          'type' => 'on-off',
          'desc' => 'Enable Social Icons. You can set the social icons in the theme options page.',
          'std' => 'on',
          'rows' => '',
          'post_type' => '',
          'taxonomy' => '',
          'class' => '',
        ),
        array(
          'label' => 'Image Based Layout',
          'id' => 'image',
          'type' => 'upload',
          'desc' => '(Image Based Layout) Upload the Image background.',
          'std' => '',
          'rows' => '',
          'post_type' => '',
          'taxonomy' => '',
          'class' => ''
        ),
        array(
          'label' => 'Longitude',
          'id' => 'long',
          'type' => 'text',
          'desc' => '(Map Settings) Longitude for your location.',
          'std' => '-73.9400',
          'rows' => '',
          'post_type' => '',
          'taxonomy' => '',
          'class' => ''
        ),
        array(
          'label' => 'Latitude',
          'id' => 'lat',
          'type' => 'text',
          'desc' => '(Map Settings) Latitude for your location.',
          'std' => '40.6700',
          'rows' => '',
          'post_type' => '',
          'taxonomy' => '',
          'class' => ''
        ),
        array(
          'label' => 'Map Zoom',
          'id' => 'zoom',
          'type' => 'numeric-slider',
          'desc' => '(Map Settings) Slide to select Map Zoom',
          'std' => '14',
          'min_max_step' => '1,50,1',
          'rows' => '',
          'post_type' => '',
          'taxonomy' => '',
          'class' => '',
        ),
        array(
          'label' => 'Add Contact Info',
          'id' => 'c5ab_contact_info',
          'type' => 'list-item',
          'desc' => 'Add Contact Info to the box.',
          'settings' => array(
            array(
              'label' => 'Icon',
              'id' => 'icon',
              'type' => 'icon-list',
              'desc' => '',
              'std' => 'fa fa-phone',
              'rows' => '',
              'post_type' => '',
              'taxonomy' => '',
              'class' => 'c5ab_icons'
            ),
            array(
              'label' => 'Subtitle',
              'id' => 'subtitle',
              'type' => 'text',
              'desc' => 'Subtitle.',
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
      );
    }

  }
  ?>
