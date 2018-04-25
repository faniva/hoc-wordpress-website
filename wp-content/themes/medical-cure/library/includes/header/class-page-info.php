<?php
/**
*
*/
class C5_Page_Info
{
    public $show = true;
    public $is_video = false;
    public $attachment_id = '';
    public $darkness = 'c5-dark-background';
    public $image = array();
    public $video_class = '';
    public $ID = '';
    public $classes = '';
    public $layout = 'layout-1';
    public $image_class = '';
    public $breacrumb_object;

    function __construct()
    {
        $this->show = $this->show();
        if (!$this->show) {
            return;
        }
        if (is_page()) {
            $page_info = get_post_meta( get_the_ID(), 'page_info_layout', true );
            if ($page_info != '' && $page_info != 'default') {
                $this->layout = $page_info;
            }else{
                $this->layout = ot_get_option('page_info_layout' , 'layout-1');
            }

        }else{
            $this->layout = ot_get_option('page_info_layout' , 'layout-1');
        }


        $this->breacrumb_object = new C5_bread_crumb();
        $this->is_video = $this->is_video();
        if(!$this->is_video){
            $this->attachment_id = $this->get_attachment_ID();
        }else{
            $this->video_class = ' c5-video-banner ';
        }
        $this->darkness = $this->darkness();

        $this->image = $this->get_image();
        $this->ID = $this->get_ID();

        if ($this->layout == 'layout-1') {
            $this->image_class = '.c5-page-info.c5-page-info-'.$this->ID.' .c5-page-info-inner:after';
        }elseif ($this->layout == 'layout-2' || $this->layout == 'layout-4' ) {
            $this->image_class = '.c5-page-info.c5-page-info-'.$this->ID.' .c5-page-info-inner';
        }

        $this->align_class = ot_get_option('page_info_layout');

        $classes = array(
            $this->align_class,
            $this->darkness,
            $this->video_class
        );
        if(is_single()){
            $classes[] = 'c5-single-article';
        }
        if(is_author()){
            if ($this->layout == 'layout-2') {
                $classes[] = 'c5-centered';
            }
            $classes[] = 'c5-author-profile';
        }
        $classes[] = 'c5-page-info-' . $this->ID;
        $classes[] = 'code125-page-info-' . $this->layout;
        $this->classes = implode(' ', $classes);
    }
    public function get_attachment_ID()
    {
        if (is_page() || is_single() ) {

            $post_type = get_post_type();
            if ($post_type == 'staff') {
                $banner_bg  = get_post_meta( get_the_ID() , 'banner_bg' , 'true');
                if ($banner_bg != '') {
                    $attachment_id = c5ab_get_attachment_id_from_src($banner_bg);
                    if($attachment_id){
                        return $attachment_id;
                    }
                }
            }else{
                if (class_exists('WooCommerce')) {
                    $page_id = c5_wc_get_current_page();
                }else{
                    $page_id = get_the_ID();
                }
                $custom_background  = get_post_meta( $page_id , 'custom_background' , 'true');
                if ($custom_background != '') {
                    $attachment_id = c5ab_get_attachment_id_from_src($custom_background);
                    if($attachment_id){
                        return $attachment_id;
                    }
                }
                $attachment_id = get_post_thumbnail_id( $page_id );
                if ($attachment_id!= '') {
                    return $attachment_id;
                }
            }

        }elseif(is_category() || is_tax()|| is_tag()  ){
            $obj = get_queried_object();
            $term_id = $obj->term_id;
            $tax = $obj->taxonomy;

            $cover = get_option( 'c5_term_meta_' . $tax .'_'. $term_id .'_custom_cover' );
            if ($cover!='') {
                $attachment_id = c5ab_get_attachment_id_from_src($cover);
                if($attachment_id){
                    return $attachment_id;
                }
            }
        }elseif(is_author()){
            $obj = get_queried_object();

            $cover = get_the_author_meta('c5_term_meta_user_cover', $obj->ID);
            if ($cover!='') {
                $attachment_id = c5ab_get_attachment_id_from_src($cover);
                if($attachment_id){
                    return $attachment_id;
                }
            }
        }
        if ($this->layout == 'layout-2' || $this->layout == 'layout-4') {
            $default_banner = ot_get_option('default_banner');
            $attachment_id = c5ab_get_attachment_id_from_src($default_banner);
            if($attachment_id){
                return $attachment_id;
            }
        }
    }
    public function show()
    {
        $show = true;
        if (is_home() ) {
            $show =  false;
        }
        if (is_single()) {
            $show =  false;
        }
        if (is_404()) {
            $show =  false;
        }
        if ( is_post_type_archive() ) {
            $show = true;
        }
        if (is_page( )) {
            if (class_exists('WooCommerce')) {
                $page_id = c5_wc_get_current_page();
            }else{
                $page_id = get_the_ID();
            }
            $enable_breadcrumb = get_post_meta($page_id , 'enable_breadcrumb' , true);
            if ($enable_breadcrumb == 'off') {
                $show = false;
            }

        }

        $show = apply_filters('code125_show_page_info' , $show);

        return $show;
    }
    public function is_video()
    {
        if (is_page( )) {
            if (class_exists('WooCommerce')) {
                $page_id = c5_wc_get_current_page();
            }else{
                $page_id = get_the_ID();
            }
            $page_info_video = get_post_meta($page_id , 'page_info_video' , true);
            if ($page_info_video != '') {
                return true;
            }
        }
        return false;
    }
    public function video_url()
    {
        if (is_page( )) {
            if (class_exists('WooCommerce')) {
                $page_id = c5_wc_get_current_page();
            }else{
                $page_id = get_the_ID();
            }
            $page_info_video = get_post_meta($page_id , 'page_info_video' , true);
            if ($page_info_video != '') {
                echo $page_info_video;
            }
        }
    }
    public function get_image()
    {
        if ($this->layout == 'layout-1') {
            $width = max(0.7*$GLOBALS['c5_content_width'] , 400);
        }else{
            $width = $GLOBALS['c5_content_width'];
        }
        if ($width == 1170) {
            $width = 1280;
        }


        $image_size = c5ab_generate_image_size($width , 300 , true );
        $image_attributes = c5_wp_get_attachment_image_src( $this->attachment_id , $image_size);
        if (is_array($image_attributes)) {
            $img = array($image_attributes[0], $image_attributes[3]);
            if ($width == 1280) {
                $width = 1600;
                $image_size = c5ab_generate_image_size($width , 300 , true );
                $images_1600 = c5_wp_get_attachment_image_src( $this->attachment_id , $image_size);
                $img[2] = isset($images_1600[0]) ? $images_1600[0] : '';
                $img[3] = isset($images_1600[3]) ? $images_1600[3] : '';

                $width = 1920;
                $image_size = c5ab_generate_image_size($width , 300 , true );
                $images_1920 = c5_wp_get_attachment_image_src( $this->attachment_id , $image_size);
                $img[4] = isset($images_1920[0]) ? $images_1920[0] : '';
                $img[5] = isset($images_1920[3]) ? $images_1920[3] : '';
            }
            return $img;
        }
        if ($this->layout == 'layout-2' || $this->layout == 'layout-4') {
            $default_image = array(C5_URI .'library/images/default-cover.jpg');
            return $default_image;
        }
    }
    public function darkness()
    {
        $class = 'c5-dark-background';
        if ($this->layout == 'layout-3'  ) {
            return '';
        }
        return $class;
        //
        // if ($this->is_video()) {
        //     return $class;
        // }
        // if($this->attachment_id != ''){
        //     $obj = new Code125_Colors();
        //     $colors = $obj->get_colors($this->attachment_id , true);
        //     $class = $colors['average']['class'];
        //     $class .= ' c5-lum-' . $colors['average']['lum'];
        // }
        //
        // return $class;

    }
    public function render()
    {
        if (!$this->show) {
            return;
        }

        $this->page();
    }

