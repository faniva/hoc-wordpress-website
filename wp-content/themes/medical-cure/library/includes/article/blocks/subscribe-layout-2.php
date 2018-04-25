<?php
//validate and get options
$settings_obj = new C5_theme_options();
$enable_article_subscribe = $settings_obj->get_meta_option('enable_article_subscribe');
//check on/off
if ($enable_article_subscribe != 'off') {
  $article_subscribe_title = $settings_obj->get_meta_option('article_subscribe_title');
  $article_subscribe_desc  = $settings_obj->get_meta_option('article_subscribe_desc');
  $article_subscribe_form  = $settings_obj->get_meta_option('article_subscribe_form');

  $args = array(
    'title' => $article_subscribe_title,
    'description' => $article_subscribe_desc,
    'form_id' => $article_subscribe_form,
    'layout' => '2',
  );

  $obj = new C5_SUBSCRIBE_BASE();
  $obj->render($args);
}

?>
