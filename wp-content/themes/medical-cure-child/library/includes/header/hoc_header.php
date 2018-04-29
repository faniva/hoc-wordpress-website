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
<!--            --><?php //do_action('c5_main_logo'); ?>

            <?php

                $home_url = apply_filters('c5_logo_url' , esc_url( home_url('/') ) );

                $src = HOC_URI . 'library/images/hoc-logo-opt.svg';

                $format = '<div class="c5-logo">
                                <a  href="%s" rel="nofollow">
                                    <img alt="Logo" src="%s" width="260" />
                                </a>
                            </div>';

                $data = sprintf($format, $home_url, $src);

                echo $data;


            ?>

            <!-- ./content -->
        </div>

        <!-- right-col -->
        <div class="pull-right">
            <div class="pull-left">
                <div class="c5-info-top-bar clearfix">
                    <ul>
                        <li><a href="tel:+17324834501"><i class="c5-header-icon flaticon-technology-2"></i><span class="title">+1 732-483-4501</span><span class="subtitle">Call Us Today!</span></a></li>
                        <li><i class="c5-header-icon flaticon-clock-1"></i><span class="title">Mon-Sat: 08am - 7pm</span><span class="subtitle">Sunday: Off</span></li>
                    </ul>
                </div>


                <a href="#" class="patient-area"><i class="c5-header-icon flaticon-doctor-1">&nbsp;</i>Patient Area</a>

                <?php $obj->social_icons('layout-3'); ?>

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
<div class="c5-dark-background c5-header-layout-2 c5-header-layout-3 c5-main-menu-bar c5-accent-background">

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
