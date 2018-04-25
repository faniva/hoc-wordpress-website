<?php

class C5AB_register extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = true;
    public $_options = array();

    function __construct() {

        $id_base = 'register-widget';
        $this->_shortcode_name = 'c5ab_register';
        $name = 'Account Registeration';
        $desc = 'Add Account Registeration Box.';
        $classes = '';

        $this->self_construct($name, $id_base, $desc, $classes);
    }



    function shortcode($atts, $content) {
        $data = '';
        if (!is_user_logged_in()) {
            $error = false;
            $created = false;
            $message = '';
            $user_name = '';
            $email = '';
            $password = '';
            $password_confirm = '';
            $terms = 'off';
            if (isset($_POST['reg-name'])) {

                $user_name = sanitize_user( $_POST['reg-name'] );
                $email = sanitize_email( $_POST['reg-email'] );
                $password = esc_attr( $_POST['reg-pass'] );
                $password_confirm = esc_attr( $_POST['reg-repass'] );
                $terms = esc_attr($_POST['reg-terms']);
                if (username_exists($user_name)) {
                    $error = true;
                    $message .=  '<p>'.$atts['user_error'].'</p>';
                }
                if (email_exists($user_name)) {
                    $error = true;
                    $message .=  '<p>'.$atts['email_error'].'</p>';
                }
                if ((  $password != $password_confirm ) || $password =='') {
                    $error = true;
                    $message .=  '<p>'.$atts['error_password'].'</p>';
                }
                if($atts['agree_text']!=''){
                    if ($terms != 'on') {
                        $error = true;
                        $message .=  '<p>'.$atts['terms_error'].'</p>';
                    }
                }
                if (!$error) {
                    $user_id = wp_create_user( $user_name, $password, $email );
                    wp_set_auth_cookie( $user_id, true );
                    $created = true;
                }

            }
            if ($created) {
                return '';
            }
            $data .= '<div class="c5-login-full c5-registration"><div class="c5-content"><div class="c5-con-data">';

            $data .= '<div class="c5-title"><h5>'.$atts['section_title'].'</h5></div>';


            $data .= '<div class="c5-form c5-form-style">';

            if ($error) {
                $data .= '<div class="c5-error">'.$message.'</div>';
            }

            $data .= '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post" >';

            $data .= '<div class="row">';

            $data .= '<div class="col-md-6"> <input type="text" id="reg-name" name="reg-name" value="'.$user_name.'" placeholder="'.$atts['username_text'].'"></div>';

            $data .= '<div class="col-md-6"><input type="text" id="reg-email" name="reg-email" value="'.$email.'" placeholder="'.$atts['email_text'].'"></div>';
            $data .= '<div class="col-md-6"><input type="password" id="reg-pass" name="reg-pass" value="'.$password.'" placeholder="'.$atts['password_text'].'"></div>';

            $data .= '<div class="col-md-6"><input type="password" id="reg-repass" name="reg-repass" value="'.$password_confirm.'"  placeholder="'.$atts['confirm_password_text'].'"></div>';

            if($atts['agree_text']!=''){
                $data .= '<div class="col-md-12"><div class="c5-form-checkbox"><label for="reg-terms"><input type="checkbox" value="'.$terms.'" id="reg-terms" name="reg-terms"><a href="'.$atts['agree_link'].'">'.$atts['agree_text'].'</a></label></div></div>';
            }
            $data .= '<div class="col-md-12"><button class="btn c5-btn-theme-dark c5-lg" type="submit">'.$atts['register_text'].'</button></div>';


            $data .= '</div></form></div>';
            $data .= '</div></div></div>';


            /////

        }

        return $data;
    }

    function custom_css() {



    }

    function options() {



        $this->_options = array(
            array(
                'label' => 'Registration Title',
                'id' => 'section_title',
                'type' => 'text',
                'desc' => 'Add Registration Box Title.',
                'std' => 'Create New Account',
            ),
            array(
                'label' => 'Username Placeholder Text',
                'id' => 'username_text',
                'type' => 'text',
                'desc' => 'Add your Username Placeholder text.',
                'std' => 'User Name (Login Name)',
            ),
            array(
                'label' => 'Email Placeholder Text',
                'id' => 'email_text',
                'type' => 'text',
                'desc' => 'Add your Email Placeholder text.',
                'std' => 'Your Email',
            ),

            array(
                'label' => 'Confirm Password Placeholder Text',
                'id' => 'password_text',
                'type' => 'text',
                'desc' => 'Add your Confirm Password Placeholder text.',
                'std' => 'Your Password',
            ),
            array(
                'label' => 'Password Placeholder Text',
                'id' => 'confirm_password_text',
                'type' => 'text',
                'desc' => 'Add your Password  Placeholder text.',
                'std' => 'Confirm Your Password',
            ),
            array(
                'label' => 'Terms and Conditions text',
                'id' => 'agree_text',
                'type' => 'text',
                'desc' => 'Terms and Conditions text.',
                'std' => 'Agree with Terms & Conditions',
            ),
            array(
                'label' => 'Terms and Conditions link',
                'id' => 'agree_link',
                'type' => 'text',
                'desc' => 'Terms and Conditions link.',
                'std' => '#',
            ),
            array(
                'label' => 'Create Account text',
                'id' => 'register_text',
                'type' => 'text',
                'desc' => 'Create Account text.',
                'std' => 'Create My Account',
            ),


            array(
                'label' => 'Username validation error message',
                'id' => 'error_username',
                'type' => 'text',
                'desc' => 'Username validation error message.',
                'std' => 'Username already existed. Please choose another username',
            ),
            array(
                'label' => 'Email validation error message',
                'id' => 'error_email',
                'type' => 'text',
                'desc' => 'Email validation error message.',
                'std' => 'Email already existed. Please choose another Email',
            ),
            array(
                'label' => 'Passowrd validation error message',
                'id' => 'error_password',
                'type' => 'text',
                'desc' => 'Passowrd validation error message.',
                'std' => 'Passowrd Missmatch. Please make sure that passwords are matched.',
            ),
            array(
                'label' => 'Terms validation error message',
                'id' => 'terms_error',
                'type' => 'text',
                'desc' => 'Terms validation error message.',
                'std' => 'Please Agree on the terms & conditions',
            ),



        );
    }


}
?>
