<div id="main" class=" clearfix">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php setPostViews(get_the_ID());

        $class = '';
        $c5_rtl = get_post_meta(get_the_ID() , 'c5_rtl' , true);
        if ($c5_rtl == 'on') {
            $class = 'rtl';
        }

        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(' clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
            <section class="entry-content c5-doctor-single c5-staff-single-content c5-article-content <?php echo $class; ?> clearfix" itemprop="articleBody">
                <div class="container">
                    <div class="col-sm-4">
                        <?php
                        $image_size = c5ab_generate_image_size(350, 99999, false);
                        $attachment_id = get_post_thumbnail_id();
                        $src= '';
                        $src_2x = '';
                        $image_attributes = c5_wp_get_attachment_image_src($attachment_id , $image_size , false );
                        if ($image_attributes) {
                            $src = $image_attributes[0];
                            $src_2x = $image_attributes[3];
                        }
                        if ($src!='') {

                            $src_set = $src .' 1x';
                            if ($src_2x != '') {
                                $src_set .= ', '.$src_2x. ' 2x';
                            }
                            echo '<figure class="c5-ds-img">';
                            echo '<img src="'.$src.'" srcset="'.$src_set.'" alt="'.get_the_title().'" />';
                            echo '</figure>';
                        }
                        ?>
                        <div class="c5-content">


                            <div class="code125-doctor-main-info clearfix">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                            <?php $subtitle = get_post_meta(get_the_ID() , 'subtitle' , true);
                            if ($subtitle!='') {
                                echo '<p class="subtitle">'.$subtitle.'</p>';
                            }
                            echo '</div>';

                            $other_staff_info = get_post_meta(get_the_ID() , 'other_staff_info' , true);
                            if (!empty($other_staff_info)) {
                                ?>
                                <div class="code125-doctor-single-info">
                                    <h4><?php  esc_html_e('Personal Information', 'medical-cure'); ?></h4>
                                    <ul>
                                        <?php
                                        foreach ($other_staff_info as $single_info) {
                                            if ($single_info['value'] != '') {
                                                if ($single_info['link']!= '') {
                                                    $single_info['value'] = '<a href="'.$single_info['link'].'">' . $single_info['value'] . '</a>';
                                                }
                                                ?>
                                                <li  class="clearfix"><span class="title"><?php echo $single_info['title']; ?></span><span class="value"><?php echo $single_info['value']; ?></span></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <?php
                            }

                            $contact_info = get_post_meta(get_the_ID() , 'contact_info' , true);
                            if (!empty($contact_info)) {
                                ?>
                                <div class="code125-doctor-single-info contact-information">
                                    <h4><?php  esc_html_e('Contact Information', 'medical-cure'); ?></h4>
                                    <?php
                                    $icons = array();
                                    foreach ($contact_info as $social_icon) {
                                        $icons[] = array(
                                            'icon'=> $social_icon['icon'],
                                            'link' => $social_icon['link'],
                                            'title' => $social_icon['title'],
                                        );
                                    }
                                    $instance = array(
                                        'layout' => 'layout-2',
                                        'c5ab_social_icon' => $icons
                                    );
                                    echo code125_do_shortcode( 'C5AB_social_icons', $instance);
                                    ?>
                                </div>
                                <?php
                            }

                            $time_table = get_post_meta(get_the_ID() , 'time_table' , true);
                            if (!empty($time_table)) {
                                ?>
                                <div class="code125-doctor-single-info schedule">
                                    <h4><?php  esc_html_e('Schedule', 'medical-cure'); ?></h4>
                                    <ul>
                                        <?php
                                        foreach ($time_table as $single_info) {
                                            if ($single_info['value'] != '') {
                                                ?>
                                                <li class="clearfix"><span class="title"><?php echo $single_info['title']; ?></span><span class="value"><?php echo $single_info['value']; ?></span></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <?php
                            }

                            $social_profile = get_post_meta(get_the_ID() , 'social_profile' , true);
                            if ($social_profile) {
                                $icons = array();
                                foreach ($contact_info as $social_icon) {
                                    $icons[] = array(
                                        'icon'=> $social_icon['icon'],
                                        'link' => $social_icon['link'],
                                        'title' => $social_icon['title'],
                                    );
                                }
                                $instance = array(
                                    'layout' => 'layout-3',
                                    'c5ab_social_icon' => $icons
                                );
                                echo code125_do_shortcode( 'C5AB_social_icons', $instance);
                            }

                            ?>

                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="code125-article-layout-common code125-article-layout-staff ">
                            <div class="entry-content">
                            <?php
                            //main article content
                            the_content();

                            wp_link_pages(
                                array(
                                    'before' => '<div class="c5-pagination-article clearfix"><nav class="page-links pagination c5-pagination"><ul class="page-numbers"><li><span class="page-links-title">' . __('Pages:', 'medical-cure') . '</span></li>',
                                    'after' => '</ul></nav></div>',
                                    'link_before' => '<li><span class="num">',
                                    'link_after' => '</span></li>'
                                    )
                                );
                                ?>
                            </div>
                        </div>
                    </div>
                    </div>
                </section>
            </article>

        <?php endwhile; ?>

    <?php else : ?>

        <article id="post-not-found" class="hentry clearfix">
            <header class="article-header">
                <h1><?php esc_html_e('Oops, Post Not Found!', 'medical-cure'); ?></h1>
            </header>
            <section class="entry-content">
                <p><?php esc_html_e('Uh Oh. Something is missing. Try double checking things.', 'medical-cure'); ?></p>
            </section>
            <footer class="article-footer">
                <p><?php esc_html_e('This is the error message in the single.php template.', 'medical-cure'); ?></p>
            </footer>
        </article>

    <?php endif; ?>

</div>
