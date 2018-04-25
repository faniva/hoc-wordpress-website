<?php
/**
 *
 */
class C5_AO_THEME extends C5_theme_option_elements
{

    function __construct() { }

    public function hook()
    {
        add_filter( 'c5_ao_meta_box', array($this, 'meta_box') );
    }

    public function meta_box()
    {
        $options = array();

        $options[] = array(
            'post_type' => 'header',
            'title' => 'Logo',
            'options' => $this->get_logo_options('')
        );

        $options[] = array(
            'post_type' => 'header',
            'title' => 'Header',
            'options' => $this->get_header_options('')
        );


        //skin
        $options[] = array(
            'post_type' => 'skin',
            'title' => 'Layout Settings',
            'options' => $this->get_layout_options('')
        );

        $options[] = array(
            'post_type' => 'skin',
            'title' => 'Color Settings',
            'options' => $this->get_colors_options('')
        );

        $options[] = array(
            'post_type' => 'skin',
            'title' => 'Fonts Settings',
            'options' => $this->get_fonts_options('')
        );





        return $options;
    }
}
$obj = new C5_AO_THEME();
$obj->hook();
?>
