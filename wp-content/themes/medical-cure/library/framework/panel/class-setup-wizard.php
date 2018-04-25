<?php

class C5_SETUP_WIZARD extends C5_Admin_Panel{

    function hook() {

        add_action('admin_menu', array($this, 'hook_page'));
    }


    function hook_page() {
        $code125_submenu_page_creation_method = 'add_'.'submenu_page';

        $code125_submenu_page_creation_method(C5_SLUG_ABOUT, 'Setup Wizard', 'Setup Wizard', 'manage_options', C5_SETUP_WIZARD, array($this, 'setup_wizard'));

    }


    function setup_wizard() {
        $tab = 'welcome';
        if (isset($_GET['tab'])) {
            $tab = $_GET['tab'];
        }
        echo '<div class="wrap about-wrap c5-setup-wizard-wrap c5-setup-wizard-tab-'.$tab.'">';

        echo '<img src="'.C5_URI.'/library/images/logo.png" srcset="'.C5_URI.'/library/images/logo.png 1x, '.C5_URI.'/library/images/logo-2x.png 2x" alt="theme logo" class="c5-theme-logo" />';

        $tabs = array();
        $tabs['welcome'] = 'Welcome';
        $tabs['plugins'] = 'Plugins';
        $tabs['activate'] = 'License';
        
        $code125_external_import_loaded = apply_filters( 'code125_external_import_loaded', false );
        if ($code125_external_import_loaded) {
            $tabs['import'] = 'Import Demo';
        }

        $tabs['quick_setup'] = 'Quick Setup';
        $tabs['support'] = 'Support';
        $tabs['website_ready'] = 'Ready!';



        echo '<ul class="c5-setup-ul clearfix">';
        foreach ($tabs as $key => $value) {
            $class = $key == $tab ? 'active' : "";
            echo '<li class="'.$class.'">'.$value.'</li>';
        }
        echo '</ul>';
        echo '<div class="clearfix"></div>';


        echo '<div id="welcome-panel" class="c5-main-panel c5-quick-setup-wrap welcome-panel">';

        switch ($tab) {
            case 'welcome':
                $this->welcome_page();
                break;
            case 'plugins':
                $obj = new C5_FW_AUTO_IMPORT_PLUGINS();
                $obj->envato_setup_default_plugins();
                break;
            case 'activate':
                do_action('c5_activate_form');

                break;
            case 'quick_setup':
                $obj = new C5_quick_setup();
                $obj->quick_setup_page();
                break;
            case 'import':
                if (class_exists('C5_theme_activation')) {
                    $obj = new C5_theme_activation();
                    $obj->import_page();
                }

                break;
            case 'support':
                if(isset($_POST['c5-quick-setup-data'])){
                    $obj = new C5_quick_setup();
                    $obj->done_page();
                }
                $this->support_page();
                break;
            case 'website_ready':
                $this->website_ready();
                break;
            default:
                $this->welcome_page();
                break;
        }
        echo '</div>';
        echo '<a href="'.admin_url('admin.php?page=' .C5_SLUG_ABOUT).'" class="c5-close-setup-wizard">Return to the WordPress Dashboard</a>';

        echo '</div>';

    }

    public function welcome_page()
    {
        $theme_name = apply_filters( 'c5_theme_name', 'Code125' );
        if (isset($_GET['activated'])) {
        ?>
            <h1>Successfully Activated...</h1>
        <?php
        }else{ ?>
            <h1>Welcome to <?php echo $theme_name ?> Theme</h1>
        <?php
        }
        ?>
        <p>We would like to thank you for using <?php echo $theme_name ?> WordPress Theme. This wizard will install the required WordPress plugins, help you to import demo, perform quick setup for important features and tell you a little about Help &amp; Support options. It should only take 5 minutes.</p>

        <p>If you are busy you can skip this setup wizard. But we strongly advise you to complete this wizard as it will help you install some essential plugins you will need in your website.</p>
        <?php
        $tab = 'import';
        $status = get_option('c5_au_token_status');
        if($status == ''){
            $tab = 'activate';
        }
        if ($this->get_tgma_unactive_count() > 0) {
            $tab = 'plugins';
        } ?>
        <a href="<?php echo admin_url('admin.php?page='.C5_SETUP_WIZARD.'&tab='.$tab); ?>" class="button button-hero pull-right button-primary"><?php   esc_html_e('Continue', 'medical-cure') ?> <span class="fa fa-chevron-right"></span></a>
        <?php
    }

