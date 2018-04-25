<?php
$settings_obj = new C5_theme_options();
//before article
$article_before = $settings_obj->get_meta_option('article_before');
if ($article_before!='') {
    echo '<div class="code125-before-content">';
    echo html_entity_decode( do_shortcode($article_before));
    echo '</div>';
}

?>
<div class="entry-content">
    <?php the_content( esc_html__('Continue reading','medical-cure') );  ?>
</div>
<?php
echo '<div class="clearfix"></div>';

wp_link_pages(
array(
    'before' => '<div class="c5-pagination-article clearfix"><nav class="page-links pagination c5-pagination"><ul class="page-numbers"><li><span class="page-links-title">' . __('Pages:', 'medical-cure') . '</span></li>',
    'after' => '</ul></nav></div>',
    'link_before' => '<li><span class="num">',
    'link_after' => '</span></li>'));

//before article
$article_after = $settings_obj->get_meta_option('article_after');
if ($article_after!='') {
    echo '<div class="code125-after-content">';
    echo html_entity_decode( do_shortcode($article_after));
    echo '</div>';
}
?>
