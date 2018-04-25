<?php

/**
 *
 */
class Code125_ROW_Seperators
{

    public $width = 1600;
    public $height = 200;
    public $margin = 4;
    public $shadow_margin = 12;
    function __construct()
    {

    }

    public function none($color , $height,$class = 'top')
    {
        $this->height = $height;
        $color_1 = $color;
        $margin = 4;

        $half  = round(0.5*$this->height) ;
        ?>
        <svg class="code125-background-seperator-<?php echo $class; ?>" preserveAspectRatio="none"  viewBox="0 0 <?php echo $this->width ?> <?php echo $height ?>" data-height="<?php echo $height ?>">
            <polygon style="fill: <?php echo $color_1; ?>;" points="-4,<?php echo $half ?> 1604,<?php echo $half; ?> 1604,<?php echo $height ?> -4,<?php echo $height; ?> "></polygon>

        </svg>
        <?php
    }

    public function shape_v($color , $height, $class='top')
    {
        $this->height = $height;
        $color_object = new Code125_Colors();
        $rgb = $color_object->hex2rgb($color);
        $color_1 = 'rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')';
        $color_2 = 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].', 0.75)';
        $color_3 = 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].', 0.5)';
        $margin = 4;
        $v_point = $this->height - $margin;
        $end_point = $this->height + $margin;

        $first_point = 0;
        $second_point = round(0.15*$this->height);
        $third_point = round(0.3*$this->height);

        ?>
        <svg class="code125-background-seperator-<?php echo $class ?>" preserveAspectRatio="none"  viewBox="0 0 <?php echo $this->width ?> <?php echo $this->height ?>" data-height="<?php echo $this->height ?>">
            <polygon style="fill: <?php echo $color_1 ?>;" points="-4,<?php echo $third_point ?> 800,<?php echo $v_point ?> 1604,<?php echo $third_point ?> 1604,<?php echo $end_point ?> -4,<?php echo $end_point ?> "></polygon>
            <polygon style="fill: <?php echo $color_2 ?>;" points="-4,<?php echo $second_point ?> 800,<?php echo $v_point ?> 1604,<?php echo $second_point ?> 1604,<?php echo $end_point ?> -4,<?php echo $end_point ?> "></polygon>
            <polygon style="fill: <?php echo $color_3 ?>;" points="-4,<?php echo $first_point ?> 800,<?php echo $v_point ?> 1604,<?php echo $first_point ?> 1604,<?php echo $end_point ?> -4,<?php echo $end_point ?> "></polygon>

        </svg>
        <?php
    }
    public function shape_n($color , $height,$class = 'top')
    {
        $this->height = $height;
        $color_object = new Code125_Colors();
        $rgb = $color_object->hex2rgb($color);
        $color_1 = 'rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')';
        $color_2 = 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].', 0.75)';
        $color_3 = 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].', 0.5)';
        $margin = 4;

        $first_point_s = 0;
        $first_point_e = $this->width;
        $second_point_s = round(-0.15*$this->width);
        $second_point_e = $this->width + round(0.15*$this->width);
        $third_point_s = round(-0.3*$this->width);
        $third_point_e = $this->width + round(0.3*$this->width);
        ?>
        <svg class="code125-background-seperator-<?php echo $class; ?>" preserveAspectRatio="none"  viewBox="0 0 <?php echo $this->width ?> <?php echo $this->height ?>" data-height="<?php echo $this->height ?>">
            <polygon style="fill: <?php echo $color_1; ?>;" points="<?php echo $first_point_s ?>,<?php echo $this->height ?> 800,0 <?php echo $first_point_e ?>,<?php echo $this->height ?> "></polygon>

            <polygon style="fill: <?php echo $color_2; ?>;" points="<?php echo $second_point_s ?>,<?php echo $this->height ?> 800,0 <?php echo $second_point_e ?>,<?php echo $this->height ?> "></polygon>

            <polygon style="fill: <?php echo $color_3; ?>;" points="<?php echo $third_point_s ?>,<?php echo $this->height ?> 800,0 <?php echo $third_point_e ?>,<?php echo $this->height ?> "></polygon>
        </svg>
        <?php
    }
    public function slash_left($color , $height,$class = 'top')
    {
        $this->height = $height;
        $color_object = new Code125_Colors();
        $rgb = $color_object->hex2rgb($color);
        $color_1 = 'rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')';
        $color_2 = 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].', 0.75)';
        $color_3 = 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].', 0.5)';
        $margin = 4;

        $first_point = round(0.3*$this->height) ;
        $second_point =round(0.15*$this->height);
        $third_point = 0;
        ?>
        <svg class="code125-background-seperator-<?php echo $class; ?>" preserveAspectRatio="none"  viewBox="0 0 <?php echo $this->width ?> <?php echo $this->height ?>" data-height="<?php echo $this->height ?>">
            <polygon style="fill: <?php echo $color_1; ?>;" points="-4,<?php echo $this->height ?> 1604,<?php echo $first_point; ?> 1604,<?php echo $this->height ?> "></polygon>
            <polygon style="fill: <?php echo $color_2; ?>;" points="-4,<?php echo $this->height ?> 1604,<?php echo $second_point; ?> 1604,<?php echo $this->height ?> "></polygon>
            <polygon style="fill: <?php echo $color_3; ?>;" points="-4,<?php echo $this->height ?> 1604,<?php echo $third_point; ?> 1604,<?php echo $this->height ?> "></polygon>

        </svg>
        <?php
    }
    public function slash_right($color , $height,$class = 'top')
    {
        $this->height = $height;
        $color_object = new Code125_Colors();
        $rgb = $color_object->hex2rgb($color);
        $color_1 = 'rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')';
        $color_2 = 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].', 0.75)';
        $color_3 = 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].', 0.5)';
        $margin = 4;

        $first_point = round(0.3*$this->height) ;
        $second_point =round(0.15*$this->height);
        $third_point = 0;
        ?>
        <svg class="code125-background-seperator-<?php echo $class; ?>" preserveAspectRatio="none"  viewBox="0 0 <?php echo $this->width ?> <?php echo $this->height ?>" data-height="<?php echo $this->height ?>">
            <polygon style="fill: <?php echo $color_1; ?>;" points="-4,<?php echo $this->height ?> -4,<?php echo $first_point; ?> 1604,<?php echo $this->height ?> "></polygon>
            <polygon style="fill: <?php echo $color_2; ?>;" points="-4,<?php echo $this->height ?> -4,<?php echo $second_point; ?> 1604,<?php echo $this->height ?> "></polygon>
            <polygon style="fill: <?php echo $color_3; ?>;" points="-4,<?php echo $this->height ?> -4,<?php echo $third_point; ?> 1604,<?php echo $this->height ?> "></polygon>

        </svg>
        <?php
    }


    public function curve($color , $height,$class = 'top')
    {
        $this->height = $height;
        $color_object = new Code125_Colors();
        $rgb = $color_object->hex2rgb($color);
        $color_1 = 'rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')';
        $color_2 = 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].', 0.75)';
        $color_3 = 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].', 0.5)';

        $end_point = $this->height - 2;
        $end_point_2 = round(0.85*$this->height) - 2;
        $end_point_3 = round(0.7*$this->height) - 2;

        $height_half = round(0.5*$this->height);
        ?>
        <svg class="code125-background-seperator-<?php echo $class; ?>" preserveAspectRatio="none"  viewBox="0 0 <?php echo $this->width ?> <?php echo $this->height ?>" data-height="<?php echo $this->height ?>">
            <path style="fill: <?php echo $color_1; ?>;" d="M0,0 C400,0 600,<?php echo $end_point ?> 800,<?php echo $end_point ?> C1204,<?php echo $end_point ?> 1200,0 1604,0 L1604,<?php echo $this->height ?> L0,<?php echo $this->height ?> Z" ></path>

            <path style="fill: <?php echo $color_2; ?>;" d="M0,0 C400,0 600,<?php echo $end_point_2 ?> 800,<?php echo $end_point_2 ?> C1204,<?php echo $end_point_2 ?> 1200,0 1604,0 L1604,<?php echo $this->height ?> L0,<?php echo $this->height ?> Z" ></path>

            <path style="fill: <?php echo $color_3; ?>;" d="M0,0 C400,0 600,<?php echo $end_point_3 ?> 800,<?php echo $end_point_3 ?> C1204,<?php echo $end_point_3 ?> 1200,0 1604,0 L1604,<?php echo $this->height ?> L0,<?php echo $this->height ?> Z" ></path>
        </svg>
        <?php
    }

    public function curve_right($color , $height,$class = 'top')
    {
        $this->height = $height;
        $color_object = new Code125_Colors();
        $rgb = $color_object->hex2rgb($color);
        $color_1 = 'rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')';
        $color_2 = 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].', 0.75)';
        $color_3 = 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].', 0.5)';

        $end_point = $this->height - 2;
        $end_point_2 = round(0.85*$this->height) - 2;
        $end_point_3 = round(0.7*$this->height) - 2;

        $height_half = round(0.5*$this->height);
        ?>
        <svg class="code125-background-seperator-<?php echo $class; ?>" preserveAspectRatio="none"  viewBox="0 0 <?php echo $this->width ?> <?php echo $this->height ?>" data-height="<?php echo $this->height ?>">
            <path style="fill: <?php echo $color_1; ?>;" d="M0,0 C600,0 1000,<?php echo $end_point; ?> 1604,<?php echo $end_point; ?> L1604,<?php echo $this->height ?> L0,<?php echo $this->height ?> Z" ></path>

            <path style="fill: <?php echo $color_2; ?>;" d="M0,0 C600,0 1000,<?php echo $end_point_2; ?> 1604,<?php echo $end_point_2; ?> L1604,<?php echo $this->height ?> L0,<?php echo $this->height ?> Z" ></path>

            <path style="fill: <?php echo $color_3; ?>;" d="M0,0 C600,0 1000,<?php echo $end_point_3; ?> 1604,<?php echo $end_point_3; ?> L1604,<?php echo $this->height ?>  L0,<?php echo $this->height ?> Z" ></path>
        </svg>
        <?php
    }

    public function curve_left($color , $height,$class = 'top')
    {
        $this->height = $height;
        $color_object = new Code125_Colors();
        $rgb = $color_object->hex2rgb($color);
        $color_1 = 'rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')';
        $color_2 = 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].', 0.75)';
        $color_3 = 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].', 0.5)';

        $end_point = round(0.3*$this->height);
        $end_point_2 = round(0.15*$this->height);
        $end_point_3 = 2;

        $height_half = round(0.5*$this->height);
        ?>
        <svg class="code125-background-seperator-<?php echo $class; ?>" preserveAspectRatio="none"  viewBox="0 0 <?php echo $this->width ?> <?php echo $this->height ?>" data-height="<?php echo $this->height ?>">
            <path style="fill: <?php echo $color_1; ?>;" d="M0,<?php echo $this->height ?> C600,<?php echo $end_point ?> 1000,<?php echo $end_point; ?> 1604,<?php echo $end_point; ?> L1604,0 L1604,<?php echo $this->height ?> Z" ></path>

            <path style="fill: <?php echo $color_2; ?>;" d="M0,<?php echo $this->height ?> C600,<?php echo $end_point_2 ?> 1000,<?php echo $end_point_2; ?> 1604,<?php echo $end_point_2; ?> L1604,0 L1604,<?php echo $this->height ?> Z" ></path>

            <path style="fill: <?php echo $color_3; ?>;" d="M0,<?php echo $this->height ?> C600,<?php echo $end_point_3 ?> 1000,<?php echo $end_point_3; ?> 1604,<?php echo $end_point_3; ?> L1604,0 L1604,<?php echo $this->height ?> Z" ></path>

        </svg>
        <?php
    }
}


?>
