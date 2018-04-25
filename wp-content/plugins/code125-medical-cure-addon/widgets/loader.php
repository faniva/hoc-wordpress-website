<?php


if(!class_exists('C5BP_EXTRA')){
	class C5BP_EXTRA {
		public function __construct() {
			/* load Plugin */
			$this->load();
		}


		function load() {
			/* setup the constants */
			$this->constants();
			/* hook into WordPress */
			$this->hooks();
			/* include the required admin files */
			$this->admin_includes();
		}


		private function constants() {
			define('C5BP_EXTRA_URI', C5_MC_URL . 'widgets/');
			define('C5BP_EXTRA_ROOT',C5_MC_ROOT . 'widgets/' );
		}

		function add_widgets($widgets){
			/* global include files */
			$files = array(
				'account'=> 'C5AB_account',
				'ads'=> 'C5AB_ads',
				'showcase'=> 'C5AB_showcase',
				'animated_text'=> 'C5AB_animated_texts',
				'appointment'=> 'C5AB_appointment',
				'audio'=> 'C5AB_audio',
				'authors_info'=> 'C5AB_authors_info',
				'authors_list'=> 'C5AB_authors_list',
				'box'=> 'C5AB_box',
				'button'=> 'C5AB_button',
				'call_an_action'=> 'C5AB_call_an_action',
				'center'=> 'C5AB_center',
				'comments'=> 'C5AB_comment',
				'contact-info'=> 'C5AB_contact_infos',
				'contact_form'=> 'C5AB_contact_form',
				'current-widgets'=> 'C5AB_current_widgets',
				'divider'=> 'C5AB_divider',
				'dribbble'=> 'C5AB_dribbble',
				'facebook_like_box'=> 'C5AB_facebook_like_box',
				'facebook_post'=> 'C5AB_facebook_post',
				'featured_post'=> 'C5AB_featured_post',
				'flickr'=> 'C5AB_flickr',
				'gallery'=> 'C5AB_gallery',
				'google_maps'=> 'C5AB_google_maps',
				'google_plus_box'=> 'C5AB_google_plus_box',
				'html_element'=> 'C5AB_html_element',
				'icon'=> 'C5AB_icon',
				'image-comparison'=> 'C5AB_image_comparison',
				'image'=> 'C5AB_image',
				'instagram'=> 'C5AB_instagram',
				'login'=> 'C5AB_login',
				'menu'=> 'C5AB_menu',
				'newsletter'=> 'C5AB_newsletter',
				'numbers'=> 'C5AB_number',
				'our-clients'=> 'C5AB_clients',
				'percentage'=> 'C5AB_percentage',
				'posts'=> 'C5AB_posts',
				'pricing_item'=> 'C5AB_pricing_item',
				'pricing_list'=> 'C5AB_pricing_list',
				'pricing_plan'=> 'C5AB_pricing_plan',
				'pricing_table'=> 'C5AB_pricing_table',
				'rating'=> 'C5AB_review',
				'register'=> 'C5AB_register',
				'search'=> 'C5AB_search',
				'service_column'=> 'C5AB_service_column',
				'services_carousel'=> 'C5AB_services_carousel',
				'services_slider'=> 'C5AB_services_slider',
				'sitemap'=> 'C5AB_sitemap',
				'slider'=> 'C5AB_slider',
				'social_count'=> 'C5AB_social_count',
				'social_icons'=> 'C5AB_social_icons',
				'space'=> 'C5AB_space',
				'tabs'=> 'C5AB_tabs',
				'team_member'=> 'C5AB_team_member',
				'testimonials'=> 'C5AB_testimonials',
				'testimonials_carousel'=> 'C5AB_testimonials_carousel',
				'testimonials_slider'=> 'C5AB_testimonials_slider',
				'text'=> 'C5AB_text',
				'timeline'=> 'C5AB_timeline',
				'title'=> 'C5AB_title',
				'toggle'=> 'C5AB_toggle',
				'tweet'=> 'C5AB_tweet',
				'twitter'=> 'C5AB_twitter',
				'twitter_slider'=> 'C5AB_twitter_slider',
				'ul'=> 'C5AB_ul',
				'video-button'=> 'C5AB_video_button',
				'video-popup'=> 'C5AB_video_popup',
				'video'=> 'C5AB_video',
				'working-hours'=> 'C5AB_wokring_hours',
				'youtube_box'=> 'C5AB_youtube_box',
				'../footer/footer_desc' => 'C5AB_footer_desc',
				'../footer/footer_contact_form' => 'C5AB_footer_contact_form',
				'../footer/footer_newsletter' => 'C5AB_footer_newsletter',


				'../banners/widget-banner-slider' => 'C5AB_banner_slider',
				'../banners/widget-banner-content' => 'C5_banner_content_Widget',
				'../banners/banners-carousel' => 'C5AB_banners_carousel',
			);

			/* require the files */
			foreach ( $files as $file => $widget_class ) {
				$widgets[] = array(
					'path' => C5BP_EXTRA_ROOT .'widgets/'. $file .'.php',
					'class' => $widget_class
				);
			}
			return $widgets;
		}



		private function admin_includes() {

			$this->load_file( C5BP_EXTRA_ROOT . 'C5_Widget.php');

			$extenral_list = array( );
			$extenral_list = apply_filters('c5ab_external_widgets', $extenral_list);
			foreach ($extenral_list as $widget) {
				$this->load_file($widget['path']);
			}
		}

		private function load_file( $file ){

			include_once( $file );

		}

		function hooks() {
			add_action('widgets_init' , array($this, 'register_widgets'));
			add_filter('c5ab_external_widgets', array($this, 'add_widgets') );

			global $c5ab_custom_js;
			$c5ab_custom_js = '';

			add_action('wp_footer', array($this, 'custom_js'), 300);
		}


		function custom_js() {
			global $c5ab_custom_js;
			if ($c5ab_custom_js != '') {
				?>
				<script id="custom-js"  type="text/javascript">
				jQuery(document).ready(function($) {
					<?php echo $c5ab_custom_js; ?>
				});
				</script>
				<?php
			}
		}

		function register_widgets() {

			$extenral_list = array( );
			$extenral_list = apply_filters('c5ab_external_widgets', $extenral_list);
			foreach ($extenral_list as $widget) {
				if (class_exists($widget['class'])) {
					register_widget( $widget['class'] );
				}

			}
		}
	}
	$c5bp_extra = new C5BP_EXTRA();
}

?>
