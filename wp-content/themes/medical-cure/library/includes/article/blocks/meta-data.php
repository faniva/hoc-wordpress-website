<?php
$post_object = new C5_post();
$settings_obj = new C5_theme_options();
$meta_data = $settings_obj->get_meta_option('article_meta_data');

$meta_data = 'time_on';
$atts  = array(
    'meta_data' => $meta_data,
    'author_format' => 'text',
    'c5_date_format' => $settings_obj->get_meta_option('article_date_format')
 );
echo $post_object->get_metadata($atts);
?>
