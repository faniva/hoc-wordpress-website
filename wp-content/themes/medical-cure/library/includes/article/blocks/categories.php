<?php

$term_list = wp_get_post_terms(get_the_ID(), 'category', array("fields" => "all"));
if (count($term_list) > 1) {
    echo '<div class="code125-terms-list"><h3>'.esc_html__('All Categories:','medical-cure').'</h3><ul>';
    foreach($term_list as $term_single) {
        echo '<li><a href="'.get_term_link(intval($term_single->term_id) , 'category').'">'.$term_single->name.'</a></li>';
    }
    echo '</ul></div>';
}


?>
