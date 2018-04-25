<?php
$obj = new C5_header();
$floating_enable = ot_get_option('floating_enable', 'on');
if ($floating_enable == 'off') {
    return;
}
?>

<!-- floating header -->
<div class="c5-floating-header clearfix">


    <!-- left-col -->
    <div class="pull-left">
        <!-- content -->
        <?php do_action('c5_floating_logo'); ?>
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

</div>
<!-- ./header -->
