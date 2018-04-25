<?php

class C5PB_LAYOUT extends C5PB_BASE {


	public $width = array(
		'lg'=> 12,
		'md'=> 12,
		'sm'=> 12,
		'xs'=> 12,
	);

	public $desktop;
	public $tablet;
	public $phone;
	public $settings = array(
		'custom_background' => '',
	);
	public $style_settings = array();



	function __construct() {

	}


	function set_width($width) {
		if(is_array($width)){
			$this->width = $width;
		}else {
			$this->width = array(
				'lg'=> $width,
				'md'=> $width,
				'sm'=> $width,
				'xs'=> $width,
			);
		}
	}

	function options() {
		$this->options =  array(
			'type'=>'layout',
			'id' => $this->id,
			'order'=>'',
			'parent'=> '',
			'settings' => array(
				'custom_background'=> '',
			),
			'content'=> $this->content,
			'desktop' => $this->desktop,
			'tablet' => $this->tablet,
			'phone' => $this->phone
		);
	}

	function get_css_class() {

	}

	function html_classes() {
		$class= '';
		$class .= ' c5ab_col_' . $this->desktop .'  c5ab_base_col ';

		return $class;
	}

	function sub_classes() {
		return ' c5ab-panel-rows-wrap ';
		// return '';
	}

	function html_controls() {

	}

	function after_html() {

	}

	function after_elements() {
		?>
		<div class="c5ab-add-element c5ab-base " >
			<div class="c5ab-widget-info c5ab-edit-column-style" title="<?php  esc_html_e('Edit Column Style, Add Background, Spacing, Border or Custom Class', 'medical-cure'); ?>" data-id="<?php echo $this->id ?>">
				<span class="c5ab-edit-column"><i class="fa fa-edit"></i></span>
			</div>
			<div class="c5ab-widget-info c5ab-add-new-element" title="<?php  esc_html_e('Add New Element', 'medical-cure'); ?>">
				<span class="c5ab-add"><i class="fa fa-plus"></i></span>
			</div>
		</div>
		<?php
	}

	function settings_parametars() {

		$bg_object = new Code125_Background_Editor();
		$this->style_settings = $bg_object->settings();

	}


	function edit_options_panel() {
		?>
		<form method="post" action="" id="c5ab-column-form">
			<div class="c5ab-widget-header clearfix">
				<h4><?php esc_html_e('Column Settings', 'medical-cure') ?></h4>
			</div>
			<?php echo '<div class="c5ab-header-screens">'; ?>
				<span class="c5ab-screen-control c5ab-close-screen " title="<?php  esc_html_e('Close', 'medical-cure') ?>">x</span>
				<?php
				echo '</div>';


				$this->settings_parametars();
				$tab_opend = false;
				$tabs_content = '';
				$tabs = '';
				foreach ($this->style_settings as $key => $value) {
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
				<span class="c5ab-btn c5ab-save-column-data" data-id="<?php echo $this->id ?>"><?php esc_html_e('Save Changes', 'medical-cure') ?></span>
				<span class="c5ab-btn c5ab-save-column-data-and-update" data-id="<?php echo $this->id ?>"><?php esc_html_e('Save Changes and Update Page', 'medical-cure') ?></span>
			</div>
			<?php
		}

		function validate_settings() {

			$this->settings_parametars();

			foreach ($this->style_settings as  $value) {
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
			$background_object = new Code125_Background_Implementation();
			if ($this->settings['custom_class'] != '') {
				$background_object->parent = '#c5ab-column-'. $this->id .' > div > .code125-ab-background-wrap';
			}else{
				$background_object->parent = '#c5ab-column-'. $this->id .' > .code125-ab-background-wrap';
			}

			$background_object->container = '.c5ab-center-content';
			$background_object->inner = '.c5ab-background-inner';

			$background_object->options($this->settings['custom_background']);

			$class = $background_object->background_css();
			$background_object->spacing($this->settings);

			$sticky = '';
			if (isset( $GLOBALS['code125-sticky-columns'] ) && $GLOBALS['code125-sticky-columns'] == 'on') {
				$sticky = ' code125-sticky-content ';
			}

			echo '<div id="c5ab-column-'. $this->id .'" class="c5ab-col-base c5ab-col-lg-'. $this->desktop .' c5ab-col-md-'. $this->tablet .' c5ab-col-sm-'. $this->phone .' '. $class .' '.$sticky.' ">';
			if ($this->settings['custom_class'] != '') {
				echo '<div class="'.$this->settings['custom_class'].'" >';
			}
			echo '<div class="code125-ab-background-wrap ">';

			$background_object->background_html(false);
		}

		function render() {

			$this->validate_settings();
			if (C5AB_ENABLE_CACHE) {
				if(  c5_is_mobile() ){
					$device = 'mobile';
				} elseif(   c5_is_tablet() ){
					$device = 'tablet';
				}else{
					$device = 'desktop';
				}

				$transient_key = 'code125_element_before_' . $device . '_' . $this->id;

				if ( false === ( $render_before = get_transient($transient_key ) ) ) {
					ob_start();
					$this->render_before();
					$render_before = ob_get_clean();
					$duration = 60*60*24;
					set_transient( $transient_key , $render_before, C5AB_CACHE_TIME );
				}
				echo $render_before;
			}else{
				$this->render_before();
			}


			$temp_width = $GLOBALS['c5_content_width'];
			$test_width = $GLOBALS['c5_content_margin'] + $GLOBALS['c5_content_width'];

			if(  c5_is_mobile() ){
				$GLOBALS['c5_content_width'] = floor( $test_width *$this->phone/C5BP_COLUMNS_COUNT)- $GLOBALS['c5_content_margin'];
			}

			if(   c5_is_tablet() ){
				$GLOBALS['c5_content_width'] = floor( $test_width*$this->tablet/C5BP_COLUMNS_COUNT )- $GLOBALS['c5_content_margin'];
			}

			if(  c5_is_desktop() ){
				$GLOBALS['c5_content_width'] = floor( $test_width*$this->desktop/C5BP_COLUMNS_COUNT )- $GLOBALS['c5_content_margin'];
			}

			if( isset($this->options['content']) &&  is_array($this->options['content'])	){
				foreach ($this->options['content'] as $key => $single) {
					$class_name = $this->get_class_name($single['type']);

					$obj = new $class_name();
					if(!is_array($single['content'])){
						if( is_array(@code125_decode( $single['content']) ) ){
							$single['content'] = code125_decode( $single['content'] );
						}
					}
					$obj->set_options($single);


					$obj->render();
				}
			}
			$GLOBALS['c5_content_width'] = $temp_width ;

			echo '</div>';
			if ($this->settings['custom_class'] != '') {
				echo '</div>';
			}
			echo '</div>';

		}

		function sample_layout() {
			$options =  array(
				'type'=>'layout',
				'id' => 'test-id',
				'order'=>'',
				'parent'=> '',
				'content'=> array(),
				'desktop' => 0,
				'tablet' => 2,
				'phone' => 12
			);
			$this->set_options($options);
			$this->html();

		}
	}









	?>
