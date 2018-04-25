<?php
if ( ! function_exists( 'ot_type_custom_background' ) ) {
	function ot_type_custom_background( $args = array() ) {

		/* turns arguments array into variables */
		extract( $args );
		$obj = new Code125_Background_Type();

		$obj->set_options( $field_value );
		$id = $obj->generate_id();

		/* format setting outer wrapper */
		echo '<div class="format-setting code125-type-custom-background c5cbg-'.$id.'">';


		$obj->set_field_id($field_id);
		$obj->set_field_name($field_name);


		echo '<div class="code125-custom-background-options clearfix">';
		echo '<div class="code125-cpt-background-form">';
		echo '<input type="hidden" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="'.$field_value.'" class="code125-custom-background-field-id" />';
		$obj->background_type();
		$obj->background();
		$obj->video();
		$obj->overlay_type();
		$obj->image_extras();
		$obj->gradient_type();
		$obj->color_picker( esc_html__('Primary Color', 'medical-cure') , 'code125-color-1');
		$obj->color_picker( esc_html__('Middle Color', 'medical-cure') , 'code125-color-2');
		$obj->color_picker( esc_html__('Secondary Color', 'medical-cure') , 'code125-color-3');
		$obj->reverse_color();
		$obj->border_shape('top');
		$obj->border_shape('bottom');
		$obj->dark_light();
		echo '</div>';
		echo '</div>';

		?>
		<div class="c5cbg-preview-column-wrap">
			<div class="c5cbg-preview-div">
				<?php
				$preview_object = new Code125_Background_Implementation();
				$preview_object->preview($obj->options);
				?>
			</div>

		</div>
		<div class="clearfix"></div>
		<div class="c5cbg-import-export-div">
			<?php $obj->import_export(); ?>
		</div>
		<?php

		echo '</div>';
		echo '<script  type="text/javascript"> Code125_OT_Background_Editor.init(\'.c5cbg-'.$id.'\');</script>';

	}
}

/**
*
*/
class Code125_Background_Type
{
	public $options = array();
	public $main_option;
	public $field_id;
	public $field_name;

	function __construct()
	{
		# code...
	}

	public function set_field_id($field_id){
		$this->field_id = $field_id;
	}
	public function set_field_name($field_name){
		$this->field_name = $field_name;
	}
	public function set_field_value($field_value)
	{
		$this->field_value = $field_value;
	}
	public function defaults()
	{
		$defaults = array(
			'code125-background-type' => 'none',
			'code125-background-image' => '',
			'code125-background-attachment' => '',
			'code125-background-position' => '',
			'code125-background-repeat' => '',
			'code125-background-size' => '',
			'code125-background-video-mp4' => '',
			'code125-background-video-ogg' => '',
			'code125-background-video-format' => '',
			'code125-color-overlay-type' => 'full',
			'code125-image-overlay-type' => 'none',
			'code125-video-overlay-type' => 'none',
			'code125-image-half-overlay-type' => 'left',
			'code125-background-animation' => 'none',
			'code125-image-color-overlay-type' => 'solid',
			'code125-background-gradient-orientation' => 'horizontal',
			'code125-background-lum' => 'c5-light-background',
			'code125-seperator-top' => '',
			'code125-seperator-height-top' => '100',
			'code125-seperator-bottom' => '',
			'code125-seperator-height-bottom' => '100',

			'code125-color-1-opacity' => '1',
			'code125-color-1-hover-opacity' => '1',
			'code125-color-2-opacity' => '1',
			'code125-color-2-hover-opacity' => '1',
			'code125-color-3-opacity' => '1',
			'code125-color-3-hover-opacity' => '1',

		);
		return $defaults;
	}
	public function set_options($options)
	{
		if (is_array($options)) {
			$this->options = wp_parse_args( $options, $this->defaults() );
			$this->main_option = code125_encode($options);
		}else{
			$this->main_option = $options;
			$options = code125_decode($options);
			$this->options = wp_parse_args( $options, $this->defaults() );
		}

	}
	function generate_id() {
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < 6; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return  $randomString;
	}
	public function value($key='', $echo_value = true)
	{
		if (isset($this->options[$key])) {
			if ($echo_value) {
				echo ' value="' . $this->options[$key] . '" ';
			}else{
				return $this->options[$key];
			}

		}
	}

