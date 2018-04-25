<?php
/*
Plugin Name: Awesome Builder
Plugin URI: http://www.code125.com/page-builder/
Description: A drag and drop page builder & shortcode generator that simplifies building your website.
Version: 1.7
Author: Code125
Author URI: http://themeforest.net/user/Code125
License: GPL3
License URI: http://www.gnu.org/licenses/gpl.html
*/



if(!class_exists('C5BP_LOADER')){

	class C5BP_LOADER {

		public function __construct() {

			$skip = false;
			$skip = apply_filters( 'c5ab_theme_mode', $skip );
			if (!$skip) {
				if ( !class_exists( 'OT_Loader') ) {
					include_once( plugin_dir_path( __FILE__ ) . 'tgm/option-tree.php' );
				}

				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				if (!is_plugin_active('option-tree/ot-loader.php')) {
					return;
				}
			}


			/* load languages */
			// $this->load_languages();

			/* load Plugin */
			add_action( 'after_setup_theme', array( $this, 'load_pagebuilder' ), 1 );

			add_action('wp_head', array($this, 'front_css'));

			add_filter( 'the_content',  array( $this, 'load_template_front' ) );



		}

		private function load_languages() {


			/* load the text domain  */

			add_action( 'after_setup_theme', array( $this, 'load_textdomain' ) );

		}
		/**
		* Load the text domain.
		*
		* @return    void
		*
		* @access    private
		* @since     2.0
		*/
		public function load_textdomain() {

			load_theme_textdomain( 'c5ab',  plugin_dir_path( __FILE__ ) . 'languages/' );


		}

		function front_css() {

			$this->load_file( C5BP_ROOT . "includes/front_css.php" );
		}

		function load_template_front($content) {

			$post_id = $GLOBALS['post']->ID;

			$cache = get_post_meta( $post_id , 'c5ab_cache',  true );
			if ($cache == 'on') {
				$content .=  '<!-- Cached version is loaded -->';
				if(  c5_is_mobile() ){
					$device = 'mobile';
				} elseif(   c5_is_tablet() ){
					$device = 'tablet';
				}else{
					$device = 'desktop';
				}

				$transient_key = 'code125_page_cache_' . $device . '_' . $post_id;

				if ( false === ( $return = get_transient($transient_key ) ) ) {
					$return = $this->get_front_template_content($post_id);
					$duration = 60*60*24;
					set_transient( $transient_key , $return, $duration );
				}
				$content .= $return;
			}else{
				$content .= $this->get_front_template_content($post_id);
			}

			return $content;
		}

		public function get_front_template_content($post_id)
		{
			$content = '';
			$template = get_post_meta($post_id, 'c5ab_data', true);
			if( is_array(@code125_decode( $template) ) ){
				$template = code125_decode( $template );
				$content .= c5ab_get_option('before_full');

				ob_start();

				foreach ($template as $row) {

					$obj = new C5PB_ROW();
					$obj->set_options($row);
					$obj->render();
				}

				$content .= ob_get_contents();
				ob_end_clean();

				$content .= c5ab_get_option('after_full');
			}


			return $content;
		}

		public function load_pagebuilder() {

			/* setup the constants */
			$this->constants();

			/* include the required files */
			$this->includes();

			/* hook into WordPress */
			$this->hooks();

		}



		private function constants() {

			define('C5AB_VERSION', '1.5');

			define( 'C5AB_THEME_MODE', apply_filters( 'c5ab_theme_mode', false ) );

			if (C5AB_THEME_MODE) {
				$root = '';
				$uri = '';
			}elseif (condition) {
				$root = plugin_dir_path( __FILE__ );
				$uri = plugin_dir_url( __FILE__ );
			}

			$root = apply_filters( 'c5ab_root_path', $root );
			$uri = apply_filters( 'c5ab_uri_path', $uri );

			define( 'C5BP_ROOT', $root );
			define( 'C5BP_URI', $uri );
			define('C5AB_CACHE_TIME', 60*60*2);
			define('C5AB_ENABLE_CACHE', false);

		}


		private function includes() {


			$this->load_file( C5BP_ROOT . 'ot-extra-types/class-option-tree-types.php');
			$this->load_file( C5BP_ROOT . 'includes/background-type/loader.php');

			$this->load_file( C5BP_ROOT . 'includes/pre-made.php');
			$this->load_file( C5BP_ROOT . 'includes/C5_style.php');
			$this->load_file( C5BP_ROOT . 'includes/C5_icons.php');
			$this->load_file( C5BP_ROOT . 'includes/C5_image.php');
			$this->load_file( C5BP_ROOT . 'includes/C5_social.php');
			$this->load_file( C5BP_ROOT . 'includes/ot_radio-text.php');


			// global include files
			$files = array(
				'format-builder-data',
				'settings',
				'base',
				'base-colors',
				'colors',
				'theme-templates',
				'pages-templates',
				'background',
				'element',
				'layout',
				'row',
				'template',
				'mobile',
				'generator',
				'user',
			);

			// require the files
			foreach ( $files as $file ) {
				$this->load_file( C5BP_ROOT . "classes/{$file}.php" );
			}


			define('C5BP_COLUMNS_COUNT', c5ab_get_option('col_count'));

			$this->load_file( C5BP_ROOT . 'includes/ajax.php');
			$this->load_file( C5BP_ROOT . 'includes/functions.php');

			add_action( 'add_meta_boxes',  array($this, 'metabox') , 1 );


		}

		private function load_file( $file ){

			include_once( $file );

		}

		function hooks() {
			/* add scripts for metaboxes to post-new.php & post.php */
			add_action( 'admin_enqueue_scripts', array($this, 'load_js'), 11 );

			/* add styles for metaboxes to post-new.php & post.php */
			add_action( 'admin_enqueue_scripts', array($this, 'load_css'), 11 );

			add_action('wp_enqueue_scripts', array($this, 'load_front_css') );

			add_action('admin_init' , array($this, 'admin_init'));

			add_action('edit_form_after_title',  array($this, 'media_button'), 11);

			add_action( 'pre_post_update', array($this, 'pre_post_update')  );

			$user_func = 'add_' . 'short' . 'code';
			$user_func( 'c5ab_template', array( $this, 'sc_template' ));

			$this->buttons();
		}

		function buttons() {
	    	add_filter( "mce_external_plugins", array($this, 'add_buttons')  );
			 add_filter( 'mce_buttons', array($this, 'register_buttons')  );
		}
		function add_buttons( $plugin_array ) {
		    $plugin_array['c5abPageBuilder'] = C5BP_URI . 'js/icons-button.js';
		    return $plugin_array;
		}
		public function admin_init()
		{
			add_editor_style( C5BP_URI . 'fonts/font-awesome/css/font-awesome.min.css');
		}


		function register_buttons( $buttons ) {
		    $buttons[] = 'c5abIconButton'; // dropcap', 'recentposts
		    return $buttons;
		}

		function sc_template($atts,$content) {
			$atts = shortcode_atts( array(
				'id' => ''
			), $atts );

			$content = '';

			if($atts['id'] == ''){
				return;
			}
			$cache = get_post_meta( $atts['id'] , 'c5ab_cache',  true );
			if ($cache == 'on') {
				if(  c5_is_mobile() ){
					$device = 'mobile';
				} elseif(   c5_is_tablet() ){
					$device = 'tablet';
				}else{
					$device = 'desktop';
				}

				$transient_key = 'code125_page_cache_SC_' . $device . '_' . $atts['id'];

				if ( false === ( $return = get_transient($transient_key ) ) ) {
					$return = $this->get_template_content($atts);
					$duration = 60*60*24;
					set_transient( $transient_key , $return, $duration );
				}

			}else {
				$return = $this->get_template_content($atts);
			}

			return $return;

		}
		public function get_template_content($atts)
		{
			$template = c5_get_premade_template($atts['id']);
			$content = '';

			if( !$template ){

				$template = get_post_meta($atts['id'], 'c5ab_data', true);
			}
			if( is_array(@code125_decode( $template) ) ){
				$template = code125_decode( $template );
				ob_start();

				foreach ($template as $row) {

					$obj = new C5PB_ROW();
					$obj->set_options($row);
					$obj->render();
				}

				$content .= ob_get_contents();
				ob_end_clean();
			}


			return $content;
		}

		function media_button($post) {

			$array = c5ab_get_option('post_types');
			if(is_array($array)){
				foreach($array as $type){
					if($post->post_type== $type){
						echo '<span class="c5ab-btn c5ab-launch-builder " data-show="'.__('Show Awesome Builder', 'medical-cure').'" data-hide="'.__('Show classical Editor', 'medical-cure').'" >'.__('Show Awesome Builder', 'medical-cure').'</span>';
					}
				}
			}

			$post_types = ot_get_option('page_builder_post_types' , array() );
			if(is_array($post_types)){
				foreach($post_types as $key => $type){
					if($post->post_type== $type){
						echo '<span class="c5ab-btn c5ab-launch-builder " data-show="'.__('Show Awesome Builder', 'medical-cure').'" data-hide="'.__('Show classical Editor', 'medical-cure').'" >'.__('Show Awesome Builder', 'medical-cure').'</span>';
					}
				}
			}
		}



		function load_front_css() {

			wp_enqueue_style( 'font-awesome', C5BP_URI . 'fonts/font-awesome/css/font-awesome.min.css' );

			$skip = apply_filters( 'code125_theme_stylesheets_conc', false );
			if (!$skip) {
				wp_enqueue_style( 'front-css', C5BP_URI . 'css/front-css.css' , array(), '1.0' , 'all');

				wp_enqueue_style( 'animate-css', C5BP_URI . 'css/libs/animate.min.css' , array(), '' , 'all');
				wp_enqueue_style( 'bootstrap-css', C5BP_URI . 'css/libs/bootstrap.min.css' , array(), '' , 'all');
				wp_enqueue_style( 'magnific-popup', C5BP_URI . 'css/libs/magnific-popup.css' , array(), '' , 'all');
				wp_enqueue_style( 'slick', C5BP_URI . 'css/libs/slick.css' , array(), '' , 'all');

				wp_enqueue_script( 'c5ab-front', C5BP_URI . 'js/c5ab-front.js', array(), '1.0.0', true );
				wp_enqueue_script( 'bootstrap', C5BP_URI . 'js/libs/c5ab-front.js', array(), '1.0.0', true );
				wp_enqueue_script( 'magnific-popup', C5BP_URI . 'js/libs/jquery.magnific-popup.min.js', array(), '', true );
				wp_enqueue_script( 'slick', C5BP_URI . 'js/libs/slick.min.js', array(), '', true );
				wp_enqueue_script( 'theia-sticky-sidebar', C5BP_URI . 'js/libs/theia-sticky-sidebar.js', array(), '', true );
				wp_enqueue_script( 'typed', C5BP_URI . 'js/libs/typed.min.js', array(), '', true );
				wp_enqueue_script( 'couterup', C5BP_URI . 'js/libs/jquery.counterup.min.js', array(), '', true );

				wp_enqueue_script( 'cocoen', C5BP_URI . 'js/libs/cocoen.min.js', array(), '', true );

			}else{
				// wp_enqueue_script( 'code125-plugins', C5BP_URI . 'js/code125-plugins.js', array(), '', true );
			}

		}

		function load_css($hook) {

			wp_enqueue_style( 'c5ab-admin', C5BP_URI . 'css/admin.css' , array(), '1.8' , 'all');

			wp_enqueue_style( 'animate-css', C5BP_URI . 'css/libs/animate.min.css' , array(), '' , 'all');
			wp_enqueue_style( 'magnific-popup', C5BP_URI . 'css/libs/magnific-popup.css' , array(), '' , 'all');
			wp_enqueue_style( 'slick', C5BP_URI . 'css/libs/slick.css' , array(), '' , 'all');

			wp_enqueue_style( 'c5ab-admin-font', C5BP_URI . 'fonts/c5ab-font/css/c5ab-font.css' );
			wp_enqueue_style( 'font-awesome', C5BP_URI . 'fonts/font-awesome/css/font-awesome.min.css' );

		}

		function load_js() {
			wp_enqueue_script( 'jquery-ui-resizable' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_enqueue_script( 'jquery-ui-dialog' );
			wp_enqueue_script( 'jquery-ui-button' );


			wp_enqueue_script( 'c5ab-admin', C5BP_URI . 'js/admin-1-9-1.js', array(), '1.9.1', true );
			wp_enqueue_script( 'c5ab-background-editor', C5BP_URI . 'js/bg-editor.js', array(), '1.0.0', true );

			//libs
			wp_enqueue_script( 'magnific-popup', C5BP_URI . 'js/libs/jquery.magnific-popup.min.js', array(), '', true );
			wp_enqueue_script( 'slick', C5BP_URI . 'js/libs/slick.min.js', array(), '', true );
			wp_enqueue_script( 'c5ab-tooltip', C5BP_URI . 'js/libs/tooltip.min.js', array(), '1.0.0', true );
			wp_enqueue_script( 'c5ab-underscore', C5BP_URI . 'js/libs/underscore-min.js', array(), '1.8.3', true );


			wp_localize_script( 'c5ab-admin', 'c5ab_ajax_object',
			array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		}

		function metabox() {

			$array = c5ab_get_option('post_types') ;
			if(is_array($array) ){
				foreach($array as $type){
					add_meta_box( 'c5bp-builder-panel', esc_html__('Awesome Builder', 'medical-cure'), array($this, 'metabox_render') , $type, 'normal', 'high' );
				}
			}
			$array =  ot_get_option('page_builder_post_types' , array() );
			if(is_array($array) ){
				foreach($array as $key => $type){
					add_meta_box( 'c5bp-builder-panel', esc_html__('Awesome Builder', 'medical-cure'), array($this, 'metabox_render') , $type, 'normal', 'high' );
				}
			}
		}


		function metabox_render() {
			$this->load_file( C5BP_ROOT . "includes/panel.php" );
		}
		public function recursive_validation($row)
		{
			if (empty($row)) {
				return $row;
			}

			if (isset($row['id'])) {
				$parent = $row['id'];
			}else{
				$parent = '';
			}

			if (isset($row['content']) ) {
	            foreach ($row['content'] as $key => $inner_row) {
					if (isset($inner_row['id'])) {
						delete_transient( 'code125_PB_element_before_desktop_' . $inner_row['id'] );
						delete_transient( 'code125_PB_element_before_tablet_' . $inner_row['id'] );
						delete_transient( 'code125_PB_element_before_mobile_' . $inner_row['id'] );

						delete_transient( 'code125_element_before_desktop_' . $inner_row['id'] );
						delete_transient( 'code125_element_before_tablet_' . $inner_row['id'] );
						delete_transient( 'code125_element_before_mobile_' . $inner_row['id'] );
					}

					if ($inner_row['type'] != 'element') {
						 $this->recursive_validation($inner_row);
					}
				}
	        }

	        return $row;
		}
		public function reset_caching($templates)
		{

			foreach ($templates as $key => $row) {
				delete_transient( 'code125_PB_element_before_desktop_' . $row['id'] );
				delete_transient( 'code125_PB_element_before_tablet_' . $row['id'] );
				delete_transient( 'code125_PB_element_before_mobile_' . $row['id'] );

				delete_transient( 'code125_element_before_desktop_' . $row['id'] );
				delete_transient( 'code125_element_before_tablet_' . $row['id'] );
				delete_transient( 'code125_element_before_mobile_' . $row['id'] );


				if (isset($row['content'])) {
					$this->recursive_validation($row);
				}

            }


            return $templates;
		}
		function generate_unique_id() {
			$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			for ($i = 0; $i < 6; $i++) {
			    $randomString .= $characters[rand(0, strlen($characters) - 1)];
			}
			return $randomString;
		}

		function pre_post_update( $post_id ) {
			// If this is just a revision, don't send the email.
			if ( wp_is_post_revision( $post_id ) )
			return;
			if(!isset($_POST['c5ColCount'])){
				return;
			}

			delete_transient( 'code125_page_cache_SC_desktop_' . $post_id );
			delete_transient( 'code125_page_cache_SC_tablet_' . $post_id);
			delete_transient( 'code125_page_cache_SC_mobile_' . $post_id );

			delete_transient( 'code125_page_cache_desktop_' . $post_id );
			delete_transient( 'code125_page_cache_tablet_' . $post_id);
			delete_transient( 'code125_page_cache_mobile_' . $post_id );

			$obj = new C5AB_FORMAT_BUILDER_DATA();

			$order = $obj->get_children('0' , $_POST );
			$value = $obj->get_child_values($order, $_POST );

			$value= $this->reset_caching($value);
			// code125_PB_element_before_

			update_post_meta($post_id, 'c5ab_data', code125_encode($value) );
			if(isset($_POST['c5ColCount'])){
				update_post_meta($post_id, 'c5ab_col_cout', $_POST['c5ColCount'] );
			}
			$c5abShowBuilder = 'False';
			if(isset($_POST['c5abShowBuilder']) && $_POST['c5abShowBuilder'] == 'True'){
				$c5abShowBuilder = 'True';
			}
			if(isset($_POST['c5ab_cache'])){
				update_post_meta($post_id, 'c5ab_cache', $_POST['c5ab_cache'] );
			}

			update_post_meta($post_id, 'c5ab_show_builder', $c5abShowBuilder);
			c5_update_ab_templates();


		}


		function validate_col_grid($template, $saved_col_count ) {
			return $template;
		}

	}
	$c5bp_loader = new C5BP_LOADER();
}

?>
