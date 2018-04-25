<?php

class C5_header_base {

    function __construct() {

    }

    function get_article_rtl_class() {
        $class = ' ';
        $c5_rtl = get_post_meta(get_the_ID() , 'c5_rtl' , true);
        if ($c5_rtl == 'on') {
            $class = ' rtl ';
        }
        return $class;
    }


    function social_icons($layout = 'layout-1') {
        echo $this->get_social_icons($layout);
    }

    public function get_social_icons($layout = 'layout-1')
    {
        $social_icons = ot_get_option('social_icons', array());
        $icons = array();
        foreach ($social_icons as $social_icon) {
            $icons[] = array(
                'icon'=> $social_icon['icon'],
                'link' => $social_icon['link'],
                'title' => $social_icon['title'],
            );
        }
        $instance = array(
            'layout' => $layout,
            'c5ab_social_icon' => $icons
        );
        return code125_do_shortcode( 'C5AB_social_icons', $instance);
    }

    public function main_menu($location= 'main-nav', $style ='default')
    {
        if (has_nav_menu($location)) {
            $menu = wp_nav_menu(array(
                'container' => false, // remove nav container
                'container_class' => 'menu clearfix', // class of container (should you choose to use it)
                'menu' => 'The Main Menu', // nav name
                'menu_class' => ' top-nav menu-sc-nav clearfix', // adding custom nav class
                'theme_location' => $location, // where it's located in the theme
                'before' => '', // before the menu
                'after' => '', // after the menu
                'link_before' => '', // before each link
                'link_after' => '', // after each link
                'depth' => 3,
                'echo' => 0,
                'walker' => new C5_description_walker()));


            echo '<nav class="navigation-shortcode responsive-on light '.$style.' top-menu-nav clearfix">' . $menu . '</nav>';
        } else {

            $args = array(
                'depth' => 0,
                'sort_column' => 'menu_order, post_title',
                'menu_class' => 'top-nav menu-sc-nav c5-pages-menu clearfix',
                'include' => '',
                'exclude' => '',
                'echo' => false,
                'show_home' => true,
                'link_before' => '',
                'link_after' => '');
            echo '<nav class="c5-pages-menu-wrap navigation-shortcode responsive-on light '.$style.' top-menu-nav clearfix" style="display:none;"><div class="responsive-controller clearfix"><span class="menu-enable icon-menu"></span></div>' . wp_page_menu($args) . '</nav>';

        }
    }

    public function get_language_switcher()
    {
        if (function_exists('icl_get_languages')) {
            $langs = icl_get_languages();
            
            if (!empty($langs)) {

                $top = '';
                $lis = '';
                foreach ($langs as $language) {
                    $class = $language['active'] == '1' ? 'class="active"' : '';
                    if ($language['active'] == '1') {
                        $top =  '<p class="first-element clearfix"><img src="'.$language['country_flag_url'].'" alt="'.$language['code'].'" /><span class="lang-code">'.$language['code'].'</span><i class="fa fa-angle-down"></i></p>';
                    }
                    $lis .= '<li '.$class.'><a href="'.$language['url'].'" class="clearfix" ><img src="'.$language['country_flag_url'].'" alt="'.$language['code'].'" /><span class="lang-code">'.$language['code'].'</span></a></li>';
                }
                echo '<div class="code125-language-switcher-wrap">' . $top;
                echo '<ul class="code125-language-switcher">' . $lis .'</ul>';
                echo '</div>';
            }
        }
    }



    public function get_search_placeholder()
    {
        return ot_get_option('search_placeholder','Search your website');
    }



    public function header_btn()
    {
        $return = '';

        $html = code125_format_button( ot_get_option('header_btn')  , 'btn c5-btn-theme');
        if ($html != '') {
            $return = '<div class="c5-call-head">' . $html . '</div>';
        }
        echo $return;
    }

