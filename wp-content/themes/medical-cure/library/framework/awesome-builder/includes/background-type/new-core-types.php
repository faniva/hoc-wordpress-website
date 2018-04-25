<?php


if ( ! function_exists( 'ot_type_extended_title' ) ) {

    function ot_type_extended_title( $args = array() ) {

        /* turns arguments array into variables */
        extract( $args );

        /* verify a description */
        $has_desc = $field_desc ? true : false;

        /* format setting outer wrapper */
        echo '<div class="format-setting type-extended-title ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';

        /* description */
        echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';

        /* format setting inner wrapper */
        echo '<div class="format-setting-inner code125-extended-title-setting-wrap clearfix">';

        echo '<div class="c5-row">';

        //icon
        $icon = isset( $field_value['icon'] ) ? esc_attr( $field_value['icon'] ) : '';

        echo '<div class="col-sm-1 code125-subelement-group">';
        echo '<input type="hidden" name="' . esc_attr( $field_name ) . '[icon]" id="' . esc_attr( $field_id ) . '-icon" value="'.$icon.'" class="c5-icon-list-value" />';
        $icon_text = esc_html__('icon', 'medical-cure');
        if ($icon !='') {
            $icon_text = $icon;
        }
        echo '<p class="c5-icon-select" title="choose icon"><span class="'.$icon.'">'.$icon_text.'</span></p>';
        echo '<div class="c5-icons-wrap"></div>';

        echo '</div>';

        //title
        $title = isset( $field_value['title'] ) ? esc_attr( $field_value['title'] ) : '';
        echo '<div class="col-sm-11 code125-subelement-group"><input type="text" name="' . esc_attr( $field_name ) . '[title]" id="' . esc_attr( $field_id ) . '-title" value="' . $title . '" class="code125-ui-input-title code125-ui-input ' . esc_attr( $field_class ) . '" placeholder="" /></div>';

        //color
        echo '<div class="col-sm-4 code125-subelement-group">';
        echo '<div class="option-tree-ui-colorpicker-input-wrap">';
        echo '<span class="title">Color:</span>';
          $color = isset( $field_value['color'] ) ? esc_attr( $field_value['color'] ) : '';
          /* colorpicker JS */
          echo '<script>jQuery(document).ready(function($) { OT_UI.bind_colorpicker("' . esc_attr( $field_id ) . '-color"); });</script>';
          echo '<input type="text" name="' . esc_attr( $field_name ) . '[color]" id="' . $field_id . '-color" value="' . $color . '" class="hide-color-picker ' . esc_attr( $field_class ) . '" />';

        echo '</div>';
        echo '<div class="option-tree-ui-colorpicker-input-wrap">';
            echo '<span class="title">hover:</span>';
          $colorhover = isset( $field_value['colorhover'] ) ? esc_attr( $field_value['colorhover'] ) : '';
          /* colorpicker JS */
          echo '<script>jQuery(document).ready(function($) { OT_UI.bind_colorpicker("' . esc_attr( $field_id ) . '-colorhover"); });</script>';
          echo '<input type="text" name="' . esc_attr( $field_name ) . '[colorhover]" id="' . $field_id . '-colorhover" value="' . $colorhover . '" class="hide-color-picker ' . esc_attr( $field_class ) . '" />';

        echo '</div>';

        echo '</select>';
        echo '</div>';

        //font-size
        $font_size = isset( $field_value['fontsize'] ) ? esc_attr( $field_value['fontsize'] ) : '';

        echo '<div class="col-sm-2 code125-subelement-group">';
        echo '<select name="' . esc_attr( $field_name ) . '[fontsize]" id="' . esc_attr( $field_id ) . '-fontsize" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';

          echo '<option value="">' . __('font-size', 'medical-cure') . '</option>';
          $options  = array(
              'xsmall' => 'XSmall (14px)',
              'small' => 'Small (18px)',
              'medium' => 'Medium  (24px)',
              'large' => 'Large  (30px)',
              'xlarge' => 'XLarge  (36px)',
              'xxlarge' => 'XXLarge  (48px)',
              'xxxlarge' => 'XXXLarge  (64px)',
              'xxxxlarge' => 'XXXXLarge  (72px)',
          );
          foreach ( $options as $key => $value ) {

            echo '<option value="' . esc_attr( $key ) . '" ' . selected( $font_size, $key, false ) . '>' . esc_attr( $value ) . '</option>';

          }

        echo '</select>';
        echo '</div>';

        //font-weight
        $fontweight = isset( $field_value['fontweight'] ) ? esc_attr( $field_value['fontweight'] ) : '';

        echo '<div class="col-sm-3 code125-subelement-group">';
        echo '<select name="' . esc_attr( $field_name ) . '[fontweight]" id="' . esc_attr( $field_id ) . '-fontweight" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';

          echo '<option value="">' . __('font-weight', 'medical-cure') . '</option>';
          $options  = array(
              'lighter' => 'Lighter',
              'normal' => 'Regular',
              'bold' => 'Bold',
              'bolder' => 'Bolder',
              '100' => '100',
              '200' => '200',
              '300' => '300',
              '400' => '400',
              '500' => '500',
              '600' => '600',
              '700' => '700',
              '800' => '800',
              '900' => '900',
          );
          foreach ( $options as $key => $value ) {

            echo '<option value="' . esc_attr( $key ) . '" ' . selected( $fontweight, $key, false ) . '>' . esc_attr( $value ) . '</option>';

          }

        echo '</select>';


        echo '</div>';


        //letter-spacing
        $letterspacing = isset( $field_value['letterspacing'] ) ? esc_attr( $field_value['letterspacing'] ) : '';

        echo '<div class="col-sm-3 code125-subelement-group">';
        echo '<select name="' . esc_attr( $field_name ) . '[letterspacing]" id="' . esc_attr( $field_id ) . '-letterspacing" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';

          echo '<option value="">' . __('letter-spacing', 'medical-cure') . '</option>';
          $options  = array(
              '-3px' => '-3px',
              '-2px' => '-2px',
              '-1px' => '-1px',
              '0' => '0',
              '1px' => '1px',
              '2px' => '2px',
              '3px' => '3px',
          );
          foreach ( $options as $key => $value ) {

            echo '<option value="' . esc_attr( $key ) . '" ' . selected( $letterspacing, $key, false ) . '>' . esc_attr( $value ) . '</option>';

          }

        echo '</select>';
        echo '</div>';

        $texttransform = isset( $field_value['texttransform'] ) ? esc_attr( $field_value['texttransform'] ) : '';

        echo '<div class="col-sm-3 code125-subelement-group">';
        echo '<select name="' . esc_attr( $field_name ) . '[texttransform]" id="' . esc_attr( $field_id ) . '-texttransform" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';

          echo '<option value="">' . __('text-transform', 'medical-cure') . '</option>';
          $options  = array(
              'none' => 'None',
              'capitalize' => 'Capitalize',
              'uppercase' => 'Uppercase',
              'lowercase' => 'Lowercase',
          );
          foreach ( $options as $key => $value ) {

            echo '<option value="' . esc_attr( $key ) . '" ' . selected( $texttransform, $key, false ) . '>' . esc_attr( $value ) . '</option>';

          }

        echo '</select>';
        echo '</div>';


        $lineheight = isset( $field_value['lineheight'] ) ? esc_attr( $field_value['lineheight'] ) : '';

        echo '<div class="col-sm-3 code125-subelement-group">';
        echo '<input type="text" name="' . esc_attr( $field_name ) . '[lineheight]" id="' . esc_attr( $field_id ) . '-lineheight value="' . $lineheight . '" class="code125-ui-input" placeholder="line-height" />';

        echo '</div>';







        echo '</div>';


        echo '</div>';

        echo '</div>';

    }

}

