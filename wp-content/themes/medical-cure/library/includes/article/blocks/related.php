<?php
$settings_obj = new C5_theme_options();
$post_obj = new C5_post();
global $post;


$related_type = $settings_obj->get_meta_option('related_type');
$post_count = 6;

$args = array(
    'post__not_in' => array($post->ID),
    'posts_per_page' => $post_count, // Number of related posts that will be shown.
    'ignore_sticky_posts' => 1
);
if ($related_type == 'tags') {
    $tags = wp_get_post_tags($post->ID);

    if ($tags) {
        $tag_ids = array();
        foreach ($tags as $individual_tag) {
            $tag_ids[] = $individual_tag->term_id;
        }
        $args['tag__in'] = $tag_ids;
    } else {
        $args['orderby'] = 'rand';
    }
} elseif ($related_type == 'category') {
    $tax = c5_get_post_tax(get_the_ID());
    $cat = $post_obj->get_dominaiting_category();
    if ($tax = 'category') {
        $args['cat'] = $cat;
    } else {
        $args['tax_query'] = array(
            array(
                'taxonomy' => $tax,
                'field' => 'id',
                'terms' => $cat
            )
        );
    }
} else {
    $args['orderby'] = 'rand';
}


// Getting args
$query_object = new C5_BLOG_QUERY();

$slider_id = $query_object->get_unique_id();
$slider_wrap = $query_object->get_unique_id();

// the query
$the_query = new WP_Query( $args ); ?>

<?php if ( $the_query->have_posts() ) : ?>

    <div class="c5-related-wrap  clearfix">

        <h3 class="title"><?php  esc_html_e('Related Stories', 'medical-cure'); ?></h3>

        <section class="posts-blocks">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- carousel -->
                        <div class="c5-post-45-carousel c5-slide-carousel-<?php echo $slider_id ?> c5-slider-<?php echo $slider_wrap ?>">
                            <ul class="slides">
                                <?php
                                $temp_value = $GLOBALS['c5_content_width'];
                                if ($GLOBALS['c5_content_width'] < 400) {
                                    $count = 1;
                                }elseif($GLOBALS['c5_content_width'] < 900 ){
                                    $count = 3;
                                }else{
                                    $count = 4;
                                }
                                $GLOBALS['c5_content_width'] = round(( $GLOBALS['c5_content_width'] - ( ($count-1) * 30) )/$count);
                                ?>
                                <!-- the loop -->
                                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                                    <?php get_template_part(C5_BLOGS_TEMPLATE . 'sliders/elements/slider-element-11');?>
                                <?php endwhile; ?>
                                <!-- end of the loop -->
                            </ul>

                            <!-- nav -->
                            <div class="c5-slide-carousel-nav-47">

                                <!-- prev -->
                                <a href="javascript:;" class="flex-prev">
                                    <span class="fa fa-angle-left"></span>
                                </a>
                                <!-- ./prev -->

                                <!-- next -->
                                <a href="javascript:;" class="flex-next">
                                    <span class="fa fa-angle-right"></span>
                                </a>
                                <!-- ./next -->

                            </div>
                            <!-- ./nav -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ./carousel -->
    </div>

    <?php wp_reset_postdata(); ?>


    <?php
    $GLOBALS['c5_posts_slider_js'] .= '$(".c5-slide-carousel-'.$slider_id.'").css("display","block");';
    $GLOBALS['c5_posts_slider_js'] .= '$(".c5-slide-carousel-'.$slider_id.'").slick();';


    $GLOBALS['c5_content_width'] = $temp_value;
    ?>

<?php else : ?>

<?php endif; ?>
