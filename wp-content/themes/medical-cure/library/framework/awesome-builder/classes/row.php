<?php
class C5PB_ROW extends C5PB_BASE {

	public $actions =array(
		'add',
		'edit',
		'delete',
		'duplicate',
	);
	public $row_settings = array();

	public $settings = array(
		'margin'=>30,
		'full_width' => 'off',
		'align' => 'left',
		'video_background_mp4'=>'',
		'video_background_ogg'=>'',
		'video_background_webm'=>'',
		'desktop'=>'TRUE',
		'tablet'=>'TRUE',
		'mobile'=>'TRUE',
	);

	public $export_data = '';

	function __construct() {

	}

	function options() {
		$this->options =  array(
			'type'=>'row',
			'id' => $this->id,
			'order'=>'',
			'parent'=> '',
			'content' =>$this->content,
			'settings' => $this->settings,
		);
	}

	function sample_layout() {
		$options =  array(
			'type'=>'row',
			'id' => 'test-id',
			'order'=>'',
			'parent'=> '',
			'content'=> array(),
			'settings' => array(
				'margin'=>30,
				'full_width' => 'off',
				'align' => 'left',
				'desktop'=>'TRUE',
				'tablet'=>'TRUE',
				'mobile'=>'TRUE',
			),
		);
		$this->set_options($options);
		$this->html();

	}

	function settings_parametars() {
		$row_align = array(
			'left',
			'center',
			'right',
		);

		$row_align_array = array();
		foreach ($row_align as $value) {
			$row_align_array[] = array(
				'src' => C5BP_URI.'image/'.$value.'.png',
				'label' => '',
				'value' => $value
			);
		}

		$row_settings = array();
		$row_settings[] = array(
			'label' => esc_html__('Layout', 'medical-cure'),
			'id' => 'row_layout_tab',
			'type' => 'tab',
			'icon' => 'fa fa-columns'
		);
		$row_settings[] =  array(
			'label' => esc_html__('Full Width', 'medical-cure'),
			'id' => 'full_width',
			'type' => 'on_off',
			'desc' => esc_html__('Choose whether to Open Full Width or No .', 'medical-cure') ,
			'std' => 'off',
			'rows' => '',
			'post_type' => '',
			'taxonomy' => '',
			'class' => '',
		);
		$row_settings[] =  array(
			'label' => esc_html__('Row Width', 'medical-cure'),
			'id' => 'row_width',
			'type' => 'select',
			'desc' => esc_html__('Choose whether to follow the width you added in settings or add a custom width.', 'medical-cure') ,
			'choices' => array(
				array(
					'value'   => 'default',
					'label'   => esc_html__('Default Width', 'medical-cure'),
				),
				array(
					'value'   => 'custom',
					'label'   => esc_html__('Custom Width "Below"', 'medical-cure'),
				),
			),
			'std' => 'default',
			'rows' => '',
			'post_type' => '',
			'taxonomy' => '',
			'class' => '',
		);
		$row_settings[] =  array(
			'label' => esc_html__('Custom Row width', 'medical-cure'),
			'id' => 'custom_width',
			'type' => 'numeric-slider',
			'desc' => esc_html__('Add the custom width you want for that row.', 'medical-cure'),
			'std' => c5_get_desktop_full_width(),
			'min_max_step' => '500,2000,1',
			'rows' => '',
			'post_type' => '',
			'taxonomy' => '',
			'class' => ''
		);
		$row_settings[] =  array(
			'label'       => esc_html__('Text and Blocks Alignment', 'medical-cure'),
			'id'          => 'align',
			'type'        => 'radio-image',
			'desc'        => 'Choose Text and Blocks Alignment',
			'choices' => $row_align_array,
			'std'         => 'left',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => ''
		);
		$row_settings[] =  array(
			'label' => esc_html__('Columns margin', 'medical-cure'),
			'id' => 'margin',
			'type' => 'numeric-slider',
			'desc' => esc_html__('Add columns margin in pixels, Default is 30.', 'medical-cure'),
			'std' => c5_get_default_margin(),
			'min_max_step' => '0,200,1',
			'rows' => '',
			'post_type' => '',
			'taxonomy' => '',
			'class' => ''
		);
		$row_settings[] =  array(
			'label' => esc_html__('Align Columns Height', 'medical-cure'),
			'id' => 'align_columns',
			'type' => 'on_off',
			'desc' => esc_html__('Choose whether to Align Columns Height.', 'medical-cure') ,
			'std' => 'off',
			'rows' => '',
			'post_type' => '',
			'taxonomy' => '',
			'class' => '',
		);

		$row_settings[] =  array(
			'label' => esc_html__('Sticky Columns Scroll', 'medical-cure'),
			'id' => 'sticky_columns',
			'type' => 'on_off',
			'desc' => esc_html__('Choose whether to make the columns sticky if they are not the same height.', 'medical-cure') ,
			'std' => 'off',
			'rows' => '',
			'post_type' => '',
			'taxonomy' => '',
			'class' => '',
		);

		$bg_object = new Code125_Background_Editor();
		$row_settings = array_merge($row_settings ,$bg_object->settings() );



		$this->row_settings = $row_settings;

	}