if ( ! function_exists( 'ot_type_button' ) ) {

    function ot_type_button( $args = array() ) {

        /* turns arguments array into variables */
        extract( $args );

        /* verify a description */
        $has_desc = $field_desc ? true : false;

        /* format setting outer wrapper */
        echo '<div class="format-setting type-button ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';

        /* description */
        echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';

        /* format setting inner wrapper */
        echo '<div class="format-setting-inner code125-extended-title-setting-wrap clearfix">';

        echo '<div class="c5-row">';

        //icon
        $icon = isset( $field_value['icon'] ) ? esc_attr( $field_value['icon'] ) : '';

        echo '<div class="col-sm-1 code125-subelement-group">';
        echo '<input type="hidden" name="' . esc_attr( $field_name ) . '[icon]" id="' . esc_attr( $field_id ) . '-icon" value="'.$icon.'" class="c5-icon-list-value" />';
        $icon_text = esc_html__('icon', 'medical-cure');
        if ($icon !='') {
            $icon_text = $icon;
        }
        echo '<p class="c5-icon-select" title="choose icon"><span class="'.$icon.'">'.$icon_text.'</span></p>';
        echo '<div class="c5-icons-wrap"></div>';

        echo '</div>';

        //title
        $title = isset( $field_value['text'] ) ? esc_attr( $field_value['text'] ) : '';
        echo '<div class="col-sm-5 code125-subelement-group"><input type="text" name="' . esc_attr( $field_name ) . '[text]" id="' . esc_attr( $field_id ) . '-text" value="' . $title . '" class="code125-ui-input-title code125-ui-input ' . esc_attr( $field_class ) . '" placeholder="button-text" /></div>';

        //link
        $link = isset( $field_value['link'] ) ? esc_attr( $field_value['link'] ) : '';
        echo '<div class="col-sm-6 code125-subelement-group"><input type="text" name="' . esc_attr( $field_name ) . '[link]" id="' . esc_attr( $field_id ) . '-link" value="' . $link . '" class="code125-ui-input-title code125-ui-input ' . esc_attr( $field_class ) . '" placeholder="button-link" /></div>';

        //color
        echo '<div class="col-sm-4 code125-subelement-group">';
        echo '<div class="option-tree-ui-colorpicker-input-wrap">';
        echo '<span class="title">Button Color:</span>';
          $color = isset( $field_value['color'] ) ? esc_attr( $field_value['color'] ) : '';
          /* colorpicker JS */
          echo '<script>jQuery(document).ready(function($) { OT_UI.bind_colorpicker("' . esc_attr( $field_id ) . '-color"); });</script>';
          echo '<input type="text" name="' . esc_attr( $field_name ) . '[color]" id="' . $field_id . '-color" value="' . $color . '" class="hide-color-picker ' . esc_attr( $field_class ) . '" />';

        echo '</div>';
        echo '</div>';



        //link-target
        $target = isset( $field_value['target'] ) ? esc_attr( $field_value['target'] ) : '';

        echo '<div class="col-sm-4 code125-subelement-group">';
        echo '<select name="' . esc_attr( $field_name ) . '[target]" id="' . esc_attr( $field_id ) . '-target" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';

          echo '<option value="">' . __('link-target', 'medical-cure') . '</option>';
          $options  = array(
              '_blank' => 'Opens the linked document in a new window or tab',
              '_self' => 'Opens the linked document in the same frame as it was clicked (this is default)',
              '_parent' => 'Opens the linked document in the parent frame',
              '_top' => 'Opens the linked document in the full body of the window',
          );
          foreach ( $options as $key => $value ) {

            echo '<option value="' . esc_attr( $key ) . '" ' . selected( $target, $key, false ) . '>' . esc_attr( $value ) . '</option>';

          }

        echo '</select>';
        echo '</div>';



        echo '</div>';


        echo '</div>';

        echo '</div>';

    }

}