    public function support_page()
    {
        ?>
        <h1>Help and Support</h1>
        <p>This theme comes with 6 months item support from purchase date (with the option to extend this period).</p>
        <p>This license allows you to use this theme on a single website. Please purchase an additional license to use this theme on another website.</p>
        <p>Item Support can be accessed from your dashboard <a href="<?php echo admin_url('admin.php?page='.C5_SLUG_SUPPORT); ?>" target="_blank">here</a></p>
        <p>Item Support includes:</p>
        <ul>
            <li>Availability of the author to answer questions</li>
            <li>Answering technical questions about item features</li>
            <li>Assistance with reported bugs and issues</li>
            <li>Help with bundled 3rd party plugins</li>
        </ul>

        <p>Item Support <strong>DOES NOT</strong> Include:</p>
        <ul>
            <li>Customization services (this is available through <a href="https://studio.envato.com" target="_blank">Envato Studio</a>)</li>
            <li>Installation services (this is available through <a href="https://studio.envato.com" target="_blank">Envato Studio</a>)</li>
            <li>Help and Support for non-bundled 3rd party plugins (i.e. plugins you install yourself later on)</li>
        </ul>
        <p>More details about item support can be found in the ThemeForest <a href="http://themeforest.net/page/item_support_policy" target="_blank">Item Support Polity</a>. </p>

        <a href="<?php echo admin_url('admin.php?page='.C5_SETUP_WIZARD.'&tab=website_ready'); ?>" class="button button-hero pull-right button-primary"><?php   esc_html_e('Continue', 'medical-cure') ?> <span class="fa fa-chevron-right"></span></a>

        <?php
    }

    public function website_ready()
    {
        ?>
        <h1><?php  esc_html_e('Your Website is Ready!', 'medical-cure'); ?></h1>

        <p>Congratulations! The theme has been activated and your website is ready. Login to your WordPress dashboard to make changes and modify any of the default content to suit your needs.</p>
        <p>Please come back and <a href="http://themeforest.net/downloads" target="_blank">leave a 5-star rating</a> if you are happy with this theme.</p> <p>Follow <a href="https://twitter.com/Code125Themes" target="_blank">@Code125Themes</a> on Twitter to see updates. Thanks! </p>



        <div class="envato-setup-next-steps-last">
            <h3><?php  esc_html_e('More Resources', 'medical-cure'); ?></h3>
            <ul>
                <li class="documentation"><a href="<?php echo C5_THEME_DOCS_URL ?>" target="_blank"><?php  esc_html_e('Read the Theme Documentation', 'medical-cure'); ?></a> </li>
                <li class=""><a href="https://wordpress.org/support/" target="_blank"><?php  esc_html_e('Learn how to use WordPress', 'medical-cure'); ?></a> </li>
                <li class="rating"><a href="http://themeforest.net/downloads" target="_blank"><?php  esc_html_e('Leave an Item Rating', 'medical-cure'); ?></a></li>
                <li class="support"><a href="<?php echo admin_url('admin.php?page='.C5_SLUG_SUPPORT); ?>" target="_blank"><?php  esc_html_e('Get Help and Support', 'medical-cure'); ?></a></li>
            </ul>
        </div>
        <a class="button button-primary button-large button-hero pull-left" href="https://twitter.com/Code125Themes" target="_blank"><?php  esc_html_e('Follow @Code125Themes on Twitter', 'medical-cure'); ?></a>
        <a class="button button-next button-large  button-hero pull-right" href="<?php echo esc_url( home_url('/') ); ?>"><?php  esc_html_e('View your new website!', 'medical-cure'); ?></a>
    <?php
}

public function get_tgma_unactive_count()
{
    $count = 0;
    $plugins = array( );
    $plugins = apply_filters( 'c5_fw_tgmpa', $plugins );
    foreach ($plugins as $plugin) {
        if (!is_admin()) {
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }
        if (!is_plugin_active( $this->_get_plugin_basename_from_slug( $plugin['slug'] ) )) {
            $count++;
        }
    }
    return $count;
}

}

$c5_import_demo = new C5_SETUP_WIZARD();
$c5_import_demo->hook();
?>
