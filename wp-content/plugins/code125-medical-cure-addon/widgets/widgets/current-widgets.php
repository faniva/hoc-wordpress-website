<?php 

class C5AB_current_widgets extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();
	
	
	function __construct() {
		
		$id_base = 'current_widgets-widget';
		$this->_shortcode_name = 'c5ab_current_widgets';
		$name = 'Choose Existing Widget';
		$desc = 'Choose exisiting widget instance in sidebar.';
		$classes = '';
		
		$this->self_construct($name, $id_base , $desc , $classes);
		
		
	}
	
	
	function shortcode($atts,$content) {
		global $wp_registered_widgets;
		
		$info = explode('#', $atts['widget']);
		
		$widget = $info[1];
		$widget_type = trim( substr( $widget, 0, strrpos( $widget, '-' ) ) );
		$widget_type_index = trim( substr( $widget, strrpos( $widget, '-' ) + 1 ) );
		$widget_options = get_option( 'widget_' . $widget_type );
		
		$class = get_class($wp_registered_widgets[$widget]['callback'][0]);
		
		if(!class_exists($class)){
			return;
		}
		
		$the_widget = new $class;
		
		ob_start();
		$the_widget->widget( array(
			'before_widget' => '<div class="">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
			'widget_id' => 'widget-'
		), $widget_options[$widget_type_index] );
		
		$content = ob_get_contents();
		ob_end_clean();
		
		return $content;
	}
	
	
	function custom_css() {
		
	}
	
	 function get_sidebar_info( $sidebar_id ) {
			global $wp_registered_sidebars;
	
			if(is_array($wp_registered_sidebars)){
				foreach ( $wp_registered_sidebars as $sidebar ) {
					if ( isset( $sidebar['id'] ) && $sidebar['id'] == $sidebar_id )
						return $sidebar;
				}
			}
			return false;
		}
	
	function options() {
		$sidebars = wp_get_sidebars_widgets();
		$widgets = array();
		
		if(is_array($sidebars)){
		
			foreach ($sidebars as $sidebar_name => $sidebar_data) {
				if($sidebar_name!='wp_inactive_widgets'){
					
					
					$sidebar_info = $this->get_sidebar_info($sidebar_name);
					if(is_array($sidebar_data)){
						foreach ($sidebar_data as $widget) {
							
							$widget_type = trim( substr( $widget, 0, strrpos( $widget, '-' ) ) );
							$widget_type_index = trim( substr( $widget, strrpos( $widget, '-' ) + 1 ) );
							$widget_options = get_option( 'widget_' . $widget_type );
							
							$title =  ucfirst( $widget_type );
							if( !empty( $widget_title ) )
								$title .= ' - ' . $widget_title;
							
							$widgets[] = array(
								'label'=>'[ ' . $sidebar_info['name'] .' ] '.  $title,
								'value'=>$sidebar_name .'#'.  $widget
							);
							
						}
					}
					
					
				}
			}
			
		}
		
		$this->_options =array(
			array(
			    'label' => 'Select Widget',
			    'id' => 'widget',
			    'type' => 'select',
			    'desc' => 'Select Widget.',
			    'choices' => $widgets,
			    'std' => '',
			    'rows' => '',
			    'post_type' => '',
			    'taxonomy' => '',
			    'class' => '',
			)
		 
		);
	}
	
	function css() {
		?>
		<style>
		
		</style>
		<?php
	}

}


 ?>