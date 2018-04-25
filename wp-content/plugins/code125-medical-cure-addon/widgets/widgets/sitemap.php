<?php

class C5AB_sitemap extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();


	function __construct() {

		$id_base = 'sitemap-widget';
		$this->_shortcode_name = 'c5ab_sitemap';
		$name = 'Sitemap';
		$desc = 'Sitemap of your website.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);


	}


	function shortcode($atts,$content) {


		    $data = '<div class="row  c5-sitemap">
		    	<div class="col-md-3">
		    		<h3 class="title"><span class="fa fa-copy"> </span>'. esc_html__('Pages', 'medical-cure') .'</h3>
		    		<ul class="sitemap">
		    		'. wp_list_pages('title_li=&echo=0').'
		    		</ul>
		    	</div>
		    	<div class="col-md-3">
		    		<h3 class="title"><span class="fa fa-tag"> </span>'.__('Categories', 'medical-cure') .'</h3>
		    		<ul class="sitemap">
		    		'. wp_list_categories('title_li=&echo=0') .'
		    		</ul>
		    	</div>
		    	<div class="col-md-3">
		    		<h3 class="title"><span class="fa fa-tags"> </span>'. esc_html__('Tags', 'medical-cure') .'</h3>
		    		<ul class="sitemap">';
		    		$tags = get_tags( array('orderby' => 'count', 'order' => 'DESC') );
		    		foreach ( (array) $tags as $tag ) {
		    		$data.= '<li><a href="' . get_tag_link ($tag->term_id) . '" rel="tag">' . $tag->name . ' (' . $tag->count . ') </a></li>';
		    		}
		    	$data .= '</ul>
		    	</div>
		    	<div class="col-md-3">
		    		<h3 class="title"><span class="fa fa-user"> </span> '. esc_html__('Authors', 'medical-cure') .'<span class="arrow"></span></h3>
		    		<ul class="sitemap">
		    		'. wp_list_authors('echo=0') .'
		    		</ul>
		    	</div>
		    </div>';
		    return $data;

	}


	function custom_css() {

	}

	function options() {
		
		$this->_options =array(

		);
	}

	function css() {
		?>
		<style>
		.c5-sitemap ul{
			list-style: circle;
			padding-left:20px;
		}

		.c5-sitemap ul a{
			color: inherit;
			font-weight:bold;
		}
		.c5-sitemap ul a:hover{
			text-decoration:none;
		}


		</style>
		<?php
	}

}


 ?>
