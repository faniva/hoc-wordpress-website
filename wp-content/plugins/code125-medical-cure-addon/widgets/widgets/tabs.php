<?php

class C5AB_tabs extends C5_Widget {

    public $_shortcode_name;
    public $_shortcode_bool = false;
    public $_options = array();

    function __construct() {

        $id_base = 'tabs-widget';
        $this->_shortcode_name = 'c5ab_tabs';
        $name = 'Tabs';
        $desc = 'Add Tabs box.';
        $classes = '';

        $this->self_construct($name, $id_base, $desc, $classes);
    }

	function get_content($tab) {
		$content  = '';
		if( $tab['post'] == ''){
			$content = wpautop( $tab['tab_content'] );
		}else{

			$type = get_post_type( $tab['post'] );
			$args = array(
				'p'=>$tab['post'],
				'post_type' => $type
			);
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) {
			    while ( $the_query->have_posts() ) {
					$the_query->the_post();
                    $data = get_post_meta( get_the_ID(), 'c5ab_data', true );
                    $class ='';
                    if ($data == '' || $data == 'YTowOnt9') {
                    	$class = ' code125-article-layout-common code125-article-layout-1 ';
                    }
					$content .= '<div class="'.$class.'"><div class="c5-entry entry-content">'. apply_filters( 'the_content',  get_the_content() ). '</div></div>';
				}
			}
			wp_reset_postdata();

		}
		return $content;
	}
    function shortcode($atts, $content) {

        $tab_id = $this->get_unique_id();

        $counter = 1;

        $return = '';


        $design = ($atts['design'] != '') ?  $atts['design'] : 'normal';

        if( c5_is_mobile() ){
            if ($atts['type'] == 'side' || $atts['type'] == 'side-left') {
                $atts['type'] = 'tabs';
            }
        }

        if (isset($atts['c5ab_tab']) && is_array($atts['c5ab_tab'])) {
            if ($atts['type'] == 'tabs') {


                $tabs = '';
                $panes = '';
                foreach ($atts['c5ab_tab'] as $tab) {
                    $class = '';
                    $display = 'style="display:none;"';
                    if ($counter == 1) {
                        $class = "current";
                        $display = 'style="display:block;"';
                        $counter++;
                    }
                    $unique_id = $this->get_unique_id();

                    $tabs .= '<li class="' . $class . '" data-id="'.$unique_id.'"><span class="c5-icon ' . $tab['icon'] . '" ></span><span class="text">' . $tab['title'] . '</span></li>';
                    $panes .= '<div class="c5-pane clearfix pane-'.$unique_id.'" '.$display.'>' . $this->get_content($tab) . '</div>';

                }
                $return = '<div class="c5-tabs-wrap c5-tabs-layout-'.$design.' clearfix"><ul class="c5-tabs c5-tabs-' . $tab_id . ' clearfix">' . $tabs . '</ul><div class="c5-panes">' . $panes . '</div></div>' . "\n";

            } elseif ($atts['type'] == 'side' || $atts['type'] == 'side-left') {
                $tabs = '';
                $panes = '';
                if ($design == 'light') {
                    $design = '-'. $design;
                }else{
                    $design = '';
                }
                foreach ($atts['c5ab_tab'] as $tab) {
                    if ($tab['icon'] != '' && $tab['icon'] != 'none') {
                        $icon = '<span class="c5-icon ' . $tab['icon'] . '"></span>';
                    } else {
                        $icon = '';
                    }

                    $unique_id = $this->get_unique_id();

                    $class = '';
                    $display = 'style="display:none;"';
                    if ($counter == 1) {
                        $class = "current";
                        $display = 'style="display:block;"';
                        $counter++;
                    }
                    $end_span = '';
                    if ($design == '') {
                        $end_span = '<span class="c5-span-icon fa fa-angle-right"></span>';
                    }
                    $tabs .= '<li class="' . $class . '" data-id="'.$unique_id.'"><span class="li-wrap">' . $icon . '<span class="text">' . $tab['title'] . '</span></span>'.$end_span.'</li>';
                    $panes .= '<div class="c5-pane clearfix pane-'.$unique_id.'" '.$display.'>' . $this->get_content($tab) . '</div>';
                }
                $class = isset($atts['sticky_columns']) && $atts['sticky_columns'] == 'on' ? ' code125-sticky-content ' : '';
				if ($atts['type'] == 'side'){
                	$return = '<div class="c5-tabs-wrap c5-tabs-layout-side'.$design.' c5-tabs-right  clearfix"><div class="c5-panes '.$class.'">' . $panes . '</div><ul class="c5-tabs '.$class.' clearfix">' . $tabs . '</ul></div>';
                }else {
                	$return = '<div class="c5-tabs-wrap c5-tabs-layout-side'.$design.' c5-tabs-left clearfix"><ul class="c5-tabs '.$class.' clearfix">' . $tabs . '</ul><div class="c5-panes '.$class.'">' . $panes . '</div></div>';
                }

            } elseif ($atts['type'] == 'accordion') {
                $tabs = '';
                foreach ($atts['c5ab_tab'] as $tab) {
                    $unique_id = $this->get_unique_id();
                    $class = '';
                    $display = 'style="display:none;"';
                    if ($counter == 1) {
                        $class = "current";
                        $display = 'style="display:block;"';
                        $counter++;
                    }

                    $plus_minus = '<span class="c5-tabs-plus-minus"><i class="fa fa-plus"></i><i class="fa fa-minus"></i></span>';

                    $tabs .= '<div class="c5-accordion-single">';
                    $tabs .= '<div class="c5-accordion-tab '.$class.'" data-id="'.$unique_id.'">'.$plus_minus.'<span class="c5-icon ' . $tab['icon'] . '" data-id="'.$unique_id.'"></span><span class="text">' . $tab['title'] . '</span></div>';
                    $tabs .= '<div class="c5-pane pane-'.$unique_id.'" '.$display.'>' . $this->get_content($tab) . '</div>';
                    $tabs .= '</div>';
                    $counter++;
                }
                $return = '<div class="c5-accordion c5-layout-'.$design.' c5-accordion-'.$tab_id.'">' . $tabs . '</div>';


            }
        }
        return do_shortcode($return);
    }

    function get_unique_id() {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < 5; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }




    function options() {


        $tabs = array(
            'tabs',
            'side',
            'side-left',
            'accordion',
        );
        $tabs_array = array();
        foreach ($tabs as $value) {
            $tabs_array[] = array(
                'src' => C5_OPTIONS_IMG_URL . 'tabs/' . $value . '.png',
                'label' => '',
                'value' => $value
            );
        }


        $this->_options = array(
            array(
                'label' => 'Tabs type',
                'id' => 'type',
                'type' => 'radio-image',
                'desc' => '',
                'choices' => $tabs_array,
                'std' => 'tabs',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => ''
            ),
            array(
			    'label' => 'Tabs Design',
			    'id' => 'design',
			    'type' => 'select',
			    'desc' => 'Choose Tabs Design.',
			    'choices' => array(
			        array(
			            'label' => 'Normal',
			            'value' => 'normal'
			        ),
			        array(
			            'label' => 'Light',
			            'value' => 'light'
			        ),
			    ),
			    'std' => 'normal',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),

            array(
			    'label' => 'Enable  Sticky Columns for Side Tabs',
			    'id' => 'sticky_columns',
			    'type' => 'on-off',
			    'desc' => 'Enable  Sticky Columns for Side Tabs.',
			    'std' => 'off',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
            array(
                'label' => 'Add tab to the tabs box',
                'id' => 'c5ab_tab',
                'type' => 'list-item',
                'desc' => '',
                'settings' => array(
                    array(
                        'label' => 'Icon',
                        'id' => 'icon',
                        'type' => 'icon-list',
                        'desc' => '',
                        'std' => 'fa fa-none',
                        'rows' => '',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => 'c5ab_icons'
                    ),
                    array(
                        'label' => 'Post ID',
                        'id' => 'post',
                        'type' => 'text',
                        'desc' => 'Get the content from a post, add the post ID here',
                        'std' => '',
                        'rows' => '8',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => '',
                    ),
                    array(
                        'label' => 'Content',
                        'id' => 'tab_content',
                        'type' => 'textarea-simple',
                        'desc' => '',
                        'std' => '',
                        'rows' => '8',
                        'post_type' => '',
                        'taxonomy' => '',
                        'class' => '',
                    )
                ),
                'std' => '',
                'rows' => '',
                'post_type' => '',
                'taxonomy' => '',
                'class' => ''
            ),
        );
    }


}
?>
