<?php
/**
* Initialize the custom Meta Boxes.
*/
add_action( 'admin_init', 'c5_staff_meta_box' );

/**
* Meta Boxes demo code.
*
* You can find all the available option types in demo-theme-options.php.
*
* @return    void
* @since     2.0
*/
function c5_staff_meta_box() {

    /**
    * Create a custom meta boxes array that we pass to
    * the OptionTree Meta Box API Class.
    */
    $staff_meta_box = array(
        'id'          => 'staff_meta_box',
        'title'       => __( 'Staff meta data', 'code125' ),
        'desc'        => '',
        'pages'       => array( 'staff' ),
        'context'     => 'normal',
        'priority'    => 'high',
        'fields'      => array(
            array(
                'label'       => __( 'Staff Short Description', 'code125' ),
                'id'          => 'subtitle',
                'type'        => 'text',
                'desc'        => __( 'This short description will be used beneath his name and in some staff designs.', 'code125' ),
                'std'         => ''
            ),
            array(
                'label' => 'Departement Label',
                'id' => 'departement',
                'type' => 'text',
                'desc' => 'Departement Label',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
            ),
            array(
                'label' => 'Departement Link',
                'id' => 'departement_link',
                'type' => 'text',
                'desc' => 'Departement Link',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => '',
            ),
            array(
                'label' => 'Personal Infomration',
                'id' => 'other_staff_info',
                'type' => 'list-item',
                'desc' => 'Add Staff Personal Infomration, for example: Department, Birth date, University etc.',
                'settings' => array(
                    array(
                        'label' => 'Value',
                        'id' => 'value',
                        'type' => 'text',
                        'desc' => 'Value for the title',
                        'std' => '',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => '',
                    ),
                    array(
                        'label' => 'Icon',
                        'id' => 'icon',
                        'type' => 'icon-list',
                        'desc' => '',
                        'std' => 'fa fa-angle-right',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => ''
                    ),
                    array(
                        'label' => 'Link',
                        'id' => 'link',
                        'type' => 'text',
                        'desc' => 'Info Url. (Optional)',
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
            array(
                'label' => 'Contact Infomration',
                'id' => 'contact_info',
                'type' => 'list-item',
                'desc' => 'Add Staff Contact Infomration, for example: Email, Phone, Addresse etc.',
                'settings' => array(
                    array(
                        'label' => 'Icon',
                        'id' => 'icon',
                        'type' => 'icon-list',
                        'desc' => '',
                        'std' => 'fa fa-facebook',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => 'c5ab_icons'
                    ),
                    array(
                        'label' => 'Link',
                        'id' => 'link',
                        'type' => 'text',
                        'desc' => 'Icon Url',
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
            array(
                'label' => 'Schedule',
                'id' => 'time_table',
                'type' => 'list-item',
                'desc' => 'Add Staff Personal Schedule, for example: Mon-Fri: 15:00-18:00',
                'settings' => array(
                    array(
                        'label' => 'Value',
                        'id' => 'value',
                        'type' => 'text',
                        'desc' => 'Value for the title',
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

            array(
                'label' => 'Social Profile',
                'id' => 'social_profile',
                'type' => 'list-item',
                'desc' => 'Add Social Icons for the staff info.',
                'settings' => array(
                    array(
                        'label' => 'Icon',
                        'id' => 'icon',
                        'type' => 'icon-list',
                        'desc' => '',
                        'std' => 'fa fa-facebook',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => 'c5ab_icons'
                    ),
                    array(
                        'label' => 'Link',
                        'id' => 'link',
                        'type' => 'text',
                        'desc' => 'Icon Url',
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
        )
    );

    /**
    * Register our meta boxes using the
    * ot_register_meta_box() function.
    */
    if ( function_exists( 'ot_register_meta_box' ) ){
        ot_register_meta_box( $staff_meta_box );
    }
}
