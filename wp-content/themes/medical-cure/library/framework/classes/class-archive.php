<?php


class C5_archive_settings {

	public $_terms_options =array();
	public $_author_options =array();
	function __construct() {

	}

	public function hook()
	{
		//Tags
		add_action ( 'edit_category_form_fields', array($this , 'edit_terms_form'));
		add_action('edit_tag_form_fields' , array($this , 'edit_terms_form'));
		add_action ( 'edited_terms', array($this , 'save_terms_form'));


		//Author
		add_action('show_user_profile', array($this, 'user_checboxes'));
		add_action('edit_user_profile', array($this, 'user_checboxes'));
		add_action('personal_options_update', array($this, 'user_save'));
		add_action('edit_user_profile_update', array($this, 'user_save'));
	}




	function add_terms_options($options) {
		$this->_terms_options = array_merge($this->_terms_options, $options);
	}

	function add_author_options($options) {
		$this->_author_options = array_merge($this->_author_options, $options);
	}

	function set_author_options() {

		$this->_author_options = apply_filters( 'c5_author_options', array() ) ;


	}

	function user_save($user_id) {
		if(!current_user_can('remove_users')){
			return;
		}
		if (!current_user_can('edit_user', $user_id)) {
			return false;
		}

		$this->set_author_options();

		foreach ($this->_author_options as $option) {
			$value = $option['id'];
			if(isset($_POST[$value])){
				update_user_meta($user_id, 'c5_term_meta_user_' . $value, $_POST[$value]  );
			}

		}
	}

	function user_checboxes($user) {
		if(!current_user_can('remove_users')){
			return;
		}
		$this->set_author_options();
		?>
		<h3><?php echo C5_THEME_NAME ?> related User Info</h3>
		<table class="form-table c5-author-settings">
			<?php
			foreach ($this->_author_options as $option) {
				$value = get_the_author_meta('c5_term_meta_user_' . $option['id'], $user->ID);
				?>
				<tr class="form-field c5-no-label  <?php echo $option['class'] ?>-wrap">
					<th scope="row" valign="top">
						<label for="<?php echo $option['id'] ?>"><?php echo $option['label'] ?></label>
					</th>
					<td>
						<?php
						$option['label'] = '';
						$value_array = array($option['id'] =>  $value);
						$this->display_setting($option, $value_array ); ?>
					</td>
				</tr>
				<?php
			}

			?>

		</table>
		<?php


	}

	function save_terms_form($term_id) {

		$this->set_terms_options();

		if(isset($_POST['taxonomy'])){
			$tax = $_POST['taxonomy'];
			foreach ($this->_terms_options as $option) {
				$value = $option['id'];
				if(isset($_POST[$value])){
					update_term_meta($term_id, $value, $_POST[$value]);
				}
			}
		}
		$css_obj = new C5_header_css();
		$css_obj->create_terms_array();
	}

	function set_terms_options() {
		$this->_terms_options = apply_filters( 'c5_terms_options', array() ) ;
	}


	function edit_terms_form($term) {


		$this->set_terms_options();
		$tax = $_GET['taxonomy'];
		$term_id = $_GET['tag_ID'];
		if(isset($_GET['post_type'])){
			$post_type = $_GET['post_type'];
		}else {
			$post_type = 'post';
		}

		foreach ($this->_terms_options as $option) {

			$value = get_term_meta($term_id , $option['id'], true);
			?>
			<tr class="form-field c5-no-label c5-author-settings <?php echo $option['class'] ?>-wrap">
				<th scope="row" valign="top">
					<label for="<?php echo $option['id'] ?>"><?php echo $option['label'] ?></label>
				</th>
				<td>
					<?php
					$option['label'] = '';
					$value_array = array($option['id'] =>  $value);
					$this->display_setting($option, $value_array ); ?>
				</td>
			</tr>
			<?php
		}
	}



	function display_setting( $args = array(), $instance= array() ) {
		extract( $args );

		/* get current saved data */
		//$options = get_option( $get_option, false );

		// Set field value

		$current_value =  isset($instance[$id]) ? $instance[$id] : '';
		$id_tag =  $id;
		if($type == 'textarea' ){
			$id_tag = strtolower($id_tag);
			$id_tag = str_replace('-', '_', $id_tag);
		}
		$name =  $id;


		$field_value = isset( $current_value ) ? $current_value: '';




		/* set standard value */
		if ( isset( $current_value ) && $current_value=='' ) {
			$field_value = ot_filter_std_value( $field_value, $std );
		}else {
			$field_value = $current_value;
		}

		if( (  $type == 'background') && $field_value!=''){
			unset($field_value);
			if(is_array($current_value)){
				$field_value = $current_value;
			}else {
				$field_value= array();
				$field_value = unserialize(ot_decode($current_value));
			}

		}

		if($id == 'content'){
			//$field_value= html_entity_decode($field_value);
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
		echo '<div class="c5-setting-wrap c5-setting-wrap-'.$id.' c5-class-'.$class.'">';
		echo '<div class="format-setting-label">';

		echo '<h4 class="label">' . $label . '</h4>';

		echo '</div>';

		/* get the option HTML */
		echo ot_display_by_type( $_args );

		echo '</div>';
	}




}

$archive_settings = new C5_archive_settings();
$archive_settings->hook();
?>
