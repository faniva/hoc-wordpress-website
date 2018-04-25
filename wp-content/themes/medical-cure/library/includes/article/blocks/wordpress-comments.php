<?php
$settings_obj = new C5_theme_options();
if ( $settings_obj->get_meta_option('enable_wp_comments') =='off' ) {
    return;
}
?>
<div role="tabpanel" class="tab-pane code125-wordpress-comments-tab active" id="wp-comments">
  <div class="code125-posts-wordpress-comments">
      <?php
      comments_template();

      $commenter = wp_get_current_commenter();
      $req = get_option('require_name_email');
      $aria_req = ( $req ? " aria-required='true'" : '' );
      $fields = array(
          'author' => '<input id="author" name="author" class="element-block " type="text" value="' .
          esc_attr($commenter['comment_author']) . '" size="30" tabindex="1" ' . $aria_req . ' placeholder="' . __('Name:', 'medical-cure') . '"  />',
          'email' => '<input id="email" name="email" class="element-block" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" tabindex="2" ' . $aria_req . ' placeholder="' . __('Email:', 'medical-cure') . '" />' .
          '</label>',
          'url' => '<input id="url" name="url" type="text" class="element-block " value="' . esc_attr($commenter['comment_author_url']) . '" size="30" tabindex="3"  placeholder="' . __('Website:', 'medical-cure') . '" />' .
          '</label >'
      );



      $defaults = array(
          'fields' => apply_filters('comment_form_default_fields', $fields),
          'id_form' => 'commentform',
          'id_submit' => 'submit',
          'class_submit' => 'btn c5-btn-theme',
          'title_reply' => '<h4>' . __('Leave a Comment', 'medical-cure') . '</h4>' ,
          'comment_notes_after' => '',
          'title_reply_to' => __('Leave a Reply to %s', 'medical-cure'),
          'cancel_reply_link' => __('Cancel reply', 'medical-cure'),
          'label_submit' => __('Post comment', 'medical-cure'),
          'comment_field' => '<textarea id="comment"  placeholder="' . __('Your comment', 'medical-cure') . '" name="comment" rows="10" class="element-block  " tabindex="4" aria-required="true"></textarea>',
          'comment_notes_before' => ''
      );
      echo '<div class="c5-add-comment"><div class="c5-bd-add-c-form">';
      comment_form($defaults);
      echo '</div></div>';
      ?>
  </div>
</div>
<?php
$primary_color = ot_get_option('primary_color');
?>
<style>
.code125-article-layout-common .code125-posts-wordpress-comments .c5-add-comment form p.form-submit input {
  background: <?php echo $primary_color ?>;
}
</style>