	public function color_picker($label = 'Primary Color' , $element_id ='code125-color-1')
	{
		?>
		<div class="code125-cpt-bg-ui-common code125-color-wrap <?php echo $element_id ?>-wrap clearfix">
			<div class="c5-color-base">
				<p class="code125-label"><?php echo $label; ?></p>
			</div>
			<div class="c5-color-base">
				<input class="<?php echo $element_id; ?> code125-color-input" type="text" <?php $this->value($element_id); ?> <?php echo $this->name($element_id); ?> />
			</div>
			<div class="c5-color-base">
				<?php $this->opacity( $element_id .'-opacity'); ?>
			</div>

			<div class="c5-color-base">
				<p class="code125-label code125-indent"><?php  esc_html_e('hover:', 'medical-cure'); ?></p>
			</div>
			<div class="c5-color-base">
				<input class="<?php echo $element_id; ?>-hover code125-color-input" type="text" <?php $this->value($element_id . '-hover' ); ?> <?php echo $this->name($element_id .'-hover'); ?> />
			</div>
			<div class="c5-color-base">
				<?php $this->opacity( $element_id .'-hover-opacity'); ?>
			</div>
		</div>
		<?php
	}

	public function opacity($element_id ='' )
	{

		$options = array(
			'' => esc_html__('Opacity', 'medical-cure')
		);
		for ($i=0; $i <= 20 ; $i++) {
			$key = (string) (double) ($i/20);
			$label = $key;
			if ($i == 0) {
				$label = '0.00';
			}elseif($i == 20){
				$label = '1.00';
			}elseif ($i%2 == 0) {
				$label .= '0';
			}
			$options[$key] = $label;
		}
		$this->select($element_id , $options);

	}
	public function select($element_id='' , $options)
	{
		$current_value = $this->value($element_id , false);
		?>
		<select class="code125-cpt-bg-ui-common code125-ui-select option-tree-ui-select  <?php echo $element_id ?>" <?php echo $this->name($element_id) ?> >
			<?php
			foreach ($options as $key => $value) {
				$selected = ($current_value == $key ) ? 'selected' : '';
				echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
			}
			?>
		</select>
		<?php
	}

	public function background_type( )
	{
		$atts = array(
			'name' => 'code125-background-type',
			'choices' => array( 'none'  => esc_html__('None', 'medical-cure'),
			'color' => esc_html__('Color', 'medical-cure'),
			'image' => esc_html__('Image', 'medical-cure'),
			'video' => esc_html__('Video', 'medical-cure'),
			)
		);
		$this->choices($atts);

	}

	public function overlay_type( )
	{
		$atts = array(
			'name' => 'code125-color-overlay-type',
			'choices' => array( 'full' => esc_html__('Color Overlay', 'medical-cure'),
			'half' => esc_html__('Split', 'medical-cure'),
			)
		);
		$this->choices($atts);

		$atts = array(
			'name' => 'code125-image-overlay-type',
			'choices' => array( 'none' => esc_html__('Plain Layout', 'medical-cure'),
			'full' => esc_html__('Color Overlay', 'medical-cure'),
			'container' => esc_html__('Container Overlay', 'medical-cure'),
			'half' => esc_html__('Split', 'medical-cure'),
			)
		);
		$this->choices($atts);

		$atts = array(
			'name' => 'code125-video-overlay-type',
			'choices' => array( 'none' => esc_html__('Plain Layout', 'medical-cure'),
			'full' => esc_html__('Color Overlay', 'medical-cure'),
			'container' => esc_html__('Container Overlay', 'medical-cure'),

			)
		);
		$this->choices($atts);


	}

