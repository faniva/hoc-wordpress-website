<?php

class C5_header_css {

	function hook() {
		add_action('wp_print_styles', array($this, 'wp_print_styles'), 229);
	}
	public function wp_print_styles()
	{
		ob_start();
		$this->custom_css();
		$css = ob_get_clean();
		wp_add_inline_style( 'medical-cure-theme-stylesheet', $css );

		$custom_js = ot_get_option('custom_js');
		if ($custom_js!='') {
			wp_add_inline_script( 'medical-cure-theme-script',  $custom_js );
		}
	}
	function format_background($array) {
		$data = '';
		$properties = array(
			'background-color',
			'background-position',
			'background-repeat',
			'background-attachment',
			'background-image',
		);

		foreach ($properties as $property) {
			if( isset($array[$property]) ){
				if ($array[$property] != '') {
					if($property == 'background-image'){
						$data .= $property . ':url(\'' . esc_url($array[$property]) . '\');';
					}else{
						$data .= $property .':' . $array[$property] . ';';
					}
				}
			}

		}
		return $data;
	}


	function custom_css() {

		global $c5_font_obj;
		$heading_font = is_rtl() ?  $c5_font_obj->get_font_name('heading_font_rtl') .', ' . $c5_font_obj->get_font_name('heading_font') : $c5_font_obj->get_font_name('heading_font');

		$body_font = is_rtl() ?  $c5_font_obj->get_font_name('body_font_rtl') .', ' . $c5_font_obj->get_font_name('body_font') : $c5_font_obj->get_font_name('body_font');


		$background = ot_get_option('background');
		if ($background=='') {
			$background =array(
				'background-color' => '#f8f8f8'
			);
		}
		$background_css = $this->format_background($background);


		$this->primary_color_css();
		?>

		.c5-main-blog-content {
			width: calc(100% - 36.3rem);
		}
		.c5-dr-middle {
			width: calc(100% - 66.2rem);
		}
		@media only screen and (max-width: 600px) {
			html #wpadminbar {
			    margin-top: -46px;
			}
		}
		<?php
		if (!apply_filters( 'code125_external_import_loaded', false )) {
		    ?>
		    .code125-article-layout-common .entry-content blockquote:before {
		        content: "\f10d";
		        font-family: FontAwesome;
		    }
		    <?php
		}
		?>

		.top-menu-nav ul.menu-sc-nav>li.menu-item>a,
		header.c5-header.c5-header-layout-5 .top-menu-nav ul.menu-sc-nav>li.menu-item>a{
			font-size: <?php echo ot_get_option('menu_fs' , '14'); ?>px;
		}

		/** Font **/
		body{
			font-size: <?php echo ot_get_option('body_fs' , '14'); ?>px;
			<?php echo $background_css; ?>
		}
		body,
		.code125-testimonial-single.code125-testimonial-layout-8 .testimonial-meta h3,
		.woocommerce div.product .woocommerce-tabs ul.tabs li,
		header.c5-header.c5-header-layout-6 .top-menu-nav ul.menu-sc-nav>li.menu-item>a{
			font-family: <?php echo $body_font ?>, "Helvetica Neue", Helvetica, Arial, sans-serif ;
		}
		h1,h2,h3,h4,h5,h6,
		.top-menu-nav ul.menu-sc-nav,
		.code125-testimonial-single.code125-testimonial-layout-8 .testimonial-content p {
			font-family: <?php echo $heading_font ?>, "Helvetica Neue", Helvetica, Arial, sans-serif ;
			font-weight: <?php echo ot_get_option('heading_font_weight' , '500'); ?>;

		}

