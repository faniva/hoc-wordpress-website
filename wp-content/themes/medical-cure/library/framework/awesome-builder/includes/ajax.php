<?php

function c5ab_load_widgets() {

	$panel_widgets = array();
	global $wp_widget_factory;

	?>
	<input type="text" name="c5ab-search" value="" class="c5ab_search" placeholder="<?php esc_html_e('Start typing the widget name', 'medical-cure') ?>" />




	<ul class="c5ab-all-widgets clearfix">
		<?php

		$widgets_skip = array(
			'WP_Widget_Media_Audio',
			'WP_Widget_Media_Gallery',
			'WP_Widget_Custom_HTML',
			'WP_Widget_Media_Image',
			'WP_Widget_Media_Video',
			'WP_Widget_Text',
		);

		foreach($wp_widget_factory->widgets as $class => $info){

			$saved_data = get_the_author_meta('c5_widget_allow_' . $class, get_current_user_id()) ;
			if($saved_data == 'off'){
				continue;
			}
			if(in_array($class,  $widgets_skip)){
				continue;
			}

			$widget = new $class();
			?>
			<li class="c5ab-single-widget" data-widget-class="<?php echo $class ?>" data-parent="<?php echo $_POST['parent'] ?>" >
				<div class="c5ab-single-widget-wrap">
					<h4><?php echo esc_html($widget->name) ?></h4>
					<?php if(!empty($widget->widget_options['description'])) : ?>
						<small class="description"><?php echo esc_html($widget->widget_options['description']) ?></small>
					<?php endif; ?>
				</div>
				<div class="c5ab-single-widget-hidden">
					<?php

					$sample_element_obj = new C5PB_ELEMENT();
					$settings =  array(
						'type' => 'element',
						'id' => 'test-id',
						'order'=>'',
						'parent'=> '',
						'widget_class' => $class,
						'content' => array(),
						'animation' => 'no',
						'show_on' => 'all'
					);
					$sample_element_obj->set_options($settings);
					$sample_element_obj->html();
					?>
				</div>
			</li>
			<?php
		}
		?>
	</ul>
	<?php

	die();
}


add_action( 'wp_ajax_c5ab_load_widgets', 'c5ab_load_widgets' );

//Import/export ajax functions

function c5ab_load_import_export() {

	?>
	<div class="c5ab-header-screens"><span class="c5ab-screen-control c5ab-close-screen " title="<?php  esc_html_e('Close', 'medical-cure') ?>">x</span></div>

	<h2><?php esc_html_e('Import/Export', 'medical-cure'); ?></h2>
	<p><?php esc_html_e('You can export this template to another website that have Awesome Builder. We added this feature to make it more easy to test layouts in your demo site before publishing it online.', 'medical-cure') ?></p>
	<h3><?php esc_html_e('Import', 'medical-cure') ?></h3>
	<p><?php esc_html_e('Please paste the export code in the following text box and click Import.', 'medical-cure') ?></p>
	<textarea name="c5ab-import-textarea" class="c5ab-import-textarea"></textarea>


	<button class="c5ab-import-button c5ab-import-export-button"><span class="fa fa-download"></span><?php esc_html_e('Import', 'medical-cure') ?></button>
	<div class="clearfix"></div>


	<?php
	$post_id = $_POST['post_id'];
	if ($post_id!='NULL') {
		if (get_post_meta($post_id , 'c5ab_data' , true) != 'YTowOnt9') {
			?>
			<h3><?php esc_html_e('Export', 'medical-cure') ?></h3>
			<p><?php esc_html_e('Copy the following text to be imported later in another page. <strong>Please Note</strong> that the code here represents the latest saved version, so make sure that you click Update to get the updated template.', 'medical-cure') ?></p>
			<textarea name="c5ab-export-textarea" class="c5ab-export-textarea" readonly><?php echo get_post_meta($post_id , 'c5ab_data' , true); ?></textarea>
			<?php
		}
	}


	die();
}


add_action( 'wp_ajax_c5ab_load_import_export', 'c5ab_load_import_export' );