	public function image_extras( )
	{
		$atts = array(
			'name' => 'code125-image-half-overlay-type',
			'choices' => array( 'left' => esc_html__('Left', 'medical-cure'),
			'right' => esc_html__('Right', 'medical-cure'),
			)
		);
		$this->choices($atts);

		$atts = array(
			'name' => 'code125-background-animation',
			'choices' => array( 'none' => esc_html__('No Background Animation', 'medical-cure'),
			'parallax' => esc_html__('Parallax Background Animation', 'medical-cure'),
			'sliding' => esc_html__('Sliding Background Animation', 'medical-cure'),
			)
		);
		$this->choices($atts);

		$atts = array(
			'name' => 'code125-image-color-overlay-type',
			'choices' => array( 'solid' => esc_html__('Solid Color Overlay', 'medical-cure'),
			'gradient-two' => esc_html__('Two Color Gradient', 'medical-cure'),
			'gradient-three' => esc_html__('Three Color Gradient', 'medical-cure'),
			)
		);
		$this->choices($atts);

	}
	public function gradient_type( )
	{
		$atts = array(
			'name' => 'code125-background-gradient',
			'choices' => array( 'two' => esc_html__('Two Color Points Gradient', 'medical-cure'),
			'three' => esc_html__('Three Color Points Gradient', 'medical-cure'),
			)
		);
		// $this->choices($atts);
		$atts = array(
			'name' => 'code125-background-gradient-orientation',
			'choices' =>  array( 'horizontal'  => esc_html__('→', 'medical-cure'),
			'vertical' => esc_html__('↓', 'medical-cure'),
			'diagonal' => esc_html__('↘', 'medical-cure'),
			'diagonal-bottom' => esc_html__('↗', 'medical-cure'),
			'radial' => esc_html__('○', 'medical-cure'),
			)
		);
		$this->choices($atts);

	}
	public function border_shape($direction = 'top')
	{
		$key_direction = 'code125-seperator-'.$direction;
		$current_value = $this->value($key_direction , false);
		?>
		<div class="code125-cpt-bg-ui-common code125-row-seperator-select-wrap <?php echo $key_direction ?>-wrap clearfix">

			<div class="c5-row">
				<div class="col-sm-4"><p class="code125-label"><?php
				if ($direction == 'top') {
					 esc_html_e( 'Background Seperator Top', 'medical-cure' );
				}else{
					 esc_html_e( 'Background Seperator Bottom', 'medical-cure' );
				}
				?></p></div>
				<div class="col-sm-3">
					<?php
					$border_height_key = 'code125-seperator-height-'.$direction;
					$border_height_value = $this->value($border_height_key , false);
					?>
					<select class="code125-cpt-bg-ui-common code125-ui-select option-tree-ui-select  <?php echo $border_height_key ?>" <?php echo $this->name($border_height_key) ?> >
						<?php
						$options = array(
							''=> 'height',
							'50'=> '50px',
							'100'=> '100px',
							'150'=> '150px',
							'200'=> '200px',
							'250'=> '250px',
						);
						foreach ($options as $key => $value) {
							$selected = ($border_height_value == $key ) ? 'selected' : '';
							echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
						}
						?>
					</select>
				</div>

				<div class="col-sm-5">
					<?php
					if ($current_value == '') {
						$current_value = 'none';
					}
					?>
					<input type="hidden" <?php echo $this->name($key_direction) ?>  value="<?php echo $current_value ?>" class="code125-row-seperator-input" />
					<div class="code125-row-seperator-demo"><?php
					$sperator = new Code125_ROW_Seperators();
					$sperator->$current_value( '#1e73be', 400 ,'admin-'.$direction);
					?></div>
					<ul class="code125-seperator-wrap">
						<li data-choice="none"><?php $sperator->none( '#1e73be', 400 ,'admin-'.$direction); ?></li>
						<li data-choice="shape_v"><?php $sperator->shape_v( '#1e73be', 400 ,'admin-'.$direction); ?></li>
						<li data-choice="shape_n"><?php $sperator->shape_n( '#1e73be', 400 ,'admin-'.$direction); ?></li>
						<li data-choice="slash_left"><?php $sperator->slash_left( '#1e73be', 400 ,'admin-'.$direction); ?></li>
						<li data-choice="slash_right"><?php $sperator->slash_right( '#1e73be', 400 ,'admin-'.$direction); ?></li>
						<li data-choice="curve_left"><?php $sperator->curve_left( '#1e73be', 400 ,'admin-'.$direction); ?></li>
						<li data-choice="curve_right"><?php $sperator->curve_right( '#1e73be', 400 ,'admin-'.$direction); ?></li>
					</ul>
				</div>
			</div>
		</div>
		<?php

	}
	public function css_image($element, $file_name)
	{
		$css = $element .' span{background-image: url(\''.C5BP_URI . 'image/bg-border/' .$file_name.'.jpg\')}' . "\n";
		return $css;
	}
	public function dark_light()
	{
		$atts = array(
			'name' => 'code125-background-lum',
			'choices' => array( 'c5-dark-background' => esc_html__('Dark', 'medical-cure'),
			'c5-light-background' => esc_html__('Light', 'medical-cure'),
			)
		);
		$this->choices($atts);
	}


