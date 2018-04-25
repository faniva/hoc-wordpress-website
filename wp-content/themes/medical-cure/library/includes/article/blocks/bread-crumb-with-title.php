<?php
$settings_obj = new C5_theme_options();
$article_enable_breadcrumb = $settings_obj->get_meta_option('article_enable_breadcrumb');
if ($article_enable_breadcrumb != 'off') {
    $object = new C5_bread_crumb();
    $object->render();
}
?>
