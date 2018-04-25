<?php
$data = '';
$width = $GLOBALS['c5_content_width'];

$height = 780;
$meta_attachment = get_post_meta(get_the_ID(), 'meta_attachment', true);

$image_size = c5ab_generate_image_size($width, $height, true);
$object = new C5_post();
ob_start();
$object->render_article_featured_image($image_size);
$data .= ob_get_clean();

echo $data;
?>
