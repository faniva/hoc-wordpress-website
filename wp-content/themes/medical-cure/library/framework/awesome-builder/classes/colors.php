<?php
if (class_exists('Code125_Colors')) {
    return;
}
class Code125_Colors extends Code125_Base_Colors {

    public $width;
    public $height;
    public $x_step;
    public $y_step;
    public $start_width;
    public $end_width;
    public $start_height;
    public $end_height;

    public $attachment_meta_key = 'c5_attachment_image_color_properties';

    function update_info($post_id = '' , $is_attachment = false) {

        $image_size = c5ab_generate_image_size(800, 9999, false);
        if ($is_attachment) {
            $attachment_id = $post_id;
        }else{
            $attachment_id = get_post_thumbnail_id($post_id);
        }

        $image_attributes = wp_get_attachment_image_src($attachment_id,'large' );

        $image_src = '';
        if ($image_attributes) {
            $image_src = $image_attributes[0];
        }
        if ($image_src == '') {
            return false;
        }

        $colors = $this->get_avg_rgb($image_src);
        $final_colors = array();
        foreach ($colors as $location => $color) {
            $custom = get_post_meta($post_id, 'custom_color_' . $location, true);
            if ($custom != '') {
                $color = $custom;
            }
            $rgb = $this->hex2rgb($color);
            $lum = $this->get_lum_hex($color);
            $final_colors[$location] = array(
                'hex' => $color,
                'rgb' => $rgb,
                'lum' => $lum,
                'class' => $this->get_color_class($lum)
            );
        }

        update_post_meta($post_id, $this->attachment_meta_key, $final_colors);
        return true;
    }

    function get_colors($post_id , $is_attachment) {
        $values = get_post_meta($post_id, $this->attachment_meta_key , true);
        if (empty($values)) {
            $result = $this->update_info($post_id , $is_attachment);
            if (!$result) {
                return false;
            }
            $values = $this->get_colors($post_id , $is_attachment);
        }
        return $values;
    }

    function get_image_data($filepath) {

        $type = exif_imagetype($filepath); // [] if you don't have exif you could use getImageSize()
        $allowedTypes = array(
            1, // [] gif
            2, // [] jpg
            3, // [] png
            6   // [] bmp
        );
        if (!in_array($type, $allowedTypes)) {
            return false;
        }
        switch ($type) {
            case 1 :
            $im = imageCreateFromGif($filepath);
            break;
            case 2 :
            $im = imageCreateFromJpeg($filepath);
            break;
            case 3 :
            $im = imageCreateFromPng($filepath);
            break;
            case 6 :
            $im = imageCreateFromBmp($filepath);
            break;
        }
        return $im;
    }

    // get average luminance, by sampling $num_samples times in both x,y directions
    function get_avg_luminance($filename, $num_samples = 10) {
        if (!function_exists('exif_imagetype')) {
            return 0;
        }
        $options = get_option('c5_images_luminance');
        if (is_array($options)) {
            if (isset($options[$filename])) {
                return $options[$filename];
            }
        } else {
            $options = array();
        }


        $this->img = $this->get_image_data($filename);

        $this->width = imagesx($img);
        $this->height = imagesy($img);

        $this->x_step = intval($width / $num_samples);
        $this->y_step = intval($height / $num_samples);

        $total_lum = 0;

        $sample_no = 1;

        for ($x = 0; $x < $width; $x+=$x_step) {
            for ($y = 0; $y < $height; $y+=$y_step) {

                $rgb = imagecolorat($img, $x, $y);
                $lum = $this->get_lum($rgb);

                $total_lum += $lum;

                // debugging code
                //           echo "$sample_no - XY: $x,$y = $r, $g, $b = $lum<br />";
                $sample_no++;
            }
        }

        // work out the average
        $avg_lum = round($total_lum / $sample_no);


        $options[$filename] = $avg_lum;
        update_option('c5_images_luminance', $options);
        return $avg_lum;
    }


