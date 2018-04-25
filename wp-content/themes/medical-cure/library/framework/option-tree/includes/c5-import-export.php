<?php


 add_action( 'init', 'c5_register_export_settings_page' ,400);

if ( ! function_exists( 'c5_register_export_settings_page' ) ) {


  function c5_register_export_settings_page() {

    // Create the filterable pages array
    $ot_register_pages_array =  array(
      array(
        'id'              => 'export_settings',
        'parent_slug'     => apply_filters( 'ot_theme_options_parent_slug', 'themes.php'),
        'page_title'      => __('Theme Options Import/ Export', 'medical-cure'),
        'menu_title'      => __('Import / Export', 'medical-cure'),
        'capability'      => 'edit_theme_options',
        'menu_slug'       => apply_filters( 'ot_theme_options_export_slug', 'ot-export-settings'),
        'icon_url'        => null,
        'position'        => null,
        'updated_message' => __('Theme Options updated.', 'medical-cure'),
        'reset_message'   => __('Theme Options reset.', 'medical-cure'),
        'button_text'     => __('Save Settings', 'medical-cure'),
        'show_buttons'    => false,
        'screen_icon'     => 'themes',
        'sections'        => array(
          array(
            'id'          => 'import',
            'title'       => __('Import', 'medical-cure')
          ),
          array(
            'id'          => 'export',
            'title'       => __('Export', 'medical-cure')
          )
        ),
        'settings'        => array(
          array(
            'id'          => 'import_data_text',
            'label'       => __('Theme Options', 'medical-cure'),
            'type'        => 'import-data',
            'section'     => 'import'
          ),
          array(
            'id'          => 'export_data_text',
            'label'       => __('Theme Options', 'medical-cure'),
            'type'        => 'export-data',
            'section'     => 'export'
          )
        )
      )

    );

    $ot_register_pages_array = apply_filters( 'ot_register_pages_array', $ot_register_pages_array );


    ot_register_settings( array(
        array(
          'id'              => 'option_tree_settings',
          'pages'           => $ot_register_pages_array
        )
      )
    );


  }

}



 ?>
