<?php
/**
*
*/
class Code125_Background_Implementation
{
    public $parent;
    public $inner;
    public $container;

    public $values;
    public $main_value;
    function __construct()
    {

    }
    public function defaults()
    {
        $defaults = array(
            'code125-background-type' => 'none',
            'code125-background-image' => '',
            'code125-background-attachment' => '',
            'code125-background-position' => '',
            'code125-background-repeat' => '',
            'code125-background-size' => '',
            'code125-background-video-mp4' => '',
            'code125-background-video-ogg' => '',
            'code125-background-video-format' => '',
            'code125-color-overlay-type' => 'full',
            'code125-image-overlay-type' => 'none',
            'code125-video-overlay-type' => 'none',
            'code125-image-half-overlay-type' => 'left',
            'code125-background-animation' => 'none',
            'code125-image-color-overlay-type' => 'solid',
            'code125-background-gradient-orientation' => 'horizontal',
            'code125-background-lum' => 'c5-light-background',
            'code125-seperator-top' => '',
            'code125-seperator-height-top' => '100',
            'code125-seperator-bottom' => '',
            'code125-seperator-height-bottom' => '100',

            'code125-color-1-opacity' => '1',
            'code125-color-1-hover-opacity' => '1',
            'code125-color-2-opacity' => '1',
            'code125-color-2-hover-opacity' => '1',
            'code125-color-3-opacity' => '1',
            'code125-color-3-hover-opacity' => '1',

        );
        return $defaults;
    }


