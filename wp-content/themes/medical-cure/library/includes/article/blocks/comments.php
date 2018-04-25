<?php
$settings_obj = new C5_theme_options();

if ( $settings_obj->get_meta_option('enable_facebook') =='off' && $settings_obj->get_meta_option('enable_wp_comments') =='off' ) {
    return;
}
?>
<div id="comments" class="code125-post-comments clearfix">
    <?php

    $code125_external_import_loaded = apply_filters( 'code125_external_import_loaded', true );
    if ($code125_external_import_loaded) {
        echo '<h3>'.esc_html__('Comments' , 'medical-cure').'</h3>';
        get_template_part( C5_ARTICLES_TEMPLATE  . 'blocks/wordpress-comments' );

    }else{
        $tabs = array();

        $comments_order = $settings_obj->get_meta_option('comments_order' , 'comments_facebook');
        $comments_order_array = explode('_', $comments_order);
        foreach ($comments_order_array as $comment_type) {
            if($comment_type == 'facebook'){
                ob_start();
                get_template_part( C5_ARTICLES_TEMPLATE  . 'blocks/facebook-comments' );
                $tab_content =  ob_get_clean();

                $tabs[] = array(
                    'icon' => 'fa fa-none',
                    'title' => esc_html__('Facebook comments' , 'medical-cure'),
                    'post' => '',
                    'tab_content' => $tab_content
                );
            }else {
                ob_start();
                get_template_part( C5_ARTICLES_TEMPLATE  . 'blocks/wordpress-comments' );
                $tab_content = ob_get_clean();

                $tabs[] = array(
                    'icon' => 'fa fa-none',
                    'title' => esc_html__('Comments' , 'medical-cure'),
                    'post' => '',
                    'tab_content' => $tab_content
                );
            }
        }
        $instance = array(
            'type' => 'tabs',
            'design' => 'naked',
            'c5ab_tab' => $tabs
        );

        echo code125_do_shortcode( 'C5AB_tabs' , $instance );
    }


    ?>
</div>
