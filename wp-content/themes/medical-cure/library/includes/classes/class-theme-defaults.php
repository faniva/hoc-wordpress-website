<?php

/**
*
*/
class C5_ADD_THEME_DEFAULTS
{

    function __construct()
    {
        add_filter( 'c5_theme_defaults', array($this, 'set_values'));
    }
    public function set_values($defaults)
    {
        $defaults =
        array (
          'skin_default' => '',
          'skin_default_category' => '',
          'skin_default_search' => '',
          'skin_default_archive' => '',
          'skin_default_404' => '',
          'logo' => '',
          'logo_height' => '60',
          'logo_margin' => '15',
          'preload' => 'on',
          'category_styling' => 'on',
          'gallery_style' => 'on',
          'custom_css' => '',
          'custom_js' => '',
          'default_blog_layout' => 'blog-3',
          'meta_data' => 'author_off,time_on,category_off,comment_on,like_on',
          'c5_date_format' => 'date',
          'rtl' => 'ltr',
          'page_width' => 'right',
          'big_sidebar' => 'sidebar',
          'header_style' => 'header-style-1',
          'main_ad' => '',
          'search_on' => 'on',
          'top_bar_enable' => 'on',
          'today_date' => 'on',
          'search_placeholder' => 'Search our website',
          'social_icons' => '',
          'floating_enable' => 'on',
          'floating_logo' => '',
          'floating_logo_height' => '30',
          'floating_logo_margin' => '12',
          'breaking_enable' => 'off',
          'breaking_title' => 'Breaking News',
          'breaking_post_type' => 'post',
          'breaking_orderby' => 'date',
          'breaking_posts_per_page' => '9',
          'breaking_posts' => '',
          'breaking_custom' => '',
          'primary_color' => '#fd5a27',
          'background' => '',
          'heading_font' => 'Open Sans#latin#googlefont',
          'body_font' => 'Lora#latin#googlefont',
          'body_fs' => '14',
          'menu_fs' => '12',
          'title_fs' => '14',
          'article_meta_fs' => '12',
          'article_text_fs' => '16',
          'default_template' => '',
          'cat_template' => '',
          'tag_template' => '',
          'author_template' => '',
          'search_template' => '',
          'archive_template' => '',
          '404_template' => '',
          'facebook_ID' => '',
          'facebook_language' => 'en_US',
          'consumerkey' => '',
          'consumersecret' => '',
          'accesstoken' => '',
          'accesstokensecret' => '',
          'reading_progress_bar' => '3',
          'article_layout' => 'layout_2',
          'article_bg_width' => '1170',
          'article_sidebar' => 'sidebar',
          'article_meta_data' => 'category_on,author_on,time_on,comment_on,like_on,views_on,share_on',
          'article_date_format' => 'date_ago',
          'article_social_media' => 'facebook_on,twitter_on,googleplus_on,linkedin_on',
          'article_before' => '',
          'article_after' => '',
          'enable_article_author' => 'on',
          'enable_facebook' => 'on',
          'enable_wp_comments' => 'on',
          'comments_order' => 'facebook_comments',
          'facebook_color' => 'light',
          'search_post' => 'post',
          'sidebars' => '',
          'menus' => '',
          'custom_fonts' => '',
          'footer_enable' => 'on',
          'footer_columns_count' => '4',
          'footer_advertisement' => '',
          'footer_background' => '#222222',
          'footer_copyrights_enable' => 'on',
          'footer_copyrights' => '<p>2015 - Code125. All Rights Reserved. Designed &amp; Developed by <a href="https://code125.com/out/master/" target="_blank">Code125</a></p>',
        );
        return $defaults;
    }
}
$obj = new C5_ADD_THEME_DEFAULTS();


?>
