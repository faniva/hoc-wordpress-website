<?php

class C5AB_login extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = true;
    public $_options = array();

    function __construct() {

        $id_base = 'login-widget';
        $this->_shortcode_name = 'c5ab_login';
        $name = 'Account Login';
        $desc = 'Add Account Login Box.';
        $classes = '';

        $this->self_construct($name, $id_base, $desc, $classes);
    }



    function shortcode($atts, $content) {
        $data = '';
        if (!is_user_logged_in()) {
            $data .= '<div class="c5-login-full c5-alt-1"><div class="c5-content"><div class="c5-con-data"><div class="c5-log-reg"><div class="c5-form c5-form-style">';
            $data .= '<form name="loginform" class="c5_loginform clearfix" action="' . esc_url(home_url() . '/wp-login.php').'" method="post" >';
            $data .= '<input type="text" id="user" name="log" placeholder="'.$atts['username_text'].'">';
            $data .= '<input type="password" id="password" name="pwd" placeholder="'.$atts['password_text'].'">';

            $data .= '<div class="c5-form-checkbox"><label for="checkboxes"><input name="rememberme" type="checkbox" id="rememberme" value="forever"> ' . $atts['remember_text'] . '</label>';
            $data .= '<a href="'.wp_lostpassword_url().'" class="c5-btn-text pull-right">' . $atts['forget_text'] . '</a>
            </div>';

            $data .= '<input type="hidden" name="redirect_to" value="' . home_url() . '">';
            $data .= '<button class="btn c5-btn-theme" type="submit">' . $atts['login_text'] . '</button></form></div>';

            $data .= '<div class="c5-register"><div class="c5-reg-title"><h5>' . $atts['register_title'] . '</h5></div>';
            $data .= '<div class="c5-reg-data"><p>' . $atts['register_desc'] . '</p></div><div class="c5-reg-btn"><a href="' . $atts['register_link'] . '" class="btn c5-btn-theme c5-lg" type="submit">' . $atts['register_text'] . '</a></div></div>';

            $data .= '</div></div></div></div>';
        }

        return $data;
    }

    function custom_css() {



    }

    function options() {



        $this->_options = array(
            array(
                'label' => 'Username Placeholder Text',
                'id' => 'username_text',
                'type' => 'text',
                'desc' => 'Add your Username  Placeholder text.',
                'std' => 'Username',
            ),
            array(
                'label' => 'Password Placeholder Text',
                'id' => 'password_text',
                'type' => 'text',
                'desc' => 'Add your Password  Placeholder text.',
                'std' => '******',
            ),
            array(
                'label' => 'Login Button Text',
                'id' => 'login_text',
                'type' => 'text',
                'desc' => 'Add your Login Button Text.',
                'std' => 'Login',
            ),

            array(
                'label' => 'Forget Password Text',
                'id' => 'forget_text',
                'type' => 'text',
                'desc' => 'Add your Forget Password Text.',
                'std' => 'Forget Password ?',
            ),
            array(
                'label' => 'Remember Me Text',
                'id' => 'remember_text',
                'type' => 'text',
                'desc' => 'Add your Remember Me Text.',
                'std' => 'Remember me ?',
            ),
            array(
                'label' => 'Show Forget Link',
                'id' => 'forget',
                'type' => 'on_off',
                'desc' => 'Show Forget Link.',
                'std' => 'on',
            ),
            array(
                'label' => 'Register Section Title',
                'id' => 'register_title',
                'type' => 'text',
                'desc' => 'Add your Register Section Title.',
                'std' => 'Not a Member',
            ),
            array(
                'label' => 'Register Section Description',
                'id' => 'register_desc',
                'type' => 'text',
                'desc' => 'Add your Register Section Description.',
                'std' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus, omnis! Consequuntur magni doloribus velit perspiciatis natus.',
            ),
            array(
                'label' => 'Register Button Text',
                'id' => 'register_text',
                'type' => 'text',
                'desc' => 'Add your Register Button Text.',
                'std' => 'Register',
            ),
            array(
                'label' => 'Registeration Page Link',
                'id' => 'register_link',
                'type' => 'text',
                'desc' => 'Add your Register Button Text.',
                'std' => wp_registration_url(),
            ),

        );
    }


}
?>
