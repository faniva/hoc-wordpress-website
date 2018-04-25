<?php
$obj = new C5_header();
?>

<!-- header -->
<header class="c5-header c5-header-layout-6 clearfix">

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
            <?php $obj->main_menu(); ?>
        </div>

        <!-- ./right-col -->
    </div>

</header>
<!-- ./header -->
