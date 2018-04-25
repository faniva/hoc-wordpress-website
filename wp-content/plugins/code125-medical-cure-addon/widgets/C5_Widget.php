<?php



class C5_Widget extends WP_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_child_shortcode_bool = false;
	public  $_skip_title = false;
	public  $_cache_output = false;
	public  $_child_shortcode = '';
	public  $_options =array();
	public  $_base_id;
	public 	$_widget_local_id;
	public 	$_private_id = '';
	public 	$_js = '';

	public  $_js_id = '';

	function __construct() {

		$id_base = 'menu-widget';
		$this->_shortcode_name = 'menu';
		$name = 'Menu';
		$desc = 'Show Menu in Sidebar.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}

	function self_construct($name, $id_base , $desc , $classes) {

		$this->_base_id = $id_base;
		$this->_widget_local_id = $this->get_unique_id();
		$widget_ops = array(
			'classname' => 'clearfix c5-widget c5-widget-'.$id_base .' ' . $classes,
			'description' => $desc
		);

		$control_ops = array( 'width' => 700, 'height' => 350, 'id_base' => $id_base );

		if( is_admin() ){
			$this->options();

			$this->update_cached_options();


		}

		if ($this->_shortcode_bool) {
			add_shortcode(  $this->_shortcode_name, array($this, 'build'));
		}

		$prefix = apply_filters('c5_widget_prefix', 'AB - ');

		parent::__construct( $id_base, $prefix . $name, $widget_ops, $control_ops );
	}


	public function atts(  ) {
		$atts_list = array();
		foreach ($this->_options as $key => $value) {
			$atts_list[ $value['id'] ] = isset($value['std']) ?$value['std'] : '' ;

		}
		//print_r($atts_list);
		return $atts_list;
	}

	public function atts_child() {
		$atts_list = array();
		foreach ($this->_options as $key => $value) {
			if($value['id']== $this->_child_shortcode){
				foreach ($value['settings'] as $key2 => $value2) {

					$atts_list[ $value2['id'] ] = $value2['std'];

				}
			}
		}
		$atts_list['title']= '';
		return $atts_list;
	}



	public function build_child($atts,$content)
	{
		// extract the attributes into variables
		$atts = shortcode_atts( $this->atts_child() , $atts);

		if(isset($atts['content']) && $content == ''){
			$content = $atts['content'];
			unset($atts['content']);

		}
		$data = $this->child_shortcode($atts,$content);
		return $data;
	}
	function child_shortcode($atts, $content) {

	}

	public function get_helper_array() {
		return array(
			array(
				'label' => 'Reference Title',
				'id' => 'c5_helper_title',
				'type' => 'text',
				'desc' => 'This text will be used as the sub-text in your page builder, leave it empty for auto assign<br/><strong>Note: this won\'t get rendered in your widget</strong>',
				'std' => '',
			)
		);
	}

	public function get_title_array() {
		if($this->_skip_title){
			return array();
		}
		return array(
			array(
				'label' => 'Title',
				'id' => 'c5_title',
				'type' => 'text',
				'desc' => '',
				'std' => '',
			)
		);
	}

	public function return_title_html($atts) {
		if($this->_skip_title){
			return '';
		}
		if( isset($atts['c5_title']) ){
			if($atts['c5_title']!=''){
				$code =  '<h3 class="title">'.$atts['c5_title'].'</h3>';
				return $code;
			}
		}
		return '';
	}


	public function build($atts,$content)
	{
		$this->get_cached_options();
		// extract the attributes into variables
		$atts = shortcode_atts( $this->atts(   ) , $atts);

		if(isset($atts['content'])  && $content == ''){
			$content = $atts['content'];
			unset($atts['content']);

		}
		$data = '';

		$data .= $this->return_title_html($atts) ;

		$data .=  $this->shortcode($atts,$content);

		if ($this->_js != '') {
			global $c5ab_custom_js;

			$c5ab_custom_js .= $this->_js;
		}

		return $data;
	}

	function shortcode($atts,$content) {
		//shortcode implementation
	}
	function update_cached_options() {
		$this->options();
		$this->_options = array_merge($this->get_title_array() , $this->_options);
		$options_to_be_saved =  array();
		foreach ($this->_options as $option) {
			$new_option = array(
				'id'=>$option['id'],
				'type'=>$option['type'],
				'std'=>$option['std']
			);
			if(isset($option['settings']) && is_array($option['settings'])){

				$new_settings =array();
				foreach ($option['settings'] as $setting) {
					$new_settings[] = array(
						'id'=>$setting['id'],
						'type'=>$setting['type'],
						'std'=>$setting['std']
					);
				}
				$new_option['settings'] = $new_settings;
			}

			$options_to_be_saved[] = $new_option;
		}

		update_option('c5_shortcode_option_' . $this->_base_id, $options_to_be_saved);
	}
	function get_cached_options() {
		$options = get_option('c5_shortcode_option_' . $this->_base_id);

		if(!is_array($options)){
			$this->update_cached_options();
		}else {
			$this->_options = $options;
		}
	}

	function options() {


		$this->_options =array(
			array(
				'label' => 'Title',
				'id' => 'title',
				'type' => 'text',
				'desc' => 'Menu Widget title.',
				'std' => '',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => '',
			),

		);
	}

	function get_unique_id() {
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < 5; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

	function get_main_colors() {
		$array = array(
			'primary'=> apply_filters( 'c5ab_primary_color' , ''),
			'light'=>apply_filters( 'c5ab_light_color' , ''),
			'dark'=>apply_filters( 'c5ab_dark_color' , ''),
			'grey'=>apply_filters( 'c5ab_grey_color' , ''),
			'text'=>apply_filters( 'c5ab_text_color' , ''),

		);
		return $array;
	}

	function widget( $args, $instance ) {

		$this->_private_id = isset($instance['_private_id']) ? $instance['_private_id'] : '';
		if ($this->_cache_output && C5AB_ENABLE_CACHE && $this->_private_id!='') {
			if( c5_is_mobile() ){
				$device = 'mobile';
			} elseif( c5_is_tablet() ){
				$device = 'tablet';
			}else{
				$device = 'desktop';
			}
			$transient_key = 'code125_widget_' . $device . '_' . $this->_private_id;
			$transient_key_js = 'code125_widget_js_' . $device . '_' . $this->_private_id;

			if ( false === ( $content = get_transient( $transient_key ) ) ) {

				$content = do_shortcode( $this->prepare_shortcode( $args, $instance) ) ;
				set_transient( $transient_key_js , $this->_js , C5AB_CACHE_TIME );
				set_transient( $transient_key , $content , C5AB_CACHE_TIME );
			}else{
				$this->_js = get_transient( $transient_key_js );
				$content = '<!-- Widget '.$this->_private_id. ' Cache Loaded -->' . $content;
			}
			echo $content;

		}else{
			echo do_shortcode( $this->prepare_shortcode( $args, $instance) ) ;

		}

		if ($this->_js != '') {
			global $c5ab_custom_js;

			$c5ab_custom_js .= $this->_js;
		}

	}

	function prepare_shortcode( $args, $instance ) {


		$shortcode = $args['before_widget'] .  $this->build_shortcode( $instance) . $args['after_widget'];


		return   $shortcode ;
	}

	function build_shortcode(  $instance) {

		$this->get_cached_options();

		$content = '';
		$atts = array();

		foreach ($this->_options as $key => $value) {
			if($value['type'] == 'list-item'){
				if (isset($instance[$value['id']])) {
					if (is_array( $instance[$value['id']] )) {
						$atts[$value['id']] =$instance[$value['id']];
					}else{
						$atts[$value['id']] = unserialize(base64_decode( $instance[$value['id']] ));
					}
				}
			}elseif($value['id'] == 'content'){
				if (isset($instance[$value['id']])) {
					$content = $instance[$value['id']];
				}
			}else {
				$atts[$value['id']] = isset($instance[$value['id']]) ? $instance[$value['id']] : $value['std'];
			}
		}


		$output =  $this->return_title_html($atts) ;


		 $output .= $this->shortcode($atts, $content);
		 return $output;
	}

	//Update the widget
	function _get_update_callback() {

		if (isset($_POST['widget_number'])) {
			if ($_POST['widget_number'] < 0) {
				$_POST['widget_number'] = $_POST['multi_number'];
			}
		}
		if(isset($_POST['id_base'])){
			if (!empty($_POST)) {
				// print_r($_POST);
			}
			$new_key = 'widget-' . $_POST['id_base'];

			foreach ($_POST as $key => $value) {

				if(strpos($key, 'widget-' . $_POST['widget-id'] .'-') !== false){
					$test_string = str_replace('widget-' . $_POST['widget-id'] .'-', "", $key);
					if(strpos($key, '_settings_array') !== false){
						unset($_POST[$key]);
						continue;
					}
					if (!isset($_POST[$new_key][$_POST['widget_number']][$test_string])) {
						$_POST[$new_key][$_POST['widget_number']][$test_string] = ot_encode(serialize($value[$key]));
						unset($_POST[$key]);
					}

				}

			}
			if(isset($_POST[$new_key][ $_POST['widget_number'] ]) && is_array($_POST[$new_key][ $_POST['widget_number'] ])){
				foreach ($_POST[$new_key][ $_POST['widget_number'] ] as $key => $value) {
					if (is_array($value)) {
						$_POST[$new_key][ $_POST['widget_number'] ][$key] = ot_encode(serialize($value));
					}
				}
				$all_data = array();
				foreach ($_POST[$new_key] as $key => $options) {
					foreach ($options as $key_2 => $new_value) {

						if (is_array($new_value)) {
							$new_value = ot_encode(serialize($new_value));
						}
						$all_data[$key_2] = $new_value;
					}
				}
				$_POST[$new_key]= array( $_POST['widget_number'] => $all_data);
			}
			$_POST['_private_id'] = $this->get_unique_id();
			if (!empty($_POST)) {
				// print_r($_POST);
			}
		}
		return array($this, 'update_callback');
	}

	function prepare_atts($data) {
		// print_r($data);
		$instance = array();
		foreach ($data as $key => $value) {
			preg_match_all("/\[.*?\]/",$key,$matches);
			if(count( $matches[0] ) !=0){
				$test_array = $matches[0];
				if(count( $test_array ) ==3){
					if (strpos($test_array[0], $this->_child_shortcode) !== false && $this->_child_shortcode != '') {
						$instance[$this->_child_shortcode][ c5ab_strip( $test_array[1] ) ][c5ab_strip($test_array[2])] = $value;
					}else{
						$instance[c5ab_strip($test_array[1])] = $value;
					}
				}else {
					$instance[c5ab_strip($test_array[1])] = $value;
				}
			}
		}
		$return = array();
		foreach ($instance as $key => $value) {
			if(is_array($value)){
				$key = str_replace(']' , "", $key);
				$return[$key] = base64_encode(serialize($value));
			}else {
				$return[$key] = $value;
			}
		}

		$demo = array('before_widget' => '' , 'after_widget' => '' );

		return $this->prepare_shortcode($demo, $return);
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;


		foreach ($new_instance as $key => $value) {
			if(is_array($new_instance[ $key ])){
				$instance[ $key ] =  $new_instance[ $key ];
			}else {
				if($key =='content'){
					$instance[ $key ] = htmlspecialchars( stripslashes( $new_instance[ $key ]) );
				}else {

					$instance[ $key ] = strip_tags( $new_instance[ $key ] );
				}
			}
		}
		$instance['_private_id'] = $this->generate_unique_id();
		return $instance;
	}

	function form( $instance ) {

		foreach ($this->_options as $key => $value) {
			$this->display_setting($value, $instance);
		}

		echo '<script  type="text/javascript"> OT_UI.init();</script>';

		$this->admin_footer_js();

	}

	function admin_footer_js() {

	}


	function display_setting( $args = array(), $instance= array() ) {
		extract( $args );

		/* get current saved data */
		//$options = get_option( $get_option, false );

		// Set field value

		$current_value =  isset($instance[$id]) ? $instance[$id] : '';
		$id_tag = $this->get_field_id($id);
		if($type == 'textarea' ){
			$id_tag = strtolower($id_tag);
			$id_tag = str_replace('-', '_', $id_tag);
		}
		$name = $this->get_field_name($id);


		$field_value = isset( $current_value ) ? $current_value: '';


		/* set standard value */
		if ( isset( $current_value ) && $current_value=='' ) {
			$field_value = ot_filter_std_value( $field_value, $std );
		}else {
			$field_value = $current_value;
		}

		if( ( $type == 'list-item' || $type == 'background' || $type == 'spacing' ||  $type == 'border' || $type == 'box-shadow'  || $type == 'extended-title'  || $type == 'button' ) && $field_value!=''){
			unset($field_value);
			$field_value= array();
			$field_value = unserialize(ot_decode($current_value));

		}

		if($id == 'content'){
			$field_value= html_entity_decode($field_value);
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

		$class = isset( $class ) ? $class : '';
		echo '<div class="format-settings c5-setting-wrap c5-setting-wrap-'.$id.' format-settings-'.$id.' c5-class-'.$class.'">';
		echo '<div class="format-setting-label">';

		echo '<h4 class="label">' . $label . '</h4>';

		echo '</div>';

		/* get the option HTML */
		echo ot_display_by_type( $_args );

		echo '</div>';
	}

	function custom_css() {

	}

	function css() {

	}


	function encode($value) {
		if(is_bool($value)){
			if($value){
				return 'TRUE';
			}else {
				return 'FALSE';
			}
		}elseif (is_array($value)) {
			return base64_encode(serialize($value));
		}else {
			return $value;
		}
	}
	public function slick_direction()
	{
		$direction = '\'nextArrow\' : \'<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>\',
		\'prevArrow\' : \'<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>\',';
		if (is_rtl()) {
			$direction = '\'nextArrow\' : \'<button type="button" class="slick-next"><i class="fa fa-angle-left"></i></button>\',
			\'prevArrow\' : \'<button type="button" class="slick-prev"><i class="fa fa-angle-right"></i></button>\',';
			$direction .= '"rtl": true,';
		}
		return $direction;
	}

	function decode($value) {
		if($value == 'TRUE' || $value == 'FALSE'){
			if($value == 'TRUE'){
				return true;
			}else {
				return false;
			}
		}elseif( is_array(@unserialize( base64_decode($value) )) ){
			return unserialize( base64_decode($value) );
		}else {
			return $value;
		}
	}

	function generate_unique_id() {
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < 6; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
}

/* add scripts for metaboxes to post-new.php & post.php */
add_action( 'admin_print_scripts-widgets.php', 'ot_admin_scripts', 11 );

/* add styles for metaboxes to post-new.php & post.php */
add_action( 'admin_print_styles-widgets.php', 'ot_admin_styles', 11 );


?>
