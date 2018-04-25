<?php
$settings_obj = new C5_theme_options();
if ( $settings_obj->get_meta_option('enable_facebook') =='off' ) {
    return;
}
?>
<div role="tabpanel" class="tab-pane code125-facebook-comments-tab active" id="facebook-comments">
  <div class="code125-post-facebook-comments clearfix">
      <?php
      // echo '<h3 class="title">' . __('Facebook Comments', 'code125') . '</h3>';
      $facebook_color = $settings_obj->get_meta_option('facebook_color');
      $width = $GLOBALS['c5_content_width'] ;
      ?>
      <div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="<?php echo $width ?>" data-num-posts="5" data-colorscheme="<?php echo $facebook_color ?>"></div>
  </div>
</div>
