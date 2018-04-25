<?php

class C5AB_social_count extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = true;
    public $_options = array();

    function __construct() {

        $id_base = 'social_count-widget';
        $this->_shortcode_name = 'c5ab_social_count';
        $name = 'Social Followers Count';
        $desc = 'Social Followers Counter.';
        $classes = '';

        $this->self_construct($name, $id_base, $desc, $classes);
    }

    function custom_number_format($n) {

        $precision = 1;

        if ($n < 1000) {
            $n_format = round($n);
        } else if ($n < 1000000) {
            $n_format = round($n / 1000, $precision) . 'K';
        } else {
            $n_format = round($n / 1000000, $precision) . 'M';
        }

        return $n_format;
    }

    function shortcode($atts, $content) {

        $data = '';

        $social_obj = new c5ab_social_counter_Counter();
        $count = $social_obj->update_transients($atts);
        $data .= '<div class="c5ab_social_counter clearfix" ><ul>';
        if ($atts['twitter'] != '') {
            $data .= '<li><a href="http://www.twitter.com/user/' . $atts['twitter'] . '" class="c-twitter" target="_blank"><span class="fa fa-twitter"></span><span class="count">' . $this->custom_number_format($count['twitter']) . '</span></a></li>';
        }
        if ($atts['facebook'] != '') {
            $data .= '<li><a href="http://www.facebook.com/' . $atts['facebook'] . '" class="c-facebook" target="_blank"><span class="fa fa-facebook"></span><span class="count">' . $this->custom_number_format($count['facebook']) . '</span></a></li>';
        }
        if ($atts['google_plus'] != '') {
            $data .= '<li><a href="http://www.google.com/+' . $atts['google_plus'] . '" class="c-google-plus" target="_blank"><span class="fa fa-google-plus"></span><span class="count">' . $this->custom_number_format($count['googleplus']) . '</span></a></li>';
        }
        if ($atts['youtube'] != '') {
            $data .= '<li><a href="http://www.youtube.com/user/' . $atts['youtube'] . '" class="c-youtube" target="_blank"><span class="fa fa-youtube"></span><span class="count">' . $this->custom_number_format($count['youtube']) . '</span></a></li>';
        }

        $data .= '</ul></div>';
        return $data;
    }

    function custom_css() {
        
    }

    function options() {




        $this->_options = array(
            array(
                'label' => 'Twitter username',
                'id' => 'twitter',
                'type' => 'text',
                'desc' => 'Add your social_count username.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Twitter Consumer Key',
                'id' => 'consumerkey',
                'type' => 'text',
                'desc' => 'Add your social_count Consumer Key <a href="http://themepacific.com/how-to-generate-api-key-consumer-token-access-key-for-social_count-oauth/994/" >Click Here to learn about these keys</a>.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Twitter Consumer Secret',
                'id' => 'consumersecret',
                'type' => 'text',
                'desc' => 'Add your social_count Consumer Secret.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Twitter Access Token',
                'id' => 'accesstoken',
                'type' => 'text',
                'desc' => 'Add your social_count Access Token.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Twitter Access Token Secret',
                'id' => 'accesstokensecret',
                'type' => 'text',
                'desc' => 'Add your social_count Access Token Secret.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Facebook username',
                'id' => 'facebook',
                'type' => 'text',
                'desc' => 'Add your Facebook username.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Google Plus username',
                'id' => 'google_plus',
                'type' => 'text',
                'desc' => 'Add your Google Plus username.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
            array(
                'label' => 'Youtube username',
                'id' => 'youtube',
                'type' => 'text',
                'desc' => 'Add your Youtube username.',
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
        );
    }

    function css() {
        ?>
        <style>
            .c5ab_social_counter ul{
                margin: 0px -2px;
                padding: 0px;
                list-style: none;
            }
            .c5ab_social_counter ul li{
                float: left;
            }
            .c5ab_social_counter ul li a{
                width: 70px;
                height: 70px;
                text-align: center;
                font-size: 20px;
                display: block;
                margin: 2px;
                padding: 15px 0px;
                border: 2px solid #333;
                color: #333;
                border-radius: 100%;

                -webkit-transition: all .2s ease;
                -moz-transition: all .2s ease;
                -ms-transition: all .2s ease;
                -o-transition: all .2s ease;
                transition: all .2s ease;
            }
            .c5ab_social_counter ul li a:hover{
                color: white;
                text-decoration:none;
            }
            .c5ab_social_counter ul li a.c-facebook:hover{
                background: #3b5998;
                border-color:#3b5998;
            }
            .c5ab_social_counter ul li a.c-twitter:hover{
                background: #00aced;
                border-color:#00aced;
            }
            .c5ab_social_counter ul li a.c-google-plus:hover{
                background: #dd4b39;
                border-color:#dd4b39;
            }
            .c5ab_social_counter ul li a.c-youtube:hover{
                background: #bb0000;
                border-color:#bb0000;
            }
            .c5ab_social_counter ul li a span{
                display: block;
            }
            .c5ab_social_counter ul li a span.count{
                font-size:14px;
            }
        </style>
        <?php

    }

}
?>