    public function page()
    {
        if (class_exists('WooCommerce')) {
            $page_id = c5_wc_get_current_page();
        }else{
            $page_id = get_the_ID();
        }
        $custom_top_content = get_post_meta($page_id , 'custom_top_content' , true);
        if ($custom_top_content!='') {
            echo do_shortcode( $custom_top_content );
            return;
        }

        $banner_slides = get_post_meta($page_id , 'banner_slides' , true);
        if ($banner_slides!='') {
            echo do_shortcode( '[c5_banner_slider posts="'.$banner_slides.'"]' );
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
        $header_obj = new C5_header();
        $header_layout = $header_obj->validate($header_layout)
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



    function get_ID(){
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 6; $i++) {
            $randstring .= $characters[rand(0, strlen($characters)-1 )];
        }
        return $randstring;
    }
    function background_css( $element ,  $image_data ){
        $css = '';

        $css .= $element . '{background-image:url(\'' . $image_data[0] . '\');}';


        if (isset($image_data[1]) && $image_data[1]!= '') {
            $css .= ' @media
            only screen and (-webkit-min-device-pixel-ratio: 2),
            only screen and (   min--moz-device-pixel-ratio: 2),
            only screen and (     -o-min-device-pixel-ratio: 2/1),
            only screen and (        min-device-pixel-ratio: 2),
            only screen and (                min-resolution: 192dpi),
            only screen and (                min-resolution: 2dppx) { ';
                $css .= $element . '{background-image:url(\'' . $image_data[1] . '\');}';
                $css .= '}';
        }

        if (isset($image_data[2]) && $image_data[2]!= '') {
            $css .= ' @media
            only screen and (min-width: 1281px) { ';
                $css .= $element . '{background-image:url(\'' . $image_data[2] . '\');}';
                $css .= '}';
        }
        if (isset($image_data[3]) && $image_data[3]!= '') {
            $css .= ' @media
            only screen and (-webkit-min-device-pixel-ratio: 2) and (min-width: 1281px),
            only screen and (   min--moz-device-pixel-ratio: 2) and (min-width: 1281px),
            only screen and (     -o-min-device-pixel-ratio: 2/1) and (min-width: 1281px),
            only screen and (        min-device-pixel-ratio: 2) and (min-width: 1281px),
            only screen and (                min-resolution: 192dpi) and (min-width: 1281px),
            only screen and (                min-resolution: 2dppx) and (min-width: 1281px) { ';
                $css .= $element . '{background-image:url(\'' . $image_data[3] . '\');}';
                $css .= '}';
        }

        if (isset($image_data[4]) && $image_data[4]!= '') {
            $css .= ' @media
            only screen and (min-width: 1601px) { ';
                $css .= $element . '{background-image:url(\'' . $image_data[4] . '\');}';
                $css .= '}';
        }
        if (isset($image_data[5]) && $image_data[5]!= '') {
            $css .= ' @media
            only screen and (-webkit-min-device-pixel-ratio: 2) and (min-width: 1601px) ,
            only screen and (   min--moz-device-pixel-ratio: 2) and (min-width: 1601px) ,
            only screen and (     -o-min-device-pixel-ratio: 2/1) and (min-width: 1601px) ,
            only screen and (        min-device-pixel-ratio: 2) and (min-width: 1601px) ,
            only screen and (                min-resolution: 192dpi) and (min-width: 1601px) ,
            only screen and (                min-resolution: 2dppx) and (min-width: 1601px) { ';
                $css .= $element . '{background-image:url(\'' . $image_data[5] . '\');}';
                $css .= '}';
        }


            return $css;
        }
    }


    ?>
