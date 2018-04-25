<?php

class C5PB_ELEMENT extends C5PB_BASE {

	public $animation = '';
	public $desktop = 'TRUE';
	public $tablet = 'TRUE';
	public $mobile = 'TRUE';
	public $widget_class = '';
	public $animation_delay = '0';
	public $animation_duration = '1000';
	public $helper_text;


	function options() {
		$this->options =  array(
			'type' => 'element',
			'id' => $this->id,
			'order'=> '',
			'parent'=> '',
			'helper_text' =>$this->helper_text,
			'widget_class' => $this->widget_class,
			'content' => $this->content,
			'animation' => $this->animation,
			'animation_delay' => $this->animation_delay,
			'animation_duration' => $this->animation_duration,
			'desktop' => $this->desktop,
			'tablet' => $this->tablet,
			'mobile' => $this->mobile,
		);
	}

	function render() {

		if( ( $this->mobile == 'FALSE') && c5_is_mobile()){
			return;
		}
		if( ( $this->tablet == 'FALSE') && c5_is_tablet()){
			return;
		}
		if( ( $this->desktop == 'FALSE') && c5_is_desktop()){
			return;
		}



		if ( !class_exists( $this->widget_class ) ) return;

		$the_widget = new $this->widget_class;

		$classes = array(  'c5ab-widget' );
		if ( !empty( $the_widget->id_base ) ){
			$classes[] = 'widget_' . $the_widget->id_base;
		}

		$classes[] = 'c5ab-desktop-' . $this->desktop;
		$classes[] = 'c5ab-tablet-' . $this->tablet;
		$classes[] = 'c5ab-mobile-' . $this->mobile;

		$animation_tag = '';
		if($this->animation!='no' && $this->animation!=''){
			$animation_tag = 'data-animation-name="'.$this->animation.'"';
		}

		$the_widget->widget( array(
			'before_widget' => '<div class="' . esc_attr( implode( ' ', $classes ) ) . '" id="c5ab-widget-'.$this->id.'" '.$animation_tag.'>',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
			'widget_id' => 'widget-'
		), $this->content );
		if($this->animation!='no' && $this->animation!=''){
		?>
		<style>
		#c5ab-widget-<?php echo $this->id ?>{
			animation-duration: <?php echo $this->animation_duration ?>ms;
			-webkit-animation-duration: <?php echo $this->animation_duration ?>ms;
			-moz-animation-duration: <?php echo $this->animation_duration ?>ms;
			-ms-animation-duration: <?php echo $this->animation_duration ?>ms;
			-o-animation-duration: <?php echo $this->animation_duration ?>ms;


			animation-delay:<?php echo $this->animation_delay ?>ms;
			-webkit-animation-delay:<?php echo $this->animation_delay ?>ms;
			-moz-animation-delay:<?php echo $this->animation_delay ?>ms;
			-ms-animation-delay:<?php echo $this->animation_delay ?>ms;
			-o-animation-delay:<?php echo $this->animation_delay ?>ms;
		}
		</style>
		<?php
		}
	}

	function html_classes() {
		return '';
	}

	function html_controls() {
		echo '';
	}

	function element_form() {
		if ( !class_exists( $this->widget_class ) ) return;

		$the_widget = new $this->widget_class;
		$the_widget->number = $this->id;

		 echo $the_widget->form($this->content);
	}

	function html() {
		if ( !class_exists( $this->widget_class ) ) return;

		$the_widget = new $this->widget_class;
		?>
		<div class="c5ab-element ui-state-default c5ab-base <?php echo $this->html_classes(); ?>"  draggable="true" data-id="<?php echo $this->id; ?>">
			<div class="c5ab-widget-info">
			<?php

			$this->html_controls();

			foreach ($this->options as $key => $value) {
				$this->input_hidden($key);
			}
			 ?>
			<h4><?php $this->control_button('c5abf-duplicate' , esc_html__('Duplicate', 'medical-cure'));
			 ?><?php echo $the_widget->name; ?><?php $this->control_button('c5abf-trash' , esc_html__('Delete', 'medical-cure')); ?><span class="c5ab-helper-text"><?php echo $this->helper_text; ?></span></h4>

			<?php // echo $the_widget->form($this->content); ?>
			</div>
		</div>
		<?php
	}

	function sample_layout() {
		$options =  array(
			'type' => 'element',
			'id' => 'test-id',
			'order'=>'',
			'parent'=> '',
			'helper_text'=>'',
			'widget_class' => '',
			'content' => array(),
			'animation' => 'no',
			'animation_delay' => '0',
			'animation_duration' => '1000',
			'desktop' => 'TRUE',
			'tablet' => 'TRUE',
			'mobile' => 'TRUE',
		);
		$this->set_options($options);
		$this->html();

	}


	function get_animation_elements() {
		$animation_array = array(
			array(
				'class' => 'no',
				'title' => esc_html__('No Animation', 'medical-cure'),
			),
			array(
				'class' => 'flipInX',
				'title' => esc_html__('Flip In Horizontally', 'medical-cure'),
			),
			array(
				'class' => 'flipInX',
				'title' => esc_html__('Flip In Vertically', 'medical-cure'),
			),
			array(
				'class' => 'fadeIn',
				'title' => esc_html__('Fade In', 'medical-cure'),
			),
			array(
				'class' => 'fadeInUp',
				'title' => esc_html__('Fade In Up', 'medical-cure'),
			),
			array(
				'class' => 'fadeInDown',
				'title' => esc_html__('Fade In Down', 'medical-cure'),
			),
			array(
				'class' => 'fadeInLeft',
				'title' => esc_html__('Fade In Left', 'medical-cure'),
			),
			array(
				'class' => 'fadeInRight',
				'title' => esc_html__('Fade In Right', 'medical-cure'),
			),
			array(
				'class' => 'fadeInUpBig',
				'title' => esc_html__('Fade In Up Big', 'medical-cure'),
			),
			array(
				'class' => 'fadeInDownBig',
				'title' => esc_html__('Fade In Down Big', 'medical-cure'),
			),
			array(
				'class' => 'fadeInLeftBig',
				'title' => esc_html__('Fade In Left Big', 'medical-cure'),
			),
			array(
				'class' => 'fadeInRightBig',
				'title' => esc_html__('Fade In Right Big', 'medical-cure'),
			),

			array(
				'class' => 'slideInDown',
				'title' => esc_html__('Slide In Down', 'medical-cure'),
			),
			array(
				'class' => 'slideInLeft',
				'title' => esc_html__('Slide In Left', 'medical-cure'),
			),
			array(
				'class' => 'slideInRight',
				'title' => esc_html__('Slide In Right', 'medical-cure'),
			),

			array(
				'class' => 'bounceIn',
				'title' => esc_html__('Bounce In', 'medical-cure'),
			),
			array(
				'class' => 'bounceInDown',
				'title' => esc_html__('Bounce In Down', 'medical-cure'),
			),
			array(
				'class' => 'bounceInUp',
				'title' => esc_html__('Bounce In Up', 'medical-cure'),
			),
			array(
				'class' => 'bounceInLeft',
				'title' => esc_html__('Bounce In Left', 'medical-cure'),
			),
			array(
				'class' => 'bounceInRight',
				'title' => esc_html__('Bounce In Right', 'medical-cure'),
			),

			array(
				'class' => 'rotateIn',
				'title' => esc_html__('Rotate In', 'medical-cure'),
			),
			array(
				'class' => 'rotateInDownLeft',
				'title' => esc_html__('Rotate In Down Left', 'medical-cure'),
			),
			array(
				'class' => 'rotateInDownRight',
				'title' => esc_html__('Rotate In Down Right', 'medical-cure'),
			),
			array(
				'class' => 'rotateInUpLeft',
				'title' => esc_html__('Rotate In Up Left', 'medical-cure'),
			),
			array(
				'class' => 'rotateInUpRight',
				'title' => esc_html__('Rotate In Up Right', 'medical-cure'),
			),

		);

		return $animation_array;
	}

	function edit_widget_layout() {
		if(class_exists( $this->widget_class )){
			$widget_obj = new $this->widget_class;
		}else {
			return '';
		}
		$id_tag = $widget_obj->get_field_id($this->id);
		 ?>

		<form method="post" action="" id="c5ab-widget-form">
		 <div class="c5ab-widget-header clearfix"><h4><?php echo $widget_obj->name ?></h4>
		 	<div class="c5ab-animation-preview-wrap">
		 		<div class="c5ab-animation-preview animated">
		 			<?php esc_html_e('Click on animation and see me.', 'medical-cure') ?>
		 		</div>
		 	</div>
		 </div>
		 <div class="c5ab-header-screens">
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
		 		)
		 	);
		 	foreach ($view_array as $info) {
		 	?>
		 		<input type="hidden" name="<?php echo $info['id'] ?>" id="<?php echo $info['id'] ?>" value="<?php echo $_POST[ $info['id'] ] ?>" />
		 		<span class="c5ab-screen-control <?php echo $_POST[ $info['id'] ] ?> c5abf-<?php echo $info['icon'] ?>" title="<?php echo $info['title'] ?>"></span>
		 	<?php
		 	}
		 	 ?>

		 	<span class="c5ab-animation-text"><?php esc_html_e('Animation', 'medical-cure');  ?></span>

		 </div>


		<input type="hidden" name="id_base" value="<?php echo $widget_obj->id_base ?>" />
		<input type="hidden" name="widget-id" value="<?php echo $widget_obj->id_base ?>-<?php echo $this->id ?>" />

		<div class="c5ab-animation-container c5ab-animation-container-wrap clearfix">
		<input type="hidden" name="c5ab-animation" id="c5ab-animation" value="<?php echo $this->animation ?>" />
		<div class="c5ab-animation-info">
			<div class="c5ab-animation-container clearfix">
				<div class="c5ab-animation-info">
					<label for="c5ab-animation-duration"><?php esc_html_e('Animation Duration (micro Second):', 'medical-cure') ?></label>
				</div>
				<div class="c5ab-animation-info">
					<input type="text" name="c5ab-animation-duration" id="c5ab-animation_duration" value="<?php echo $this->animation_duration ?>" />
				</div>
			</div>
		</div>
		<div class="c5ab-animation-info">
			<div class="c5ab-animation-container clearfix">
				<div class="c5ab-animation-info">
					<label for="c5ab-animation-delay"><?php esc_html_e('Animation Delay (micro Second):', 'medical-cure') ?></label>
				</div>
				<div class="c5ab-animation-info">
					<input type="text" name="c5ab-animation-delay" id="c5ab-animation_delay" value="<?php echo $this->animation_delay ?>" />
				</div>
			</div>
		</div>
		<?php
		$animation_array = $this->get_animation_elements();
		foreach ($animation_array as $key => $info) {
			$class = '';
			if($this->animation == $info['class']){
				$class = 'selected';
			}
			?>
			<div class="c5ab-animation-single">
				<div class=" c5ab-animation-wrap <?php echo $class ?>" data-animation="<?php echo $info['class'] ?>"><?php echo $info['title'] ?></div>
			</div>
			<?php
		}
		 ?>
		 </div>
		<?php
		$this->element_form();
		?>
		</form>
		<div class="c5ab-actions">
		<span class="c5ab-btn c5ab-save-widget-data" data-id="<?php echo $this->id ?>"><?php esc_html_e('Save Changes', 'medical-cure') ?></span>
		<span class="c5ab-btn c5ab-save-widget-data-and-update" data-id="<?php echo $this->id ?>"><?php esc_html_e('Save Changes and Update Page', 'medical-cure') ?></span>
		</div>
		<?php

	}
}
 ?>
