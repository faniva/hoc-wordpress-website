<h1 class="entry-title "><?php the_title() ?></h1>
<?php
$settings_obj = new C5_theme_options();
$article_title_fs = $settings_obj->get_meta_option('article_title_fs','40');
?>
<style>
    .code125-article-layout-common .entry-title{
        font-size: <?php echo $article_title_fs ?>px;
    }
</style>
