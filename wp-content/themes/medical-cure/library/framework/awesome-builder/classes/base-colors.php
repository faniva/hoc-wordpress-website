<?php
/**
*
*/
if (class_exists('Code125_Base_Colors')) {
    return;
}
class Code125_Base_Colors
{

    function __construct()
    {
        # code...
    }

    // Validates hex color code and returns proper value
    // Input: String - Format #ffffff, #fff, ffffff or fff
    // Output: hex value - 3 byte (000000 if input is invalid)
    function validate_hex($hex) {
        // Complete patterns like #ffffff or #fff
        if(preg_match("/^#([0-9a-fA-F]{6})$/", $hex) || preg_match("/^#([0-9a-fA-F]{3})$/", $hex)) {
            // Remove #
            $hex = substr($hex, 1);
        }

        // Complete patterns without # like ffffff or 000000
        if(preg_match("/^([0-9a-fA-F]{6})$/", $hex)) {
            return $hex;
        }

        // Short patterns without # like fff or 000
        if(preg_match("/^([0-9a-f]{3})$/", $hex)) {
            // Spread to 6 digits
            return substr($hex, 0, 1) . substr($hex, 0, 1) . substr($hex, 1, 1) . substr($hex, 1, 1) . substr($hex, 2, 1) . substr($hex, 2, 1);
        }

        // If input value is invalid return black
        return "000000";
    }
    function hex2rgb($hex) {
        //Validate Hex Input
        $color = $this->validate_hex($hex);

        if (strlen($color) == 6)
        list($r, $g, $b) = array($color[0] . $color[1],
        $color[2] . $color[3],
        $color[4] . $color[5]);
        elseif (strlen($color) == 3)
        list($r, $g, $b) = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
        else
        return false;

        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);

        return array($r, $g, $b);
    }

    function hex2hsl($hex) {

        $rgb = $this->hex2rgb($hex);


        return $this->rgb2hsl($rgb);
    }

    function rgb2hsl($rgb) {
        // Fill variables $r, $g, $b by array given.
        list($r, $g, $b) = $rgb;

        $oldR = $r;
        $oldG = $g;
        $oldB = $b;
        $r /= 255;
        $g /= 255;
        $b /= 255;
        $max = max( $r, $g, $b );
        $min = min( $r, $g, $b );
        $h;
        $s;
        $l = ( $max + $min ) / 2;
        $d = $max - $min;
        if( $d == 0 ){
            $h = $s = 0; // achromatic
        } else {
            $s = $d / ( 1 - abs( 2 * $l - 1 ) );
            switch( $max ){
                case $r:
                $h = 60 * fmod( ( ( $g - $b ) / $d ), 6 );
                if ($b > $g) {
                    $h += 360;
                }
                break;
                case $g:
                $h = 60 * ( ( $b - $r ) / $d + 2 );
                break;
                case $b:
                $h = 60 * ( ( $r - $g ) / $d + 4 );
                break;
            }
        }
        return array( round( $h, 2 ), round( $s, 2 ), round( $l, 2 ) );
    }

    function hsl2rgb($hsl) {
        list($h, $s, $l) = $hsl;
        $r;
        $g;
        $b;
        $c = ( 1 - abs( 2 * $l - 1 ) ) * $s;
        $x = $c * ( 1 - abs( fmod( ( $h / 60 ), 2 ) - 1 ) );
        $m = $l - ( $c / 2 );
        if ( $h < 60 ) {
            $r = $c;
            $g = $x;
            $b = 0;
        } else if ( $h < 120 ) {
            $r = $x;
            $g = $c;
            $b = 0;
        } else if ( $h < 180 ) {
            $r = 0;
            $g = $c;
            $b = $x;
        } else if ( $h < 240 ) {
            $r = 0;
            $g = $x;
            $b = $c;
        } else if ( $h < 300 ) {
            $r = $x;
            $g = 0;
            $b = $c;
        } else {
            $r = $c;
            $g = 0;
            $b = $x;
        }
        $r = ( $r + $m ) * 255;
        $g = ( $g + $m ) * 255;
        $b = ( $b + $m  ) * 255;
        return array( floor( $r ), floor( $g ), floor( $b ) );
    }

    function rgb2hex($rgb) {
        list($r,$g,$b) = $rgb;

        return "#".sprintf("%02X",$r).sprintf("%02X",$g).sprintf("%02X",$b);
    }

    function hsl2hex($hsl) {
        $rgb = $this->hsl2rgb($hsl);
        return $this->rgb2hex($rgb);
    }

    public function get_color_complement($hex)
    {
        $hex = $this->shift_color_hue($hex, 180);
        return $hex;
    }
    public function shift_color_hue($hex, $shift = 0)
    {

        $hsl = $this->hex2hsl($hex);

        $h = $hsl[0];
        $h += $shift;
        if ($h > 360) {
            $h = $h - 360;
        }
        $hsl[0] = $h;
        // $hsl[1] = 0.25;
        // $hsl[2] = 0.15;
        $hex = $this->hsl2hex($hsl);
        return $hex;
    }
    public function AdjustHSL($hex , $s = '', $l = '' )
	{

		$hsl = $this->hex2hsl($hex);

		$hsl[1] = ($s != '') ? $s : $hsl[1];
		$hsl[2] = ($l != '') ? $l : $hsl[2];

		$hex = $this->hsl2hex($hsl);
		return $hex;
	}
}


?>
