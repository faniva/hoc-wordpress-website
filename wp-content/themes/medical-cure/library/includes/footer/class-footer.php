<?php
/**
*
*/
class C5_footer
{

    function __construct()
    {

    }
    public function hook()
    {

    }
    public function render()
    {
        get_template_part('library/includes/footer/footer-layout' );
    }

}
$footer_object = new C5_footer();
$footer_object->hook();
?>
