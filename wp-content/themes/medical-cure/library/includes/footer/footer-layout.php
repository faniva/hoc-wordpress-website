<?php
$footer_enable = ot_get_option('footer_enable');
if ($footer_enable == 'off') {
    return;
}
?>

<footer class="code125-page-footer">
    <?php
    $footer_source = ot_get_option('footer_source' , 'widegts');
    if ($footer_source == 'cpt') {
        $footer_template = ot_get_option('footer_template');
        if ($footer_template != '') {
            echo do_shortcode( '[c5ab_template id="'.$footer_template.'"]' );
        }
    }else{
        $footer_enable = ot_get_option('footer_background' , '#f3f6f7');
        ?>
        <style>
        .code125-page-footer-main{ background: <?php echo $footer_enable; ?>;}
        </style>

        <div class="code125-page-footer-main">
            <div class="container">
                <!-- row -->
                <div class="row">
                    <?php
                    $footer_enable = ot_get_option('footer_layout' , '4-4-4');
                    $columns = explode('-', $footer_enable );
                    $counter = 1;
                    foreach ($columns as $column) {
                        echo '<div class="col-sm-'.$column.'">';
                        if ( is_active_sidebar( 'c5-footer-'.$counter ) ){
                            dynamic_sidebar('c5-footer-'.$counter );
                        }
                        echo '</div>';
                        $counter++;
                    }
                    ?>
                </div>
                <!-- ./row -->
            </div>
        </div>
        <!-- ./container -->
        <?php } ?>
    </footer>
    <!-- ./footer -->

    <?php
    $footer_copyrights_enable = ot_get_option('footer_copyrights_enable');
    if($footer_copyrights_enable != 'off'){
        ?>
        <!-- footer Bar -->
        <div class="c5-footerbar c5-footerbar-wrap">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">

                    <!-- column left -->
                    <div class="col-md-6 col-sm-6">
                        <?php echo ot_get_option('footer_copyrights'); ?>
                    </div>
                    <!-- ./column left -->

                    <!-- column right -->
                    <div class="col-md-6 col-sm-6">
                        <div class="code125-footer-social pull-right">
                            <?php
                            $obj = new C5_header_base();
                            echo $obj->get_social_icons('layout-3');
                            ?>
                        </div>
                    </div>
                    <!-- ./column right -->

                </div>
                <!-- ./row -->
            </div>
            <!-- ./container -->

            <!-- Back to top Link -->
            <a data-scroll href="#c5-top" class="c5-top-arrow"><i class="fa fa-angle-up"></i></a>
            <!-- ./Back to top Link -->

        </div>
        <!-- ./footer Bar -->
        <?php } ?>
