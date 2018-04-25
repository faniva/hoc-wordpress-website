<?php
/**
*
*/
class C5_System_Status extends C5_Admin_Panel
{

    static $system_status = array();

    function __construct()
    {

    }

    static function add_system_status($section, $status_array) {
        self::$system_status[$section] []= $status_array;
    }

    public function get_status()
    {
        $return = array();
        foreach (self::$system_status as $section_name => $section_statuses) {
            foreach ($section_statuses as $status_params) {
                $name = str_replace(' ', '_' , $status_params['check_name']);
                $name = strtolower($name);
                $return[$name] = $status_params['value'];
            }
        }
        return $return;
    }

    static function render_tables() {
        foreach (self::$system_status as $section_name => $section_statuses) {
            ?>
            <table class="widefat c5-system-status-table" cellspacing="0">
                <thead>
                    <tr>
                        <th colspan="4"><?php echo $section_name ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($section_statuses as $status_params) {
                        ?>
                        <tr>
                            <td class="c5-system-status-name"><?php echo $status_params['check_name'] ?></td>
                            <td class="c5-system-status-help"><!--<a href="#" class="help_tip">[?]</a>--></td>
                            <td class="c5-system-status-status">
                                <?php
                                switch ($status_params['status']) {
                                    case 'green':
                                    echo '<div class="c5-system-status-led c5-system-status-green c5-tooltip" data-position="right" title="' . $status_params['tooltip'] . '"><span class="fa fa-check-circle"></span></div>';
                                    break;
                                    case 'yellow':
                                    echo '<div class="c5-system-status-led c5-system-status-yellow c5-tooltip" data-position="right" title="' . $status_params['tooltip'] . '"><span class="fa fa-check-circle"></span></div>';
                                    break;
                                    case 'red' :
                                    echo '<div class="c5-system-status-led c5-system-status-red c5-tooltip" data-position="right" title="' . $status_params['tooltip'] . '"><span class="fa fa-check-circle"></span></div>';
                                    break;
                                    case 'info':
                                    echo '<div class="c5-system-status-led c5-system-status-info c5-tooltip" data-position="right" title="' . $status_params['tooltip'] . '"><span class="fa fa-info-circle"></span></div>';
                                    break;
                                }
                                ?>
                            </td>
                            <td class="c5-system-status-value"><?php echo $status_params['value'] ?><?php
                            if (isset($status_params['extra-info']) ){
                                echo ' ' .$status_params['extra-info'];
                            } ?></td>
                        </tr>
                        <?php
                    }

                    ?>
                </tbody>
            </table>
            <?php
        }
    }

    static function wp_memory_notation_to_number( $size ) {
        $l   = substr( $size, -1 );
        $ret = substr( $size, 0, -1 );
        switch ( strtoupper( $l ) ) {
            case 'P':
            $ret *= 1024;
            case 'T':
            $ret *= 1024;
            case 'G':
            $ret *= 1024;
            case 'M':
            $ret *= 1024;
            case 'K':
            $ret *= 1024;
        }
        return $ret;
    }