    public function options($values)
    {
        if (is_array($values)) {
			$this->values = wp_parse_args( $values, $this->defaults() );
			$this->main_value = code125_encode($this->values);
		}else{
            $this->main_value = $values;
            $options = code125_decode($values);
            $this->values = wp_parse_args( $options, $this->defaults() );
		}

    }
    public function set_options($values)
    {
        $this->values = wp_parse_args( $values, $this->defaults() );
    }
    public function preview($values)
    {

        $this->parent = '.c5cbg-preview-wrap';
        $this->inner = '.c5bg-editor-inner';
        $this->container = '.container';

        $GLOBALS['c5_content_width'] = 350;

        $this->set_options($values);
        $class = $this->background_css();
        ?>
        <div class="<?php $this->get_class('parent'); ?> <?php echo $class ?>">
            <?php $this->background_html() ?>
            <div class="<?php $this->get_class('container'); ?>">
                <p class="code125-bgep-title"><?php  esc_html_e('Preview', 'medical-cure'); ?></p>
            </div>
            <div class="code125-cbgep-preview-controls">
                <span class="code125-cbgep-preview-refresh"><i class="fa fa-refresh"></i><?php  esc_html_e('Refresh Preview', 'medical-cure') ?></span>
                <span class="code125-cbgep-preview-loading "><i class="fa fa-spin fa-spinner"></i> <?php  esc_html_e('Refreshing Preview...', 'medical-cure') ?></span>
            </div>
        </div>

        <?php
        $this->suggestions();
    }
    public function suggestions()
    {
        $temp_values = $this->values;
        $temp_parent = $this->parent;

        ?>
        <p><?php  esc_html_e('Suggested Background Styles:', 'medical-cure') ?></p>
        <?php
        echo '<div class="c5cbg-suggestion-wrap clearfix">';

        $color_object = new Code125_Colors();
        $suggestions = array();
        if ($this->values['code125-background-type'] == 'image' && $this->values['code125-background-image'] != '') {
            $colors = $color_object->get_image_colors_data($this->values['code125-background-image']);
            $accent_color = apply_filters( 'c5cbg_default_color_suggestion', '#A00A00' );
            $dark_accent_color = $color_object->hexDarker( $accent_color , 20);
            $light_accent_color = $color_object->AdjustHSL( $accent_color , '0.47', '0.95' );

            if (!empty($colors)) {
                $suggestions[] = $colors['left'];
                $suggestions[] = $colors['middle'];
                $suggestions[] = $colors['right'];
                $suggestions[] = $colors['average'];
            }

            $this->values['code125-background-lum'] = 'c5-dark-background';

            //suggestion 1
            $this->values['code125-color-1'] = $suggestions[0];
            $this->values['code125-color-1-opacity'] = 1;
            $this->values['code125-color-1-hover'] = $suggestions[0];
            $this->values['code125-color-1-hover-opacity'] = 1;

            $this->values['code125-color-2'] = $suggestions[1];
            $this->values['code125-color-2-opacity'] = 0.25;
            $this->values['code125-color-2-hover'] = $suggestions[1];
            $this->values['code125-color-2-hover-opacity'] = 0.5;

            $this->values['code125-color-3'] = $suggestions[2];
            $this->values['code125-color-3-opacity'] = 1;
            $this->values['code125-color-3-hover'] = $suggestions[2];
            $this->values['code125-color-3-hover-opacity'] = 1;

            $this->values['code125-image-overlay-type'] = 'container';
            $this->values['code125-background-gradient-orientation'] = 'horizontal';
            $this->render_suggestion();

            //suggestion 2
            $this->values = $temp_values;
            $this->values['code125-color-1'] = $suggestions[0];
            $this->values['code125-color-1-opacity'] = 0.5;
            $this->values['code125-color-1-hover'] = $suggestions[0];
            $this->values['code125-color-1-hover-opacity'] = 0.75;


            $this->values['code125-color-3'] = $suggestions[2];
            $this->values['code125-color-3-opacity'] = 0.5;
            $this->values['code125-color-3-hover'] = $suggestions[2];
            $this->values['code125-color-3-hover-opacity'] = 0.75;

            $this->values['code125-image-overlay-type'] = 'full';
            $this->values['code125-image-color-overlay-type'] = 'gradient-two';
            $this->values['code125-background-gradient-orientation'] = 'horizontal';
            $this->render_suggestion();

            //suggestion 3
            $this->values = $temp_values;
            $this->values['code125-color-1'] = $suggestions[3];
            $this->values['code125-color-1-opacity'] = 1;
            $this->values['code125-color-1-hover'] = $suggestions[1];
            $this->values['code125-color-1-hover-opacity'] = 1;


            $this->values['code125-image-overlay-type'] = 'half';
            $this->values['code125-image-color-overlay-type'] = 'solid';
            $this->render_suggestion();

            //suggestion 6
            $this->values['code125-color-1'] =$accent_color;
            $this->values['code125-color-1-hover'] = '';
            $this->values['code125-background-lum'] = 'c5-dark-background';
            $this->render_suggestion();

            //suggestion 5
            $this->values['code125-color-1'] = $light_accent_color;
            $this->values['code125-color-1-hover'] = '';
            $this->values['code125-background-lum'] = 'c5-light-background';
            $this->render_suggestion();

            //suggestion 5
            $this->values['code125-color-1'] = $accent_color;
            $this->values['code125-color-1-opacity'] = '0.7';
            $this->values['code125-image-overlay-type'] = 'full';
            $this->values['code125-image-color-overlay-type'] = 'solid';
            $this->values['code125-background-lum'] = 'c5-dark-background';
            $this->render_suggestion();

            $this->values['code125-color-1'] = '#000';
            $this->values['code125-color-1-opacity'] = '0.7';
            $this->render_suggestion();

            //suggestion 5
            $this->values['code125-color-1'] = $light_accent_color;
            $this->values['code125-color-1-opacity'] = '0.7';
            $this->values['code125-background-lum'] = 'c5-light-background';
            $this->render_suggestion();



        }else{

            $this->color_suggestions();
        }


        echo '</div>';



        $this->values = $temp_values;
        $this->parent = $temp_parent;

    }
    public function color_suggestions()
    {
        $color_object = new Code125_Colors();

        $accent_color = apply_filters( 'c5cbg_default_color_suggestion', '#A00A00' );
        $dark_accent_color = $color_object->hexDarker( $accent_color , 20);
        $light_accent_color = $color_object->AdjustHSL( $accent_color , '0.47', '0.95' );

        $this->values['code125-background-type'] = 'color';

        //suggestion 1
        $this->values['code125-color-1'] = $accent_color;
        $this->values['code125-color-1-opacity'] = 1;
        $this->values['code125-color-1-hover'] = '';
        $this->values['code125-color-1-hover-opacity'] = 1;
        $this->values['code125-color-overlay-type'] = 'full';
        $this->values['code125-image-color-overlay-type'] = 'solid';
        $this->values['code125-background-lum'] = 'c5-dark-background';
        $this->render_suggestion('Theme Accent Color');



        //suggestion 1
        $this->values['code125-color-1'] = $light_accent_color;
        $this->values['code125-color-1-opacity'] = 1;
        $this->values['code125-color-1-hover'] = '';
        $this->values['code125-color-1-hover-opacity'] = 1;
        $this->values['code125-color-overlay-type'] = 'full';
        $this->values['code125-image-color-overlay-type'] = 'solid';
        $this->values['code125-background-lum'] = 'c5-light-background';
        $this->render_suggestion('Theme Accent Color (Light)');

        //suggestion 1
        $this->values['code125-color-1'] = $accent_color;
        $this->values['code125-color-1-opacity'] = 1;
        $this->values['code125-color-1-hover'] = '';
        $this->values['code125-color-1-hover-opacity'] = 1;

        $this->values['code125-color-3'] = $dark_accent_color;
        $this->values['code125-color-3-opacity'] = 1;
        $this->values['code125-color-3-hover'] = '';
        $this->values['code125-color-3-hover-opacity'] = 1;

        $this->values['code125-color-overlay-type'] = 'full';
        $this->values['code125-image-color-overlay-type'] = 'gradient-two';
        $this->values['code125-background-lum'] = 'c5-dark-background';
        $this->values['code125-background-gradient-orientation'] = 'radial';
        $this->render_suggestion('Theme Accent Color (Gradient)');


        $this->values['code125-color-1'] = '#43cea2';
        $this->values['code125-color-3'] = '#185a9d';
        $this->values['code125-background-gradient-orientation'] = 'diagonal-bottom';
        $this->render_suggestion('Suggested Gradient');

        $this->values['code125-color-1'] = '#4AC29A';
        $this->values['code125-color-3'] = '#BDFFF3';
        $this->values['code125-background-gradient-orientation'] = 'diagonal-bottom';
        $this->render_suggestion('Suggested Gradient');

        $this->values['code125-color-1'] = '#36D1DC';
        $this->values['code125-color-3'] = '#5B86E5';
        $this->values['code125-background-gradient-orientation'] = 'diagonal-bottom';
        $this->render_suggestion('Suggested Gradient');

        $this->values['code125-color-1'] = '#1D976C';
        $this->values['code125-color-3'] = '#93F9B9';
        $this->values['code125-background-gradient-orientation'] = 'diagonal-bottom';
        $this->render_suggestion('Suggested Gradient');


        $this->values['code125-color-1'] = '#5C258D';
        $this->values['code125-color-3'] = '#4389A2';
        $this->render_suggestion('Suggested Gradient');

        $this->values['code125-color-1'] = '#9D50BB';
        $this->values['code125-color-3'] = '#6E48AA';
        $this->render_suggestion('Suggested Gradient');

        $this->values['code125-color-1'] = '#141E30';
        $this->values['code125-color-3'] = '#243B55';
        $this->render_suggestion('Suggested Gradient');

        $this->values['code125-color-1'] = '#67B26F';
        $this->values['code125-color-3'] = '#4ca2cd';
        $this->render_suggestion('Suggested Gradient');





        // //suggestion 3
        // $this->values['code125-color-1'] = $suggestions[0];
        // $this->values['code125-color-1-opacity'] = 1;
        // $this->values['code125-color-1-hover'] = $color_object->hexDarker( $suggestions[0] , 20);
        // $this->values['code125-color-1-hover-opacity'] = 1;
        //
        // $this->values['code125-color-3'] = $suggestions[1];
        // $this->values['code125-color-3-opacity'] = 1;
        // $this->values['code125-color-3-hover'] = $color_object->hexDarker( $suggestions[1] , 20);
        // $this->values['code125-color-3-hover-opacity'] = 1;
        //
        // $this->values['code125-color-overlay-type'] = 'half';
        // $this->values['code125-image-color-overlay-type'] = 'solid';
        // $this->render_suggestion();
    }
    public function render_suggestion($label = '')
    {
        $id = $this->generate_unique_id();

        $this->parent = '.suggestion-' . $id ;
        $this->inner = '.c5bg-editor-inner';
        $this->container = '.container';

        $GLOBALS['c5_content_width'] = 100;
        $class = $this->background_css();


        ?>
        <div class="c5cbg-col">

            <div class="c5cbg-suggestion-single suggestion-<?php echo $id ?> <?php echo $class ?>" data-import="<?php echo $this->encode_values(); ?>">
                <?php $this->background_html() ?>
                <div class="<?php $this->get_class('container'); ?>">
                    <p><?php echo $label ?></p>
                </div>
            </div>
        </div>
        <?php
    }
    public function encode_values()
    {
        return code125_encode($this->values);
    }

