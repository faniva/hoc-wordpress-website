<?php
/*
todo: add option into theme options to show/hide next and previous
todo: validate the option here
*/
$settings_obj = new C5_theme_options();
$article_next_prev = $settings_obj->get_meta_option('enable_article_next_prev');
?>
<?php if ($article_next_prev == 'on') { ?>
<div class="code125-post-next-prev clearfix">
    <?php
    $prev_post = get_previous_post();
    if (!empty( $prev_post )){
        ?>
        <div class="code125-post-next-prev-left">
            <a href="<?php echo get_permalink( $prev_post->ID ); ?>">
                <span class="text"><?php esc_html_e('Previous Article' , 'medical-cure'); ?></span>
                <span class="title"><?php echo $prev_post->post_title; ?></span>
            </a>
        </div>
    <?php }

    $next_post = get_next_post();
    if (!empty( $next_post )){
        ?>
        <div class="code125-post-next-prev-right">
            <a href="<?php echo get_permalink( $next_post->ID ); ?>">
                <span class="text"><?php esc_html_e('Next Article' , 'medical-cure'); ?></span>
                <span class="title"><?php echo $next_post->post_title; ?></span>
            </a>

        </div>
    <?php
    }
    ?>
</div>
<?php return; } ?>