    public function get_system_status_array()
    {
        /*  ----------------------------------------------------------------------------
        WordPress Environment
        */
        $section = 'WordPress Environment';

        // home url
        $this->add_system_status( $section , array(
            'check_name' => 'WP Home URL',
            'tooltip' => 'WordPress Address (URL) - the address where your WordPress core files reside',
            'value' => esc_url( home_url('/') ),
            'status' => 'info'
        ));

        // site url
        $this->add_system_status( $section , array(
            'check_name' => 'WP Site URL',
            'tooltip' => 'Site Address (URL) - the address you want people to type in their browser to reach your WordPress blog',
            'value' => site_url(),
            'status' => 'info'
        ));

        // home_url == site_url
        if (home_url() != site_url()) {
            $this->add_system_status( $section , array(
                'check_name' => 'Home URL - Site URL',
                'tooltip' => 'Home URL not equal to Site URL, this may indicate a problem with your WordPress configuration.',
                'value' => 'Home URL != Site URL <span class="c5-status-small-text">Home URL not equal to Site URL, this may indicate a problem with your WordPress configuration.</span>',
                'status' => 'yellow'
            ));
        }

        // Theme name
        $this->add_system_status( $section , array(
            'check_name' => 'Theme name',
            'tooltip' => 'The current theme name activated.',
            'value' =>  C5_THEME_NAME,
            'status' => 'info'
        ));

        // Theme version
        $this->add_system_status( $section , array(
            'check_name' => 'Theme version',
            'tooltip' => 'Theme current version',
            'value' =>  C5_THEME_VERSION,
            'status' => 'info'
        ));

        // version
        $this->add_system_status( $section , array(
            'check_name' => 'WordPress version',
            'tooltip' => 'Wordpress version',
            'value' => get_bloginfo('version'),
            'status' => 'info'
        ));

        // is_multisite
        $this->add_system_status( $section , array(
            'check_name' => 'WP Multisite enabled',
            'tooltip' => 'A multisite network is a collection of sites that all share the same WordPress installation.',
            'value' => is_multisite() ? 'Yes' : 'No',
            'status' => 'info'
        ));

        $count_posts = wp_count_posts();
        $this->add_system_status(  $section  , array(
            'check_name' => 'Posts Count',
            'tooltip' => '',
            'value' =>  $count_posts->publish,
            'status' => 'info'
        ));

        // language
        $this->add_system_status( $section , array(
            'check_name' => 'WP Language',
            'tooltip' => 'WP Language - can be changed from Settings -> General',
            'value' => get_locale(),
            'status' => 'info'
        ));

        // wp debug
        if (defined('WP_DEBUG') and WP_DEBUG === true) {
            $this->add_system_status( $section , array(
                'check_name' => 'WP_DEBUG Mode:',
                'tooltip' => 'The WP_DEBUG mode is intended for development and it may display unwanted messages. You should disable it on your side.',
                'value' => 'ON',
                'status' => 'yellow',
                'extra-info' => 'The WP_DEBUG mode is intended for development and it may display unwanted messages. You should disable it on your side.'
            ));
        } else {
            $this->add_system_status( $section , array(
                'check_name' => 'WP_DEBUG Mode:',
                'tooltip' => 'WP_DEBUG mode is disabled.',
                'value' => 'OFF',
                'status' => 'green'
            ));
        }

        /*  ----------------------------------------------------------------------------
        Server status
        */
        $section = 'Server Environment';

        // server info
        $this->add_system_status($section, array(
            'check_name' => 'Server software',
            'tooltip' => 'Server software version',
            'value' =>  esc_html( $_SERVER['SERVER_SOFTWARE'] ),
            'status' => 'info'
        ));

        // php version
        $this->add_system_status( $section , array(
            'check_name' => 'PHP Version',
            'tooltip' => 'You should have PHP version 5.2.4 or greater (recommended: PHP 5.4 or greater)',
            'value' => phpversion(),
            'status' => 'info'
        ));
        global $wpdb;
        if (isset($wpdb->dbh->server_info)) {
            // print_r($wpdb->dbh);
            $mysql = explode('-' , $wpdb->dbh->server_info );
            $this->add_system_status( $section , array(
                'check_name' => 'MySQL Server Version',
                'tooltip' => 'MySQL Server Version',
                'value' =>  $mysql[0],
                // 'value' => 'test',
                'status' => 'info'
            ));
        }

        // memory limit
        $memory_limit = $this->wp_memory_notation_to_number(WP_MEMORY_LIMIT);
        if ( $memory_limit < 67108864 ) {
            $this->add_system_status(  $section  , array(
                'check_name' => 'WP Memory Limit',
                'tooltip' => 'By default in wordpress the PHP memory limit is set to 40MB. With some plugins this limit may be reached and this affects your website functionality. To avoid this increase the memory limit to at least 64MB.',
                'value' => size_format( $memory_limit ),
                'status' => 'yellow',
                'extra-info' => '/request <span class="c5-status-small-text">- We recommend setting memory to at least 64MB. The theme is well tested with a 40MB/request limit, but if you are using multiple plugins that may not be enough. See: <a href="http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">Increasing memory allocated to PHP</a>. You can also check our guide.</span>'
                ));
            } else {
                $this->add_system_status(  $section , array(
                    'check_name' => 'WP Memory Limit',
                    'tooltip' => 'This parameter is properly set.',
                    'value' => size_format( $memory_limit ),
                    'status' => 'green',
                    'extra-info' => '/request'
                ));
            }

            // post_max_size
            $this->add_system_status(  $section  , array(
                'check_name' => 'post_max_size',
                'tooltip' => 'Sets max size of post data allowed. This setting also affects file upload. To upload large files you have to increase this value and in some cases you also have to increase the upload_max_filesize value.',
                'value' =>  ini_get('post_max_size'),
                'status' => 'info',
                'extra-info' => '<span class="c5-status-small-text"> - You cannot upload images, themes and plugins that have a size bigger than this value.</span>'
            ));


            // php time limit
            $max_execution_time = ini_get('max_execution_time');
            if ($max_execution_time == 0 or $max_execution_time >= 60) {
                $this->add_system_status(  $section , array(
                    'check_name' => 'max_execution_time',
                    'tooltip' => 'This parameter is properly set',
                    'value' =>  $max_execution_time,
                    'status' => 'green'
                ));
            } else {
                $this->add_system_status(  $section  , array(
                    'check_name' => 'max_execution_time',
                    'tooltip' => 'This sets the maximum time in seconds a script is allowed to run before it is terminated by the parser. The theme demos download images from our servers and depending on the connection speed this process may require a longer time to execute. We recommend that you should increase it 60 or more.',
                    'value' =>  $max_execution_time ,
                    'status' => 'yellow',
                    'extra-info' => '<span class="c5-status-small-text"> - the execution time should be bigger than 60 if you plan to use the demos.</span>'
                ));
            }


            // php max input vars
            $max_input_vars = ini_get('max_input_vars');
            if ($max_input_vars == 0 or $max_input_vars >= 2000) {
                $this->add_system_status(  $section , array(
                    'check_name' => 'max_input_vars',
                    'tooltip' => 'This parameter is properly set',
                    'value' =>  $max_input_vars,
                    'status' => 'green'
                ));
            } else {
                $this->add_system_status(  $section  , array(
                    'check_name' => 'max_input_vars',
                    'tooltip' => 'This sets how many input variables may be accepted (limit is applied to $_GET, $_POST and $_COOKIE superglobal separately). By default this parameter is set to 1000 and this may cause issues when saving the menu, we recommend that you increase it to 2000 or more. ',
                    'value' =>  $max_input_vars ,
                    'status' => 'yellow',
                    'extra-info' => '<span class="c5-status-small-text"> - the max_input_vars should be bigger than 2000, otherwise it can cause incomplete saves in the menu panel in WordPress.</span>'
                ));
            }

            $gzip = 'Disabled';
            $gzip_status = 'yellow';
            if (function_exists('ob_gzhandler')) {
                $gzip = 'Enabled';
                $gzip_status = 'green';
            }

            $this->add_system_status(  $section  , array(
                'check_name' => 'gzip',
                'tooltip' => '',
                'value' =>  $gzip,
                'status' => $gzip_status
            ));

            $this->add_system_status(  $section  , array(
                'check_name' => 'allow_url_fopen',
                'tooltip' => '',
                'value' =>  ini_get('allow_url_fopen') ? 'Enabled' : 'Disabled',
                'status' => ini_get('allow_url_fopen') ? 'green' : 'red'
            ));


            /*  ----------------------------------------------------------------------------
            Theme Options
            */
            $section = 'Theme Options';
            $option_tree = get_option('option_tree');

            foreach ($option_tree as $key => $value) {
                $this->add_system_status(  $section  , array(
                    'check_name' => $key,
                    'tooltip' => '',
                    'value' =>  is_array($value) ? json_encode( $value ) : $value,
                    'status' => 'info'
                ));
            }
        }

        function render(){
            ?>
            <div class="wrap about-wrap c5-admin-wrap">
                <h1>System status</h1>
                <div class="about-text" style="margin-bottom: 30px;">
                    <p>In this page you can check your website technical status. Here is few tips about the status you will find below.</p>
                    <ul class="c5-lists">
                        <li><span class="c5-system-status-info">Info </span> means that the information shown is for reference.</li>
                        <li><span class="c5-system-status-yellow">Yellow status</span> means that the site will work as expected on the front end but it may cause problems in wp-admin.</li>
                        <li><span class="c5-system-status-green">Green status</span> means that the site should work fine. Your server specs can power your website.</li>
                        <li><span class="c5-system-status-red">Red status</span> means that your website will face a malfunction and can lead to a fatal error.</li>
                    </ul>

                    <?php $this->badge(); ?>
                </div>
                <?php

                $this->header();

                echo '<p><strong>Memory notice:</strong> - the theme is well tested with a limit of 40MB/request but plugins may require more, for example woocommerce requires 64MB.</p>';

                $this->get_system_status_array();
                $this->render_tables();


            }
        }

        ?>
