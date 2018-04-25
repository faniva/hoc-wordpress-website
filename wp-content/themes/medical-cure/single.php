<?php get_header();

$layout_obj = new C5_theme_layout();

$layout_obj->build_layout('single');

$article_object = new C5_Article();
$article_object->related_posts();


get_footer(); ?>
