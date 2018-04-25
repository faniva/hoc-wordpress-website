<?php
$obj = new C5_header();
?>

<!-- header -->
<header class="c5-header c5-header-layout-4 clearfix">


    <!-- left-col -->
    <div class="pull-left">
        <!-- content -->
        <?php do_action('c5_main_logo'); ?>
        <!-- ./content -->
    </div>
    <!-- ./left-col -->

    <!-- right-col -->
    <div class="pull-right">
        <div class="pull-left">
            <?php $obj->main_menu(); ?>
        </div>

        <div class="pull-left">
            <?php $obj->header_btn(); ?>
        </div>
    </div>
    <!-- ./right-col -->

</header>
<!-- ./header -->
