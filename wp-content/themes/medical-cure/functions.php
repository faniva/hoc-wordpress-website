<?php


add_filter('c5ab_theme_mode', '__return_true');

define('C5_SIMPLE_OPTION', true);
$GLOBALS['c5-in-article'] =false;
$GLOBALS['c5_content_width'] = 1170;
$GLOBALS['c5_sidebar_active'] = false;



define('C5_LOCAL_OPTIONS_IMG_URL', apply_filters( 'code125_images_path', '' ));

define('C5_ROOT', get_parent_theme_file_path() . '/');
define('C5_URI', get_parent_theme_file_uri() . '/');

if ( ! isset( $content_width ) ) $content_width = 740;

global $c5_skindata;
$c5_skindata = array();


require_once(C5_ROOT . 'library/bones.php' );
require_once(C5_ROOT . 'library/framework/loader.php' );
require_once(C5_ROOT . 'library/includes/loader.php' );
require_once(C5_ROOT . 'languages/translation.php' );

add_filter('c5ab_setting_before_full' , 'c5_theme_c5ab_setting_before_full');
add_filter('c5ab_setting_after_full' , 'c5_theme_c5ab_setting_after_full');
function c5_theme_c5ab_setting_before_full($option) {
    global $c5_skindata;
    if (isset($c5_skindata['page_width']) && $c5_skindata['page_width'] == 'full') {
        return '</div>';
    }
    return $option;
}
function c5_theme_c5ab_setting_after_full($option) {
    global $c5_skindata;
    if (isset($c5_skindata['page_width']) && $c5_skindata['page_width'] == 'full') {
        return '<div class="container">';
    }
    return $option;
}

add_filter('pre_get_posts',  'c5_theme_search_filter' );
function c5_theme_search_filter($query)
{
    if (defined('DOING_AJAX') && DOING_AJAX) {
        return $query;
    }

    if ($query->is_search)
    {
        $query->set('post_type', ot_get_option('search_post','post'));
    }
    return $query;

}