	public function choices($atts)
	{

		$current_value = $this->value($atts['name'] , false);
		$options = $atts['choices'];
		$count = count($options);
		?>
		<div class="code125-cpt-bg-ui-common code125-custom-bg-select-wrap <?php echo $atts['name'] ?>-wrap">

			<?php
			echo '<input type="hidden" '.$this->name($atts['name']).' value="' . $current_value . '" class="code125-custom-bg-select-input" />';
			?>

			<ul class="code125-custom-bg-select code125-count-<?php echo $count ?> clearfix">
				<?php

				foreach ($options as $key => $value) {
					$selected = ($key == $current_value ) ? 'current' : '';
					echo '<li class="'.$atts['name'].'-'.$key.'"><span class="code125-custom-bg-select-element '.$selected.'" data-value="'.$key.'">'.$value.'</span></li>';
				}
				?>
			</ul>
		</div>
		<?php
	}

	public function reverse_color()
	{
		?>
		<div class="code125-cpt-bg-ui-common code125-switch-background-colors clearfix"><p><i class="fa fa-refresh"></i> <?php  esc_html_e( 'Reverse Colors', 'medical-cure' ) ?></p></div>
		<?php
	}

	public function video()
	{
		?>
		<div class="code125-cpt-bg-ui-common code125-custom-background-video-ui clearfix">
			<div class="code125-video-label">
				<p><?php  esc_html_e('Background Video', 'medical-cure') ?></p>
			</div>
			<div class="code125-video-inputs">
				<?php
				$class = ($this->value('code125-background-video-mp4',false) != '') ? 'delete-input-active' : '';
				?>
				<div class="c5-custom-bg-ui-wrap <?php echo $class ?>">
					<input type="text"  <?php echo $this->name('code125-background-video-mp4') ?> <?php $this->value('code125-background-video-mp4') ?> class="widefat ot-background-size-input option-tree-ui-input code125-background-video-mp4" placeholder="video in mp4 format">
					<span class="fa-plus fa c5-custom-bg-upload"></span>
					<span class="fa-minus fa c5-custom-bg-delete"></span>
				</div>
				<?php
				$class = ($this->value('code125-background-video-ogg',false) != '') ? 'delete-input-active' : '';
				?>
				<div class="c5-custom-bg-ui-wrap <?php echo $class ?>">
					<input type="text"  <?php echo $this->name('code125-background-video-ogg') ?> <?php $this->value('code125-background-video-ogg') ?> class="widefat ot-background-size-input option-tree-ui-input code125-background-video-ogg" placeholder="video in ogg format">
					<span class="fa-plus fa c5-custom-bg-upload"></span>
					<span class="fa-minus fa c5-custom-bg-delete"></span>
				</div>
				<?php
				$class = ($this->value('code125-background-video-webm',false) != '') ? 'delete-input-active' : '';
				?>
				<div class="c5-custom-bg-ui-wrap <?php echo $class ?>">
					<input type="text"  <?php echo $this->name('code125-background-video-webm') ?>  <?php $this->value('code125-background-video-webm') ?> class="widefat ot-background-size-input option-tree-ui-input code125-background-video-webm" placeholder="video in webm format">
					<span class="fa-plus fa c5-custom-bg-upload"></span>
					<span class="fa-minus fa c5-custom-bg-delete"></span>
				</div>

				<div class="c5-custom-bg-ui-wrap">
					<input type="text"  <?php echo $this->name('code125-background-video-youtube') ?>  <?php $this->value('code125-background-video-youtube') ?> class="widefat ot-background-size-input option-tree-ui-input code125-background-video-youtube" placeholder="youtube link">
					<span class="fa-plus fa c5-custom-bg-upload"></span>
					<span class="fa-minus fa c5-custom-bg-delete"></span>
				</div>



			</div>
		</div>
		<?php
	}

