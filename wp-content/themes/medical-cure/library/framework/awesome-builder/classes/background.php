<?php

/**
*
*/
class Code125_Background_Editor {

    public function settings() {
        $options = array(

            array(
                'label' => esc_html__('Spacing & Border', 'medical-cure'),
                'id' => 'code125-box-layout',
                'type' => 'tab',
                'icon' => 'fa fa-tasks',
                'class' => ''
            ),
            array(
                'label' => 'Border',
                'id' => 'row_border',
                'type' => 'border',
                'desc' => 'Add Border to the element.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Border (Hover)',
                'id' => 'row_border_hover',
                'type' => 'border',
                'desc' => 'Add Border (Hover) to the element.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Box Shadow',
                'id' => 'row_box_shadow',
                'type' => 'box-shadow',
                'desc' => 'Add Box Shadow to the element.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),

            array(
                'label' => 'Content Padding',
                'id' => 'row_padding',
                'type' => 'spacing-type',
                'desc' => 'Adjust Row Padding to fit your design.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Content Margin',
                'id' => 'row_margin',
                'type' => 'spacing-type',
                'desc' => 'Adjust Row Margin to fit your design.',
                'std' =>'',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => esc_html__('Background', 'medical-cure'),
                'id' => 'code125-background-editor',
                'type' => 'tab',
                'icon' => 'fa fa-paint-brush',
                'class' => 'code125-background-editor'
            ),
            array(
                'label' => 'Background',
                'id' => 'custom_background',
                'type' => 'custom-background',
                'desc' => '',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => esc_html__('Miscellaneous', 'medical-cure'),
                'id' => 'row_misc_tab',
                'type' => 'tab',
                'icon' => 'fa fa-code'
            ),
            array(
                'label' => esc_html__('Custom Class', 'medical-cure'),
                'id' => 'custom_class',
                'type' => 'text',
                'desc' => esc_html__('Add Custom Class .', 'medical-cure') ,
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
            ),
            array(
                'label' => esc_html__('Custom CSS', 'medical-cure'),
                'id' => 'custom_css',
                'type' => 'textarea-simple',
                'desc' => esc_html__('Add Custom CSS .', 'medical-cure') ,
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
            )
        );

        return $options;
    }


}

?>