    public function opacity($color , $opacity)
    {
        $rgb = $this->hex2rgb($color);

        $color = 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].','.$opacity.')';
        return $color;
    }

    public function gradient($color='', $class , $inner_class )
    {
        $rgb = $this->opacity($color, '0.5');
        $html = '';
        $html .= $class . '{ background-color: '. $color .' }';
        $html .= $class . ' ' . $inner_class . ':before { '.$this->left_gradient($color , $rgb) .' }' . "\n";
        $html .= $class . ' ' . $inner_class . ':after { '.$this->right_gradient($color , $rgb) .' }' . "\n";

        return $html;
    }
    public function image_gradient_css($url, $class , $inner_class)
    {
        $attachment_id = c5ab_get_attachment_id_from_src($url);
        if(!$attachment_id){
            return '';
        }
        $colors = $this->get_colors($attachment_id , true);
        $html = '';
        $html .= $class . ' ' . $inner_class . '{ background-image: url(\''. $url .'\'); }';
        $html .= $this->image_gradient($colors['left']['hex'], $colors['right']['hex'], $class , $inner_class );
        return $html;
    }
    public function single_color_gradient($color, $class , $inner_class)
    {
        return $this->image_gradient($color, $color, $class , $inner_class, '0.5');
    }

    public function image_gradient($color_left, $color_right, $class , $inner_class, $opacity = 0 )
    {
        $rgb_left = $this->opacity($color_left, $opacity);
        $rgb_right = $this->opacity($color_right, $opacity);
        $html = '';
        $html .= $class . '{ background-color: '. $color_left .' }';
        $html .= $class . ':after{ background-color: '. $color_right .' }';
        $html .= $class . ' ' . $inner_class . ':before { '.$this->left_gradient($color_left , $rgb_left) .' }' . "\n";
        $html .= $class . ' ' . $inner_class . ':after { '.$this->right_gradient($color_right , $rgb_right) .' }' . "\n";

        return $html;
    }
    public function gradient_css($type='left' , $color_1 = '' , $color_2 = '')
    {
        $css = 'background: '.$color_1.';';
        $css .= 'background: -moz-linear-gradient('.$type.',  '.$color_1.' 0%, '.$color_2.' 100% );';
        $css .= 'background: -webkit-linear-gradient('.$type.',  '.$color_1.' 0%, '.$color_2.' 100% );';
        $css .= 'background: linear-gradient('.$type.',  '.$color_1.' 0%, '.$color_2.' 100% );';

        return $css;
    }
    public function gradient_css_3($type='left' , $color_1 = '' , $color_2 = '', $color_3 = '')
    {
        $css = 'background: '.$color_1.';';
        $css .= 'background: -moz-linear-gradient('.$type.',  '.$color_1.' 0%, '.$color_2.' 50%, '.$color_3.' 100%   );';
        $css .= 'background: -webkit-linear-gradient('.$type.',  '.$color_1.' 0%, '.$color_2.' 50%, '.$color_3.' 100%  );';
        $css .= 'background: linear-gradient('.$type.',  '.$color_1.' 0%, '.$color_2.' 50% , '.$color_3.' 100% );';

        return $css;
    }
    public function gradient_container($type='left' , $color_1 = '' , $color_2 = '', $color_3 = '' , $container_width = 1170)
    {
        $width = round($container_width/2) . 'px';
        $css = 'background: '.$color_1.';';
        $css .= 'background: -moz-linear-gradient('.$type.',  '.$color_1.' 0%, '.$color_1.' calc(50% - '.$width.'), '.$color_2.' 50% ,'.$color_3.' calc(50% + '.$width.'),  '.$color_3.' 100% );';
        $css .= 'background: -webkit-linear-gradient('.$type.',  '.$color_1.' 0%, '.$color_1.' calc(50% - '.$width.'), '.$color_2.' 50% ,'.$color_3.' calc(50% + '.$width.') , '.$color_3.' 100% );';
        $css .= 'background: linear-gradient('.$type.',  '.$color_1.' 0%, '.$color_1.' calc(50% - '.$width.'), '.$color_2.' 50% ,'.$color_3.' calc(50% + '.$width.'),  '.$color_3.' 100% );';

        $css .= 'z-index: 3;';

        return $css;
    }
    public function left_gradient($color , $rgb)
    {
        $html = 'background-color: '. $rgb .';
        background-image: -webkit-gradient(linear,left top,left top,color-stop(0%,'. $color .'),color-stop(100% '. $rgb .'));
        background-image: -webkit-linear-gradient(left,'. $color .' 0%,'. $rgb .' 100%);
        background-image: -moz-linear-gradient(left,'. $color .' 0%,'. $rgb .' 100%);
        background-image: -ms-linear-gradient(left,'. $color .' 0%,'. $rgb .' 100%);
        background-image: -o-linear-gradient(left,'. $color .' 0%,'. $rgb .' 100%);
        background-image: linear-gradient(left,'. $color .' 0%,'. $rgb .' 100%);';
        return $html;
    }
    public function top_gradient($top , $bottom)
    {
        $html = 'background-color: '. $top ;
        $html .= 'background: -webkit-linear-gradient('.$top.', '.$bottom.');';
        $html .= 'background: -o-linear-gradient('.$top.', '.$bottom.');';
        $html .= 'background: -moz-linear-gradient('.$top.', '.$bottom.'); ';
        $html .= 'background: linear-gradient('.$top.', '.$bottom.');';

        return $html;
    }
    public function radial_gradient($center , $border)
    {
        $html = 'background-color: '. $center ;
        $html .= 'background: -webkit-radial-gradient(circle, '.$center.', '.$border.');';
        $html .= 'background: -o-radial-gradient(circle, '.$center.', '.$border.');';
        $html .= 'background: -moz-radial-gradient(circle, '.$center.', '.$border.'); ';
        $html .= 'background: radial-gradient(circle, '.$center.', '.$border.');';

        return $html;
    }
    public function radial_gradient_3($color_1 , $color_2 , $color_3)
    {
        $html = 'background-color: '. $center ;
        $html .= 'background: -webkit-radial-gradient(circle, '.$color_1.' 0%, '.$color_2.' 50%, '.$color_3.' 100%);';
        $html .= 'background: -o-radial-gradient(circle, '.$color_1.' 0%, '.$color_2.' 50%, '.$color_3.' 100%);';
        $html .= 'background: -moz-radial-gradient(circle, '.$color_1.' 0%, '.$color_2.' 50%, '.$color_3.' 100%);';
        $html .= 'background: radial-gradient(circle, '.$color_1.' 0%, '.$color_2.' 50%, '.$color_3.' 100%);';

        return $html;
    }
    public function right_gradient($color , $rgb)
    {
        $html = 'background-color: '. $rgb .';
        background-image: -webkit-gradient(linear,left top,left top,color-stop(0%,'. $rgb .'),color-stop(100% '. $color .'));
        background-image: -webkit-linear-gradient(left,'. $rgb .' 0%,'. $color .' 100%);
        background-image: -moz-linear-gradient(left,'. $rgb .' 0%,'. $color .' 100%);
        background-image: -ms-linear-gradient(left,'. $rgb .' 0%,'. $color .' 100%);
        background-image: -o-linear-gradient(left,'. $rgb .' 0%,'. $color .' 100%);
        background-image: linear-gradient(left,'. $rgb .' 0%,'. $color .' 100%);';
        return $html;
    }
    public function get_image_colors_data($image_src='')
    {
        if ($image_src!='') {
            $colors = $this->get_avg_rgb($image_src, 10);
            return $colors;
        }
        return false;
    }
    public function get_average_color($attachment_id)
    {
        $image = wp_get_attachment_image_src( $attachment_id, 'full');
        if (!empty($image)) {
            $colors = $this->get_avg_rgb($image[0], 10);
            return $colors['average'];
        }
        return false;
    }

    function get_avg_rgb($filename, $num_samples = 10) {
        if (!function_exists('exif_imagetype')) {
            return 0;
        }

        $this->img = $this->get_image_data($filename);

        $width = $this->width = imagesx($this->img);
        $height = $this->height = imagesy($this->img);

        $this->x_step = intval($width / $num_samples);
        $this->y_step = intval($height / $num_samples);

        //average color
        $this->start_width = 0 ;
        $this->end_width = $width;
        $this->start_height = 0;
        $this->end_height = $height;
        $colors['average']  = $this->compute_average();

        //left color
        $this->start_width = 0 ;
        $this->end_width = round( $width / 4);
        $this->start_height = 0;
        $this->end_height = $height;
        $colors['left']  = $this->compute_average();

        //right color
        $this->start_width = round(3 * $width / 4);
        $this->end_width = $width;
        $this->start_height = 0;
        $this->end_height = $height;
        $colors['right']  = $this->compute_average();


        //top color
        $this->start_width = 0;
        $this->end_width = $width;
        $this->start_height = 0;
        $this->end_height = round( $height / 4);
        $colors['top']  = $this->compute_average();


        //bottom color
        $this->start_width = 0;
        $this->end_width = $width;
        $this->start_height = round(3 * $height / 4);
        $this->end_height = $height;
        $colors['bottom']  = $this->compute_average();

        //middle color
        $this->start_width = round( $width / 3);
        $this->end_width = round( 2 * $width / 3);
        $this->start_height = 0;
        $this->end_height = $height;
        $colors['middle']  = $this->compute_average();

        return $colors;
    }
    public function compute_average( )
    {
        $total_lum = 0;
        $total_red = 0;
        $total_green = 0;
        $total_blue = 0;

        $sample_no = 1;
        for ($x = $this->start_width; $x < $this->end_width; $x+=$this->x_step) {
            for ($y = $this->start_height; $y < $this->end_height; $y+=$this->y_step) {

                $rgb = imagecolorat($this->img, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $total_red += $r;
                $g = ($rgb >> 8) & 0xFF;
                $total_green += $g;
                $b = $rgb & 0xFF;
                $total_blue += $b;
                $sample_no++;
            }
        }

        // work out the average
        $avg_r = round($total_red / $sample_no);
        $avg_g = round($total_green / $sample_no);
        $avg_b = round($total_blue / $sample_no);

        $r = dechex($avg_r < 0 ? 0 : ($avg_r > 255 ? 255 : $avg_r));
        $g = dechex($avg_g < 0 ? 0 : ($avg_g > 255 ? 255 : $avg_g));
        $b = dechex($avg_b < 0 ? 0 : ($avg_b > 255 ? 255 : $avg_b));

        $color = (strlen($r) < 2 ? '0' : '') . $r;
        $color .= (strlen($g) < 2 ? '0' : '') . $g;
        $color .= (strlen($b) < 2 ? '0' : '') . $b;
        $avg_color = '#' . $color;
        return $avg_color;
    }


    function get_lum_hex($color) {
        $hex = str_replace('#', '', $color);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $lum = round(($r + $r + $b + $g + $g + $g) / 6);
        return $lum;
    }

    function get_lum($color) {
        // choose a simple luminance formula from here
        // http://stackoverflow.com/questions/596216/formula-to-determine-brightness-of-rgb-color
        $r = ($color >> 16) & 0xFF;
        $g = ($color >> 8) & 0xFF;
        $b = $color & 0xFF;

        // choose a simple luminance formula from here
        // http://stackoverflow.com/questions/596216/formula-to-determine-brightness-of-rgb-color
        $lum = round(($r + $r + $b + $g + $g + $g) / 6);
        return $lum;
    }

    public function get_color_class($lum='')
    {
        $class = 'c5-dark-background';
        if ($lum > 170 ) {
            $class = 'c5-light-background';
        }
        return $class;
    }

    public function get_class($color)
    {
        $lum = $this->get_lum_hex($color);
        return $this->get_color_class($lum);
    }

    function image_background_css( $element ,  $image_data ){
        $css = '';
        
        $css .= $element . '{background-image:url(\'' . $image_data[0] . '\');}' . "\n";
        if (isset($image_data[1]) && $image_data[1]!= '') {
            $css .= ' @media
            only screen and (-webkit-min-device-pixel-ratio: 2),
            only screen and (   min--moz-device-pixel-ratio: 2),
            only screen and (     -o-min-device-pixel-ratio: 2/1),
            only screen and (        min-device-pixel-ratio: 2),
            only screen and (                min-resolution: 192dpi),
            only screen and (                min-resolution: 2dppx) { ';
                $css .= $element . '{ background-image:url(\'' . $image_data[1] . '\'); }';
                $css .= '}';
        }
        if (isset($image_data[2]) && $image_data[2]!= '') {
            $css .= ' @media
            only screen and (min-width: 1281px) { ';
                $css .= $element . '{background-image:url(\'' . $image_data[2] . '\');}';
                $css .= '}';
        }
        if (isset($image_data[3]) && $image_data[3]!= '') {
            $css .= ' @media
            only screen and (-webkit-min-device-pixel-ratio: 2) and (min-width: 1281px),
            only screen and (   min--moz-device-pixel-ratio: 2) and (min-width: 1281px),
            only screen and (     -o-min-device-pixel-ratio: 2/1) and (min-width: 1281px),
            only screen and (        min-device-pixel-ratio: 2) and (min-width: 1281px),
            only screen and (                min-resolution: 192dpi) and (min-width: 1281px),
            only screen and (                min-resolution: 2dppx) and (min-width: 1281px) { ';
                $css .= $element . '{background-image:url(\'' . $image_data[3] . '\');}';
                $css .= '}';
        }

        if (isset($image_data[4]) && $image_data[4]!= '') {
            $css .= ' @media
            only screen and (min-width: 1601px) { ';
                $css .= $element . '{background-image:url(\'' . $image_data[4] . '\');}';
                $css .= '}';
        }
        if (isset($image_data[5]) && $image_data[5]!= '') {
            $css .= ' @media
            only screen and (-webkit-min-device-pixel-ratio: 2) and (min-width: 1601px) ,
            only screen and (   min--moz-device-pixel-ratio: 2) and (min-width: 1601px) ,
            only screen and (     -o-min-device-pixel-ratio: 2/1) and (min-width: 1601px) ,
            only screen and (        min-device-pixel-ratio: 2) and (min-width: 1601px) ,
            only screen and (                min-resolution: 192dpi) and (min-width: 1601px) ,
            only screen and (                min-resolution: 2dppx) and (min-width: 1601px) { ';
                $css .= $element . '{background-image:url(\'' . $image_data[5] . '\');}';
                $css .= '}';
        }


        return $css;
    }
    function format_background($array) {
        $data = '';

        if($array['background-repeat']!=''){
            $data .= 'background-repeat:'. $array['background-repeat'] .';';
        }
        if($array['background-attachment']!=''){
            $data .= 'background-attachment:'. $array['background-attachment'] .';';
        }

        $data .=  ($array['background-position'] == '') ? 'background-position:center;' : 'background-position:'. $array['background-position'] .';';

        $data .=  ($array['background-size'] == '') ? 'background-size:cover;' : 'background-size:'. $array['background-size'] .';';

        return $data;

    }


    function hexDarker($hex,$factor = 30) {
        $new_hex = '';
        $hex = substr($hex,1);
        $base['R'] = hexdec($hex{0}.$hex{1});
        $base['G'] = hexdec($hex{2}.$hex{3});
        $base['B'] = hexdec($hex{4}.$hex{5});

        foreach ($base as $k => $v)
        {
            $amount = $v / 100;
            $amount = round($amount * $factor);
            $new_decimal = $v - $amount;

            $new_hex_component = dechex($new_decimal);
            if(strlen($new_hex_component) < 2)
            { $new_hex_component = "0".$new_hex_component; }
            $new_hex .= $new_hex_component;
        }

        return '#' . $new_hex;
    }


    function hexLighter($hex,$factor = 30)
    {
        $new_hex = '';

        $base['R'] = hexdec($hex{0}.$hex{1});
        $base['G'] = hexdec($hex{2}.$hex{3});
        $base['B'] = hexdec($hex{4}.$hex{5});

        foreach ($base as $k => $v)
        {
            $amount = 255 - $v;
            $amount = $amount / 100;
            $amount = round($amount * $factor);
            $new_decimal = $v + $amount;

            $new_hex_component = dechex($new_decimal);
            if(strlen($new_hex_component) < 2)
            { $new_hex_component = "0".$new_hex_component; }
            $new_hex .= $new_hex_component;
        }

        return $new_hex;
    }

}

function c5ab_update_image_data_on_save($post_id) {

    if (wp_is_post_revision($post_id))
    return;

    $obj = new Code125_Colors();
    $obj->update_info($post_id , false);
}

add_action('save_post', 'c5ab_update_image_data_on_save');
?>
