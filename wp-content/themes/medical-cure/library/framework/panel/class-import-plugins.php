<?php

/**
*
*/
class C5_FW_AUTO_IMPORT_PLUGINS
{
    protected $tgmpa_url = 'themes.php?page=tgmpa-install-plugins';

    protected $tgmpa_menu_slug = 'tgmpa-install-plugins';

    function __construct()
    {

    }

    public function hook()
    {
        add_action( 'wp_ajax_envato_setup_plugins', array( $this, 'ajax_plugins' ) );
    }
    private function _get_plugins() {
        $instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
        $plugins  = array(
            'all'      => array(), // Meaning: all plugins which still have open actions.
            'install'  => array(),
            'update'   => array(),
            'activate' => array(),
        );
        $_plugins = array();
        $_plugins = apply_filters( 'c5_fw_tgmpa', $_plugins );
        foreach ( $_plugins as $plugin ) {
			call_user_func( array( $instance, 'register' ), $plugin );
		}
        foreach ( $_plugins as $plugin ) {
            $slug = $plugin['slug'];
            if ($slug!='revslider') {
                if ( $instance->is_plugin_active( $slug ) && false === $instance->does_plugin_have_update( $slug ) ) {
                    // No need to display plugins if they are installed, up-to-date and active.
                    continue;
                } else {
                    $plugins['all'][ $slug ] = $plugin;

                    if ( ! $instance->is_plugin_installed( $slug ) ) {
                        $plugins['install'][ $slug ] = $plugin;
                    } else {
                        if ( false !== $instance->does_plugin_have_update( $slug ) ) {
                            $plugins['update'][ $slug ] = $plugin;
                        }

                        if ( $instance->can_plugin_activate( $slug ) ) {
                            $plugins['activate'][ $slug ] = $plugin;
                        }
                    }
                }
            }
        }
        return $plugins;
    }