function c5_import_admin_js($hook) {


    wp_enqueue_style( 'c5-admin-ss', get_template_directory_uri() . '/library/css/admin.css' );
    wp_register_script( 'admin-import-js', get_template_directory_uri() . '/library/js/js-admin.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'admin-import-js' );
}
add_action( 'admin_enqueue_scripts', 'c5_import_admin_js' );

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function c5_register_sidebars() {
    $all_sidebars = array(
        array(
            'id'=>'sidebar',
            'name'=>  esc_html__( 'Primary Sidebar' ,'medical-cure'),
            'description' => esc_html__( 'Default Sidebar for All Pages' ,'medical-cure')
        ),
        array(
            'id'=>'article',
            'name'=> esc_html__( 'Article Sidebar' ,'medical-cure'),
            'description' => esc_html__( 'Default Sidebar for Articles' ,'medical-cure')
        ),
        array(
            'id'=>'departments',
            'name'=> esc_html__( 'Departments' ,'medical-cure'),
            'description' => esc_html__( 'Departments Sidebar' ,'medical-cure')
        ),
    );
    if(class_exists( 'WooCommerce' )){
        $all_sidebars[] =  array(
            'id'=>'shop_sidebar',
            'name'=> esc_html__( 'Shop Sidebar' ,'medical-cure'),
            'description' => esc_html__( 'Shop Sidebar' ,'medical-cure')
        );
    }
    $footer_enable = esc_attr( ot_get_option('footer_layout' , '4-4-4'));
    $footer_columns_count = count(explode('-', $footer_enable ));

    $counter = 1;
    while ($footer_columns_count > 0) {
        $all_sidebars[] = array(
            'id'=>'c5-footer-'.$counter,
            'name'=> esc_html__( 'Footer Column #' ,'medical-cure'). $counter,
            'description' => esc_html__( 'Footer Column'  ,'medical-cure') . ' '.$counter. ' '.  esc_html__( 'Content' ,'medical-cure')
        );
        $footer_columns_count--;
        $counter++;
    }


    $sidebars = ot_get_option('sidebars', array());
    if ($sidebars) {
        foreach ($sidebars as $sidebar) {
            $all_sidebars[] = array(
                'id'=> esc_attr( $sidebar['slug']),
                'name'=> esc_attr( $sidebar['title']),
                'description' => esc_attr( $sidebar['description'])
            );
        }
    }

    foreach ($all_sidebars as  $sidebar) {
        register_sidebar(array(
            'id' => esc_attr( $sidebar['id']) ,
            'name' => esc_attr( $sidebar['name'] ),
            'description' => esc_attr( $sidebar['description']),
            'before_widget' => '<div id="%1$s" class="widget c5_al_widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }


} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/

// Comment Layout
function c5_comments( $comment, $args, $depth ) {
    ?>
    <li <?php comment_class(); ?>>
        <article id="comment-<?php comment_ID(); ?>" class="clearfix">
            <div class="comment-author vcard clearfix">
                <?php
                echo '<figure class="c5-img">';
                $avatar_args = array(
                    'class' => 'img-circle'
                );
                echo get_avatar( $comment , '64' , '' ,'', $avatar_args );
                echo '</figure>';

                echo '<div class="c5-content">';
                echo '<div class="c5-author">';

                $article_author = get_the_author_meta( 'ID' );
                $span = $article_author == $comment->user_id ? '<span class="code125-comment-article-author">'.esc_html__('Author','medical-cure').'</span>' : '';

                echo '<cite class="fn">'.get_comment_author_link() . $span .'</cite>';
                ?>
                <time class="time_class" datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time('F jS, Y'); ?> </a></time>
                <?php edit_comment_link(__('(Edit)', 'medical-cure'),'  ',''); ?>

            </div>

            <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'])));

            if ($comment->comment_approved == '0') : ?>
            <div class="alert info">
                <p><?php esc_html_e('Your comment is awaiting moderation.', 'medical-cure') ?></p>
            </div>
        <?php endif; ?>
        <div class="clearfix"></div>
        <div class="entry-content">
            <?php comment_text() ?>
        </div>
    </div>
</div>
</article>
<!-- </li> is added by wordpress automatically -->
<?php
} // don't remove this bracket!

add_filter('comment_reply_link', 'c5_replace_reply_link_class');


function c5_replace_reply_link_class($class){
    $class = str_replace("class='comment-reply-link", "class='comment-reply-link c5-btn-reply pull-right", $class);
    return $class;
}



function c5_get_tax_from_post_type($post_type) {
    $obj = get_post_type_object( $post_type);
    if (!is_object($obj) ) {
        return false;
    }

    foreach ($obj->taxonomies as  $taxonomy) {
        if($taxonomy!='post_tag'){
            return $taxonomy;
        }
    }
    return false;

}


function c5_in_sidebar() {
    if ($GLOBALS['c5_sidebar_active']) {
        return true;
    }
    return false;
}

add_filter( 'comments_template', 'code125_comments_pings', 9 );
function code125_comments_pings( $pings_before_dsq_comments) {
    if (!code125_post_has('pings' , get_the_ID())) {
        return;
    }
    echo'<div class="post-navigation pings">';
    echo '<h3>'.esc_html__('Pingbacks','medical-cure').'</h3>';
    echo '<ul class="code125-pings">';
    wp_list_comments(
        array(
            'style'             => 'ul',
            'type'              => 'pings'
        )
    );
    echo '</ul>';
    echo'</div>';

    return $pings_before_dsq_comments;
}

function code125_post_has( $type, $post_id ) {

$comments = get_comments('status=approve&type=' . $type . '&post_id=' . $post_id );
$comments = separate_comments( $comments );

return 0 < count( $comments[ $type ] );

}


?>
