<?php
/**
 *
 */
class C5_FW_META_BOX
{

    function __construct(){
        add_action('admin_init', array($this, 'meta_boxes'));
    }

    public function meta_boxes()
    {
        $post_types = array();

        $args = array('show_ui' => true);
        $output = 'objects'; // names or objects
        $post_types_all = get_post_types($args, $output);

        $exlude_array_no_page = array(
            'attachment',
            'skin',
            'header',
            'footer',
            'page',
            'post',
            'cpt',
            'wpcf7_contact_form'
        );
        $exlude_array_no_page = apply_filters('c5_metadata_post_types_exlude' , $exlude_array_no_page);

        foreach ($post_types_all as $key => $post_type) {
            if (!in_array($key, $exlude_array_no_page)) {
                $post_types[] = $key;
            }
        }

        $theme_name = apply_filters( 'c5_theme_name', 'Code125' );
        $this->meta_box('c5_fw_meta_box_post' , 'post', $theme_name . ' Meta Options');
        $this->meta_box('c5_fw_meta_box_page' , 'page', $theme_name . ' Meta Options');
        $this->meta_box('c5_fw_meta_box_rest' , $post_types , $theme_name . ' Meta Options');

    }
    function meta_box($filter , $post_type, $title){

        $options = array();

        $sections = array();
        $sections = apply_filters( $filter , $sections );

        usort($sections, array($this, 'section_order'));
        foreach ($sections as $section) {
			$single_options = array();
			$id = strtolower( str_replace(' ', '_' , $section['title']) );
			$single_options[] = array(
				'label'       =>  $section['title'],
				'id'          => $id,
				'type'        => 'tab'
			);
			$single_options = array_merge($single_options , $section['options'] );

			$options  = array_merge($options , $single_options );
		}
        $id = strtolower(str_replace(' ', '_' , $title));
		$my_meta_box = array(
			'id'          => $id,
			'title'       => $title,
			'desc'        => '',
			'pages'       => $post_type,
			'context'     => 'normal',
			'priority'    => 'high',
			'fields'      => $options
		);
		ot_register_meta_box( $my_meta_box );
    }

    public function section_order($a, $b)
    {
        if (!isset($a['order'])) {
            $a['order'] = 9999;
        }
        if (!isset($b['order'])) {
            $b['order'] = 9999;
        }
        return ($a['order'] < $b['order']) ? -1 : 1;
    }
}

$obj = new C5_FW_META_BOX();
?>
