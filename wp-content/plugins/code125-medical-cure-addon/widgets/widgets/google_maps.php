<?php

class C5AB_google_maps extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = true;
    public $_options = array();

    function __construct() {

        $id_base = 'google_maps-widget';
        $this->_shortcode_name = 'c5ab_google_maps';
        $name = 'Google Maps';
        $desc = 'Google Maps for contact us page.';
        $classes = '';

        add_action( 'wp_footer', array($this, 'footer') );
        $this->self_construct($name, $id_base, $desc, $classes);
    }


    function shortcode($atts, $content) {
        $data = '';

        $id = $this->get_unique_id();

        $data .= '<div id="c5-map_canvas-'.$id.'" class="c5-google-maps"></div>';
        $data .= '<style>#c5-map_canvas-'.$id.'{min-height: '.$atts['height'].'px;}</style>';

        $data .= '<script>';
        $data .= 'function code125_google_maps_'.$id.'(){ map_'.$id.' = new google.maps.Map(document.getElementById("c5-map_canvas-'.$id.'"), {
            center: {lat: '.$atts['lat'].', lng: '.$atts['long'].'},
            zoom: '.$atts['zoom'].',
            scrollwheel: false,
        });' . "\n";


        if ($atts['marker'] != 'off') {
            $data .='var icon_'.$id.' = {
                url: "'.C5_URI.'library/images/marker.svg", // url
                scaledSize: new google.maps.Size(31, 45), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };';
            $data .= '
            var beachMarker'.$id.' = new google.maps.Marker({
                position: {lat: '.$atts['lat'].', lng: '.$atts['long'].'},
                map: map_'.$id.',
                icon: icon_'.$id.'
            });';
        }

        $data .= '}</script>';
        $api_key = ot_get_option('google_maps_api');
        $data .= '<script src="https://maps.googleapis.com/maps/api/js?key='.$api_key.'&callback=code125_google_maps_'.$id.'" async defer></script>';


        return $data;
    }


    function options() {




        $this->_options = array(
            array(
                'label' => 'Longitude',
                'id' => 'long',
                'type' => 'text',
                'desc' => 'Longitude for your location.',
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
                'desc' => 'Latitude for your location.',
                'std' => '40.6700',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Show Marker',
                'id' => 'marker',
                'type' => 'on-off',
                'desc' => 'Show Marker on the center of the map.',
                'std' => 'on',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Map Zoom',
                'id' => 'zoom',
                'type' => 'numeric-slider',
                'desc' => 'Slide to select Map Zoom',
                'std' => '14',
                'min_max_step' => '1,50,1',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
            ),
            array(
                'label' => 'Height in Pixels',
                'id' => 'height',
                'type' => 'numeric-slider',
                'desc' => 'Slide to select Map Height in Pixels',
                'std' => '400',
                'min_max_step' => '200,800,10',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
            ),

        );
    }


    public function footer($value='')
    {
        global $code125_google_maps_js;
        if ($code125_google_maps_js != '') {
            $api_key = ot_get_option('google_maps_api');
            ?>
            <script>function code125_google_maps(){ <?php echo $code125_google_maps_js; ?>}</script>
            <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $api_key; ?>&callback=code125_google_maps" async defer></script>
            <?php
        }


    }




}
?>
