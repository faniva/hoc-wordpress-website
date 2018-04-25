<?php

class C5PB_GENERATOR {

	function __construct() {
		

		add_action('media_buttons', array($this , 'button'), 100);
	}

	function button($page = null, $target = null) {

		echo '<span class="c5ab_launch_generator button" title="' . esc_html__('Insert shortcode', 'medical-cure') . '" data-page="' . $page . '" data-target="' . $target . '">[ ] '.__('Insert shortcode', 'medical-cure').'</span>';

	}


}


$obj = new C5PB_GENERATOR();








 ?>
