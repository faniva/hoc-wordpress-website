<?php

/**
*
*/
class C5_FW_SUPPORT_UPDATES extends C5_Admin_Panel
{

    function __construct()
    {
        add_action( 'c5_theme_support_page', array($this, 'render') );
        add_action( 'c5_support_form', array($this, 'no_plugin') );
        add_action( 'c5_license_page', array($this, 'no_plugin') );

        add_action('c5_admin_panel_header' , array($this, 'c5error') );

    }
    public function render()
    {
        ?>
        <div class="feature-section under-the-hood two-col">
            <div class="col">
                <?php
                do_action('c5_support_form');
                ?>
            </div>
            <div class="col">
                <?php
                do_action('c5_check_for_updates');
                ?>
                <div class="c5-container ">
                    <h3>Documentation</h3>
                    <p>We built a detailed documentation for <?php echo C5_THEME_NAME?>. There is a high chance we covered your question in the documentation. Please check the documentation before opening a ticket.</p>
                    <a href="<?php echo esc_url(C5_THEME_DOCS_URL) ?>" class="button button-primary" target="_blank">Check out Documentation</a>

                    <div class="c5-space"></div>
                    <h3>Video Tutorials</h3>
                    <p>We created Youtube tutorials to help you on how to use our products, kindly review them as we always update them with the most questions we got asked related to our products.</p>
                    <a href="<?php echo esc_url(C5_THEME_VIDEO_TUTORIALS_URL) ?>" class="button button-primary" target="_blank">See Video Tutorials</a>

                    <div class="c5-space"></div>
                    <h3>Support Policy</h3>
                    <p>We grouped some guidelines should help you to determine wheither your question fails into the scope of Theme Support or it is a customization.</p>
                    <h4>What’s included in support:</h4>
                    <ul class="c5-lists">
                        <li>Responding to questions or problems regarding the item and its features</li>
                        <li>Fixing bugs and reported issues</li>
                        <li>Providing updates to ensure compatibility with new software versions</li>
                    </ul>

                    <h4>What’s not included in support:</h4>
                    <ul class="c5-lists">
                        <li>Customization and installation services</li>
                        <li>Support for third party software and plug-ins</li>
                        <li>Fixing Bugs related to hosting setup or WordPress itself.</li>
                    </ul>
                    <p>You can read more about Envato Item Support Policy <a href="http://themeforest.net/page/item_support_policy?ref=code125" target="_blank">Here</a></p>
                </div>

            </div>

        </div>
        <?php
    }

    public function c5error()
    {
        if(!isset($_GET['c5error'])){
            return;
        }
        $message = esc_html__('There has been an error connecting to envato. Please try again in few minutes.', 'medical-cure');
        if ($_GET['c5error'] == 'no_purchase') {
            $message = esc_html__('Sorry, we couldnt find a valid purchase for ', 'medical-cure');
            $message .= C5_THEME_NAME . '. ';
            $message .= esc_html__('Please purchase a valid license ', 'medical-cure');
            $message .= '<a href="'.esc_url(C5_THEME_PURCHASE_URL).'" target="_blank">'. esc_html__('here', 'medical-cure') .'</a>.';
        }

        ?>
        <div class="c5-notice c5-notice-red">
            <p><?php echo $message; ?></p>
        </div>
        <?php
    }
    public function no_plugin()
    {
        if (!class_exists('C5_AU_SUPPORT')) {
            $obj = new C5_FW_AUTO_IMPORT_PLUGINS();
            $obj->updates_plugin_install();
        }

    }
}
$obj = new C5_FW_SUPPORT_UPDATES();

?>
