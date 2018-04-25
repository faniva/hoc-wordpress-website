<?php
$settings_obj = new C5_theme_options();
$article_enable_featured_media = $settings_obj->get_meta_option('article_enable_featured_media');
if ($article_enable_featured_media == 'off') {
    return;
}
$posts_object = new C5_Article();
echo $posts_object->get_featured_media();
?>
