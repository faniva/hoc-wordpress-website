<?php
$settings_obj = new C5_theme_options();
//tags
if ($settings_obj->get_meta_option('enable_tags') !='off' && has_tag() ) {
    ?>
    <div class="code125-post-tags">
        <h3><?php  esc_html_e( 'Tags', 'medical-cure' ) ?></h3>
        <ul>
            <?php the_tags('<li>', '</li><li>', '</li>'); ?>
        </ul>
    </div>
<?php }
?>
