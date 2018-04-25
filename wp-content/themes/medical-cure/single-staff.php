<?php get_header();

$layout_obj = new C5_theme_layout();

global $c5_skindata;
$c5_skindata['page_width'] = 'full';

$layout_obj->build_layout('single-staff');


get_footer(); ?>