    public function background_html($in_row = true)
    {
        $class = '';



        if ($this->values['code125-background-type'] == 'video') {
            if ($this->values['code125-video-overlay-type'] == 'container') {
                ?>
                <div class="<?php $this->get_class('inner'); ?>-video-wrap">
                    <div class="<?php $this->get_class('container'); ?>">
                        <div class="<?php $this->get_class('inner'); ?>">
                            <?php $this->video(); ?>
                        </div>
                    </div>
                </div>
                <?php
            }else{
                ?>
                <div class="<?php $this->get_class('inner'); ?>-video-wrap">
                    <?php $this->video(); ?>
                </div>
                <?php
            }

        }elseif($this->values['code125-background-type'] == 'color'){
            if ($this->values['code125-color-overlay-type'] == 'full' && $this->values['code125-image-color-overlay-type'] == 'solid' && $in_row) {
                $sperator = new Code125_ROW_Seperators($this->values);
                $color = $this->values['code125-color-1'];
                $func = $this->values['code125-seperator-top'];
                $height = $this->values['code125-seperator-height-top'];
                if ($height == '') {
                    $height = 100;
                }
                if ($func != '' && $func != 'none') {
                    $sperator->$func($color , $height ,'top');
                }

                $color = $this->values['code125-color-1'];
                $func = $this->values['code125-seperator-bottom'];
                $height = $this->values['code125-seperator-height-bottom'];
                if ($height == '') {
                    $height = 100;
                }
                if ($func != '' && $func != 'none') {
                    $sperator->$func($color , $height ,'bottom');
                }

            }

            $class .= ' code125-background-solid-shape';
        }elseif($this->values['code125-background-type'] == 'image'){
            ?>
            <div class="<?php $this->get_class('inner'); ?>-wrap">
                <div class="<?php $this->get_class('container'); ?>">
                    <div class="<?php $this->get_class('inner'); ?>"></div>
                </div>
            </div>
            <?php
        }
    }
    public function video()
    {
        if ($this->values['code125-background-video-youtube'] !='') {
            $video = explode('/' , $this->values['code125-background-video-youtube']);
            if(isset($video[3])){
                $id = str_replace('watch?v=' , '', $video[3] );
                ?>
                <iframe src="https://www.youtube.com/embed/<?php echo $id ?>?loop=1&controls=0&showinfo=0&rel=0&autoplay=1&enablejsapi=1&playlist=<?php echo $id ?>" frameborder="0" allowfullscreen style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; z-index: 0; width: 100%;height:100%; border:none;" class="code125-youtube-video-background"></iframe>
                <?php
            }


        }elseif($this->values['code125-background-video-mp4'] !='' || $this->values['code125-background-video-ogg'] !='' || $this->values['code125-background-video-webm'] !='' ){
            ?>
            <video id="video_background" preload="auto" autoplay="autoplay" loop="loop" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; z-index: 0; width: 100%;">
                <?php
                if($this->values['code125-background-video-mp4'] !='' ){
                    echo '<source src="'.$this->values['code125-background-video-mp4'].'" type="video/mp4">';
                }
                if($this->values['code125-background-video-ogg'] !='' ){
                    echo '<source src="'.$this->values['code125-background-video-ogg'].'" type="video/ogg">';
                }
                if($this->values['code125-background-video-webm'] !='' ){
                    echo '<source src="'.$this->values['code125-background-video-webm'].'" type="video/webm">';
                }
                ?>
            </video>
            <?php
        }
    }

