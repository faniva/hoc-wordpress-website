<?php
/*
The comments page for Bones
*/

// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
die ('Please do not load this page directly. Thanks!');

if ( post_password_required() ) { ?>
    <div class="alert help">
        <p class="nocomments"><?php esc_html_e('This post is password protected. Enter the password to view comments.', 'medical-cure'); ?></p>
    </div>
    <?php
    return;
}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
    <div class="c5-post-comments-wrap">
        <nav id="comment-nav">
            <ul class="clearfix">
                <li><?php previous_comments_link() ?></li>
                <li><?php next_comments_link() ?></li>
            </ul>
        </nav>

        <ol class="c5-post-comments">
            <?php wp_list_comments('type=comment&callback=c5_comments'); ?>
        </ol>

        <nav id="comment-nav">
            <ul class="clearfix">
                <li><?php previous_comments_link() ?></li>
                <li><?php next_comments_link() ?></li>
            </ul>
        </nav>
    </div>
<?php else : // this is displayed if there are no comments so far ?>

    <?php if ( comments_open() ) : ?>
        <!-- If comments are open, but there are no comments. -->

    <?php else : // comments are closed ?>

        <!-- If comments are closed. -->
        <p class="nocomments"><?php esc_html_e('Comments are closed.', 'medical-cure'); ?></p>

    <?php endif; ?>

<?php endif; ?>
