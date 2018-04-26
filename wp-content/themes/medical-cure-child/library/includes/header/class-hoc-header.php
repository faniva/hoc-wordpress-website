<?php

class HOC_Header extends C5_header{


    /**
     * @param $header_layout
     * @return int
     */
    public static function validate_layout($header_layout){

        if ($header_layout == 'layout_1') {
            return 1;
        }
        if ($header_layout == 'layout_2') {
            return 2;
        }
        if ($header_layout == 'layout_3') {
            return 3;
        }
        if ($header_layout == 'layout_4') {
            return 4;
        }
        if ($header_layout == 'layout_5') {
            return 5;
        }
        if ($header_layout == 'layout_6') {
            return 6;
        }
        return 1;

    }


}
