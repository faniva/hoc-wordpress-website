<?php

add_action('wp_ajax_c5cbg_preview_update', 'c5cbg_preview_update');
function c5cbg_preview_update()
{
    if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
        die();
    }

    parse_str($_POST['options'], $options);

    $new_options = $options[$_POST['option_id']];
    $preview_object = new Code125_Background_Implementation();
    $preview_object->preview($new_options);

    die();
}


add_action('wp_ajax_c5cbg_import_settings', 'c5cbg_import_settings');
function c5cbg_import_settings()
{
    if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
        die();
    }

    $import_data = code125_decode($_POST['import_data']);
    echo json_encode( $import_data );

    die();
}


add_action('wp_ajax_c5cbg_update_main_option', 'c5cbg_update_main_option');
function c5cbg_update_main_option()
{
    if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
        die();
    }

    parse_str($_POST['options'], $options);
    echo code125_encode($options);

    die();
}




?>
