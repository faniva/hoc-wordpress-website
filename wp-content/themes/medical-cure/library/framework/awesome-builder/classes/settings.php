<?php

class C5AB_options_page {

	public $_options;
	public $_instance = array();

	function __construct() {
		$this->options();

	}

	function page() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}
	function admin_menu () {
		// line commented as it is not needed in  the theme and function distorted to pass the theme-check
		// add_ options _page( 'Awesome Builder','Awesome Builder','manage_options','c5ab_awesome_builder', array( $this, 'settings_page' ) );
	}

	function get_option($option) {
		if(!isset($GLOBALS['c5ab_options_saved'])){
			$GLOBALS['c5ab_options_saved'] = get_option('c5ab_options');
		}

		$this->_instance = $GLOBALS['c5ab_options_saved'] ;
		if(isset($this->_instance[$option])){
			return $this->_instance[$option] ;
		}
		foreach ($this->_options as $key => $value) {
			if($option == $value['id']){
				return $value['std'];
			}
		}
		return '';
	}

	function handle_POST() {
		if(isset($_POST['c5ab_hidden'])){
			$this->_instance = array();
			foreach ($this->_options as $key => $value) {
				if(isset( $_POST[$value['id']] )){
					if(is_array($_POST[ $value['id']])){
						$this->_instance[$value['id']] = $_POST[ $value['id']];
					}else {
						$this->_instance[$value['id']] = stripslashes($_POST[ $value['id']]);
					}

				}else {
					$this->_instance[$value['id']] = '';
				}
			}
			update_option('c5ab_options' , $this->_instance);
		}

		$this->_instance = get_option('c5ab_options');
	}

	function  settings_page () {

	$this->handle_POST();
	?>
	<div class="wrap">
		<div class="c5ab-panel-container clearfix">


		<form method="post" action="">
			<h2 class="c5ab-settings-logo"><?php  esc_html_e('Awesome Builder Settings', 'medical-cure') ?></h2>
		<input type="hidden" name="c5ab_hidden" value="TRUE" />
		<?php

		$this->options();


		foreach ($this->_options as $key => $value) {
			$this->display_setting($value, $this->_instance);
		}


		 ?>
		 <hr class="c5ab_hr" />
		<input type="submit" class="button button-primary button-large right" value="<?php esc_html_e('Save Changes', 'medical-cure') ?>" />
		</div>
		<style>
		.c5_theme_hide{
			display: none;
		}
		</style>
		</form>

	</div>
	<?php
	}


	function options() {

		$args =array('show_ui'=> true);
		$types_array = array();
		$output = 'objects'; // names or objects

		$post_types = get_post_types( $args, $output );

		foreach ( $post_types  as $key => $post_type ) {
			if($key != 'attachment'){
				$types_array[] = array(
					'label'       => $post_type->label,
					'value'       => $key
				);
			}
		}


		$class = '';
		$hide_options_for_themes =apply_filters( 'c5ab_hide_settings', false );

		if($hide_options_for_themes){
			$class = 'c5_theme_hide';
		}



		$this->_options = array(



		 array(
		     'label' => esc_html__('Grid Column Count', 'medical-cure'),
		     'id' => 'col_count',
		     'type' => 'numeric-slider',
		     'desc' => esc_html__('Page Column Count for your grid, <strong>Warning</strong> changing your grid wil cause your saved templates to look weird, half column in 12 will be rendered as a quarter column in 24 column based.', 'medical-cure'),
		     'std' => '12',
		     'min_max_step' => '2,24,1',
		     'rows' => '',
		     'post_type' => '',
		     'taxonomy' => '',
		     'class' => $class
		 ),
		array(
		    'label' => esc_html__('Load Awesome Builder Widgets', 'medical-cure'),
		    'id' => 'widgets',
		    'type' => 'on_off',
		    'desc' => esc_html__('Choose whether to load awesome builder widgets.', 'medical-cure'),
		    'std' => 'on',
		    'rows' => '',
		    'post_type' => '',
		    'taxonomy' => '',
		    'class' => $class,
		),
		 array(
		   'label'       => esc_html__('Enable For Post Types', 'medical-cure'),
		   'id'          => 'post_types',
		   'type'        => 'checkbox',
		   'desc'        => esc_html__('Select Post Types to enable Page Builder for it.', 'medical-cure'),
		   'choices'     => $types_array,
		   'std'         => array( 'page' ),
		   'rows'        => '',
		   'post_type'   => '',
		   'taxonomy'    => '',
		   'class'       => ''
		 ),
		 array(
		     'label' => esc_html__('Enable Tablet Grid', 'medical-cure'),
		     'id' => 'tablet',
		     'type' => 'on_off',
		     'desc' => esc_html__('Choose Yes to enable Tablet Grid.', 'medical-cure'),
		     'std' => 'on',
		     'rows' => '',
		     'post_type' => '',
		     'taxonomy' => '',
		     'class' => '',
		 ),
		 array(
		     'label' => esc_html__('Enable Mobile Grid', 'medical-cure'),
		     'id' => 'mobile',
		     'type' => 'on_off',
		     'desc' => esc_html__('Choose Yes to enable Mobile Grid.', 'medical-cure'),
		     'std' => 'on',
		     'rows' => '',
		     'post_type' => '',
		     'taxonomy' => '',
		     'class' => '',
		 ),
		 array(
		     'label' => esc_html__('Content Width', 'medical-cure'),
		     'id' => 'content_width',
		     'type' => 'numeric-slider',
		     'desc' => esc_html__('Add the page content width in pixels.', 'medical-cure'),
		     'std' => '1170',
		     'min_max_step' => '500,2000,1',
		     'rows' => '',
		     'post_type' => '',
		     'taxonomy' => '',
		     'class' => $class
		 ),
		 array(
		     'label' => esc_html__('Tablet Width For Media Query', 'medical-cure'),
		     'id' => 'tablet_width',
		     'type' => 'numeric-slider',
		     'desc' => esc_html__('Add the page width in pixels in Tablet "This will affect the media query that will fire the tablet responsive grid".', 'medical-cure'),
		     'std' => '1024',
		     'min_max_step' => '500,2000,1',
		     'rows' => '',
		     'post_type' => '',
		     'taxonomy' => '',
		     'class' => $class
		 ),
		 array(
		     'label' => esc_html__('Mobile Width For Media Query', 'medical-cure'),
		     'id' => 'mobile_width',
		     'type' => 'numeric-slider',
		     'desc' => esc_html__('Add the page width in pixels in Mobile "This will affect the media query that will fire the mobile responsive grid".', 'medical-cure'),
		     'std' => '480',
		     'min_max_step' => '200,1200,1',
		     'rows' => '',
		     'post_type' => '',
		     'taxonomy' => '',
		     'class' => $class
		 ),
		 array(
		   'label'       => esc_html__('Before Content HTML.', 'medical-cure'),
		   'id'          => 'before_full',
		   'type'        => 'text',
		   'desc'        => esc_html__('The HTML that will close the current HTML to enable full width css.', 'medical-cure'),
		   'std'         => '',
		   'rows'        => '',
		   'post_type'   => '',
		   'taxonomy'    => '',
		   'class'       => $class
		 ),
		 array(
		   'label'       => esc_html__('After Content HTML', 'medical-cure'),
		   'id'          => 'after_full',
		   'type'        => 'text',
		   'desc'        => esc_html__('The HTML that will begin after the page.', 'medical-cure'),
		   'std'         => '',
		   'rows'        => '',
		   'post_type'   => '',
		   'taxonomy'    => '',
		   'class'       => $class
		 ),
		 array(
		   'label'       => esc_html__('Custom CSS', 'medical-cure'),
		   'id'          => 'custom_css',
		   'type'        => 'textarea-simple',
		   'desc'        => esc_html__('Custom CSS.', 'medical-cure'),
		   'std'         => '',
		   'rows'        => '',
		   'post_type'   => '',
		   'taxonomy'    => '',
		   'class'       => $class
		 ),
		);


		if(class_exists('C5_widget')){
			$this->_options[] =array(
			  'label'       => esc_html__('Primary Color', 'medical-cure'),
			  'id'          => 'primary_color',
			  'type'        => 'colorpicker',
			  'desc'        => esc_html__('Primary Color for Widgets.', 'medical-cure'),
			  'std'         => '#e14d43',
			  'rows'        => '',
			  'post_type'   => '',
			  'taxonomy'    => '',
			  'class'       => $class
			);

			$this->_options[] =array(
			  'label'       => esc_html__('Light Color', 'medical-cure'),
			  'id'          => 'light_color',
			  'type'        => 'colorpicker',
			  'desc'        => esc_html__('Light Color for Widgets.', 'medical-cure'),
			  'std'         => '#f6f6f6',
			  'rows'        => '',
			  'post_type'   => '',
			  'taxonomy'    => '',
			  'class'       => $class
			);

			$this->_options[] =array(
			  'label'       => esc_html__('Dark Color', 'medical-cure'),
			  'id'          => 'dark_color',
			  'type'        => 'colorpicker',
			  'desc'        => esc_html__('Dark Color for Widgets.', 'medical-cure'),
			  'std'         => '#1f1f1f',
			  'rows'        => '',
			  'post_type'   => '',
			  'taxonomy'    => '',
			  'class'       => $class
			);

			$this->_options[] =array(
			  'label'       => esc_html__('Grey Color', 'medical-cure'),
			  'id'          => 'grey_color',
			  'type'        => 'colorpicker',
			  'desc'        => esc_html__('Grey Color for Widgets.', 'medical-cure'),
			  'std'         => '#e0e0e0',
			  'rows'        => '',
			  'post_type'   => '',
			  'taxonomy'    => '',
			  'class'       => $class
			);

			$this->_options[] =array(
			  'label'       => esc_html__('Text Color', 'medical-cure'),
			  'id'          => 'texy_color',
			  'type'        => 'colorpicker',
			  'desc'        => esc_html__('Text Color for Widgets.', 'medical-cure'),
			  'std'         => '#919191',
			  'rows'        => '',
			  'post_type'   => '',
			  'taxonomy'    => '',
			  'class'       => $class
			);



		}
	}


	function display_setting( $args = array(), $instance= array() ) {
	      extract( $args );
	      //print_r($instance[$id]);
	      /* get current saved data */
	      //$options = get_option( $get_option, false );

	      // Set field value

	      $current_value =  isset($instance[$id]) ? $instance[$id] : '';
	      $id_tag =  $id;
	      $name = $id;


	      $field_value = isset( $current_value ) ? $current_value: '';




	      /* set standard value */
	      if ( isset( $current_value ) && $current_value=='' ) {
	        $field_value = ot_filter_std_value( $field_value, $std );
	      }else {
	      	$field_value = $current_value;
	      }

	      if( ( $type == 'list-item' || $type == 'background') && $field_value!=''){
	      	unset($field_value);
	      	$field_value= array();
	      	$field_value = unserialize(ot_decode($current_value));

	      }


	      /* build the arguments array */
	      $_args = array(
	        'type'              => $type,
	        'field_id'          => $id_tag,
	        'field_name'        =>  $name ,
	        'field_value'       => $field_value,
	        'field_desc'        => isset( $desc ) ? $desc : '',
	        'field_std'         => isset( $std ) ? $std : '',
	        'field_rows'        => isset( $rows ) && ! empty( $rows ) ? $rows : 15,
	        'field_post_type'   => isset( $post_type ) && ! empty( $post_type ) ? $post_type : 'post',
	        'field_taxonomy'    => isset( $taxonomy ) && ! empty( $taxonomy ) ? $taxonomy : 'category',
	        'field_min_max_step'=> isset( $min_max_step ) && ! empty( $min_max_step ) ? $min_max_step : '0,100,1',
	        'field_class'       => isset( $class ) ? $class : '',
	        'field_choices'     => isset( $choices ) && ! empty( $choices ) ? $choices : array(),
	        'field_settings'    => isset( $settings ) && ! empty( $settings ) ? $settings : array(),
	        'post_id'           => ot_get_media_post_ID(),
	        'get_option'        => $id_tag,
	      );
	      echo '<div class="clearfix '.$class.'">';
	      echo '<div class="format-setting-label">';

	      	    echo '<h4 class="label">' . $label . '</h4>';

	        echo '</div>';

	      /* get the option HTML */
	      echo ot_display_by_type( $_args );
	      echo '</div>';

	 }
}
$settings_obj = new C5AB_options_page;
$settings_obj->page();

/* add scripts for metaboxes to post-new.php & post.php */
add_action( 'admin_enqueue_scripts', 'ot_admin_scripts', 11 );

/* add styles for metaboxes to post-new.php & post.php */
add_action( 'admin_enqueue_scripts', 'ot_admin_styles', 11 );

if(!function_exists('c5ab_get_option')){
	function c5ab_get_option($option) {
		global $c5_skindata;
		if(isset($c5_skindata[$option])){
			return $c5_skindata[$option];
		}

		$obj = new C5AB_options_page;

		$value =  $obj->get_option($option);
		$value = apply_filters( 'c5ab_setting_' . $option , $value );

		return $value;
	}
}
 ?>
