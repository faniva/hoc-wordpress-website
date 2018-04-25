<?php

class C5_banner_content_Widget extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	public  $_skip_title = true;

	function __construct() {

		$id_base = 'banner-content-widget';
		$this->_shortcode_name = 'c5_banner_content';
		$name = esc_html__('Banner Content', 'medical-cure');
		$desc = esc_html__('Add Banner content to your page. This element provides title, subtitle and a content and two buttons.', 'medical-cure');
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);

	}

    function shortcode($atts , $content){

		$data = '';
		$classes = array();
		$classes[] = 'code125-banner-content';
		if($atts['layout'] == 'layout-7'){
			$atts['content_align'] = 'center';
		}
		if ($atts['layout'] == 'layout-5') {
			$classes[] = 'c5-dark-background';
		}
		$classes[] = 'code125-banner-content-align-' . $atts['content_align'];
		if (!isset($_GET['c5_no_animation'])) {
			$classes[] = 'code125-banner-content-animation-' . $atts['animation'];
		}

		$classes[] = 'code125-banner-content-' . $atts['layout'];
		$classes[] = 'clearfix';

        $data .= '<div class="'.implode($classes,' ').'">';



		$data .= $this->get_content($atts);

        if ($content !='') {
			$id = $this->generate_unique_id();
            $data .=  '<div class="code125-banner-text code125-banner-text-'.$id.'">' . wpautop($content) .'</div>';
			if ($atts['content-color']!='') {
				$data .= '<style>.code125-banner-content .code125-banner-text-'.$id.'{ color: '.$atts['content-color'].';}</style>';
			}

        }

		$data .= code125_format_button($atts['button_1'], 'btn inverse code125-banner-btn');
		$data .= code125_format_button($atts['button_2'], 'btn inverse code125-banner-btn');

        $data .= '</div>';

        return $data;
    }

	public function get_content($atts)
	{
		$layouts= array(
			'layout-text',
			'layout-1',
			'layout-4',
			'layout-7'
		);
		$data = '';
		if (in_array($atts['layout'] , $layouts)) {
			$data .= code125_format_title($atts['subtitle'], 'h4');
			$data .= code125_format_title($atts['title'], 'h3');
		}else{
			$data .= code125_format_title($atts['title'], 'h3');
			$data .= code125_format_title($atts['subtitle'], 'h4');
		}
		return $data;
	}

	function options() {
		$layouts  = array(
            'layout-plain' => 'Layout Plain',
			'layout-4' => 'Layout 4',
            'layout-2' => 'Layout 2',
            'layout-3' => 'Layout 3',
			'layout-6' => 'Layout 6',
			'layout-5' => 'Layout 5',
			'layout-1' => 'Layout 1',
			'layout-7' => 'Layout 7',
			'layout-text' => 'Layout Text',
         );

        $choices = array();
        foreach ($layouts as $key => $label) {
            $choices[] = array(
                'src' => C5_OPTIONS_IMG_URL . 'banners/' . $key . '.png',
                'src_2x' => C5_OPTIONS_IMG_URL . 'banners/' . $key . '@2x.png',
                'label' => $label,
                'value' => $key
            );
        }

		$this->_options =array(

			array(
			    'label' => 'Choose Banner layout',
			    'id' => 'layout',
			    'type' => 'radio-image',
			    'desc' => '',
			    'choices' => $choices,
			    'std' => 'layout-plain',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			),
			array(
			    'label' => 'Content Align',
			    'id' => 'content_align',
			    'type' => 'select',
			    'desc' => 'Content Align',
			    'std' => 'left',
                'choices' => array(
                    array(
                        'label' => 'Left',
                        'value' => 'Left'
                    ),
                    array(
                        'label' => 'Center',
                        'value' => 'center'
                    ),
                    array(
                        'label' => 'Right',
                        'value' => 'right'
                    ),
                ),
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Enable Animation',
			    'id' => 'animation',
			    'type' => 'on-off',
			    'desc' => 'Enable Animation for this content ',
			    'std' => 'on',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Title',
			    'id' => 'title',
			    'type' => 'extended-title',
			    'desc' => 'Title ',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Subtitle',
			    'id' => 'subtitle',
			    'type' => 'extended-title',
			    'desc' => 'Subtitle.',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
            array(
			    'label' => 'Content',
			    'id' => 'content',
			    'type' => 'wp_editor',
			    'desc' => '',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
			array(
			    'label' => 'Content Color',
			    'id' => 'content-color',
			    'type' => 'colorpicker',
			    'desc' => 'Content Color overwrite',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
            array(
			    'label' => 'Button 1',
			    'id' => 'button_1',
			    'type' => 'button',
			    'desc' => 'Button 1',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
            array(
			    'label' => 'Button 2',
			    'id' => 'button_2',
			    'type' => 'button',
			    'desc' => 'Button 2',
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => ''
			),
		);
	}

	function admin_footer_js() {
        return;
        $field_id = 'widget_text_widget_daiufi_content';
        ?>
        <script type="text/javascript">


            ;
            (function($) {


                var new_id = $('#c5_sample_editor_id').val();


				delete window.tinyMCEPreInit.mceInit[new_id];
				delete  window.tinyMCEPreInit.qtInit[new_id];

				window.tinyMCEPreInit.mceInit[new_id] = _.extend({}, tinyMCEPreInit.mceInit['content'], {resize: 'vertical', height: 200});

				if (_.isUndefined(tinyMCEPreInit.qtInit[new_id])) {
                    window.tinyMCEPreInit.qtInit[new_id] = _.extend({}, tinyMCEPreInit.qtInit['replycontent'], {id: new_id})
                }


				qt = quicktags(window.tinyMCEPreInit.qtInit[new_id]);
                QTags._buttonsInit();
                window.switchEditors.go(new_id, 'tmce');
                tinymce.execCommand('mceRemoveEditor', true, new_id);
                tinymce.execCommand('mceAddEditor', true, new_id);



//				tinymce.init( window.tinyMCEPreInit.mceInit[new_id] );


            })(jQuery);

        </script>
        <?php

    }



}


 ?>
