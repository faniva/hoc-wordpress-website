<?php
	/* Start the Loop */
	while ( have_posts() ) : the_post();
		get_template_part( 'library/includes/article/templates/article-layout-1');
	endwhile; // End of the loop.
?>