    public function format_color($key)
    {
        $hex = $this->values[$key];
        $opacity=  $this->values[$key . '-opacity'];
        if ($opacity == '1') {
            return $hex;
        }
        $color_object = new Code125_Colors();
        $rgb = $color_object->hex2rgb($hex);
        return 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].','.$opacity.')';
    }
    public function gradient_type()
    {
        if ($this->values['code125-background-gradient-orientation'] =='vertical') {
            $type = 'top';
        }elseif ($this->values['code125-background-gradient-orientation'] =='diagonal') {
            $type = '135deg';
        }elseif ($this->values['code125-background-gradient-orientation'] =='diagonal-bottom') {
            $type = '45deg';
        }else {
            $type = 'left';
        }
        return $type;
    }

    public function gradient($base, $hover){
        $css = '';
        $color_object = new Code125_Colors();
        $color_1 = $this->format_color('code125-color-1');
        $color_2 = $this->format_color('code125-color-3');

        $color_1_hover = $this->format_color('code125-color-1-hover');
        $color_2_hover = $this->format_color('code125-color-3-hover');

        if($this->values['code125-background-gradient-orientation'] =='radial'){

            $css .= $base . ' { ' . $color_object->radial_gradient( $color_1 , $color_2) . '}';

            $css .= $hover . ' { ' . $color_object->radial_gradient( $color_1_hover , $color_2_hover) . '}';

        }else{
            $type = $this->gradient_type();

            $css .= $base . ' { ' . $color_object->gradient_css($type , $color_1 , $color_2) . '}';

            $css .= $hover . ' { ' . $color_object->gradient_css($type , $color_1_hover , $color_2_hover) . '}';
        }
        return $css;
    }

    public function gradient_3_points($base, $hover){
        $css = '';
        $color_object = new Code125_Colors();

        $color_1 = $this->format_color('code125-color-1');
        $color_2 = $this->format_color('code125-color-2');
        $color_3 = $this->format_color('code125-color-3');

        $color_1_hover = $this->format_color('code125-color-1-hover');
        $color_2_hover = $this->format_color('code125-color-2-hover');
        $color_3_hover = $this->format_color('code125-color-3-hover');

        if( $this->values['code125-background-gradient-orientation'] =='radial'){

            $css .= $base . ' { ' . $color_object->radial_gradient_3( $color_1 , $color_2, $color_3) . '}';

            if ($color_1_hover != '' && $color_2_hover != '' && $color_3_hover != ''  ) {
                $css .= $hover . ' { ' . $color_object->radial_gradient_3( $color_1_hover , $color_2_hover, $color_3_hover) . '}';
            }else{
                $new_id = str_replace(':before',':hover:before',$base);
                $css .= $new_id . '{opacity: 1 !important; visibility: visible !important;}';
            }

        }else{
            $type = $this->gradient_type();


            $css .= $base . ' { ' . $color_object->gradient_css_3($type , $color_1 , $color_2, $color_3) . '}';

            if ($color_1_hover != '' && $color_2_hover != '' && $color_3_hover != ''  ) {
                $css .= $hover . ' { ' . $color_object->gradient_css_3($type , $color_1_hover , $color_2_hover, $color_3_hover) . '}';
            }else{
                $new_id = str_replace(':before',':hover:before',$base);
                $css .= $new_id . '{opacity: 1 !important; visibility: visible !important;}';
            }

        }
        return $css;
    }

    public function background_solid($base , $hover , $secondary = false)
    {
        $key = 'code125-color-1';
        if ($secondary) {
            $key = 'code125-color-3';
        }
        $css = '';
        if ($this->values[$key] != '') {
            $color = $this->format_color($key);
            $css .= $base . ' { background: '. $color .'}';
        }

        if ($this->values[$key . '-hover'] != '') {
            $color = $this->format_color($key . '-hover');
            $css .= $hover . ' { background: '.$color.'}';
        }
        return $css;
    }

    public function background_type_color()
    {
        $css = '';
        if ($this->values['code125-color-overlay-type'] == 'full') {
            if ( $this->values['code125-image-color-overlay-type'] == 'solid') {

                $css .= $this->background_solid($this->parent , $this->parent . ':hover');

                $color = $this->format_color('code125-color-1');
                $css .= $this->parent .' .code125-background-solid-shape:before,';
                $css .= $this->parent .' .code125-background-solid-shape:after {';
                    $css .= 'border-color: '.$color.';';
                    $css .='}';

                    if ($this->values['code125-color-1-hover'] != '') {
                        $color = $this->format_color('code125-color-1-hover');
                        $css .= $this->parent .':hover .code125-background-solid-shape:before,';
                        $css .= $this->parent .':hover .code125-background-solid-shape:after {';
                            $css .= 'border-color: '.$color.';';
                            $css .='}';
                        }


                    }elseif ( $this->values['code125-image-color-overlay-type'] == 'gradient-two') {
                        $css .= $this->gradient($this->parent . ':before', $this->parent . ':after');


                    }elseif ( $this->values['code125-image-color-overlay-type'] == 'gradient-three') {
                        $css .= $this->gradient_3_points($this->parent . ':before', $this->parent . ':after');

                    }
                }elseif ($this->values['code125-color-overlay-type'] == 'half') {
                    $image = ':after';
                    $color = ':before';

                    $base = $this->parent .$image;
                    $hover = $this->parent . ':hover' . $image;
                    $css .= $this->background_solid($base , $hover);
                    $css .= $base . '{width:50%; right: auto !important; opacity: 1 !important; visibility: visible !important;}';

                    $base = $this->parent . $color;
                    $hover = $this->parent . ':hover' . $color;
                    $css .= $this->background_solid($base , $hover, true);
                    $css .= $base . '{width:50%; left: auto  !important;}';

                    $css .= '@media only screen and (max-width: 481px) {'.$base . '{ width:100%; } }';


                }
                return $css;
            }

            public function background_type_image()
            {
                $css = '';
                if ($this->values['code125-image-overlay-type'] == 'none') {
                    $css .= $this->format_background($this->parent);
                }elseif ($this->values['code125-image-overlay-type'] == 'full') {
                    if ($this->values['code125-image-color-overlay-type'] == 'solid') {
                        $css .= $this->format_background($this->parent);

                        $base = $this->parent .':before';
                        $hover = $this->parent . ':after';

                        $css .= $this->background_solid($base , $hover);
                    } elseif ( $this->values['code125-image-color-overlay-type'] == 'gradient-two') {
                        $css .= $this->format_background($this->parent);

                        $base = $this->parent .':before';
                        $hover = $this->parent . ':after';
                        $css .= $this->gradient( $base, $hover);

                    } elseif ( $this->values['code125-image-color-overlay-type'] == 'gradient-three') {
                        $css .= $this->format_background($this->parent);

                        $base = $this->parent .':before';
                        $hover = $this->parent . ':after';
                        $css .= $this->gradient_3_points( $base, $hover);

                    }

                }elseif ($this->values['code125-image-overlay-type'] == 'container') {
                    $css .= $this->format_background($this->parent .' ' . $this->inner);

                    $this->values['code125-color-1-opacity'] = 1;
                    $this->values['code125-color-3-opacity'] = 1;
                    $this->values['code125-color-1-hover-opacity'] = 1;
                    $this->values['code125-color-3-hover-opacity'] = 1;
                    $this->values['code125-background-gradient-orientation'] = 'horizontal';

                    $base = $this->parent .':before';
                    $hover = $this->parent . ':after';

                    $color_1 = $this->format_color('code125-color-1');
                    $color_2 = $this->format_color('code125-color-2');
                    $color_3 = $this->format_color('code125-color-3');

                    $color_1_hover = $this->format_color('code125-color-1-hover');
                    $color_2_hover = $this->format_color('code125-color-2-hover');
                    $color_3_hover = $this->format_color('code125-color-3-hover');

                    $color_object = new Code125_Colors();

                    $css .= $base . ' { ' . $color_object->gradient_container('left' , $color_1 , $color_2, $color_3 , $GLOBALS['c5_content_width']) . '  }';

                    if ($color_1_hover != '' && $color_2_hover != '' && $color_3_hover != ''  ) {
                        $css .= $hover . ' { ' . $color_object->gradient_container('left' , $color_1_hover , $color_2_hover, $color_3_hover , $GLOBALS['c5_content_width']) . '}';
                    }else{
                        $new_id = str_replace(':before',':hover:before',$base);
                        $css .= $new_id . '{opacity: 1 !important; visibility: visible !important;}';
                    }

                }elseif ($this->values['code125-image-overlay-type'] == 'half') {
                    $orientation = $this->values['code125-image-half-overlay-type'];

                    if ($orientation == 'left') {
                        $image = 'right';
                        $color = 'left';
                    }else{
                        $image = 'left';
                        $color = 'right';
                    }

                    $base = $this->parent .':after';
                    $css .= $this->format_background($base);
                    $css .= $base . '{width:50%; '.$image.': auto !important; opacity: 1 !important; visibility: visible !important;}';

                    if ($this->values['code125-image-color-overlay-type'] == 'solid') {

                        $base = $this->parent .':before';
                        $hover = $this->parent . ':hover:before';
                        $css .= $this->background_solid($base , $hover);
                        $css .= $base . '{width:50%; '.$color.': auto  !important;}';
                    }elseif ($this->values['code125-image-color-overlay-type'] == 'gradient-two') {

                        $base = $this->parent .':before';
                        $hover = $this->parent . ':hover:before';
                        $css .= $this->gradient($base , $hover);
                        $css .= $base . '{width:50%; '.$color.': auto  !important;}';
                    }elseif ($this->values['code125-image-color-overlay-type'] == 'gradient-three') {

                        $base = $this->parent .':before';
                        $hover = $this->parent . ':hover:before';
                        $css .= $this->gradient_3_points($base , $hover);
                        $css .= $base . '{width:50%; '.$color.': auto  !important;}';
                    }
                    $css .= '@media only screen and (max-width: 481px) {'.$base . '{ width:100%; } }';
                }



                return $css;
            }
            public function background_type_video()
            {
                $css = '';
                if ($this->values['code125-video-overlay-type'] == 'full') {

                    if ($this->values['code125-image-color-overlay-type'] == 'solid') {
                        $base = $this->inner .'-video-wrap:before';
                        $hover = $this->inner . '-video-wrap:after';

                        $css .= $this->background_solid($base , $hover);
                    } elseif ( $this->values['code125-image-color-overlay-type'] == 'gradient-two') {
                        $base = $this->inner .'-video-wrap:before';
                        $hover = $this->inner . '-video-wrap:after';

                        $css .= $this->gradient( $base, $hover);

                    } elseif ( $this->values['code125-image-color-overlay-type'] == 'gradient-three') {
                        $base = $this->inner .'-video-wrap:before';
                        $hover = $this->inner . '-video-wrap:after';

                        $css .= $this->gradient_3_points( $base, $hover);

                    }

                }elseif ($this->values['code125-video-overlay-type'] == 'container') {
                    $css .= $this->format_background($this->inner);

                    $this->values['code125-color-1-opacity'] = 1;
                    $this->values['code125-color-3-opacity'] = 1;
                    $this->values['code125-color-1-hover-opacity'] = 1;
                    $this->values['code125-color-3-hover-opacity'] = 1;
                    $this->values['code125-background-gradient-orientation'] = 'horizontal';

                    $base = $this->inner .'-video-wrap:before';
                    $hover = $this->inner . '-video-wrap:after';

                    $color_1 = $this->format_color('code125-color-1');
                    $color_2 = $this->format_color('code125-color-2');
                    $color_3 = $this->format_color('code125-color-3');

                    $color_1_hover = $this->format_color('code125-color-1-hover');
                    $color_2_hover = $this->format_color('code125-color-2-hover');
                    $color_3_hover = $this->format_color('code125-color-3-hover');

                    $color_object = new Code125_Colors();

                    $css .= $base . ' { ' . $color_object->gradient_container('left' , $color_1 , $color_2, $color_3 , $GLOBALS['c5_content_width']) . '  }';

                    if ($color_1_hover != '' && $color_2_hover != '' && $color_3_hover != ''  ) {
                        $css .= $hover . ' { ' . $color_object->gradient_container('left' , $color_1_hover , $color_2_hover, $color_3_hover , $GLOBALS['c5_content_width']) . '}';
                    }else{
                        $new_id = str_replace(':before',':hover:before',$base);
                        $css .= $new_id . '{opacity: 1 !important; visibility: visible !important;}';
                    }

                }



                return $css;
            }
            function format_background($element) {
                $bg = '';

                if($this->values['code125-background-repeat']!=''){
                    $bg .= 'background-repeat:'. $this->values['code125-background-repeat'] .';';
                }
                if($this->values['code125-background-attachment']!=''){
                    $bg .= 'background-attachment:'. $this->values['code125-background-attachment'] .';';
                }

                $bg .=  ($this->values['code125-background-position'] == '') ? 'background-position:center;' : 'background-position:'. $this->values['code125-background-position'] .';';

                $bg .=  ($this->values['code125-background-size'] == '') ? 'background-size:cover;' : 'background-size:'. $this->values['code125-background-size'] .';';

                $css = $element . '{'.$bg.'}';

                $temp_width = $GLOBALS['c5_content_width'];


                $color_object = new Code125_Colors();
                $attachment_id = c5ab_get_attachment_id_from_src($this->values['code125-background-image']);
                if ($attachment_id) {
                    $height = min( round(0.8*$GLOBALS['c5_content_width']) , 400) ;
                    if ($this->values['code125-background-animation'] == 'parallax') {
                        $height = '1000';
                    }
                    $width = $GLOBALS['c5_content_width'];
                    $background_image = false;
                    if ($width >= 1140) {
                        $width = 1280;
                        $background_image = true;
                    }
                    if ($this->values['code125-image-overlay-type'] == 'half') {
                        $width = round($width/2);
                    }
                    $image_size = c5ab_generate_image_size($width , 9999 , false );

                    $image_attributes = c5_wp_get_attachment_image_src( $attachment_id , $image_size);
                    if (is_array($image_attributes)) {
                        $img = array($image_attributes[0], $image_attributes[3]);
                        if ($background_image) {
                            $width = 1600;
                            if ($this->values['code125-image-overlay-type'] == 'half') {
                                $width = round($width/2);
                            }
                            $image_size = c5ab_generate_image_size($width , 9999 , false );
                            $images_1600 = c5_wp_get_attachment_image_src( $attachment_id , $image_size);
                            $img[2] = isset($images_1600[0]) ? $images_1600[0] : '';
                            $img[3] = isset($images_1600[3]) ? $images_1600[3] : '';

                            $width = 1920;
                            if ($this->values['code125-image-overlay-type'] == 'half') {
                                $width = round($width/2);
                            }
                            $image_size = c5ab_generate_image_size($width , 9999 , false );
                            $images_1920 = c5_wp_get_attachment_image_src( $attachment_id , $image_size);
                            $img[4] = isset($images_1920[0]) ? $images_1920[0] : '';
                            $img[5] = isset($images_1920[3]) ? $images_1920[3] : '';
                        }

                        $css .= $color_object->image_background_css( $element ,  $img );

                        if ($this->values['code125-background-animation'] == 'sliding') {
                                $normalized_width = 500*$image_attributes[1]/$image_attributes[2];
                                $seconds = round($normalized_width/15);
                                $css .= $element .'{';
                                $css .= '-webkit-animation-duration: '.$seconds.'s;';
                                $css .= '-moz-animation-duration: '.$seconds.'s;';
                                $css .= '-ms-animation-duration: '.$seconds.'s;';
                                $css .= '-o-animation-duration: '.$seconds.'s;';
                                $css .= 'animation-duration: '.$seconds.'s;';
                                $css .= '}';

                        }
                    }
                }else{
                    $css .= $color_object->image_background_css( $element ,  array($this->values['code125-background-image'], '') );
                }

                $GLOBALS['c5_content_width'] = $temp_width;

                return $css;

            }

            public function spacing($values='')
            {
                $css = '';
                $box_css = '';


                if (isset($values['row_border']) && !empty($values['row_border'])) {
                    if (is_array($values['row_border'])) {
                        $border = $values['row_border'];
                    }else{
                        $border = code125_decode($values['row_border']);

                    }
                    if ($border['width'] != '' ) {
                        $box_css .= 'border: ' . $border['width'] . $border['unit'] . ' ' . $border['style'] . ' ' . $border['color'] . ';';
                    }
                }
                if (isset($values['row_box_shadow']) && !empty($values['row_box_shadow'])) {
                    if (is_array($values['row_box_shadow'])) {
                        $box_shadow = $values['row_box_shadow'];
                    }else{
                        $box_shadow = code125_decode($values['row_box_shadow']);

                    }

                    if (!empty($box_shadow)) {
                        $properties = array(
                            'inset',
                            'offset-x',
                            'offset-y',
                            'blur-radius',
                            'spread-radius',
                            'color',
                        );
                        $bxs_css = '';
                        foreach ($properties as $key) {
                            $bxs_css .= (isset($box_shadow[$key]) && $box_shadow[$key]!='') ? ($box_shadow[$key] . ' ') : '';
                        }
                        if ($bxs_css!= '') {
                            $box_css .= 'box-shadow: ' . $bxs_css .';';
                        }

                    }
                }
                if (isset( $values['row_padding'] )) {
                    if (is_array($values['row_padding'])) {
                        $padding = $values['row_padding'];
                    }else{
                        $padding = code125_decode($values['row_padding']);
                    }
                    if (!$padding) {
                        $padding = array(
                            'desktop-top' => isset($values['row_padding_top']) ? $values['row_padding_top'] : '',
                            'desktop-bottom' => isset($values['row_padding_bottom']) ? $values['row_padding_bottom'] : '',
                        );
                    }
                    $css .= $this->generate_css_spacing($padding , $this->parent, true);


                }
                if (isset( $values['row_margin'] )) {
                    if (is_array($values['row_margin'])) {
                        $margin = $values['row_margin'];
                    }else{
                        $margin = code125_decode($values['row_margin']);
                    }

                    if (!$margin) {
                        $margin = array(
                            'desktop-top' => isset($values['row_margin_top']) ? $values['row_margin_top'] : '',
                            'desktop-bottom' => isset($values['row_margin_bottom']) ? $values['row_margin_bottom'] : '',
                        );
                    }
                    $css .= $this->generate_css_spacing($margin , $this->parent, false);


                }
                if ($box_css != '') {
                    $css .= $this->parent . ' {' . $box_css .  '}';
                }

                if (isset($values['row_border_hover']) && !empty($values['row_border_hover'])) {
                    if (is_array($values['row_border_hover'])) {
                        $border = $values['row_border_hover'];
                    }else{
                        $border = code125_decode($values['row_border_hover']);

                    }
                    if ($border['width'] != '' ) {
                        $css .= $this->parent . ':hover { border: ' . $border['width'] . $border['unit'] . ' ' . $border['style'] . ' ' . $border['color'] . '; }' ;
                    }

                }
                echo '<style>'.$css.'</style>';
            }

            function generate_css_spacing($spacing, $dom_ID ,$padding = false) {
                if (!is_array($spacing)) {
                    return false;
                }
                $return = '';

                if ($padding) {
                    $default = '0 ';
                    $element = 'padding';
                }else {
                    $default = 'auto ';
                    $element = 'margin';
                }
                $empty = true;

                $directions = array(
                    'top',
                    'right',
                    'bottom',
                    'left'
                );
                $css = '';
                foreach ($directions as $direction) {
                    $key = 'desktop-' . $direction;
                    if (isset($spacing[$key])) {
                        $spacing[$key] = str_replace('px','' , $spacing[$key]);
                        if (is_numeric($spacing[$key])) {
                            $css  .= $spacing[$key] . 'px ';
                            $empty = false;
                        }else {
                            $css  .= $default;
                        }
                        if (!$empty) {
                            $return .= $dom_ID .'{ '.$element . ': '.$css.';}';
                        }
                    }
                }

                $css = '';
                $empty = true;
                foreach ($directions as $direction) {
                    $key = 'tablet-' . $direction;
                    if (isset($spacing[$key])) {
                        $spacing[$key] = str_replace('px','' , $spacing[$key]);
                        if (is_numeric($spacing[$key])) {
                            $css  .= $spacing[$key] . 'px ';
                            $empty = false;
                        }else {
                            $css  .= $default;
                        }
                        if (!$empty) {
                            $return .= '@media (max-width: 768px){';
                            $return .= $dom_ID .'{ '.$element . ': '.$css.';}';
                            $return .= '}';
                        }
                    }
                }

                $css = '';
                $empty = true;
                foreach ($directions as $direction) {
                    $key = 'mobile-' . $direction;
                    if (isset($spacing[$key])) {
                        $spacing[$key] = str_replace('px','' , $spacing[$key]);
                        if (is_numeric($spacing[$key])) {
                            $css  .= $spacing[$key] . 'px ';
                            $empty = false;
                        }else {
                            $css  .= $default;
                        }
                        if (!$empty) {
                            $return .= '@media (max-width: 481px){';
                            $return .= $dom_ID .'{ '.$element . ': '.$css.';}';
                            $return .= '}';
                        }
                    }
                }

                return $return;
            }

            public function background_css()
            {

                $color_object = new Code125_Colors();
                $css = '';



                $class = $this->values['code125-background-lum'] ;

                if ($this->values['code125-background-type'] == 'color') {
                    $css .= $this->background_type_color();

                }elseif ($this->values['code125-background-type'] == 'image') {
                    $css .= $this->background_type_image();
                    if ($this->values['code125-background-animation'] != 'none') {
                        $class .= ' code125-background-animation-' . $this->values['code125-background-animation'];

                    }

                }elseif ($this->values['code125-background-type'] == 'video') {
                    $css .= $this->background_type_video();

                }


                echo '<style>'.$css.'</style>';
                return $class;
            }

            public function get_class($key)
            {
                echo str_replace('.','',$this->$key);
            }
            function generate_unique_id() {
                $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $randomString = '';
                for ($i = 0; $i < 6; $i++) {
                    $randomString .= $characters[rand(0, strlen($characters) - 1)];
                }
                return $randomString;
            }
        }


        ?>