function c5ab_template_import() {

	$template = $_POST['c5ab_content'];

	if( is_array(@code125_decode( $template) ) ){
		$template_array = code125_decode( $template );
		foreach ($template_array as $row) {

			$obj = new C5PB_ROW();
			$obj->set_options($row);
			$obj->html();
		}
	}
	die();
}


add_action( 'wp_ajax_c5ab_template_import', 'c5ab_template_import' );



function c5ab_edit_widget() {

	if( is_array(@code125_decode( $_POST['content'] ) ) ){
		$content = code125_decode( $_POST['content']  );
	}else {
		$content = array();
	}

	$sample_element_obj = new C5PB_ELEMENT();
	$settings =  array(
		'type' => 'element',
		'id' => $_POST['id'],
		'widget_class' => $_POST['class'],
		'content' => $content,
		'animation' =>  $_POST['animation'],
		'animation_duration' =>  $_POST['animation_duration'],
		'animation_delay' =>  $_POST['animation_delay'],
		'desktop' => $_POST['desktop'],
		'tablet' => $_POST['tablet'],
		'mobile' => $_POST['mobile'],
	);
	$sample_element_obj->set_options($settings);

	$sample_element_obj->edit_widget_layout();

	die();
}


add_action( 'wp_ajax_c5ab_edit_widget', 'c5ab_edit_widget' );



function c5ab_edit_options_panel() {

	if( is_array(@code125_decode( $_POST['options']  )) ){
		$options = code125_decode( $_POST['options']  );
	}else {
		$options = array();
	}

	// $obj = new C5AB_FORMAT_BUILDER_DATA();
	// $post_data = array();
	// parse_str( $_POST['form_data'] , $post_data);
	// $order = $obj->get_children('0' , $post_data );
	// $value = $obj->get_child_values($order, $post_data );


	$sample_element_obj = new C5PB_ROW();
	$settings =  array(
		'type' => 'row',
		'id' => $_POST['id'],
		'content'=>array(),
		'settings' =>  $options,
	);
	$sample_element_obj->set_options($settings);

	$sample_element_obj->edit_options_panel( );
	?>
	<?php
	die();
}


add_action( 'wp_ajax_c5ab_edit_options_panel', 'c5ab_edit_options_panel' );

function c5ab_load_column_style() {

	if( is_array(@code125_decode( $_POST['options']  )) ){
		$options = code125_decode( $_POST['options']  );
	}else {
		$options = array();
	}


	$sample_element_obj = new C5PB_LAYOUT();
	$settings =  array(
		'type' => 'layout',
		'id' => $_POST['id'],
		'settings' =>  $options,
	);
	$sample_element_obj->set_options($settings);

	$sample_element_obj->edit_options_panel( );
	?>
	<?php
	die();
}


add_action( 'wp_ajax_c5ab_load_column_style', 'c5ab_load_column_style' );





function c5ab_strip($value){
	$value = str_replace('[', "", $value);
	$value = str_replace(']', "", $value);
	return $value;
}




