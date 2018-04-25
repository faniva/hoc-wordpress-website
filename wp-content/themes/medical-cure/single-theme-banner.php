<?php get_header(); ?>
<div id="main" class=" clearfix">


    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

            <section class="entry-content clearfix">
                <div class="">
                    <?php
                    c5_check_mobile_width();
                    the_content();
                    ?>
                </div>
            </section>

        </article>



    <?php endwhile; ?>
<?php endif; ?>

</div>

<?php get_footer(); ?>