    public function header_info()
    {
        $header_info = ot_get_option('header_info');
        if($header_info != ''){
            ?>
            <div class="c5-info-top-bar">
                <ul>
                    <?php
                    foreach ($header_info as $info) {
                        $html = '<li>';
                        if ($info['link']!= '') {
                            $href = '';
                            if ($info['type'] == 'email') {
                                $href = 'mailto:';
                            }elseif($info['type'] == 'phone'){
                                $href = 'tel:';
                            }elseif($info['type'] == 'skype'){
                                $href = 'skype:';
                            }
                            $html .= '<a href="'.$href.$info['link'].'">';
                        }
                        $html .= '<i class="c5-header-icon '.$info['icon'].'"></i>' . $info['title'];
                        if ($info['link']!= '') {
                            $html .= '</a>';
                        }
                        $html .= '</li>';
                        echo $html;
                    }
                    ?>
                </ul>
            </div>
            <?php
        }
    }

    public function header_info_mobile()
    {
        $header_info = ot_get_option('header_info');
        $code = '';
        if($header_info != ''){

            $icons = array();
            foreach ($header_info as $social_icon) {
                if(!isset($social_icon['link']) && $social_icon['link']!=''){
                    if ($social_icon['type'] == 'email') {
                        $social_icon['link'] = 'mailto:' . $social_icon['link'];
                    }elseif($social_icon['type'] == 'phone'){
                        $social_icon['link'] = 'tel:' . $social_icon['link'];
                    }elseif($info['type'] == 'skype'){
                        $social_icon['link'] = 'skype:' . $social_icon['link'];
                    }
                }
                if(!isset($social_icon['title'])){
                    $social_icon['title'] = '';
                }
                $icons[] = array(
                    'icon'=> $social_icon['icon'],
                    'link' => $social_icon['link'],
                    'title' => $social_icon['title'],
                );
            }
            $instance = array(
                'layout' => 'layout-2',
                'c5ab_social_icon' => $icons
            );
            echo code125_do_shortcode( 'C5AB_social_icons', $instance);
        }
    }

    public function header_info_layout_2()
    {
        $header_info = ot_get_option('header_info');
        if($header_info != ''){
            ?>
            <div class="c5-info-top-bar clearfix">
                <ul>
                    <?php
                    foreach ($header_info as $info) {
                        $html = '<li>';
                        if ($info['link']!= '') {
                            $href = '';
                            if ($info['type'] == 'email') {
                                $href = 'mailto:';
                            }elseif($info['type'] == 'phone'){
                                $href = 'tel:';
                            }elseif($info['type'] == 'skype'){
                                $href = 'skype:';
                            }
                            $html .= '<a href="'.$href.$info['link'].'">';
                        }
                        $html .= '<i class="c5-header-icon '.$info['icon'].'"></i>';
                        $html .= '<span class="title">'.$info['title'].'</span>';
                        $html .= '<span class="subtitle">'.$info['subtitle'].'</span>';

                        if ($info['link']!= '') {
                            $html .= '</a>';
                        }
                        $html .= '</li>';
                        echo $html;
                    }
                    ?>
                </ul>
            </div>
            <?php
        }
    }

    function get_search_html($class = ''){

        $search_on = ot_get_option('search_on');
        if ($search_on!= 'off') {
            ?>
            <!-- Search-box -->
            <div class="c5-header-search <?php echo $class; ?>">
                <div class="c5-icons">
                    <span class="flaticon-magnifying-glass-1"></span>
                    <span class="fa fa-close"></span>
                </div>
                <form class="c5-content-search" method="get" action="<?php echo esc_url( home_url('/') ); ?>">
                    <input type="text" name="s" placeholder="<?php echo $this->get_search_placeholder(); ?>">
                    <button type="submit" class="btn btn-transparent"><span class="fa fa-search"></span></button>
                </form>
            </div>
            <!-- ./Search-box -->
            <?php
        }
    }


}
?>
