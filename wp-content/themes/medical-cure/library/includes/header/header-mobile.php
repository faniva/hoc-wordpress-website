<?php
$obj = new C5_header();
?>

<!-- header -->
<header class="c5-small-header clearfix">
        <!-- logo -->
        <div class="pull-left">
            <span class="fa fa-bars code125-mobile-sidebar-button"></span>
            <?php do_action('c5_main_logo'); ?>
        </div>
        <!-- ./logo -->

        <div class="pull-right">
            <?php $obj->header_btn(); ?>
        </div>

</header>
<!-- ./header -->

<!-- Mobile Nav -->
<div class="c5-mobile-sidebar">

    <a href="javascript:;" class="c5-menu-hide pull-right">
        <span class="fa fa-close"></span>
    </a>

    <!-- Logo -->
    <?php do_action('c5_main_logo'); ?>
    <!-- ./Logo -->

<div class="clearfix"></div>

    <!-- light-menu -->
    <div class="">
        <?php $obj->main_menu('main-nav', 'c5-side-menu') ?>
    </div>
    <!-- ./light-menu -->
    <div class="clearfix"></div>

    <?php $obj->header_info_mobile(); ?>


    <div class="clearfix"></div>

    <!-- Search-box -->
    <div class="code125-mobile-search">
        <?php echo $obj->get_search_html(); ?>
    </div>
    <!-- ./Search-box -->
    <div class="clearfix"></div>

    <?php $obj->social_icons('layout-4'); ?>


    <?php do_action('code125_below_header') ?>

</div>
<!-- ./Mobile Nav -->