function c5ab_save_widget_data() {

	$data =array();
	foreach (explode('&', $_POST['content']) as $chunk) {
		$param = explode("=", $chunk);

		if ($param) {
			$key = urldecode( $param[0] );
			$data[ $key]= urldecode( $param[1] );
		}
	}


	$instance = array();
	// print_r($data);
	foreach ($data as $key => $value) {
		preg_match_all("/\[.*?\]/",$key,$matches);
		if(count( $matches[0] ) !=0){
			$test_array = $matches[0];

			if(count( $test_array ) >= 3){
				if (strpos($test_array[0], 'widget-' . $data['widget-id']) !== false) {

					$id = str_replace('widget-' . $data['widget-id'] .'-', "", $test_array[0]);
					$id = str_replace('[' , '' , $id);
					$id = str_replace(']' , '' , $id);
					// print_r('*'.$id .'*'. "\n");
					// print_r($value);



					if (isset($test_array[3])) {
						$instance[$id][c5ab_strip($test_array[1])][c5ab_strip($test_array[2])][c5ab_strip($test_array[3])] = stripslashes($value);
					}else{
						$instance[$id][c5ab_strip($test_array[1])][ c5ab_strip( $test_array[2] ) ] = stripslashes($value);
					}
				}else{
					if (isset($test_array[3])) {
						$id = c5ab_strip($test_array[1]);
						$instance[$id][c5ab_strip($test_array[2])][c5ab_strip($test_array[3])] = stripslashes($value);
					}else{
						$id = c5ab_strip($test_array[1]);
						$instance[$id][c5ab_strip($test_array[2])] = stripslashes($value);
					}
				}

			}else {
				$instance[c5ab_strip($test_array[1])] = stripslashes($value);
			}
		}
	}

	if(isset($data[ 'widget-' . $data['widget-id'] .'-content' ])){
		$instance['content'] = stripslashes( $data[ 'widget-' . $data['widget-id'] .'-content' ]);
	}

	$return = array();
	foreach ($instance as $key => $value) {
		if(is_array($value)){
			$return[$key] = code125_encode($value);
		}else {
			$return[$key] = $value;
		}
	}
	$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$_private_id = '';
	for ($i = 0; $i < 6; $i++) {
		$_private_id .= $characters[rand(0, strlen($characters) - 1)];
	}
	$return['_private_id'] = $_private_id;
	echo code125_encode($return);



	die();
}


add_action( 'wp_ajax_c5ab_save_widget_data', 'c5ab_save_widget_data' );


function c5ab_save_row_data() {

	$data =array();

	parse_str($_POST['content'] , $data);
	$instance = array();
	foreach ($data as $key => $value) {
		preg_match_all("/\[.*?\]/",$key,$matches);
		$test_array = $matches[0];
		if(count( $test_array ) == 1){
			$instance[c5ab_strip( str_replace( $test_array[0], "",  $key) )][ c5ab_strip( $test_array[0] ) ] = $value;
		}else {
			$instance[c5ab_strip($key ) ] = $value;
		}

	}

	$return = array();
	foreach ($instance as $key => $value) {
		if(is_array($value)){
			$return[$key] = code125_encode($value);
		}else {
			$return[$key] = $value;
		}
	}
	echo code125_encode($return);



	die();
}


add_action( 'wp_ajax_c5ab_save_row_data', 'c5ab_save_row_data' );


function c5ab_load_template() {
	$skip = true;

	if(function_exists('c5_get_premade_templates')){
		$template = c5_get_premade_template($_POST['id']);
	}

	if(!$template){
		$template = get_post_meta($_POST['id'], 'c5ab_data', true);
	}
	if( is_array(@code125_decode( $template) ) ){
		$template_array = code125_decode( $template );
		foreach ($template_array as $row) {

			$obj = new C5PB_ROW();
			$obj->set_options($row);
			$obj->html();
		}
	}
	die();
}


add_action( 'wp_ajax_c5ab_load_template', 'c5ab_load_template' );


function c5ab_launch_generator() {



	$panel_widgets = array();
	global $wp_widget_factory;

	?>
	<input type="text" name="c5ab-search" value="" class="c5ab_search" placeholder="<?php esc_html_e('Start typing the shortcode name', 'medical-cure') ?>" />


	<ul class="c5ab-all-widgets clearfix">
		<?php
		foreach($wp_widget_factory->widgets as $class => $info){

			$widget = new $class();
			if (is_subclass_of($widget, 'C5_Widget')) {

				?>
				<li class="c5ab-single-widget c5ab-single-shortcode" data-parent-id="<?php echo  $_POST['parent_id'] ?>" data-source="<?php echo  $_POST['content'] ?>" data-widget-class="<?php echo $class ?>" data-parent="<?php echo $_POST['parent'] ?>" >
					<div class="c5ab-single-widget-wrap">
						<h4><?php echo esc_html($widget->name) ?> <span>[<?php echo esc_html($widget->_shortcode_name) ?>]</span></h4>
						<?php if(!empty($widget->widget_options['description'])) : ?>
							<small class="description"><?php echo esc_html($widget->widget_options['description']) ?></small>
						<?php endif; ?>
					</div>
					<div class="c5ab-single-widget-hidden">
						<?php

						$sample_element_obj = new C5PB_ELEMENT();
						$settings =  array(
							'type' => 'element',
							'id' => 'test-id',
							'order'=>'',
							'parent'=> '',
							'widget_class' => $class,
							'content' => array(),
							'animation' => 'no',
							'show_on' => 'all'
						);
						$sample_element_obj->set_options($settings);
						$sample_element_obj->html();
						?>
					</div>
				</li>
				<?php

			}
		}
		?>
	</ul>
	<?php
	die();
}