    public function _get_update_plugin()
    {
        $_plugins = $this->_get_plugins();
        foreach ($_plugins as $key => $plugins) {
            foreach ($plugins as $slug => $plugin) {
                if ($slug != 'c5-updates-support') {
                    unset($_plugins[$key][$slug]);
                }
            }
        }
        return $_plugins;
    }
    public function pre_check()
    {
        tgmpa_load_bulk_installer();
        // install plugins with TGM.
        if ( ! class_exists( 'TGM_Plugin_Activation' ) || ! isset( $GLOBALS['tgmpa'] ) ) {
            die( 'Failed to find TGM' );
        }
        $url = wp_nonce_url( add_query_arg( array( 'plugins' => 'go' ) ), 'envato-setup' );
        ;

        // copied from TGM

        $method = ''; // Leave blank so WP_Filesystem can populate it as necessary.
        $fields = array_keys( $_POST ); // Extra fields to pass to WP_Filesystem.

        if ( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, $fields ) ) ) {
            return true; // Stop the normal page form from displaying, credential request form will be shown.
        }

        // Now we have some credentials, setup WP_Filesystem.
        if ( ! WP_Filesystem( $creds ) ) {
            // Our credentials were no good, ask the user for them again.
            request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, $fields );

            return true;
        }
        return false;
    }

    public function echo_plugins($plugins='')
    {

        ?>
        <ul class="envato-wizard-plugins">
            <?php foreach ( $plugins['all'] as $slug => $plugin ) { ?>
                <li data-slug="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $plugin['name'] ); ?>
                    <span>
                        <?php
                        $keys = array();
                        if ( isset( $plugins['install'][ $slug ] ) ) {
                            $keys[] = 'Installation';
                        }
                        if ( isset( $plugins['update'][ $slug ] ) ) {
                            $keys[] = 'Update';
                        }
                        if ( isset( $plugins['activate'][ $slug ] ) ) {
                            $keys[] = 'Activation';
                        }
                        echo implode( ' and ', $keys ) . ' required';
                        ?>
                    </span>
                    <div class="spinner"></div>
                </li>
                <?php } ?>
            </ul>
        <?php
    }

    /**
    * Page setup
    */
    public function updates_plugin_install() {

        $should_we_exit = $this->pre_check();
        if ($should_we_exit) {
            return true;
        }

        $plugins = $this->_get_update_plugin();
        ?>
        <div class="c5-container c5-container-center">
            <span class="c5-icon-big c5-icon-green fa fa-cloud-download"></span>
            <h3><?php  esc_html_e('Plugin Required', 'medical-cure'); ?></h3>
            <form method="post">
                <?php

                if ( count( $plugins['all'] ) ) {
                    ?>
                    <p><?php  esc_html_e('To access Easy Updates & Support, you need to install the following plugin.', 'medical-cure'); ?></p>
                    <?php
                    $this->echo_plugins($plugins);
                }  ?>

                <p><?php  esc_html_e('You can remove the plugin later on from within WordPress.', 'medical-cure'); ?></p>

                <p class="envato-setup-actions step">
                    <a href="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" class="button-primary button button-large button-next" data-callback="install_plugins"><?php  esc_html_e('Install Plugin', 'medical-cure'); ?></a>
                    <?php wp_nonce_field( 'envato-setup' ); ?>
                </p>
            </form>
        </div>
        <?php
    }

    /**
    * Page setup
    */
    public function envato_setup_default_plugins() {

        $should_we_exit = $this->pre_check();
        if ($should_we_exit) {
            return true;
        }

        $plugins = $this->_get_plugins();
        ?>
        <h1><?php  esc_html_e('Default Plugins', 'medical-cure'); ?></h1>
        <form method="post">
            <?php
            if ( count( $plugins['all'] ) ) {
                ?>
                <p><?php  esc_html_e('Your website needs a few essential plugins. The following plugins will be installed or updated:', 'medical-cure'); ?></p>
                <?php $this->echo_plugins($plugins); ?>
                <p><?php  esc_html_e('You can add and remove plugins later on from within WordPress.', 'medical-cure'); ?></p>

                <p class="envato-setup-actions step">
                    <a href="<?php echo admin_url('admin.php?page='.C5_SETUP_WIZARD.'&tab=activate'); ?>" class="button-primary button button-large button-next button-hero right" data-callback="install_plugins"><?php  esc_html_e('Install Plugins', 'medical-cure'); ?></a>
                    <?php wp_nonce_field( 'envato-setup' ); ?>
                </p>
                <?php
            } else {
                echo '<p><strong>' .  esc_html_e('Good news! All plugins are already installed and up to date.', 'medical-cure') . '</strong></p>';
                ?>
                <a href="<?php echo admin_url('admin.php?page='.C5_SETUP_WIZARD.'&tab=import'); ?>" class="button-primary button button-large button-next button-hero right" ><?php  esc_html_e('Continue', 'medical-cure'); ?></a>
                <?php
            } ?>


        </form>
        <?php
    }


    public function ajax_plugins() {
        if ( ! check_ajax_referer( 'envato_setup_nonce', 'wpnonce' ) || empty( $_POST['slug'] ) ) {
            wp_send_json_error( array( 'error' => 1, 'message' => esc_html__('No Slug Found', 'medical-cure') ) );
        }
        $json = array();
        // send back some json we use to hit up TGM
        $plugins = $this->_get_plugins();
        // wp_send_json( $plugins );

        // what are we doing with this plugin?
        foreach ( $plugins['activate'] as $slug => $plugin ) {
            if ( $_POST['slug'] == $slug ) {
                $json = array(
                    'url'           => admin_url( $this->tgmpa_url ),
                    'plugin'        => array( $slug ),
                    'tgmpa-page'    => $this->tgmpa_menu_slug,
                    'plugin_status' => 'all',
                    '_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
                    'action'        => 'tgmpa-bulk-activate',
                    'action2'       => - 1,
                    'message'       => esc_html__('Activating Plugin', 'medical-cure'),
                );
                break;
            }
        }
        foreach ( $plugins['update'] as $slug => $plugin ) {
            if ( $_POST['slug'] == $slug ) {
                $json = array(
                    'url'           => admin_url( $this->tgmpa_url ),
                    'plugin'        => array( $slug ),
                    'tgmpa-page'    => $this->tgmpa_menu_slug,
                    'plugin_status' => 'all',
                    '_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
                    'action'        => 'tgmpa-bulk-update',
                    'action2'       => - 1,
                    'message'       => esc_html__('Updating Plugin', 'medical-cure'),
                );
                break;
            }
        }
        foreach ( $plugins['install'] as $slug => $plugin ) {
            if ( $_POST['slug'] == $slug ) {
                $json = array(
                    'url'           => admin_url( $this->tgmpa_url ),
                    'plugin'        => array( $slug ),
                    'tgmpa-page'    => $this->tgmpa_menu_slug,
                    'plugin_status' => 'all',
                    '_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
                    'action'        => 'tgmpa-bulk-install',
                    'action2'       => - 1,
                    'message'       => esc_html__('Installing Plugin', 'medical-cure'),
                );
                break;
            }
        }

        if ( $json ) {
            $json['hash'] = md5( serialize( $json ) ); // used for checking if duplicates happen, move to next plugin
            wp_send_json( $json );
        } else {
            wp_send_json( array( 'done' => 1, 'message' => esc_html__('Success', 'medical-cure') ) );
        }
        exit;

    }

    public function get_next_step_link()
    {
        return '#';
    }
}

$obj = new C5_FW_AUTO_IMPORT_PLUGINS();
$obj->hook();

?>
