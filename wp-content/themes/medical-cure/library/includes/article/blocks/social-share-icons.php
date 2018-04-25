<?php

$settings_obj = new C5_theme_options();
$value = $settings_obj->get_meta_option('article_social_media');

$meta_data = '';
if ($value=='') {
    $value = 'facebook_on,twitter_on,googleplus_on,linkedin_on';
}
$raw_data = explode(',', $value );

$valid_meta_data = array();
if(!empty($raw_data)){
    foreach ($raw_data as $meta_data) {
        $single_value = explode('_', $meta_data);
        if (isset($single_value[1])) {
            if ($single_value[1]=='on') {
                $valid_meta_data[] = $single_value[0];
            }
        }
    }
}


if (!empty($valid_meta_data)) {
    $meta_data = '<div class="code125-article-share"><ul>';
    $current_data = '';
    foreach ($valid_meta_data as $single_data) {

        switch ($single_data) {
                //facebook
            case 'facebook':
                $current_data .= '<li><a class="c5-social facebook" href="https://www.facebook.com/sharer.php?u='. urlencode(get_permalink()) .'"><span class="fa fa-facebook"></span></a></li>';

                break;
                //twitter
            case 'twitter':
                $current_data .= '<li><a class="c5-social twitter" href="https://twitter.com/share?text=' . get_the_title()  .'"><span class="fa fa-twitter"></span></a></li>';

                break;
                //googleplus
            case 'googleplus':
                $current_data .= '<li><a class="c5-social google" href="https://plus.google.com/share?url='. urlencode(get_permalink())  .'"><span class="fa fa-google-plus"></span></a></li>';

                break;
            case 'linkedin':
                //linkedin
                $post_obj = new C5_post();
                $url = 'https://www.linkedin.com/shareArticle?mini=true&url='. urlencode(get_permalink()) .'&title='.get_the_title().'&summary='.$post_obj->get_the_excerpt_max_charlength(300) ;

                $current_data .= '<li><a class="c5-social linkedin" href="'.$url.'"><span class="fa fa-linkedin"></span></a></li>';
                break;
            default:
                break;
        }
    }
    if ($current_data=='') {
        return '';
    }
    $meta_data .= $current_data . '</ul></div>';
    echo $meta_data;
}
?>
