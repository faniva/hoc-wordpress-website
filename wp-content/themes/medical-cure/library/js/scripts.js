(function ($) {
    "use strict";

    /* getting viewport width */
    var responsive_viewport = $(window).width();

    /* if is below 481px */
    if (responsive_viewport < 481) {

    } /* end smallest screen */

    /* if is larger than 481px */
    if (responsive_viewport > 481) {

    } /* end larger than 481px */

    /* if is above or equal to 768px */
    if (responsive_viewport >= 768) {


        $('.code125-blog-post-common').each(function() {
            var this_obj = $(this);
            if (this_obj.parent().hasClass('col-sm-6') || this_obj.hasClass('col-sm-4') ) {
                var this_parent = $(this).closest('.row');

                var min_height = this_parent.height() - 60;
                this_obj.css('minHeight',min_height+'px');
            }

        });


    }

    /* Animation reveal scroll */
    var $animation_elements = $('.c5-banner-content-animation');
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
                if (!$element.hasClass('c5-in-view')) {
                    $element.addClass('c5-in-view');
                }
            } else {
                $element.removeClass('c5-in-view');
            }
        });
    }

    $('.c5-pages-menu-wrap').each(function() {
        var this_menu = $(this);

        this_menu.find('ul').addClass('sub-menu');
        this_menu.find('li').addClass('menu-item');
        this_menu.children('.top-nav').children('ul').removeClass('sub-menu').addClass('top-nav menu-sc-nav clearfix');
        this_menu.fadeIn();
    });

    $(document).on('click', '.top-menu-nav.c5-side-menu ul.menu-sc-nav li.menu-item.menu-item-has-children > a', function(e) {

        var this_obj = $(this).parent();
        if (this_obj.hasClass('c5-menu-icon')) {
            this_obj.removeClass('c5-menu-icon');
        }else {
            this_obj.addClass('c5-menu-icon');
        }
        e.preventDefault();
    });

    $window.on('scroll resize', check_if_in_view);
    $window.trigger('scroll');

    $(".c5-top-arrow").click(function() {
        $("html, body").animate({scrollTop: 0}, "200");
    });

    var lastScrollTop = 0;
    if ($("#floating-trigger").length > 0) {
        var a = function() {

            var st = $(window).scrollTop();

            var b = $(window).scrollTop();
            var d = $("#floating-trigger").offset().top;
            var c = $(".c5-floating-header");


            if (st > lastScrollTop){
                c.removeClass('code125-show');
            } else {


                if (b > d) {
                    c.addClass('code125-show');
                } else {
                    c.removeClass('code125-show');
                }
            }
            lastScrollTop = st;



        };
        $(window).scroll(a);
    }
    if ($('.rtl .gallery_slider').length ) {
      $('.rtl .gallery_slider').slick({
          'nextArrow' : '<button type="button" class="slick-next"><i class="fa fa-angle-left"></i></button>',
          'prevArrow' : '<button type="button" class="slick-prev"><i class="fa fa-angle-right"></i></button>',
          'rtl' : true,
          'adaptiveHeight' : true,
          'autoplay': true,
          'autoplaySpeed': 7000
      });
    }else{
      $('.gallery_slider').slick({
          'nextArrow' : '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
          'prevArrow' : '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
          'adaptiveHeight' : true,
          'autoplay': true,
          'autoplaySpeed': 7000
      });
    }






    $('.c5-main-slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){
        slick.$slides.eq(nextSlide).find('.c5ab-widget').removeClass('code125-banner-in-view');
        slick.$slides.eq(nextSlide).find('.c5ab-widget').addClass('code125-banner-in-view');
    });
    $('.c5-main-slider').on('afterChange', function(event, slick, currentSlide){
        slick.$slides.eq(currentSlide-1).find('.c5ab-widget').removeClass('code125-banner-in-view');
        slick.$slides.eq(currentSlide).find('video').each(function(){
            var this_video = $(this).get(0);
            this_video.currentTime = 0;
            this_video.play();
        });
    });
    $('.c5-main-slider').on('init', function(){
        $('.c5-main-slider').find('video').each(function(){
            var this_video = $(this).get(0);
            this_video.currentTime = 0;
            this_video.play();
        });
    });

    $('a.c5-social').click(function(event) {
        event.preventDefault();
        window.open($(this).attr("href"), "popupWindow", "width=600,height=600,scrollbars=yes");
    });

    $('.code125-clients-slider').slick({
        'nextArrow' : '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
        'prevArrow' : '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
        'autoplay': true,
        'slidesToShow': 5,
        'responsive': [
              {
                'breakpoint': 768,
                'settings': {
                  'slidesToShow': 3,
                }
              },
              {
                'breakpoint': 480,
                'settings': {
                  'slidesToShow': 2,
                }
              }
            ]
    });

    $('.code125-clients-slider').on('beforeChange', function(event, slick, direction){
        $('.code125-clients-slider .c5-client-single').each(function(){
            var this_object = $(this);
            var height = this_object.closest('.code125-clients-slider').height();
            this_object.css('min-height' ,height + 'px' );
        });
    });





    /* 01- Loader */

    $('.preloader img').fadeOut();
    $('.preloader').delay(300).fadeOut(1000);

    $(window).scroll(function() {
        if ($(document).scrollTop() > 140) {
            $('.c5-header-layout-transparent').addClass('c5-header-sticky');
            $('.c5-logo img').css('marginTop', function (e){
                return $(this).attr('data-floating-margin');
            });
        } else {
            $('.c5-header-layout-transparent').removeClass('c5-header-sticky');
            $('.c5-logo img').css('marginTop', function (e){
                return $(this).attr('data-margin');
            });
        }
    });

    $('.c5-tabs-wrap.c5-tabs-layout-departments').each( function (){
        var li_count = $(this).find('ul.c5-tabs').children('li').length;
        $(this).find('ul.c5-tabs').children('li').css('width', 100/li_count + '%');
    });

    $('.code125-service-common.c5-service-layout-gradient').each(function(){
        var this_object = $(this);
        this_object.parent().css('z-index', 'auto');
        this_object.parent().parent().css('z-index', 'auto');
    });

    $(document).on("click", ".c5-tabs li", function c5ab_tab_handle (e) {
        $(this).closest('.c5-tabs-wrap').find('.c5-tabs  li').removeClass('current');
        $(this).closest('.c5-tabs-wrap').find('.c5-pane').css('display','none');
        $(this).addClass('current');

        $('.pane-' + $(this).attr('data-id')).fadeIn();
    });

    $(document).on("click", ".c5-accordion-tab", function c5ab_accordion_handle (e) {
        $(this).closest('.c5-accordion').find('.c5-accordion-tab').removeClass('current');
        $(this).closest('.c5-accordion').find('.c5-pane').css('display','none');
        $(this).addClass('current');

        $('.pane-' + $(this).attr('data-id')).css('display','block');
    });

    $(document).on("click", ".c5-toggle-tab", function c5ab_toggle_handle (e) {
        if ($(this).closest('.c5-toggle-single').hasClass('current')) {
            $(this).closest('.c5-toggle-single').removeClass('current');
        }else{
            $(this).closest('.c5-toggle-single').addClass('current');
        }
    });

    // show mobile nav
    //
    $(document).on('touchend', '.code125-mobile-sidebar-button', function(event) {
        event.stopPropagation();
        event.preventDefault();
        if(event.handled !== true) {

            // Do your magic here.

            event.handled = true;
            c5_show_sidebar_function();
        } else {
            return false;
        }
    });
    $(document).on('mouseup', '.code125-mobile-sidebar-button', function(event) {
        event.stopPropagation();
        event.preventDefault();
    });
    function c5_show_sidebar_function() {
        if ($('.c5-body-wrap').hasClass('c5-menu-show')) {
            $('.c5-body-wrap').removeClass('c5-menu-show');
        }else {
            $('.c5-body-wrap').addClass('c5-menu-show');
        }
    }


    $(document).on('click', '.c5-header-search .c5-icons', function(e) {
        var this_obj = $(this).parent();
        if (this_obj.hasClass('c5-in-search')) {
            this_obj.removeClass('c5-in-search');
        }else {
            this_obj.addClass('c5-in-search');
        }
    });

    // hide mobile nav
    //
    $(document).on('touchstart', '.c5-close-side', function(e) {
        event.stopPropagation();
        event.preventDefault();
        if(event.handled !== true) {

            // Do your magic here.

            event.handled = true;
            c5_show_sidebar_close_function();
        } else {
            return false;
        }

    });
    $(document).on('click', '.c5-menu-hide', function(e) {
        c5_show_sidebar_close_function();
    });
    function c5_show_sidebar_close_function() {
        $('.c5-body-wrap').removeClass('c5-menu-show');
    }

    // new Cocoen(document.querySelector('.cocoen'));
    $('.cocoen').cocoen();


    /* 03- Recent Works */

    $('.woocommerce-product-gallery__wrapper').magnificPopup({
        delegate: '.woocommerce-product-gallery__image a',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1]
        },
        image: {
            tError: '<a href=\"%url%\">The image #%curr%</a> could not be loaded.',
        }
    });
    $('.litebox-hero, .litebox-tour').magnificPopup({
        type: 'iframe'
    });


    $('.image-popup-no-margins').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        closeBtnInside: false,
        fixedContentPos: true,
        mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
        image: {
            verticalFit: true,
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
        },
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
        },
        zoom: {
            enabled: true,
            duration: 300 // don't foget to change the duration also in CSS
        }
    });

    $('.counter .number').counterUp({
        delay: 10,
        time: 800
    });

    $('.code125-preload-wrap').fadeOut();


})(jQuery);
