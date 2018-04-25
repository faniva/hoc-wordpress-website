<?php

/**
* version 1.0
*/
class C5_Admin_Panel
{

    function __construct(){

    }

    function constants(){
        $code125_url = 'http://code125.com';
        $theme_name = apply_filters( 'c5_theme_name', 'Code125' );
        $theme = wp_get_theme();

        define('C5_THEME_NAME' , $theme_name );
        define('C5_THEME_VERSION' , $theme->version );

        $theme_docs_url = apply_filters( 'c5_theme_docs_url', $code125_url );
        define('C5_THEME_DOCS_URL' , $theme_docs_url );

        $theme_vtutorials_url = apply_filters( 'c5_theme_videos_url', $code125_url );
        define('C5_THEME_VIDEO_TUTORIALS_URL' , $theme_vtutorials_url );

        $theme_ticket_url = apply_filters( 'c5_theme_ticket_url', 'http://themeforest.net/user/code125/portfolio?ref=code125' );
        define('C5_THEME_TICKET_URL' , $theme_ticket_url );

        $theme_purchase_URL = apply_filters( 'c5_theme_purchase_url', 'http://themeforest.net/user/code125/portfolio?ref=code125' );
        define('C5_THEME_PURCHASE_URL' , $theme_purchase_URL );

    }

    function hook(){


        add_action('wp_loaded' , array($this, 'constants'));
        add_action('admin_menu', array($this, 'register_theme_panel'));
        add_filter('ot_theme_options_parent_slug', array( $this, 'c5_theme_options_parent_slug' ));
        add_filter('ot_theme_options_menu_slug', array( $this, 'theme_options_menu_slug' ));
        add_filter('ot_header_logo_link', array( $this, 'ot_header_logo_link' ));
        add_filter('ot_theme_options_export_slug', array( $this, 'ot_theme_options_export_slug' ));
        add_filter('ot_header_version_text', array( $this, 'ot_header_version_text' ));



        add_action('c5_theme_options_header' ,array($this, 'theme_options_header' ));


    }

    function ot_header_logo_link(){
        return '<a href="https://code125.com" target="_blank" class="c5-ot-header-icon"><span class="icon-c5-code125"></span></a>';
    }
    function ot_header_version_text(){
        return C5_THEME_NAME . ' ' . C5_THEME_VERSION;
    }
    function theme_options_menu_slug(){
        return C5_SLUG_THEME_OPTIONS;
    }
    function ot_theme_options_export_slug(){
        return C5_SLUG_IMPORT_EXPORT;
    }
    function c5_theme_options_parent_slug(){
        return C5_SLUG_ABOUT;
    }
    function theme_options_header(){
        if ($_GET['page'] == C5_SLUG_IMPORT_EXPORT) {
            ?>
            <h1>Import and Export</h1>
            <div class="about-text" style="margin-bottom: 30px;">
                <p>In case you wanted to migrate your website, try new theme options or take backup. We built a small tool to help you import or export theme options easily. Please take backup before every update you perform.</p>
                <?php $this->badge(); ?>
            </div>
            <?php
            $this->header();
            return;
        }
        ?>
        <h1>Theme Options</h1>
        <div class="about-text" style="margin-bottom: 30px;">
            <p>We grouped the most options should be needed to change in your website and built this theme options panel. It is grouped in main categories to make it accessible for you to customize your website smoothly.</p>
            <?php $this->badge(); ?>
        </div>
        <?php
        $this->header();
    }

    /**
    * register our theme panel via the hook
    */
    function register_theme_panel() {

        $code125_menu_page_creation_method    = 'add_'.'menu_page';
		$code125_submenu_page_creation_method = 'add_'.'submenu_page';

        $code125_menu_page_creation_method( C5_THEME_NAME . ' Panel', C5_THEME_NAME, "edit_posts", C5_SLUG_ABOUT, array($this, "c5_about_page"), null, 3);
        $code125_submenu_page_creation_method( C5_SLUG_ABOUT , 'Support & Updates', 'Support & Updates', 'edit_posts', C5_SLUG_SUPPORT,  array( $this , "c5_theme_support" ) );
        $code125_submenu_page_creation_method( C5_SLUG_ABOUT , 'System Status', 'System Status', 'edit_posts', C5_SLUG_SYSTEM_STATUS,  array( $this , "c5_system_status" ) );
        if($this->get_tgma_unactive_count() > 0){
            $code125_submenu_page_creation_method( C5_SLUG_ABOUT , 'Plugins', 'Plugins', 'manage_options', C5_SLUG_PLUGINS,  array($this, "c5_plugins") );
        }

        // shit hack for welcome menu
        global $submenu; // this is a global from WordPress
        $submenu[C5_SLUG_ABOUT][0][0] = 'About & License';



    }

