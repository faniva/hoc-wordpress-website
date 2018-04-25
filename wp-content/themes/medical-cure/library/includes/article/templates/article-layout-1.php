<?php
$class = '';
if (ot_get_option('page_width') == 'full') {
	$class = 'container';
}

$show = apply_filters('code125_show_page_info' , false);


?>

<article itemscope itemtype="http://schema.org/Article" <?php post_class('code125-article-layout-common code125-article-layout-1 clearfix'); ?>>
    <?php get_template_part( C5_ARTICLES_TEMPLATE  . 'blocks/dominating-category-without-bg' ); ?>

	<?php if(!$show){ ?>
    <header class="entry-header <?= $class ?>">


        <?php get_template_part( C5_ARTICLES_TEMPLATE  . 'blocks/title' ); ?>
        <?php get_template_part( C5_ARTICLES_TEMPLATE  . 'blocks/meta-data-without-category' ); ?>
        <?php get_template_part( C5_ARTICLES_TEMPLATE  . 'blocks/featured-image' ); ?>
        <?php //get_template_part( C5_ARTICLES_TEMPLATE  . 'blocks/bread-crumb' ); ?>
    </header>
	<?php } ?>

    <?php get_template_part( C5_ARTICLES_TEMPLATE  . 'blocks/the-content' ); ?>
    <footer class="entry-footer <?= $class ?>">
        <?php get_template_part( C5_ARTICLES_TEMPLATE  . 'blocks/categories' ); ?>
        <?php get_template_part( C5_ARTICLES_TEMPLATE  . 'blocks/tags' ); ?>
        <?php get_template_part( C5_ARTICLES_TEMPLATE  . 'blocks/disclaimer' ); ?>
        <?php get_template_part( C5_ARTICLES_TEMPLATE  . 'blocks/social-share' ); ?>
        <?php get_template_part( C5_ARTICLES_TEMPLATE  . 'blocks/author-box' ); ?>
        <?php get_template_part( C5_ARTICLES_TEMPLATE  . 'blocks/next-previous' ); ?>
        <?php //get_template_part( C5_ARTICLES_TEMPLATE  . 'blocks/related' ); ?>
        <?php get_template_part( C5_ARTICLES_TEMPLATE  . 'blocks/comments' ); ?>
    </footer>
</article>
