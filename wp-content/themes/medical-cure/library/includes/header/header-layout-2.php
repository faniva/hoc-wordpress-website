<?php
$obj = new C5_header();
?>

<!-- header -->
<header class="c5-header c5-header-layout-2 c5-header-alt">
    <!-- container -->
    <div class="container">

            <!-- left-col -->
            <div class="pull-left">
                <!-- content -->
                <?php do_action('c5_main_logo'); ?>
                <!-- ./content -->
            </div>

            <!-- right-col -->
            <div class="pull-right">
                <div class="pull-left">
                    <?php $obj->header_info_layout_2(); ?>
                </div>
                <div class="pull-right">
                    <?php $obj->header_btn(); ?>
                </div>
            </div>
            <!-- ./right-col -->
    </div>
    <!-- ./container -->
</header>
<!-- ./header -->

<!-- dark-menu -->
<div class="c5-light-background c5-header-layout-2 c5-main-menu-bar">

    <!-- container -->
    <div class="container">

        <!-- Menu -->
        <div class="pull-left">
            <?php $obj->main_menu(); ?>
        </div>
        <!-- Menu -->

        <!-- Search-box -->
        <div class="pull-right">
            <?php $obj->get_search_html(); ?>
        </div>
        <!-- ./Search-box -->

    </div>
    <!-- ./container -->

</div>
<!-- ./dark-menu -->
