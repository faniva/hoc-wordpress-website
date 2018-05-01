<?php
/**
 * @author Jose Fano
 */
class HOC_Page_Info extends C5_Page_Info
{


    public function page()
    {
        if (class_exists('WooCommerce')) {
            $page_id = c5_wc_get_current_page();
        }else{
            $page_id = get_the_ID();
        }
        $custom_top_content = get_post_meta($page_id , 'custom_top_content' , true);
        if ($custom_top_content!='') {
            ?>

            <div id="hero-slider">
                <div class="hero-slider-wrapper">
                    <div class="hoc-slider">
                        <?php  echo do_shortcode( $custom_top_content );  ?>
                    </div>

                    <div class="hoc-slider-nav" role="navigation">
                        <div>
                            <div class="navigation-title">QUICK LINKS</div>
                            <ul>
                                <li class="breast-cancer"><a href="#"><span>Breast Cancer</span></a></li>
                                <li class="lung-cancer"><a href=""><span>Lung Cancer</span></a></li>
                                <li class="colon-cancer"><a href=""><span>Colon Cancer Treatments</span></a></li>
                                <li class="lymphoma"><a href=""><span>Lymphoma & Meloma Treatments</span></a></li>
                                <li class="infusion"><a href=""><span>Infusion Therapies</span></a></li>
                                <li class="molecular-risk"><a href=""><span></span>Cancer Molecular Risk Testing</a></li>
                            </ul>
                        </div>


                    </div>

                </div>
            </div>

            <?php
            return;
        }

        $banner_slides = get_post_meta($page_id , 'banner_slides' , true);
        if ($banner_slides!='') {

            ?>

            <div id="hero-slider">
                <?php  echo do_shortcode( '[c5_banner_slider posts="'.$banner_slides.'"]' );  ?>
            </div>

            <?php

            return;
        }

        if (is_page()) {
            $header_layout =  get_post_meta($page_id , 'header_layout' , true);
            if ($header_layout == '' || $header_layout == 'default') {
                $header_layout = ot_get_option('header_layout');
            }
        }else{
            $header_layout = ot_get_option('header_layout');
        }

        $header_layout = HOC_Header::validate_layout($header_layout);

        ?>

        <!-- Page-intro -->
        <section class="c5-page-info c5-header-layout-<?php echo $header_layout ?> c5-no-padding <?php echo $this->classes; ?> c5-no-background">
            <?php if (!$this->is_video ){ ?>
                <style>
                    <?php echo $this->background_css($this->image_class , $this->image ); ?>
                </style>
                <!-- inner -->
            <?php } ?>
            <div class="c5-page-info-inner">
                <?php
                if ($this->layout == 'layout-1') {
                    $hex = ot_get_option('primary_color' , '#0065b3');
                    if(is_rtl()){
                        ?>
                        <svg class="code125-title-seperator-left" preserveAspectRatio="none"  viewBox="0 0 100 200" data-height="200">
                            <polygon style="fill: <?php echo $hex; ?>;" points="0,0 100,0 100,200 "></polygon>
                        </svg>
                        <?php
                    }else{
                        ?>
                        <svg class="code125-title-seperator-left" preserveAspectRatio="none"  viewBox="0 0 100 200" data-height="200">
                            <polygon style="fill: <?php echo $hex; ?>;" points="0,0 100,0 0,200 "></polygon>
                        </svg>
                        <?php
                    }
                }

                if ($this->is_video ){ ?>
                    <div class="c5-video-background clearfix">
                        <video preload="auto" autoplay="autoplay" loop="loop" >
                            <source src="<?php $this->video_url(); ?>" type="video/mp4"></video>
                    </div>
                <?php } ?>
                <!-- c5-page-info-wrap -->
                <div class="c5-page-info-wrap">
                    <!-- container -->
                    <div class="container">
                        <!-- content -->
                        <div class="c5-content ">
                            <?php echo $this->breacrumb_object->author_image();?>
                            <h1 class="entry-title"><?php echo $this->breacrumb_object->title(); ?></h1>
                            <?php echo $this->breacrumb_object->description(); ?>

                        </div>
                        <!-- ./content -->
                        <?php if ($this->layout == 'layout-3') { ?>
                            <!-- breadcrumb -->
                            <div class="c5-breadcrumb code125-side-breadcrumb">
                                <?php $this->breacrumb_object->render(); ?>
                            </div>
                            <!-- ./breadcrumb -->
                        <?php } ?>
                    </div>
                    <!-- ./container -->



                </div>
                <!-- ./c5-page-info-wrap -->
            </div>
            <!-- ./inner -->
            <?php if ($this->layout != 'layout-3') { ?>
                <!-- breadcrumb -->
                <div class="c5-breadcrumb">
                    <!-- container -->
                    <div class="container">
                        <?php

                        $this->breacrumb_object->render();
                        ?>
                    </div>
                    <!-- ./container -->
                </div>
                <!-- ./breadcrumb -->
            <?php } ?>

        </section>
        <!-- ./page-intro -->

        <?php
    }



}


?>