	function edit_options_panel() {
		?>
		<form method="post" action="" id="c5ab-row-form">
			<div class="c5ab-widget-header clearfix">
				<h4><?php esc_html_e('Row Settings', 'medical-cure') ?></h4>
			</div>
			<?php echo '<div class="c5ab-header-screens">'; ?>
				<span class="c5ab-screen-control c5ab-close-screen " title="<?php  esc_html_e('Close', 'medical-cure') ?>">x</span>
				<?php

				$view_array = array(
					array(
						'id' => 'desktop',
						'icon' => 'laptop',
						'title' => esc_html__('Show/Hide on Desktop', 'medical-cure')
					),
					array(
						'id' => 'tablet',
						'icon' => 'tablet',
						'title' => esc_html__('Show/Hide on Tablet', 'medical-cure')
					),
					array(
						'id' => 'mobile',
						'icon' => 'mobile',
						'title' => esc_html__('Show/Hide on Mobile', 'medical-cure')
					),
				);

				foreach ($view_array as $info) {
					if(!isset($this->settings[  $info['id'] ] )){
						$value  = 'TRUE';
					}else {
						$value = $this->settings[  $info['id'] ] ;
					}

					?>
					<input type="hidden" name="<?php echo $info['id'] ?>" id="<?php echo $info['id'] ?>" value="<?php echo $value ?>" />
					<span class="c5ab-screen-control <?php echo $value ?> c5abf-<?php echo $info['icon'] ?>" title="<?php echo $info['title'] ?>"></span>
					<?php
				}

				echo '</div>';


				$this->settings_parametars();
				$tab_opend = false;
				$tabs_content = '';
				$tabs = '';
				foreach ($this->row_settings as $key => $value) {
					if ($value['type'] == 'tab') {
						$li = '';
						$div = 'display:none';
						if ($tab_opend) {
							$tabs_content .= '</div>';
						}else{
							$li = 'selected';
							$div = 'display:block';
						}
						$class = isset($value['class']) ? $value['class'] : '';

						$tab_id = $this->generate_unique_id();
						$tabs .= '<li class="c5-row-tab-selector '.$li.'" data-tab="'.$tab_id.'"><p><span class="'.$value['icon'].'"></span> '.$value['label'].'</p></li>';
						$content_append = '';

						$tabs_content .= '<div class="c5-content-'.$tab_id.' '.$class.' c5-row-tabs-content" style="'.$div.'" data-widget-id="">' . $content_append;
						$tab_opend = true;
					}else{
						ob_start();
						$this->display_setting($value, $this->settings);
						$tabs_content .= ob_get_clean();
					}

				}
				if ($tab_opend) {
					$tabs_content .= '</div>';
				}


				echo '<div class="c5-row-tabs"><ul class="clearfix">'.$tabs.'</ul><div class="clearfix"></div>';
				echo '<div class="c5-row-tabs-content-wrap clearfix">'.$tabs_content.'</div>';


				echo '<script  type="text/javascript"> OT_UI.init();</script>';
				?>
			</form>
			<div class="c5ab-actions">
				<span class="c5ab-btn c5ab-save-row-data" data-id="<?php echo $this->id ?>"><?php esc_html_e('Save Changes', 'medical-cure') ?></span>
				<span class="c5ab-btn c5ab-save-row-data-and-update" data-id="<?php echo $this->id ?>"><?php esc_html_e('Save Changes and Update Page', 'medical-cure') ?></span>
			</div>
			<?php
		}

