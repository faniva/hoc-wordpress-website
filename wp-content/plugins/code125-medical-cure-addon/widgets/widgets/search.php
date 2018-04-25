<?php

class C5AB_search extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = true;
    public $_options = array();
    public $post_type;
    function __construct() {

        $id_base = 'search-widget';
        $this->_shortcode_name = 'c5ab_search';
        $name = 'Search';
        $desc = 'Add Search Box.';
        $classes = '';

        $this->self_construct($name, $id_base, $desc, $classes);
    }



    function shortcode($atts, $content) {

        $form = '<div id="c5ab_widget_search" class="clearfix">';
        $form .= '<form role="search" method="get" id="c5_searchform" action="'. home_url( '/' ).'" >';
        $form .= '<input type="text" value="'. get_search_query() .'" name="s" id="c5ab_search_field" placeholder="'.$atts['search_text'].'" />';
        $form .= '</form>
        </div><div class="clearfix"></div>';

        return $form;
    }

    function options() {

        $this->_options = array(
            array(
                'label' => 'Placeholder Text',
                'id' => 'search_text',
                'type' => 'text',
                'desc' => 'Add your Placeholder text.',
                'std' => 'Search our website ...',
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
        #c5ab_search_field{
            width: 100%;
            border-radius: 3px;
            padding: 10px;
            border: 1px solid #ccc;
            color: #333;
            display: block;
            float: left;
        }

        </style>
        <?php

    }

    


}
?>
