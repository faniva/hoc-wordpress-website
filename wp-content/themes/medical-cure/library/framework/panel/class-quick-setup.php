<?php

class C5_quick_setup extends C5_archive_settings {

	public $_sections =array();
	public $_options =array();

	function __construct() {

	}

	function hook() {

		add_action('admin_menu', array($this, 'hook_page'));
		add_action( 'admin_enqueue_scripts', array( $this , 'admin_enqueue_scripts') );
	}

	function hook_page() {
		$code125_submenu_page_creation_method = 'add_'.'submenu_page';

		$code125_submenu_page_creation_method('c5_theme_welcome','Quick Setup', 'Quick Setup', 'manage_options', 'c5-quick-setup', array($this, 'quick_setup_page'));
	}
	function admin_enqueue_scripts($hook) {
		if( 'index.php' != $hook  ){
			return;
		}
		if (!defined('C5BP_EXTRA_URI')) {
			define('C5BP_EXTRA_URI','');
			return;
		}
	}

	function done_page() {

		$all_options = get_option( 'option_tree' );

		foreach ($_POST as $key => $value ) {
			$all_options[$key] = $value;
		}
		if ($_POST['logo'] != '') {
			$id = c5ab_get_attachment_id_from_src($_POST['logo']);
			if ($id) {
				set_theme_mod( 'custom_logo' , $id);
			}
		}

		update_option( 'option_tree' , $all_options);

	}


	function quick_setup_page() {
		$this->build_sections();
		$this->build_settings();

		?>

		<form method="post" action="<?php echo admin_url('admin.php?page='.C5_SETUP_WIZARD.'&tab=support') ?>">
			<input type="hidden" name="c5-quick-setup-data" value="quick_setup"/>
			<h1>Quick Setup</h1>
			<p>We grouped the most important settings you might need to set in initial setup. The following settings will help you to set those options, kindly proceed with the following wizard.</p>

			<div class="quick-panel-slider">
				<?php
				$counter = 0;
				$previous = '';
				$count = count($this->_sections);
				foreach ($this->_sections as  $section) {
					echo '<div class="code125-quick-setup-slide">';
					echo '<div class="c5-quick-slide-wrap clearfix">';
					echo '<h3>'.$section['title'].'</h3>';
					echo $section['desc'];
					foreach ($this->_options as $option) {
						if($option['section']==$section['id']){
							$value = ot_get_option($option['id']);
							if($option['type'] == 'textarea-simple'){
								$value = stripslashes (  $value );
							}
							$value_array = array($option['id'] =>  $value);
							$this->display_setting($option, $value_array );
						}
					}
					echo '</div>';

					$next_num = $counter+1;
					if ($next_num < $count) {
						echo '<p class="button c5-next-page c5-prev-page button-primary button-hero right" data-slide="'.$next_num.'">'. esc_html__('Continue', 'medical-cure') .' <span class="fa fa-chevron-right"></span></p>';
					}else{
						echo '<button type="submit" class="button button-hero pull-right button-primary">'. esc_html__('Save & Continue', 'medical-cure') .' <span class="fa fa-chevron-right"></span></button>';
					}
					$prev_num = $counter-1;
					if($prev_num >= 0){
						echo '<p class="button c5-next-page c5-prev-page button-primary button-hero " data-slide="'.$prev_num.'"><span class="fa fa-chevron-left"></span> '. esc_html__('Back', 'medical-cure') .'</p>';
					}


					echo '</div>';
					$counter++;
				}
				?>
			</div>


		</form>
		<?php



	}
	function build_page($stage = 0) {
		echo '';
	}


	function build_sections () {

		$section = array();
		$this->_sections = apply_filters( 'c5_quick_setup_sections', $section );


	}
	function build_settings() {

		$options = array();
		$this->_options = apply_filters( 'c5_quick_setup_options', $options );

	}

	function get_content($id , $label , $std,$section = '') {
		return array(
			'label' => $label,
			'id' => $id,
			'type' => 'textarea-simple',
			'desc' => '',
			'std' => $std,
			'rows' => '',
			'post_type' => '',
			'taxonomy' => '',
			'class' => '',
			'section' => $section
		);
	}


}
$quick_setup = new C5_quick_setup();
$quick_setup->hook();
?>