		function html_classes() {
			$class= ' row ';

			return $class;
		}

		public function row_demo()
		{
			?>
			<div class="c5-section-demo">
				<div class="c5-container-demo">
					<span class="c5-width"><span class="c5-width-text">1170px</span></span>
					<div class="c5-row-demo">
						<div class="c5-column-demo"><span></span></div>
						<div class="c5-column-demo"><span></span></div>
						<div class="c5-column-demo"><span></span></div>
					</div>
				</div>
			</div>
			<?php
		}

		function format_background($array) {
			$data = '';
			if($array['background-color']!=''){
				$data .= 'background-color:'. $array['background-color'] .';';
			}
			if($array['background-position']!=''){
				$data .= 'background-position:'. $array['background-position'] .';';
			}
			if($array['background-repeat']!=''){
				$data .= 'background-repeat:'. $array['background-repeat'] .';';
			}
			if($array['background-attachment']!=''){
				$data .= 'background-attachment:'. $array['background-attachment'] .';';
			}
			if($array['background-image']!=''){
				$data .= 'background-image:url(\''. $array['background-image'] .'\');';
			}
			return $data;

		}

		function validate_settings() {

			$this->settings_parametars();

			foreach ($this->row_settings as  $value) {
				if(!isset($this->settings[ $value['id'] ])){
					if (isset($value['std'])) {
						$this->settings[ $value['id'] ] =  $value['std'];
					}else{
						$this->settings[ $value['id'] ] =  '';
					}

				}
			}

			$new_array = array('mobile' , 'tablet', 'desktop');
			foreach ($new_array as  $value) {
				if(!isset($this->settings[ $value ])){
					$this->settings[ $value ] =  'TRUE';
				}
			}

		}
		public function render_before()
		{
			if($this->parent == '0'){
				if ($this->settings['margin'] != '30') {
					?>
					<style>
					#c5ab-row-<?php echo $this->id ?>, #c5ab-row-<?php echo $this->id ?> .c5ab-row{ margin-left:-<?php echo $this->settings['margin']/2; ?>px; margin-right:-<?php echo $this->settings['margin']/2; ?>px; }
					#c5ab-row-<?php echo $this->id ?> .c5ab-col-base{ padding-left: <?php echo $this->settings['margin']/2; ?>px; padding-right: <?php echo $this->settings['margin']/2; ?>px; }
					</style>
					<?php
				}
			}



			$background_object = new Code125_Background_Implementation();
			$background_object->parent = '#c5ab-section-'. $this->id;
			$background_object->container = '.c5ab-center-content';
			$background_object->inner = '.c5ab-background-inner';

			$background_object->options($this->settings['custom_background']);

			$class = $background_object->background_css();
			$background_object->spacing($this->settings);



			echo '<div id="c5ab-section-'. $this->id .'" class="'. $class.' ' .  implode( ' ', $this->prepare_classes() ) .'">';

			$background_object->background_html();
			if($this->settings['full_width'] != 'on'){
				if($this->settings['row_width'] == 'custom'){
					$max_width = $this->settings['custom_width'];
				}else {
					$max_width = c5ab_get_option('content_width');
				}
				if(!isset($GLOBALS['c5_content_width'])){
					$GLOBALS['c5_content_width'] = $max_width;
				}
				echo '<div class="c5ab-center-content" >';
				echo '<style>#c5ab-section-'. $this->id .' .c5ab-center-content{max-width: '. $max_width .'px; } </style>';
			}
			echo '<div class="c5ab-row clearfix" id="c5ab-row-'. $this->id .'">';


		}