    public function c5_plugins()
    {
        ?>
        <div class="wrap about-wrap c5-admin-wrap">
            <h1>Plugins</h1>
            <div class="about-text" style="margin-bottom: 30px;">
                <p>Welcome to  <?php echo C5_THEME_NAME?> dashboard. We in Code125 handcrafted this theme carefully for you to start your next big project. We are dedicated to serve you in the best way we can.</p>
                <?php $this->badge(); ?>
            </div>
            <?php $this->header(); ?>

            <?php
            $obj = new C5_FW_AUTO_IMPORT_PLUGINS();
            $obj->envato_setup_default_plugins();

            ?>

        </div>
        <?php
    }


    function c5_about_page(){
        do_action( 'c5_about_page' );
    }
    function c5_theme_support(){
        ?>
        <div class="wrap about-wrap c5-admin-wrap">
            <h1>Support</h1>
            <div class="about-text" style="margin-bottom: 30px;">
                <p>We love to help our customers to build an amazing website with our products. So we provide a lot of support solutions for your to get your answer as fast as possible. Below kindly check how can you get your question answered.</p>
                <?php $this->badge(); ?>
            </div>
            <?php
            $this->header();
            do_action('c5_theme_support_page');

    }
    function badge(){
        ?>
        <div class="c5-badge"><?php echo C5_THEME_NAME?> <?php echo C5_THEME_VERSION; ?></div>
        <?php
    }
    function header(){

        $pages  = array();
        $pages[C5_SLUG_ABOUT] = 'About & License';
        $pages[C5_SLUG_THEME_OPTIONS] = 'Theme Options';
        $pages[C5_SLUG_SUPPORT] = 'Support & Updates';
        $pages[C5_SLUG_SYSTEM_STATUS] = 'System Status';

        $code125_external_import_loaded = apply_filters( 'code125_external_import_loaded', false );
        if ($code125_external_import_loaded) {
            $pages[C5_SLUG_DEMOS_INSTALL] = 'Install Demos';
        }
        if($this->get_tgma_unactive_count() > 0){
            $pages[C5_SLUG_PLUGINS] = 'Plugins';
        }
        $pages[C5_SETUP_WIZARD] = 'Setup Wizard';
        $pages[C5_SLUG_IMPORT_EXPORT] = 'Import/Export';

        ?>
        <h2 class="nav-tab-wrapper">
            <?php

            $current_url = $_GET['page'];
            if (isset($_GET['tab'])) {
                $current_url .= '&tab=' . $_GET['tab'];
            }
            foreach ($pages as $slug => $title) {
                $url = admin_url( 'admin.php?page=' . $slug );
                if ($slug == C5_SLUG_DEMOS_INSTALL) {
                    $url = admin_url( 'admin.php?page=' .C5_SETUP_WIZARD.'&tab=import');
                }
                $class= '';
                if ($current_url == $slug) {
                    $class = 'nav-tab-active';
                }
                ?>
                <a href="<?php echo esc_url($url); ?>" class="nav-tab <?php echo $class ?>"><?php echo $title; ?></a>
                <?php
            }
            ?>
        </h2>
        <?php
        if (isset($_GET['c5_authenticate'])) {
            $theme = wp_get_theme();
            if( $theme->parent() ){
                $current_theme_name	=	$theme->parent()->get('Name');
            }
            else{
                $current_theme_name	=	$theme->get('Name');
            }
            ?>
            <div class="c5-notice c5-notice-red">
                <p><strong>No valid purchase found:</strong> We couldn't find a valid purchase for  "<?php echo $current_theme_name; ?>". we believe this might be a good chance to purchase a license and activate it. You can purchase "<?php echo $current_theme_name; ?>" from <a href="<?php echo  esc_url(C5_THEME_PURCHASE_URL); ?>" target="_blank">here</a>.</p>
            </div>
            <?php
        }
        do_action('c5_admin_panel_header');
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
     function _get_plugin_basename_from_slug( $slug ) {
        $keys = array_keys( $this->get_plugins() );

        foreach ( $keys as $key ) {
            if ( preg_match( '|^' . $slug . '/|', $key ) ) {
                return $key;
            }
        }

        return $slug;
    }
    public function get_plugins( $plugin_folder = '' ) {
        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        return get_plugins( $plugin_folder );
    }
    function c5_system_status(){


        $obj = new C5_System_Status();
        $obj->render();

        echo '</div>';
    }
}
$obj_check = new C5_Admin_Panel();
$obj_check->hook();


?>
