<?php
$obj = new C5_header();
?>

<!-- top bar  -->
<div class="c5-dark-background c5-header-layout-1 c5-top-bar c5-accent-background">
    <!-- container -->
    <div class="container">
        <div class="pull-left">
            <?php $obj->header_info(); ?>
        </div>
        <div class="pull-right">
            <?php $obj->social_icons('layout-5'); ?>
        </div>
    </div>
</div>

<!-- header -->
<header class="c5-header c5-header-layout-1">
    <!-- container -->
    <div class="container">

        <!-- left-col -->
        <div class="pull-left">
            <!-- content -->
            <?php do_action('c5_main_logo'); ?>
            <!-- ./content -->
        </div>
        <!-- ./left-col -->

        <!-- right-col -->
        <div class="pull-right">
            <?php $obj->header_btn(); ?>
        </div>
        <div class="pull-right">
            <?php $obj->get_language_switcher(); ?>
        </div>
        
        <div class="pull-right">
            <?php $obj->main_menu(); ?>
        </div>


        <!-- ./right-col -->

    </div>
    <!-- ./container -->
    <?php do_action('code125_below_header') ?>
</header>
<!-- ./header -->
