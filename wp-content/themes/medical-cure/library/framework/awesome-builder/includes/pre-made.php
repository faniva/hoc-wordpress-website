<?php


function c5_list_premade_templates() {
	$templates = array();
	$templates = apply_filters( 'c5ab_premade_templates', $templates );
	return $templates;
}

function c5_get_premade_templates() {

	$return = array();
	foreach ( c5_list_premade_templates() as $template) {
		$return[$template['id']] = $template['name'];
	}
	return $return;
}

function c5_get_premade_template($id) {

	foreach (c5_list_premade_templates() as $template_content) {
		if($template_content['id'] == $id){
			return $template_content['content'];
		}
	}
	return false;
}


?>
