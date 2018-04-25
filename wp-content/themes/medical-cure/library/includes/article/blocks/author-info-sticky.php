<?php

$user_id = get_the_author_meta( 'ID');
$author_data = new CODE125_AUTHOR_DATA($user_id);
$icons = $author_data->get_social_icons();
$avatar = get_avatar( $user_id, 180 );
$author_posts_url = get_author_posts_url( $user_id );
$display_name = get_the_author_meta( 'display_name');
$description = get_the_author_meta( 'description');

?>

<div class="code125-article-author-info">
  <div class="code125-author-info">
    <div class="code125-author-avatar"><a href="<?php echo esc_url($author_posts_url);?>"><?php echo "$avatar"; ?></a></div>
    <a class="code125-author-name" href="<?php echo esc_url( $author_posts_url );?>"><p><?php echo"$display_name";?></p></a>
    <div class="code125-hover-author-info">
      <a class="code125-author-name" href="<?php echo esc_url( $author_posts_url );?>"><p><?php echo"$display_name";?></p></a>
      <span><?php echo "$description";?></span>
      <a class="code125-author-post" href="<?php echo esc_url( $author_posts_url );?>"><?php  esc_html_e('All posts','medical-cure');?></a>
      <ul>
        <?php foreach($icons as $icon => $link){ ?>
          <li><a href="<?php echo esc_url($link); ?>"><span class="<?php echo $icon;?>"></span></a></li>
        <?php }?>
      </ul>
    </div>
  </div>
  <?php get_template_part( C5_ARTICLES_TEMPLATE  . 'blocks/meta-date' ); ?>
</div>

<?php
$primary_color = ot_get_option('primary_color');
?>
<style>
.code125-article-layout-2 .code125-article-author-info .code125-hover-author-info a.code125-author-post {
    color: <?php echo $primary_color ?>;
    border-color: <?php echo $primary_color ?>;
}
</style>
