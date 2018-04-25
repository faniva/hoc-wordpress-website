<?php

class C5AB_account extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = true;
    public $_options = array();

    function __construct() {

        $id_base = 'account-widget';
        $this->_shortcode_name = 'c5ab_account';
        $name = 'Account';
        $desc = 'Add Account Box. (Login Box)';
        $classes = '';
		
        $this->self_construct($name, $id_base, $desc, $classes);
    }
	
	
	
    function shortcode($atts, $content) {
    	$data = '';	
    	
    	if (!is_user_logged_in()) {
    	$data = '<form name="loginform" class="c5_loginform" action="' . home_url() . '/wp-login.php" method="post" class=" clearfix"><div class="input-wrap"><input type="text" name="log" class="element-block" id="user_login" class="input" placeholder="'.$atts['username_text'].'" size="20" /><span class="fa fa-user"></span></div><div class="clearfix"></div><div class="input-wrap"><input type="password" name="pwd" class="element-block" id="user_pass" class="input" placeholder="'.$atts['password_text'].'" size="20" /><span class="fa fa-lock"></span></div>';
    	        
    	        
    	$data .= '<div class="row"><div class="col-xs-6">';
    	if($atts['checkbox']!='off'){
    		$data .='<p class="login-remember"><label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever">' . $atts['remember_text'] . '</label></p>';
    	}
    	$data .='</div><div class="col-xs-6"><input type="submit" name="wp-submit" id="c5-login-submit" class="button-primary " value="' . $atts['login_text'] . '"></div></div>';
    	        
    	$data .='<p class="login-submit">';
    	
    	if($atts['forget']!='off'){
    	$data .='<a class="c5_forget_password" href="' . wp_lostpassword_url(home_url()) . '">' . $atts['forget_text'] . '</a>';
    	}
    	if($atts['register']!='off'){
    	$data .='<a class="c5_register" href="' . home_url() . '/wp-login.php?action=register">' . $atts['register_text'] . '</a>';
    	}
    	$data .='<input type="hidden" name="redirect_to" value="' . home_url() . '"></p></form>';
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
                'label' => 'Register Button Text',
                'id' => 'register_text',
                'type' => 'text',
                'desc' => 'Add your Register Button Text.',
                'std' => 'Register',
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
                'label' => 'Show Remember Checkbox',
                'id' => 'checkbox',
                'type' => 'on_off',
                'desc' => 'Show Remember Checkbox.',
                'std' => 'on',
            ),
            array(
                'label' => 'Show Forget Link',
                'id' => 'forget',
                'type' => 'on_off',
                'desc' => 'Show Forget Link.',
                'std' => 'on',
            ),
            array(
                'label' => 'Show Register Link',
                'id' => 'register',
                'type' => 'on_off',
                'desc' => 'Show Register Link.',
                'std' => 'on',
            ),
            
         );
    }

    function css() {
        ?>
        <style>
        
        	.input-wrap{
        		position: relative;
        		display: block;
        		padding-right:40px;
        		margin-bottom:10px;
        	}
        	.input-wrap input{
        		display: block;
        		width: 100%;
        		border: none;
        		padding: 12px;
        	}
        	.input-wrap .fa{
        		position: absolute;
        		right: 0px;
        		top: 0px;
        		width: 40px;
        		height: 40px;
        		line-height: 40px;
        		text-align: center;
        		background: #333;
        	}
        	.login-remember label{
        		font-weight: 100;
        		font-size:12px;
        	}
        	.login-remember input{
        		margin: 0px 5px 0px 0px;	
        	}
        	
        	.c5_loginform {
        	  padding: 15px;
        	  background: #eee;
        	}
        	.c5_loginform #c5-login-submit {
        	  background: #aaa;
        	  color: white;
        	}
        	.c5_loginform #c5-login-submit:hover {
        	  background: #333;
        	}
        	.c5_loginform .input-wrap .fa {
        	  color: white;
        	}
        	.single_social_icon .c5_loginform {
        			padding: 0px;
        			background: none;
        	}
        	
        	#c5-login-submit{
        		float: right;
        		border: none;
        		background: #eee;
        		padding: 10px 15px;
        		border-radius: 2px;
        		
        		-moz-transition:all .2s ease;
        		-o-transition:all .2s ease;
        		-webkit-transition:all .2s ease;
        		-ms-transition:all .2s ease;
        		transition:all .2s ease;
        	}
        	#c5-login-submit:hover{
        		color: #eee;
        		background: #333;
        	}
        	p.login-submit{
        		margin: 0px;
        		font-size:12px;
        	}
        	.c5_forget_password{
        		margin-right:10px;
        	}
        	.c5_register{
        		margin-left:10px;
        	}
		
        </style>
        <?php

    }


}
?>