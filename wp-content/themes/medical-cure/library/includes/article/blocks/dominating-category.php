<?php


$post_object = new C5_post();
$category_id = $post_object->get_dominaiting_category();
if ($category_id) {
	$tax = c5_get_post_tax(get_the_ID());
	$term = get_term( $category_id, $tax );

	$unique_term_id = $post_object->get_unique_id();

	$use_custom_color =  get_term_meta($category_id, 'use_custom_colors', true);
	if ($use_custom_color == 'on') {
		$color =  get_term_meta($category_id, 'primary_color', true);
	}else{
		$color = ot_get_option( 'primary_color');
	}
	$color_obj = new Code125_Colors();
	$background_class = $color_obj->get_class($color);
	?>
	<p class="c5-category-align">
	<a href="<?php echo get_term_link( intval($category_id) , $tax ); ?>" class="c5-term-<?php echo $unique_term_id; ?> <?php echo $background_class ?> c5-post-category c5-slide-tag">
		<?php
		$icon = get_term_meta($category_id, 'icon', true);
		if ($icon != '') {
			echo '<span class="c5-category-icon '.$icon.'"></span> ';
		}
		echo $term->name;
		?>
	</a>
</p>
	<?php if ($use_custom_color == 'on') { ?>
		<style>
			a.c5-post-category.c5-term-<?php echo $unique_term_id; ?>{
				background: <?php echo $color ?> !important;
			}
			a.c5-post-category.c5-term-<?php echo $unique_term_id; ?>:hover{
				background: <?php echo $color_obj->hexDarker($color , 10); ?> !important;
			}
		</style>
	<?php } ?>

<?php }  ?>