	public function background()
	{
		$repeat = array(
			'' => 'background-repeat',
			'no-repeat' => 'No Repeat',
			'repeat' => 'Repeat All',
			'repeat-x' => 'Repeat Horizontally',
			'repeat-y' => 'Repeat Vertically',
			'inherit' => 'Inherit',
		);

		$attachment = array(
			'' => 'background-attachment',
			'fixed' => 'Fixed',
			'scroll' => 'Scroll',
			'inherit' => 'Inherit',
		);

		$position = array(
			'' => 'background-position',
			'left top' => 'Left Top',
			'left center' => 'Left Center',
			'left bottom' => 'Left Bottom',
			'center top' => 'Center Top',
			'center center' => 'Center Center',
			'center bottom' => 'Center Bottom',
			'right top' => 'Right Top',
			'right center' => 'Right Center',
			'right bottom' => 'Right Bottom',
		);
		?>
		<div class="code125-cpt-bg-ui-common code125-custom-background-ui clearfix">
			<?php
			$class = ($this->value('code125-background-image',false) != '') ? 'delete-input-active' : '';
			?>
			<div class="c5-custom-bg-ui-wrap <?php echo $class; ?>">
				<input type="text"  <?php echo $this->name('code125-background-image') ?> <?php $this->value('code125-background-image') ?> class="widefat ot-background-size-input option-tree-ui-input code125-background-image" placeholder="background-image-url">
				<span class="fa-plus fa c5-custom-bg-upload"></span>
				<span class="fa-minus fa c5-custom-bg-delete"></span>
			</div>
			<div class="c5-row">
				<div class="col-sm-6">
					<?php $this->select('code125-background-attachment' , $attachment); ?>
				</div>
				<div class="col-sm-6">
					<?php $this->select('code125-background-position' , $position); ?>
				</div>
			</div>
			<div class="c5-row">
				<div class="col-sm-6">
					<?php $this->select('code125-background-repeat' , $repeat); ?>
				</div>
				<div class="col-sm-6">

					<input type="text" <?php echo $this->name('code125-background-size') ?>  <?php $this->value('code125-background-size') ?> class="widefat ot-background-size-input option-tree-ui-input code125-background-position" placeholder="background-size">
				</div>
			</div>
		</div>
		<?php
	}

	public function import_export()
	{
		$export_id = 'sm8Nhfd';
		$import_id = 'aloisBy6fdsk';
		?>
		<div class="c5cbg-import-export-wrap">
			<ul class="c5cbg-tabs clearfix">
				<li class="selected" data-tab="<?php echo $export_id ?>"><?php  esc_html_e('Export', 'medical-cure') ?></li>
				<li class="" data-tab="<?php echo $import_id ?>"><?php  esc_html_e('Import', 'medical-cure') ?></li>
			</ul>
			<div class="c5cbg-panes">
				<div class="c5cbg-pane pane-<?php echo $export_id; ?>">
					<div class="c5cbg-export-wrap">
						<p><?php  esc_html_e('Click the copy button to export this background settings to be used in another layout or another website.', 'medical-cure'); ?></p>
						<textarea name="code125-background-export" class="code125-background-export"><?php echo $this->main_option  ?></textarea>
						<p class="c5cbg-copy-btn c5cbg-btn "><span class="fa fa-copy"></span> <?php  esc_html_e('Copy', 'medical-cure'); ?></p>
					</div>
				</div>
				<div class="c5cbg-pane pane-<?php echo $import_id; ?>" style="display:none;">
					<div class="c5cbg-export-import" >
						<p><?php  esc_html_e('Paste the export code and click Import button to import these settings into your current view.', 'medical-cure'); ?></p>
						<textarea name="code125-background-import" class="code125-background-import"></textarea>
						<p class="c5cbg-import-btn c5cbg-btn"><span class="fa fa-download"></span> <?php  esc_html_e('Import', 'medical-cure'); ?></p>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	public function name($name='')
	{
		$return = 'name="'. esc_attr( $this->field_name ) .'['.$name.']" id="'. esc_attr( $this->field_name ) .'-'.$name.'"';
		return $return;
	}
}

?>
