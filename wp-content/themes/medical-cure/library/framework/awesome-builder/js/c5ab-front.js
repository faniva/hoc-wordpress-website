jQuery(document).ready(function ($) {


	var responsive_viewport = $(window).width();

	/* if is below 481px */
	if (responsive_viewport < 481) {

	} /* end smallest screen */

	/* if is larger than 481px */
	if (responsive_viewport > 481) {

	} /* end larger than 481px */

	/* if is above or equal to 768px */
	if (responsive_viewport >= 768) {
		$('.code125-align-columns').each(function(){
			var this_row = $(this);
			var this_height = this_row.height();
			this_row.find('.c5ab-col-base > .code125-ab-background-wrap').css('min-height' , this_height + 'px');
		});

		$('.code125-sticky-content').theiaStickySidebar({
	      // Settings
	      additionalMarginTop: 30
	    });

	}

	$('[data-animation-name]').each(function(index){
		var b = $(window).scrollTop();
		var a = $(this).offset().top -  $(window).height();
		var animataion = $(this).attr('data-animation-name');

		var this_element = $(this);
		var css_code = "";

		var delay = this_element.attr("data-animation-delay");
		if(delay){
			css_code += "animation-delay:" + delay + ";";
			css_code += "-webkit-animation-delay:" + delay + ";";
			css_code += "-moz-animation-delay:" + delay + ";";
			css_code += "-ms-animation-delay:" + delay + ";";
			css_code += "-o-animation-delay:" + delay + ";";
		}

		var duration = this_element.attr("data-animation-duration");
		if(duration){
			css_code += "animation-duration:" + delay + ";";
			css_code += "-webkit-animation-duration:" + delay + ";";
			css_code += "-moz-animation-duration:" + delay + ";";
			css_code += "-ms-animation-duration:" + delay + ";";
			css_code += "-o-animation-duration:" + delay + ";";
		}
		this_element.attr('style' , css_code);

		if(b > a){
			$(this).addClass('showme animated ' +  animataion);
		}
	});

	$(window).scroll(function() {
	    $('[data-animation-name]').each(function(index){
	    	var b = $(window).scrollTop();
	    	var a = $(this).offset().top - $(window).height();
	    	var animataion = $(this).attr('data-animation-name');
	    	if(b > a){
	    		$(this).addClass('showme animated ' +  animataion);
	    	}
	    });

	});

	/* Animation reveal scroll */
    var $animation_elements = $('.c5ab-widget');
    var $window = $(window);

	function check_if_in_view() {
        var window_height = $window.height();
        var window_top_position = $window.scrollTop();
        var window_bottom_position = (window_top_position + window_height);

        $.each($animation_elements, function() {
            var $element = $(this);
            var element_height = $element.outerHeight();
            var element_top_position = $element.offset().top;
            var element_bottom_position = (element_top_position + element_height);

            //check to see if this current container is within viewport
            if ((element_bottom_position >= window_top_position) &&
            (element_top_position <= window_bottom_position)) {
                if (!$element.hasClass('code125-banner-in-view')) {
                    $element.addClass('code125-banner-in-view');
                }
            } else {
                $element.removeClass('code125-banner-in-view');
            }
        });
    }

    $window.on('scroll resize', check_if_in_view);
	check_if_in_view();

	$(".toggle h3").click(function (e) {
		e.preventDefault();
		$(this).toggleClass("active").next("div").slideToggle("fast");
	});

	$('.code125-youtube-video-background').each(function(){
		var this_object = $(this);
		var video_height = this_object.width() * 9 / 16;
		var video_top = (video_height - this_object.height() ) /2;
		this_object.css('height' , video_height + 'px');
		this_object.css('top' , '-' + video_top + 'px')
	})


	$('.c5ab_popup').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		mainClass: 'mfp-img-mobile',
		image: {
			verticalFit: true
		}
	});

	$(document).on("click", ".code125-video-button-popup", function c5_quick_read (e) {
		$.ajax({
			type: "POST",
			data: 'url=' + $(this).attr('data-url')+ "&action=code125_video_button",
			url: ajax_var.url,
			success: function (data) {
				$.magnificPopup.open({
					items: {
						src: data
					},
					mainClass: 'c5-article-post',
					type: 'inline'
				}, 0);
			}
		});
		e.preventDefault();
	});



});