		/***General Custom CSS**/
		<?php
		echo ot_get_option('custom_css');

	}

	public function primary_color_css()
	{

		$hex = ot_get_option('primary_color' , '#0065b3');
		$second_color = ot_get_option('secondary_color' , '#f42267');

		$obj_style = new Code125_Colors();
		$rgb = $obj_style->hex2rgb(esc_attr($hex));


		?>
		a,
		.top-menu-nav ul.menu-sc-nav > li.menu-item > a .hover,
		.site-branding h1.site-title,

		.c5-service-base .c5-icon,
		.c5-service-base.c5-service-layout-gradient:hover,
		.c5-service-layout-elegant:hover .c5-icon,
		.c5-department .c5-icon,

		.c5-deep-dark-bg .c5-btn-theme:hover,
		.c5-deep-dark-bg .c5-btn-theme:focus,
		.c5-dark-background .c5-btn-theme:hover,
		.c5-dark-background .c5-btn-theme:focus,

		.c5-layout-light .c5-accordion-single .c5-accordion-tab.current, .c5-layout-light .c5-accordion-single .c5-accordion-tab:hover,
		.c5-tabs-layout-light > ul.c5-tabs li:hover,
		.c5-tabs-layout-light > ul.c5-tabs li.current,
		.c5-tabs-layout-side-light > ul.c5-tabs li:hover,
		.c5-tabs-layout-side-light > ul.c5-tabs li.current,
		.c5-tabs-layout-side > ul.c5-tabs li:hover,
		.c5-tabs-layout-side > ul.c5-tabs li.current,

		.code125-blog-post-common a.c5-category,
		.c5-related-meta ul li a:hover,
		.c5-related-meta ul li a:focus,

		.c5-post-share ul li a:hover,
		.c5-table-prices .c5-table-prices-content .c5-table-item .c5-table-heading strong,

		.c5-btn-white:hover, .c5-btn-white:focus,
		a.c5-btn-white:hover, a.c5-btn-white:focus,
		button.c5-btn-white:hover, button.c5-btn-white:focus,

		.c5-staff-layout-elegant .c5-staff-info .c5-staff-social ul li:hover, .c5-staff-layout-elegant-simplified .c5-staff-info .c5-staff-social ul li:hover,
		.c5-staff.c5-staff-cards .c5-staff-member .c5-staff-social li a:hover, .c5-staff.c5-staff-cards .c5-staff-member .c5-staff-social li a:focus,
		header.c5-header.c5-header-layout-2 .c5-info-top-bar ul li .c5-header-icon,
		.c5-infographics .c5-icon,
		.c5-infographics:hover,

		.widget_archive li:focus,
		.widget_archive li:hover,
		.widget_categories li:focus,
		.widget_categories li:hover,
		.widget_meta li:focus,
		.widget_meta li:hover,
		.widget_recent_entries li:focus,
		.widget_recent_entries li:hover,

		.c5-toggle-single.current .c5-toggle-tab,
		.c5-toggle-single:hover .c5-toggle-tab,
		.top-menu-nav ul.menu-sc-nav ul.sub-menu>li.menu-item:focus>a,
		.top-menu-nav ul.menu-sc-nav ul.sub-menu>li.menu-item:hover>a,
		.top-menu-nav ul.menu-sc-nav li.menu-item.c5-mega-menu-li>ul.sub-menu li:focus>a,
		.top-menu-nav ul.menu-sc-nav li.menu-item.c5-mega-menu-li>ul.sub-menu li:hover>a,

		.c5-tabs-layout-normal > ul.c5-tabs li:hover,
		.c5-tabs-layout-normal > ul.c5-tabs li.current,
		.c5-service-contact-info .c5-icon,
		.code125-heading.code125-heading-layout-1 p,
		.c5-service-simple-layout .c5-icon,
		.c5-service-simple-layout .service-content .fa,
		.c5-service-simple-bordered .c5-icon,
		.c5-service-mini .c5-icon,
		.c5-service-plain-bordered a.service-button,
		.c5-service-plain-bordered .c5-icon,
		.code125-newsletter-wrap .mc4wp-form-fields .code125-newsletter-button:hover,
		.c5-dark-background .code125-newsletter-wrap .mc4wp-form-fields .code125-newsletter-button,
		.code125-custom-ul ul li .c5-ul-icon,
		.code125-service-slides-layout-1 .code125-service-slides-controls .code125-service-slide-control,
		.code125-service-slides-layout-2 .code125-service-slides-controls .code125-service-slide-control.slick-current,
		.code125-service-slides-layout-2 .code125-service-slides-controls .code125-service-slide-control:hover,
		.code125-service-slides-layout-2 .code125-service-slides-controls .code125-service-slide-control .c5-icon,
		.code125-pricing-list-wrap .code125-pricing-list-title p,
		.code125-pricing-plan-wrap .code125-pricing-plan-title p.subtitle,
		.code125-pricing-plan-wrap .code125-pricing-plan-elements ul li span.c5-icon,
		.code125-testimonial-single.code125-testimonial-layout-6 .testimonial-meta h3:before,
		.code125-social-links.code125-social-links-layout-3 li a,
		.code125-social-links.code125-social-links-layout-2 .c5-icon,
		.code125-social-links.code125-social-links-layout-2 a,
		.code125-social-links.code125-social-links-layout-4 ul li,
		.code125-social-links.code125-social-links-layout-6 a,
		.code125-social-links.code125-social-links-layout-6 a.code125-social-button,
		.code125-article-layout-common .entry-content blockquote:before,
		header.c5-header.c5-header-layout-5 .btn.c5-btn-theme:hover,
		.c5-small-header .btn.c5-btn-theme:hover,
		.c5-small-header .code125-mobile-sidebar-button,
		.code125-banner-content .code125-banner-btn:hover,
		.code125-banner-content.code125-banner-content-layout-5 .code125-banner-btn,
		.widget_calendar table th,
		.c5-table-prices .c5-table-prices-content .c5-table-item .c5-table-footer a.btn,
		.c5-doctor-single h4,
		.btn.inverse:hover,
		.c5-plan-pkg .c5-plan-item .c5-item-des li .fa,
		.top-menu-nav ul.menu-sc-nav li.menu-item.current-menu-item .original, .top-menu-nav ul.menu-sc-nav li.menu-item.current-menu-parent .original,
		.c5-top-bar.c5-header-layout-5 .c5-info-top-bar li .c5-header-icon,
		.c5-header-search .c5-icons span:hover,
		.code125-service-common .c5-icon,
		.code125-service-common.c5-service-layout-gradient:hover,
		.c5-service-sidebar-based .btn.c5-btn-theme:hover,
		.code125-banner-content.code125-banner-content-layout-2 .code125-banner-btn:hover,
		.code125-banner-content.code125-banner-content-layout-3 .code125-banner-btn,
		.code125-banner-content.code125-banner-content-layout-1 .code125-banner-btn,
		.c5-dark-background .code125-banner-content.code125-banner-content-layout-plain .code125-banner-btn,
		.c5-dark-background .code125-banner-content.code125-banner-content-layout-4 .code125-banner-btn,
		.c5-error-content h2,
		header.c5-header.c5-header-layout-2 .c5-call-head .btn,
		.c5-infographics.code125-infographics-layout-2 .counter,
		.woocommerce #respond input#submit, .woocommerce #respond input#submit.alt, .woocommerce a.button, .woocommerce a.button.alt, .woocommerce button.button, .woocommerce button.button.alt, .woocommerce input.button, .woocommerce input.button.alt,
		.code125-testimonial-single.code125-testimonial-layout-5 .testimonial-content:before,
		.woocommerce-product-search input[type=submit],
		.woocommerce-info::before,
		.woocommerce #payment #place_order:hover, .woocommerce-page #payment #place_order:hover,
		.woocommerce form .form-row label,
		.tagcloud a:hover,
		.post-password-form input[type=submit],
		.code125-blog-post-common h3.entry-title:hover{
			color: <?php echo $hex ?>;
		}

		a:hover, a:focus{
			color: <?php echo $obj_style->hexDarker($hex); ?>;
		}

		.c5-btn-theme:hover, .c5-btn-theme:focus,
		.c5-service-base.c5-service-layout-gradient,
		.c5-accent-background.c5-dark-background,
		.top-menu-nav ul.menu-sc-nav li.menu-item.current-menu-parent .original:before,
		.c5-social li a:hover, .c5-social li a:focus,
		.c5-department .c5-department-back,

		.c5-layout-normal .c5-accordion-single .c5-accordion-tab.current, .c5-layout-normal .c5-accordion-single .c5-accordion-tab:hover,

		.c5-heading .c5-diamond span:before,
		.c5-heading .c5-diamond span:after,
		.btn:hover,
		.c5-table-prices .c5-table-prices-content .c5-table-item .c5-best-price,
		.code125-banner-content .code125-banner-btn,
		.c5-plan-pkg .c5-plan-item .c5-item-title,
		.c5-footerbar .c5-social-icons li a:hover,
		.searchform #searchsubmit:hover,
		.code125-blog-post-common.c5-blog-layout-slide a.c5-category,
		.c5ab_posts_slider button.slick-next, .c5ab_posts_slider button.slick-prev،
		.c5-service-simple-rounded .c5-icon,
		.code125-newsletter-wrap .mc4wp-form-fields .code125-newsletter-button,
		.c5-dark-background .code125-newsletter-wrap .mc4wp-form-fields .code125-newsletter-button:hover,
		.code125-appointment input.wpcf7-submit,
		.code125-service-slides-layout-2 .code125-service-slides-controls .slick-next,
		.code125-service-slides-layout-2 .code125-service-slides-controls .slick-prev,
		.code125-contact-infos-common .code125-contact-infos-content,
		.code125-social-links.code125-social-links-layout-3 li a:hover,
		.code125-social-links.code125-social-links-layout-2 li:hover .c5-icon,
		.code125-social-links.code125-social-links-layout-4 ul li:hover,
		.code125-social-links.code125-social-links-layout-6 li:hover .c5-icon,
		.code125-social-links.code125-social-links-layout-6 a.code125-social-button:hover,
		.btn.c5-btn-theme:focus, .btn.c5-btn-theme:hover,
		.code125-article-layout-1 .c5-category-align a:before,
		header.c5-header.c5-header-layout-5 .btn.c5-btn-theme,
		.c5-small-header .btn.c5-btn-theme,
		.c5-mobile-sidebar a.c5-menu-hide,
		.c5-header-search .c5-content-search button,
		.code125-banner-content.code125-banner-content-layout-5,
		.code125-banner-content.code125-banner-content-layout-5 .code125-banner-btn:hover,
		.code125-image-comparison .after-label, .code125-image-comparison .before-label,
		.c5-table-prices .c5-table-prices-content .c5-table-item .c5-table-footer a.btn:hover,
		.btn.inverse,
		.c5-page-info.code125-page-info-layout-1 .c5-page-info-inner:before,
		.code125-blog-post-common.c5-blog-layout-1 a.c5-category,
		.slick-slider ul.slick-dots li.slick-active,
		.slick-slider ul.slick-dots li:hover,
		.slick-slider .slick-next,
		.slick-slider .slick-prev,
		.c5-dark-background .code125-service-common .btn.c5-btn-theme:hover, .c5-dark-background.code125-service-common .btn.c5-btn-theme:hover,
		.code125-service-common.c5-service-layout-gradient,
		.code125-banner-content.code125-banner-content-layout-2 .code125-banner-btn,
		.code125-banner-content.code125-banner-content-layout-3 .code125-banner-btn:hover,
		.code125-banner-content.code125-banner-content-layout-1 .code125-banner-btn:hover,
		.c5-dark-background .code125-banner-content.code125-banner-content-layout-plain .code125-banner-btn:hover,
		.c5-dark-background .code125-banner-content.code125-banner-content-layout-4 .code125-banner-btn:hover,
		.code125-video-popup .code125-video-button-popup,
		.code125-heading.code125-heading-layout-3 h3:before,
		header.c5-header.c5-header-layout-2 .c5-call-head .btn:hover,
		.c5-contacts-form input.wpcf7-submit,
		.code125-instagram-slider-wrap a.code125-follow-button:hover,
		.code125-appointment.code125-appointment-layout-2 input.wpcf7-submit,
		.c5-service-sidebar-based .btn.c5-btn-theme,
		.code125-appointment.code125-appointment-layout-1 input.wpcf7-submit,
		.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
		.c5-error-content .c5-form-style .c5-btn-theme,
		.woocommerce #respond input#submit.alt:hover, .woocommerce #respond input#submit:hover, .woocommerce a.button.alt:hover, .woocommerce a.button:hover, .woocommerce button.button.alt:hover, .woocommerce button.button:hover, .woocommerce input.button.alt:hover, .woocommerce input.button:hover,

		.woocommerce #respond input#submit.alt.disabled, .woocommerce #respond input#submit.alt.disabled:hover, .woocommerce #respond input#submit.alt:disabled, .woocommerce #respond input#submit.alt:disabled:hover, .woocommerce #respond input#submit.alt:disabled[disabled], .woocommerce #respond input#submit.alt:disabled[disabled]:hover, .woocommerce a.button.alt.disabled, .woocommerce a.button.alt.disabled:hover, .woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled:hover, .woocommerce a.button.alt:disabled[disabled], .woocommerce a.button.alt:disabled[disabled]:hover, .woocommerce button.button.alt.disabled, .woocommerce button.button.alt.disabled:hover, .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled:hover, .woocommerce button.button.alt:disabled[disabled], .woocommerce button.button.alt:disabled[disabled]:hover, .woocommerce input.button.alt.disabled, .woocommerce input.button.alt.disabled:hover, .woocommerce input.button.alt:disabled, .woocommerce input.button.alt:disabled:hover, .woocommerce input.button.alt:disabled[disabled], .woocommerce input.button.alt:disabled[disabled]:hover,
		.woocommerce-product-search input[type=submit]:hover,
		.woocommerce #payment #place_order, .woocommerce-page #payment #place_order,
		.post-password-form input[type=submit]:hover,
		span.code125-comment-article-author,
		.c5-top-bar.c5-header-layout-5 .code125-language-switcher-wrap p.first-element span.code,
		.code125-language-switcher-wrap ul.code125-language-switcher li a span.code,
		header.c5-header.c5-header-layout-6 .top-menu-nav ul.menu-sc-nav>li.menu-item.code125-accent-btn>a{
			background: <?php echo $hex ?>;
		}

		.c5-table-prices .c5-table-prices-content .c5-table-item .c5-best-price li:nth-of-type(odd),
		.code125-appointment.code125-appointment-layout-1 input.wpcf7-submit:hover,
		.code125-appointment.code125-appointment-layout-2 input.wpcf7-submit:hover,
		.c5-table-prices .c5-best-badge,
	    .c5-contacts-form input.wpcf7-submit:hover,
		.c5-error-content .c5-form-style .c5-btn-theme:hover{
			background: <?php echo $obj_style->hexDarker($hex); ?>;
		}
		.c5-table-prices .c5-best-badge:after,
		.c5-table-prices .c5-best-badge:before {
		    border-right: 1rem solid <?php echo $obj_style->hexDarker($hex); ?>;
		    border-bottom: 1rem solid <?php echo $obj_style->hexDarker($hex); ?>;
		}
		.c5-table-prices .c5-best-badge:after {
		    border-left: 1rem solid <?php echo $obj_style->hexDarker($hex); ?>;
			border-right: 1rem solid transparent;
		}
		.c5-table-prices .c5-best-badge span:after,
		.c5-table-prices .c5-best-badge span:before {
		    border-top: .9rem solid <?php echo $obj_style->hexDarker($hex,40); ?>;
		}
		.code125-service-common .c5-icon.code125-icon-svg svg,
		.code125-service-common.c5-service-layout-gradient:hover .c5-icon.code125-icon-svg svg {
		    fill: <?php echo $hex ?>;
		}

		.c5-side-menu ul.menu-sc-nav>li.menu-item.current-menu-item>a,
		.c5-side-menu ul.menu-sc-nav>li.menu-item.current-menu-parent>a,
		.c5-side-menu ul.menu-sc-nav>li.menu-item:hover>a {
		    border-right: 4px solid <?php echo $hex ?>;
		}

		.c5-service-layout-elegant:hover,
		.btn:hover,
		.code125-banner-content .code125-banner-btn:hover,
		.code125-banner-content .code125-banner-btn,
		.c5-social li a:hover, .c5-social li a:focus,

		.c5-tabs-layout-light > ul.c5-tabs li:hover,
		.c5-tabs-layout-light > ul.c5-tabs li.current,
		.searchform #searchsubmit:hover,
		.code125-newsletter-wrap .mc4wp-form-fields .code125-newsletter-button,
		.code125-newsletter-wrap .mc4wp-form-fields .code125-newsletter-button:hover,

		.code125-service-slides-layout-1 .code125-service-slides-controls .code125-service-slide-control.slick-current,
		.code125-service-slides-layout-1 .code125-service-slides-controls .code125-service-slide-control:hover,
		header.c5-header.c5-header-layout-5 .btn.c5-btn-theme,
		.c5-small-header .btn.c5-btn-theme,
		.c5-table-prices .c5-table-prices-content .c5-table-item .c5-table-footer a.btn,
		.c5-table-prices .c5-table-prices-content .c5-table-item .c5-table-footer a.btn:hover,
		.btn.inverse,
		.btn.inverse:hover,
		.c5-dark-background .code125-service-common .btn.c5-btn-theme:hover, .c5-dark-background.code125-service-common .btn.c5-btn-theme:hover,
		.c5-service-sidebar-based .btn.c5-btn-theme,
		.c5-service-sidebar-based .btn.c5-btn-theme:hover,
		header.c5-header.c5-header-layout-2 .c5-call-head .btn:hover,
		.woocommerce #respond input#submit.alt:hover, .woocommerce #respond input#submit:hover, .woocommerce a.button.alt:hover, .woocommerce a.button:hover, .woocommerce button.button.alt:hover, .woocommerce button.button:hover, .woocommerce input.button.alt:hover, .woocommerce input.button:hover,
		.woocommerce-product-search input[type=submit]:hover,
		.woocommerce #payment #place_order, .woocommerce-page #payment #place_order,
		.tagcloud a:hover,
		.post-password-form input[type=submit]:hover{
			border-color: <?php echo $hex ?>;
		}
		.c5-tabs-layout-side-light.c5-tabs-left > ul.c5-tabs li:hover, .c5-tabs-layout-side-light.c5-tabs-left > ul.c5-tabs li.current,
		.c5-tabs-layout-side.c5-tabs-right > ul.c5-tabs li:hover, .c5-tabs-layout-side.c5-tabs-right > ul.c5-tabs li.current{
			border-right-color: <?php echo $hex ?>;
		}
		.c5-tabs-layout-side-light.c5-tabs-right > ul.c5-tabs li:hover, .c5-tabs-layout-side-light.c5-tabs-right > ul.c5-tabs li.current,
		.c5-tabs-layout-side.c5-tabs-left > ul.c5-tabs li:hover, .c5-tabs-layout-side.c5-tabs-left > ul.c5-tabs li.current{
			border-left-color: <?php echo $hex ?>;
		}


		.c5-service-layout-elegant .c5-plus-hover:before,
		.c5-department-layout-elegant .c5-department-overlay .c5-plus-hover:before,
		.code125-blog-post-common .c5-plus-hover:before,
		.c5-staff-layout-elegant .c5-staff-info .c5-plus-hover:before, .c5-staff-layout-elegant-simplified .c5-staff-info .c5-plus-hover:before {
			<?php
			if (is_rtl()) {
				?>
				border-left-color: <?php echo $hex ?>;
				<?php
			}else{
				?>
				border-right-color: <?php echo $hex ?>;
				<?php
			}
			?>
			border-top-color: <?php echo $hex ?>;
		}
		.code125-contact-infos-common .code125-contact-infos-content::before {
		    border-left: 10px solid <?php echo $hex ?>;
		    border-top: 10px solid <?php echo $hex ?>;
		}
		.code125-service-slides-layout-1 .code125-service-slides-controls .code125-service-slide-control:after{
			    border-bottom: 12px solid <?php echo $hex ?>;
		}


		.c5-heading .c5-diamond:before {
			border-bottom-color: <?php echo $hex ?>;
		}
		.c5-heading .c5-diamond:after,
		.c5-table-prices .c5-table-prices-content,
		.c5-header-search .c5-content-search,
		.woocommerce-info{
			border-top-color: <?php echo $hex ?>;
		}
		.c5-tabs-layout-light > ul.c5-tabs li.current:after, .c5-tabs-layout-light > ul.c5-tabs li:hover:after {
			border-top: 5px solid <?php echo $hex ?>;
		}

		.c5-tabs-layout-normal > ul.c5-tabs li,
		.c5-tabs-layout-light > ul.c5-tabs li,
		.c5-post-pagination li>a,
		.c5-post-pagination li>span,
		h3.title{
			color: <?php $this->hsl($hex , '0.31', '0.15' ); ?>;
		}

		.widget h3.widget-title,
		.code125-newsletter-wrap.code125-newsletter-layout-sidebar input[type=text], .code125-newsletter-wrap.code125-newsletter-layout-sidebar input[type=email],
		.c5-side-menu ul.menu-sc-nav>li.menu-item:hover,
		.c5-side-menu ul.menu-sc-nav li.menu-item.c5-menu-icon ul.sub-menu,
		.c5-tabs-layout-side > ul.c5-tabs li,
		.c5-tabs-layout-side-light > ul.c5-tabs li.current, .c5-tabs-layout-side-light > ul.c5-tabs li:hover,
		.c5-layout-light .c5-accordion-single .c5-accordion-tab.current, .c5-layout-light .c5-accordion-single .c5-accordion-tab:hover,
		.c5-layout-light .c5-accordion-single .c5-pane,
		.c5-toggle-single.current, .c5-toggle-single:hover,
		.widget .c5-heading h3,
		.code125-article-layout-common .entry-content blockquote,
		.code125-article-layout-1 .code125-article-share ul li a,
		.top-menu-nav ul.menu-sc-nav ul.sub-menu>li.menu-item:focus>a,
		.top-menu-nav ul.menu-sc-nav ul.sub-menu>li.menu-item:hover>a,
		.top-menu-nav ul.menu-sc-nav li.menu-item.c5-mega-menu-li>ul.sub-menu li:focus>a,
		.top-menu-nav ul.menu-sc-nav li.menu-item.c5-mega-menu-li>ul.sub-menu li:hover>a,
		.top-menu-nav ul.menu-sc-nav li.menu-item.c5-mega-menu-li>ul.sub-menu li.menu-item:focus>a,
		.top-menu-nav ul.menu-sc-nav li.menu-item.c5-mega-menu-li>ul.sub-menu li.menu-item:hover>a,
		.c5-tabs-layout-normal > ul.c5-tabs li:hover,
		.c5-tabs-layout-normal > ul.c5-tabs li.current,
		.c5-post-pagination li>a.current,
		.c5-post-pagination li>a:hover,
		.c5-post-pagination li>span.current,
		.c5-post-pagination li>span:hover,
		.c5-service-contact-info .c5-icon,
		.c5-service-simple-bordered:hover,
		.c5-service-simple-rounded:hover,
		.c5-service-plain-bordered a.service-button,
		.code125-newsletter-wrap .mc4wp-form-fields input,
		.code125-appointment.code125-appointment-layout-2 h3,
		.code125-appointment.code125-appointment-layout-2 input:hover,
		.code125-appointment.code125-appointment-layout-2 select:hover,
		.code125-appointment.code125-appointment-layout-2 textarea:hover,
		.code125-pricing-plan-wrap .code125-pricing-plan-title p.price,
		.code125-banner-content.code125-banner-content-layout-2,
		.c5-contacts-form input, .c5-contacts-form select, .c5-contacts-form textarea,
		.code125-social-links.code125-social-links-layout-3 li a,
		.code125-social-links.code125-social-links-layout-2 .c5-icon,
		.code125-social-links.code125-social-links-layout-4 ul li,
		.code125-social-links.code125-social-links-layout-6 .c5-icon,
		.code125-social-links.code125-social-links-layout-6 a.code125-social-button,
		header.c5-header.c5-header-layout-4 .top-menu-nav ul.menu-sc-nav>li.menu-item:hover >a,
		h3.title,
		.code125-banner-content.code125-banner-content-layout-6,
		.code125-article-layout-1 .c5-category-align a:after,
		.widget_calendar caption,
		.c5-doctor-single .code125-doctor-single-info.schedule span.value,
		.code125-pricing-list-wrap .code125-pricing-list-elements ul li span.price,
		.c5-page-info .c5-page-info-inner:after,
		.c5-page-info.code125-page-info-layout-3 .c5-page-info-inner,
		.code125-banner-content.code125-banner-content-layout-3 .code125-banner-btn,
		.woocommerce nav.woocommerce-pagination ul li>a.current,
		.woocommerce nav.woocommerce-pagination ul li>a:hover,
		.woocommerce nav.woocommerce-pagination ul li>span.current,
		.woocommerce nav.woocommerce-pagination ul li>span:hover,
		.woocommerce #respond input#submit, .woocommerce #respond input#submit.alt, .woocommerce a.button, .woocommerce a.button.alt, .woocommerce button.button, .woocommerce button.button.alt, .woocommerce input.button, .woocommerce input.button.alt,
		.woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content,
		.woocommerce-product-search input[type=submit],
		.woocommerce-error, .woocommerce-info, .woocommerce-message,
		#add_payment_method #payment, .woocommerce-cart #payment, .woocommerce-checkout #payment{
			background: <?php $this->hsl($hex , '0.47', '0.95' ); ?>;
		}
		.code125-social-links.code125-social-links-layout-3 li a:hover,
		.code125-social-links.code125-social-links-layout-2 li:hover .c5-icon,
		.code125-social-links.code125-social-links-layout-4 ul li:hover,
		.code125-social-links.code125-social-links-layout-6 li:hover .c5-icon,
		.code125-social-links.code125-social-links-layout-6 a.code125-social-button:hover{
			color: <?php $this->hsl($hex , '0.47', '0.95' ); ?>;
		}

		.code125-banner-content.code125-banner-content-layout-plain h4,
		.code125-banner-content.code125-banner-content-layout-4 h4{
			color: <?php $this->hsl($hex , '0.24', '0.66' ); ?>;
		}


		.code125-gallery .code125-gallery-item .code125-gallery-image::before{
			background: <?php $this->rgb($rgb,0.75); ?>
		}
		.c5-department-layout-elegant .c5-department-overlay, .c5-service-animated-hover .title-back,
		.c5-service-animated-hover .title-front{
			background: <?php $this->rgb($rgb,0.88); ?>
		}

		.c5-floating-header .btn{
			border-color:  <?php $this->rgb($rgb,0.15); ?>;
		}


		.c5-service-sidebar-based .c5-service-color-wrap{
			background: <?php $this->rgb($obj_style->hex2rgb($obj_style->AdjustHSL($hex ,'1', '0.95' ))
			,0.8); ?>
		}

		<?php
	}

	public function hsl($hex , $s = '', $l = '' )
	{
		$obj_style = new Code125_Colors();
		$hsl = $obj_style->hex2hsl($hex);

		$hsl[1] = ($s != '') ? $s : $hsl[1];
		$hsl[2] = ($l != '') ? $l : $hsl[2];

		$hex = $obj_style->hsl2hex($hsl);
		echo $hex;
	}
	public function rgb($rgb,$opacity)
	{
		echo 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].','.$opacity.')';
	}


	function update_category(){

		if (isset($_GET['update'])) {
			if($_GET['update'] == 'categories'){
				$terms = $this->create_terms_array();
				update_option( 'c5_terms_settings', $terms );
			}
		}
	}
	function get_terms_array() {
		global $c5_terms_array ;
		$category_styling = ot_get_option('category_styling');
		if($category_styling == 'off'){
			return array();
		}
		$terms = get_option( 'c5_terms_settings' );
		if(!is_array($terms)){
			$terms = $this->create_terms_array();
			update_option( 'c5_terms_settings', $terms );
		}

		$c5_terms_array = $terms;
		return $terms ;
	}
	function create_terms_array() {
		global $c5_terms_array ;

		$c5_terms_array= array();
		$taxonomies = get_taxonomies('', 'names');
		foreach ($taxonomies as $tax) {
			$terms = get_terms($tax);
			if (is_array($terms)) {
				foreach ($terms as $term) {
					$options =array();

					$icon = get_option('c5_term_meta_' . $tax . '_' . $term->term_id . '_icon');
					if($icon != ''){
						$options['icon']= $icon;
					}

					$use_color = get_option('c5_term_meta_' . $tax . '_' . $term->term_id . '_use_custom_colors');

					if($use_color == 'on'){
						$color = get_option('c5_term_meta_' . $tax . '_' . $term->term_id . '_primary_color');
						if($color != ''){
							$options['color']= $color;
						}
					}

					if(count($options) > 0){
						$c5_terms_array[ $tax . '-' . $term->term_id ] = $options;
					}
				}
			}
		}
		update_option( 'c5_terms_settings', $c5_terms_array );
		return $c5_terms_array;
	}


	function terms_custom_css($terms) {
		$data = '';
		foreach ($terms as $class => $options) {
			if(!isset( $options['color'] )){
				continue;
			}
			$color = $options['color'];
			$data .= $this->categories_css($color, '.' .$class);

		}
		return $data;
	}



	function categories_css($color = '', $class_name) {
		if (class_exists('Code125_Colors')) {
			$obj_style = new Code125_Colors();

			$rgb_color =  $obj_style->hex2rgb($color);
			$dark_color = $obj_style->hexDarker($color);
		}else{
			$rgb_color = array();
			$dark_color = $color;
		}

		$class_info = explode('-', $class_name);
		$class_2 = 'xx';
		if ($class_info[0] == '.category') {
			$class_2 = '.cat-item-' . $class_info[1];
		}
		$data ='
		.c5ab_posts_thumb_boxes_single'. $class_name .':hover .box-content,
		.flip-post'. $class_name .' .post-data-bg,

		.c5ab_posts_category-5 .c5-load-wrap h3.title'. $class_name .',
		.c5ab_posts_thumb_blog_4_single  a.c5-meta-cat'. $class_name .',
		.c5-portfolio-single .c5-thumb-hover .c5-meta-categories a.c5-meta-cat'. $class_name .',
		.c5ab_posts_slider-3 .c5-post-wrap-inner .c5-slider-header-data .content-middle .content a.c5-meta-cat'. $class_name .',
		.c5ab_posts_slider_2 a.c5-meta-cat'. $class_name .'{
			background-color: '. $color .';
		}
		.c5ab_posts_thumb_blog_4_single  a.c5-meta-cat'. $class_name .':hover,
		.c5-portfolio-single .c5-thumb-hover .c5-meta-categories a.c5-meta-cat'. $class_name .':hover,
		.c5ab_posts_slider-3 .c5-post-wrap-inner .c5-slider-header-data .content-middle .content a.c5-meta-cat'. $class_name .':hover,
		.c5ab_posts_slider_2 a.c5-meta-cat'. $class_name .':hover{
			background-color: '. $dark_color .';
		}

		'. $class_name .'.c5ab_post_thumb .content h3 a:hover,
		'. $class_name .'.c5ab_post_thumb .content .c5_meta_data li:hover,
		'. $class_name .'.c5ab_posts_thumb_blog_tall_single a.c5-read-more,
		'. $class_name .'.c5ab_posts_thumb_blog_wide_single a.c5-read-more{
			color: '. $color .';
		}

		h3.title'. $class_name .',
		h3.title'. $class_name .' a,
		h2.title'. $class_name .',
		h2.title'. $class_name .' a{
			background: '. $color .';
		}

		.widget_categories ul li'. $class_2 .' a:before {
			color: '. $color .';
		}


		'. $class_name .'.c5-slide-item .content-top {
			background-color: '. $color .';
			background-color: rgba('. $rgb_color[0] .' , '. $rgb_color[1] .' , '. $rgb_color[2] .', 0.8);
		}

		'. $class_name .'.c5-slide-item .content-top h3 {
			border-top: 4px solid '. $color .';
		}

		.c5ab_post_thumb'. $class_name .' .hover,
		.c5ab_posts_thumb_boxes_single'. $class_name .' .box-content{
			background-color: '. $color .';
			background-color: rgba('. $rgb_color[0] .' , '. $rgb_color[1] .' , '. $rgb_color[2] .', 0.8);
		}
		';

		return $data;
	}


}

function c5_get_category_icon($class) {
	global $c5_terms_array ;

	if(isset($c5_terms_array[$class])){
		if (isset(  $c5_terms_array[$class]['icon'] )) {
			return $c5_terms_array[$class]['icon'];
		}
	}
	return false;
}
function c5_get_category_color($class) {
	global $c5_terms_array ;

	if(isset($c5_terms_array[$class])){
		if (isset(  $c5_terms_array[$class]['color'] )) {
			return $c5_terms_array[$class]['color'];
		}
	}
	return false;
}

?>
