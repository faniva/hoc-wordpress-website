<?php
global $c5_skindata;

$tag = 'main';
if ($c5_skindata['page_width'] != 'full') {
	$tag = 'article';
}
?>
<<?php echo $tag; ?> class="c5-woocommerce-single clearfix">
	<?php
	if ($c5_skindata['page_width'] == 'full') {
		echo '<div class="container">';
	}
	c5_check_mobile_width();
	woocommerce_content();
	if ($c5_skindata['page_width'] == 'full') {
		echo '</div>';
	}
	 ?>

</<?php echo $tag;  ?>>
