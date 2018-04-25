<?php

add_action( 'after_switch_theme', 'c5_check_theme_setup' );
function c5_check_theme_setup(){

    global $c5_setup_message;
    $c5_setup_message = '';
    $reasons  = array();
    $roll_back = false;


    $php_version = '5.3.0';
    // compare versions
    if ( version_compare(phpversion(), $php_version, '<') ) {
        $roll_back = true;
        $reasons[] = 'PHP version is less than '.$php_version.', please ask your hosting company to upgrade your php.';
    }


    if ($roll_back) {
        // theme not activated info message
        add_action( 'admin_notices', 'c5_theme_setup_failed' );
        function c5_theme_setup_failed() {
            global $c5_setup_message;
            ?>
            <div class="update-nag">
                <?php echo $c5_setup_message; ?>
            </div>
            <?php
        }

        // switch back to previous theme
        switch_theme( get_option('theme_switched') );
        return false;
    }
}

function c5_is_allow_url_fopen_enabled() {
    if( ini_get('allow_url_fopen') ) {
        return true;
    }
    return false;
}

function c5_check_allow_url_fopen_html() {
    $return = '';
    if ( !c5_is_allow_url_fopen_enabled() ) {
        $return .= '<div class="alert alert-warning"><p>Sorry We can\'t show this widget. Please contact your host to enable "allow_url_fopen" flag, Please refer to this link <a href="http://www.code125.com/faq/possible-disabled-functions-on-some-servers/" target="_blank">Here</a> </p></div>';
    }
    return $return;
}



function c5_isCurl(){
    return function_exists('curl_version');
}

function c5_check_curl_html() {
    $return = '';
    if ( !c5_isCurl() ) {
        $return .= '<div class="alert alert-warning"><p>Sorry We can\'t show this widget. Please contact your host to enable curl, Please refer to this link <a href="http://www.code125.com/faq/possible-disabled-functions-on-some-servers/" target="_blank">Here</a> </p></div>';
    }
    return $return;
}
?>
