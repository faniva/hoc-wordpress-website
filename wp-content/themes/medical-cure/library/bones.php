<?php
/* Welcome to Bones :)
This is the core Bones file where most of the
main functions & features reside. If you have
any custom functions, it's best to put them
in the functions.php file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

/*********************
LAUNCH BONES
Let's fire off all the functions
and tools. I put it up here so it's
right up top and clean.
*********************/

// we're firing all out initial functions at the start
add_action( 'after_setup_theme', 'c5_ahoy', 16 );

function c5_ahoy() {

	// launching operation cleanup
	add_action( 'init', 'c5_head_cleanup' );
	// remove WP version from RSS
	add_filter( 'the_generator', 'c5_rss_version' );
	// remove pesky injected css for recent comments widget
	add_filter( 'wp_head', 'c5_remove_wp_widget_recent_comments_style', 1 );
	// clean up comment styles in the head
	add_action( 'wp_head', 'c5_remove_recent_comments_style', 1 );
	// clean up gallery output in wp
	add_filter( 'gallery_style', 'c5_gallery_style' );

	// enqueue base scripts and styles

	add_action( 'wp', 'c5_prepare_theme', 1 );
	add_action( 'wp_enqueue_scripts', 'c5_scripts_and_styles', 999 );

	// ie conditional wrapper

	// launching this stuff after theme setup
	c5_theme_support();

	// adding sidebars to Wordpress (these are created in functions.php)
	add_action( 'widgets_init', 'c5_register_sidebars' );


	// cleaning up random code around images
	add_filter( 'the_content', 'c5_filter_ptags_on_images' );
	// cleaning up excerpt
	add_filter( 'excerpt_more', 'c5_excerpt_more' );

} /* end bones ahoy */


function c5_prepare_theme() {

	$info_obj = new C5_theme_layout();

	$skin_id = $info_obj->get_current_skin();

	global $c5_font_obj;
	$c5_font_obj = new C5_font();
	$c5_font_obj->hook();
	$c5_font_obj->set_fonts( 'heading_font', ot_get_option('heading_font')  );
	$c5_font_obj->set_fonts( 'heading_font_rtl', ot_get_option('heading_font_rtl')  );
	$c5_font_obj->set_fonts( 'body_font', ot_get_option('body_font')  );
	$c5_font_obj->set_fonts( 'body_font_rtl', ot_get_option('body_font_rtl')  );

	global $wp_locale;

	if( ot_get_option('rtl') == 'rtl' && !is_admin() ){
		$wp_locale->text_direction = 'rtl';
	}

}


/*********************
WP_HEAD GOODNESS
The default wordpress head is
a mess. Let's clean it up by
removing all the junk we don't
need.
*********************/

function c5_head_cleanup() {



	// remove WP version from css
	add_filter( 'style_loader_src', 'c5_remove_wp_ver_css_js', 9999 );
	// remove Wp version from scripts
	add_filter( 'script_loader_src', 'c5_remove_wp_ver_css_js', 9999 );

	$skip = array(
		'c5ab_social_icons'
	);
	foreach ($skip as $value) {
		$GLOBALS['c5ab_custom_css_' . $value] = TRUE;
	}


} /* end bones head cleanup */

// remove WP version from RSS
function c5_rss_version() { return ''; }

// remove WP version from scripts
function c5_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
	$src = remove_query_arg( 'ver', $src );
	return $src;
}

// remove injected CSS for recent comments widget
function c5_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

// remove injected CSS from recent comments widget
function c5_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
	}
}

// remove injected CSS from gallery
function c5_gallery_style($css) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}


/*********************
SCRIPTS & ENQUEUEING
*********************/



// loading modernizr and jquery, and reply script
function c5_scripts_and_styles() {

	if (!is_admin()) {

		//Enqueue the main stylesheet of the theme
		if (is_rtl()) {
			wp_enqueue_style( 'medical-cure-theme-stylesheet', get_template_directory_uri() . '/library/css/rtl-1.1.4.css' );
		}else{
			wp_enqueue_style( 'medical-cure-theme-stylesheet', get_template_directory_uri() . '/library/css/theme-style-1.1.4.css' );
		}


		// modernizr (without media query polyfill)
		wp_enqueue_script( 'bones-modernizr', get_template_directory_uri() . '/library/js/modernizr.custom.min.js', array(), '2.5.3', false );

		// comment reply script for threaded comments
		if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_enqueue_script( 'medical-cure-theme-script', get_template_directory_uri() . '/library/js/scripts-1.1.4.js', array( 'jquery' ), '', true );



		$facebook_language = ot_get_option('facebook_language');
		if ($facebook_language=='') {
			$facebook_language = 'en_US';
		}

		$js_code = '(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id))
			return;
			js = d.createElement(s);
			js.id = id;
			js.src = "//connect.facebook.net/'. $facebook_language.'/sdk.js#xfbml=1&appId='. esc_attr( ot_get_option('facebook_ID') ) .'&version=v2.0";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, \'script\', \'facebook-jssdk\'));';
		wp_add_inline_script('medical-cure-theme-script' , $js_code);

		wp_localize_script('medical-cure-theme-script', 'ajax_var', array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ajax-nonce')
		));


	}
}

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function c5_theme_support() {

	// wp thumbnails (sizes handled in functions.php)
	add_theme_support( 'post-thumbnails' );

	// default thumb size
	set_post_thumbnail_size(125, 125, true);

	add_theme_support( 'woocommerce' );
	add_theme_support( "title-tag" );
		add_theme_support( 'custom-header');
		add_theme_support( 'custom-background' );
	// rss thingy
	add_theme_support('automatic-feed-links');

	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/

	// adding post format support
	add_theme_support( 'post-formats',
		array(
			//'aside',             // title less blurb
			'gallery',           // gallery of images
			//			'link',              // quick link to other site
			'image',             // an image
			'quote',             // a quick quote
			//'status',            // a Facebook like status update
			'video',             // video
			'audio',             // audio
			//'chat'               // chat transcript
		)
	);

	// wp menus
	add_theme_support( 'menus' );


	$menus = array(
		'main-nav' => 'Main Menu',
		'department' => 'Departements',
	);
	$menus_array = ot_get_option('menus', array());
	if ($menus_array) {
		foreach ($menus_array as $menu_array) {
			$menus[ $menu_array['location'] ] =  $menu_array['title'];
		}
	}

	// registering wp3+ menus
	register_nav_menus($menus);
} /* end bones theme support */



/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function c5_page_navi() {
	global $wp_query;
	$bignum = 999999999;
	if ( $wp_query->max_num_pages <= 1 )
	return;

	echo '<nav class="c5-pagination">';

	echo paginate_links( array(
		'base' 			=> str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
		'format' 		=> '',
		'current' 		=> max( 1, get_query_var('paged') ),
		'total' 		=> $wp_query->max_num_pages,
		'prev_text' 	=> '<span class="fa fa-chevron-left"></span>;',
		'next_text' 	=> '<span class="fa fa-chevron-right"></span>;',
		'type'			=> 'list',
		'end_size'		=> 3,
		'mid_size'		=> 3
		) );

		echo '</nav>';

	} /* end page navi */

	/*********************
	RANDOM CLEANUP ITEMS
	*********************/

	// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
	function c5_filter_ptags_on_images($content){
		return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
	}

	// This removes the annoying […] to a Read More link
	function c5_excerpt_more($more) {
		global $post;
		// edit here if you like
		return '';
	}


	?>
