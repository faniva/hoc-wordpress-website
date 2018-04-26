<?php
if (isset($_SERVER['HTTP_ACCEPT_ENCODING'])) {
    $header_encoding = $_SERVER['HTTP_ACCEPT_ENCODING'];

    if (strpos($header_encoding, 'gzip')) {
        ob_start("ob_gzhandler");
    }
}

$header_css = new C5_header_css();
$header_css->hook();

?>
<!doctype html>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <?php // Google Chrome Frame for IE     ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <?php // mobile meta (hooray!)  ?>
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale = 1.0">
    <link rel="pingback" href="<?php esc_url( bloginfo('pingback_url')); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div id="fb-root"></div>
    <?php $header_object = new HOC_Header(); ?>
    <div class="c5-body-wrap">
    <?php
        $header_object->loader();
        get_template_part('library/includes/header/header-layout-floating');
        get_template_part('library/includes/header/header-mobile');
        get_template_part('library/includes/header/hoc_header');
        echo '<div id="floating-trigger"></div>';

        if(class_exists('HOC_Page_Info')){
            $page_info = new HOC_Page_Info();
            $page_info->render();
        }

    ?>