if ( ! function_exists( 'ot_type_spacing_type' ) ) {

    function ot_type_spacing_type( $args = array() ) {

        /* turns arguments array into variables */
        extract( $args );

        /* verify a description */
        $has_desc = $field_desc ? true : false;

        /* format setting outer wrapper */
        echo '<div class="format-setting type-button ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';

        /* description */
        echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';

        /* format setting inner wrapper */
        echo '<div class="format-setting-inner code125-spacing-extended-setting-wrap clearfix">';

        echo '<div class="c5-row">';

        echo '<div class="col-sm-2">';

        echo '<div class="code125-spacing-head clearfix"></div>';
        echo '<div class="code125-spacing-item clearfix"><p>top <i class="fa fa-arrow-up"></i></p></div>';
        echo '<div class="code125-spacing-item clearfix"><p>right <i class="fa fa-arrow-right"></i></p></div>';
        echo '<div class="code125-spacing-item clearfix"><p>bottom <i class="fa fa-arrow-down"></i></p></div>';
        echo '<div class="code125-spacing-item clearfix"><p>left <i class="fa fa-arrow-left"></i></p></div>';

        echo '</div>';
        $options = array(
            'top',
            'right',
            'bottom',
            'left'
        );

        echo '<div class="col-sm-3">';

        echo '<div class="code125-spacing-head clearfix"><i class="fa fa-desktop"></i></div>';
        foreach ($options as $direction) {
            $value = isset( $field_value['desktop-'.$direction] ) ? esc_attr( $field_value['desktop-'.$direction] ) : '';
            echo '<div class="code125-spacing-item clearfix"><input type="text" name="' . esc_attr( $field_name ) . '[desktop-'.$direction.']" id="' . esc_attr( $field_id ) . '-desktop-'.$direction.'" value="' . $value . '" class="code125-ui-input-title code125-ui-input ' . esc_attr( $field_class ) . '" placeholder="" /></div>';
        }
        echo '</div>';

        echo '<div class="col-sm-3">';

        echo '<div class="code125-spacing-head clearfix"><i class="fa fa-tablet"></i></div>';
        foreach ($options as $direction) {
            $value = isset( $field_value['tablet-'.$direction] ) ? esc_attr( $field_value['tablet-'.$direction] ) : '';
            echo '<div class="code125-spacing-item clearfix"><input type="text" name="' . esc_attr( $field_name ) . '[tablet-'.$direction.']" id="' . esc_attr( $field_id ) . '-tablet-'.$direction.'" value="' . $value . '" class="code125-ui-input-title code125-ui-input ' . esc_attr( $field_class ) . '" placeholder="inherit" /></div>';
        }
        echo '</div>';

        echo '<div class="col-sm-3">';

        echo '<div class="code125-spacing-head clearfix"><i class="fa fa-mobile"></i></div>';
        foreach ($options as $direction) {
            $value = isset( $field_value['mobile-'.$direction] ) ? esc_attr( $field_value['mobile-'.$direction] ) : '';
            echo '<div class="code125-spacing-item clearfix"><input type="text" name="' . esc_attr( $field_name ) . '[mobile-'.$direction.']" id="' . esc_attr( $field_id ) . '-mobile-'.$direction.'" value="' . $value . '" class="code125-ui-input-title code125-ui-input ' . esc_attr( $field_class ) . '" placeholder="inherit" /></div>';
        }
        echo '</div>';

        echo '<div class="col-sm-1">';

        echo '<div class="code125-spacing-head clearfix"></div>';
        echo '<div class="code125-spacing-item px clearfix"><p>px</p></div>';
        echo '<div class="code125-spacing-item px clearfix"><p>px</p></div>';
        echo '<div class="code125-spacing-item px clearfix"><p>px</p></div>';
        echo '<div class="code125-spacing-item px clearfix"><p>px</p></div>';

        echo '</div>';

        echo '</div>';


        echo '</div>';

        echo '</div>';

    }

}


?>