		function render() {


			$this->validate_settings();

			if( ( $this->settings['mobile'] == 'FALSE') && c5_is_mobile()){
				return;
			}

			if( ( $this->settings['tablet'] == 'FALSE') && c5_is_tablet()){
				return;
			}

			if( ( $this->settings['desktop'] == 'FALSE') && c5_is_desktop()){
				return;
			}
			$GLOBALS['c5_content_margin']  = $this->settings['margin'];

			if (C5AB_ENABLE_CACHE) {
				if( c5_is_mobile() ){
					$device = 'mobile';
				} elseif( c5_is_tablet() ){
					$device = 'tablet';
				}else{
					$device = 'desktop';
				}
				$transient_key = 'code125_element_before_' . $device . '_' . $this->id;
				if ( false === ( $render_before = get_transient( $transient_key ) ) ) {
					ob_start();
					$this->render_before();
					$render_before = ob_get_clean();

					set_transient( $transient_key , $render_before , C5AB_CACHE_TIME );
				}
				echo $render_before;

			}else{
				$this->render_before();
			}

			if(!isset($GLOBALS['c5_content_width'])){
				$GLOBALS['c5_content_width'] = c5ab_get_option('content_width');
			}

			c5_check_mobile_width();
			$GLOBALS['code125-sticky-columns'] = $this->settings['sticky_columns'];
			if( isset($this->options['content']) &&  is_array($this->options['content'])	){
				foreach ($this->options['content'] as $key => $single) {
					$class_name = $this->get_class_name($single['type']);

					$obj = new $class_name();
					$obj->set_options($single);
					$obj->render();

				}
			}
			$GLOBALS['code125-sticky-columns'] = 'off';

			echo '</div>';
			if($this->settings['full_width'] != 'on'){
				echo '</div>';
			}
			echo '</div>';



		}
		public function prepare_classes()
		{
			$classes = array();
			$classes[] = 'c5ab-desktop-' . $this->settings['desktop'];
			$classes[] = 'c5ab-tablet-' . $this->settings['tablet'];
			$classes[] = 'c5ab-mobile-' . $this->settings['mobile'];

			if ($this->settings['align_columns'] == 'on') {
				$classes[] = ' code125-align-columns ';
			}
			if ($this->settings['full_width'] == 'on') {
				$classes[] = ' code125-full_width-row ';
			}


			$classes[] = $this->settings['custom_class'];

			$classes[] = 'c5ab-section-common';
			$classes[] = 'c5ab-align-' . $this->settings['align'];
			$classes[] = 'code125-ab-background-wrap';



			return $classes;
		}

		function html_controls() {
			?>



			<div class="c5ab-sub-row-controls">
				<?php
				$this->control_button('c5abf-duplicate' , esc_html__('Duplicate', 'medical-cure'));
				$this->control_button('c5abf-trash' , esc_html__('Delete', 'medical-cure'));
				$this->control_button('c5abf-drag' , esc_html__('Move', 'medical-cure'));
				?>
			</div>
			<div class="c5ab-row-controls">
				<div class="controls-left">
					<?php
					$this->control_button('c5abf-up-open' , esc_html__('Move Up', 'medical-cure'));
					$this->control_button('c5abf-drag' , esc_html__('Move', 'medical-cure'));
					$this->control_button('c5abf-down-open' , esc_html__('Move Down', 'medical-cure'));
					?><!--
						<span class="c5ab-move-up c5ab-sq-btn c5abf-up-open "></span>
						<span class="c5ab-move c5ab-sq-btn c5abf-drag "></span>
						<span class="c5ab-move-down c5ab-sq-btn c5abf-down-open "></span>-->
					</div>
					<div class="controls-right">
						<?php
						$this->control_button('c5abf-cog' , esc_html__('Edit Settings', 'medical-cure'));
						$this->control_button('c5abf-duplicate' , esc_html__('Duplicate', 'medical-cure'));
						$this->control_button('c5abf-trash' , esc_html__('Delete', 'medical-cure'));
						?>
						<!--<span class="c5ab-settings c5ab-sq-btn c5abf-cog "></span>
						<span class="c5ab-duplicate c5ab-sq-btn c5abf-duplicate "></span>
						<span class="c5ab-delete c5ab-sq-btn c5abf-trash "></span>-->
					</div>
				</div>

				<div class="clearfix"></div>
				<?php
			}




		}
		?>
