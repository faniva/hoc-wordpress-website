<?php

global $c5_skindata;
if (have_posts()) : while (have_posts()) : the_post();
$tag = 'main';
if ($c5_skindata['page_width'] != 'full') {
	$tag = 'article';
}

$data = get_post_meta( get_the_ID(), 'c5ab_data', true );
$class ='';
if ($data == '' || $data == 'YTowOnt9') {
	$class = ' code125-article-layout-common code125-article-layout-1 ';
}
?>
<<?php echo $tag; ?> id="post-<?php the_ID(); ?>" <?php post_class($class . ' clearfix'); ?>>
	<?php
	$login_required = get_post_meta(get_the_ID(), 'login_required', true);
	$login_required_bool = true;
	if($login_required == 'on'){
		$login_required_bool = false;
		if(is_user_logged_in()){
			$login_required_bool = true;
		}
	}

	if($login_required_bool ){ ?>
		<section class="entry-content clearfix">
			<?php
			if ($c5_skindata['page_width'] == 'full') {
				echo '<div class="container">';
			}
			c5_check_mobile_width();
			the_content();
			if ($c5_skindata['page_width'] == 'full') {
				echo '</div>';
			}
			?>
		</section>
		<?php
		c5_page_navi();


	}else {
		echo '<div class="'.c5_get_width_class().'"><div class="c5-login-required">' . do_shortcode('[c5ab_account username_text="'.__('Username', 'medical-cure') .'" password_text="******" login_text="'.__('Login in', 'medical-cure') .'" register_text="'.__('Register', 'medical-cure') .'" forget_text="'.__('Forget Password ?', 'medical-cure') .'" remember_text="'.__('Remember me ?', 'medical-cure') .'" checkbox="on" forget="on" register="on" ]') . '</div></div>';
	}
	?>
</<?php echo $tag; ?>>

<?php
if (comments_open() ) {
	?>
	<div class="code125-article-layout-common code125-article-layout-1 clearfix'" >
	    <footer class="entry-footer">
	        <?php get_template_part( C5_ARTICLES_TEMPLATE  . 'blocks/comments' ); ?>
	    </footer>
	</div>
	<?php
}
?>

<?php endwhile; ?>
<?php endif; ?>
