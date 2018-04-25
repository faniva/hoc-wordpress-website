<?php

/**
 *
 */
class C5_FW_ABOUT extends C5_Admin_Panel
{

    function __construct()
    {
        add_action('c5_about_page' , array($this, 'render'));
    }

    function render(){
        ?>
        <div class="wrap about-wrap c5-admin-wrap">
            <h1>About and License</h1>
            <div class="about-text" style="margin-bottom: 30px;">
                <p>Welcome to  <?php echo C5_THEME_NAME?> dashboard. We in Code125 handcrafted this theme carefully for you to start your next big project. We are dedicated to serve you in the best way we can.</p>
                <?php $this->badge(); ?>
            </div>
            <?php $this->header(); ?>

            <div class="feature-section two-col">

                <div class="col">
                    <div class="c5-container ">
                        <h3>About <?php echo C5_THEME_NAME?>.</h3>
                        <p><?php echo apply_filters( 'c5_about_theme', '' ); ?></p>
                        <h4>Notes</h4>
                        <ul class="c5-lists">
                            <li><?php echo C5_THEME_NAME?> is exclusivly sold on Themeforest throught this <a href="<?php echo C5_THEME_PURCHASE_URL ?>" target="_blank">link</a>.</li>
                            <li>We offer support through this <a href="<?php echo admin_url('/admin.php?page=' . C5_SLUG_SUPPORT) ?>" target="_blank">page</a>.</li>
                            <li>The purchase you made allows you to use <?php echo C5_THEME_NAME?> on one domain or project.</li>
                            <li>We appreciate everyone feedback as it allows us to keep supporting and releasing new updates</li>
                        </ul>
                    </div>

                    <?php do_action('c5_theme_change_log'); ?>
                </div>
                <div class="col">
                    <?php do_action('c5_license_page'); ?>
                </div>
            </div>



        </div>
        <?php
    }
}
$obj = new C5_FW_ABOUT();

?>
