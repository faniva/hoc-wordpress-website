<?php
/**
*
*/
class C5_header extends C5_header_base
{

    function __construct()
    {

    }

    public function render()
    {

        get_template_part('library/includes/header/header-layout-floating');
        get_template_part('library/includes/header/header-mobile');
        if (is_page()) {
            $header_layout =  get_post_meta(get_the_ID() , 'header_layout' , true);
            if ($header_layout == '' || $header_layout == 'default') {
                $header_layout = ot_get_option('header_layout');
            }
        }else{
            $header_layout = ot_get_option('header_layout');
        }
        $header_layout = $this->validate($header_layout);
        get_template_part('library/includes/header/header-layout-' . $header_layout );
        echo '<div id="floating-trigger"></div>';

        $page_info = new C5_Page_Info();
        $page_info->render();
    }



    public function validate($header_layout)
    {
        if ($header_layout == 'layout_1') {
            return 1;
        }
        if ($header_layout == 'layout_2') {
            return 2;
        }
        if ($header_layout == 'layout_3') {
            return 3;
        }
        if ($header_layout == 'layout_4') {
            return 4;
        }
        if ($header_layout == 'layout_5') {
            return 5;
        }
        if ($header_layout == 'layout_6') {
            return 6;
        }
        return 1;
    }

    public function loader()
    {
        $preload = ot_get_option('preload','on');
        if ($preload == 'on') {
            ?>
            <div class="code125-preload-wrap"><img src="<?php echo C5_URI ?>library/images/preload.svg" width="50" /></div>
            <?php
        }
    }
}


?>