add_action( 'wp_ajax_c5ab_launch_generator', 'c5ab_launch_generator' );



function c5ab_edit_shortcode() {

	if(!class_exists($_POST['class_name'])){
		die();
	}

	$widget_obj = new $_POST['class_name'];
	$widget_obj->number = 'testid';
	?>
	<form method="post" action="" id="c5ab-widget-form">
		<input type="hidden" name="id_base" value="<?php echo $widget_obj->id_base ?>" />
		<div class="c5ab-widget-header clearfix"><h4><?php echo $widget_obj->name ?></h4></div>
		<div class="c5ab-header-screens">
			<span class="c5ab-screen-control c5ab-close-screen " title="<?php  esc_html_e('Close', 'medical-cure') ?>">x</span>
		</div>

		<?php
		$widget_obj->form($widget_obj->atts());
		?>
	</form>
	<div class="c5ab-actions">
		<span class="c5ab-btn c5ab-generate-shortcode-data" data-parent-id="<?php echo $_POST['parent_id'] ?>" data-source="<?php echo $_POST['content'] ?>" data-class="<?php echo $_POST['class_name']; ?>" ><?php esc_html_e('Generate Code', 'medical-cure') ?></span>
	</div>
	<?php

	die();
}


add_action( 'wp_ajax_c5ab_edit_shortcode', 'c5ab_edit_shortcode' );


function c5ab_generate_shortcode() {

	$data =array();
	foreach (explode('&', $_POST['content']) as $chunk) {
		$param = explode("=", $chunk);

		if ($param) {
			$key = urldecode( $param[0] );

			$data[ $key]= urldecode( $param[1] );

		}
	}

	if(!class_exists($_POST['class'])){
		die();
	}

	$widget_obj = new $_POST['class'];

	echo $widget_obj->prepare_atts($data);
	die();
}


add_action( 'wp_ajax_c5ab_generate_shortcode', 'c5ab_generate_shortcode' );

add_action( 'wp_ajax_c5ab_load_theme_templates', 'c5ab_load_theme_templates' );

function c5ab_load_theme_templates()
{
	$obj = new C5AB_Theme_Templates();

	$obj->render();

	die();
}

add_action( 'wp_ajax_c5ab_load_pages_templates', 'c5ab_load_pages_templates' );

function c5ab_load_pages_templates()
{
	$obj = new C5AB_Pages_Templates();

	$obj->render();

	die();
}

add_action( 'wp_ajax_c5ab_load_page_template', 'c5ab_load_page_template' );

function c5ab_load_page_template()
{
	$post_id = $_POST['id'];

	$obj = new C5AB_Pages_Templates();

	$template = $obj->get_template_data($post_id);

	if( is_array(@code125_decode( $template)) ){
		$template_array = code125_decode( $template);
		foreach ($template_array as $row) {

			$obj = new C5PB_ROW();
			$obj->set_options($row);
			$obj->html();
		}
	}
	die();
}



function c5ab_load_theme_template() {

	$post_id = $_POST['id'];

	$obj = new C5AB_Theme_Templates();

	$template = $obj->get_template_data($post_id);

	if( is_array(@code125_decode( $template) ) ){
		$template_array = code125_decode( $template );
		foreach ($template_array as $row) {

			$obj = new C5PB_ROW();
			$obj->set_options($row);
			$obj->html();
		}
	}
	die();
}


add_action( 'wp_ajax_c5ab_load_theme_template', 'c5ab_load_theme_template' );




?>
