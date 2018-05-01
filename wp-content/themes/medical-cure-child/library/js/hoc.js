jQuery(document).ready(function($) {



    var setSliderSize  =  function(){
        var windowHeight    = window.innerHeight,
            $heroSlider     = $('#hero-slider'),
            $headerTop      = $('.c5-top-bar'),
            $headerMiddle   = $('.c5-header-alt'),
            $headerMenuBar   = $('.c5-main-menu-bar'),
            headerTotalHeight
        ;

        headerTotalHeight = $headerTop.outerHeight() + $headerMiddle.outerHeight() + $headerMenuBar.outerHeight();

        console.log('header total height', headerTotalHeight);
        console.log('window height', windowHeight);

        var sliderHeight = windowHeight - headerTotalHeight;

        $heroSlider.height(sliderHeight);

    }

    // setSliderSize();


});


jQuery(window).one('load', function(){

    'use strict';

    var $ = jQuery.noConflict();


    // Get the slider navigation

    window.App = function(){

        var $sliderNav,
            $sliderNavItems,
            slider = revapi1,
            $heroSlider

        ;

        console.log(slider);

        return {

            init : function(){
                this.cacheDom();
                this.bindEvents();

            },

            bindEvents : function(){


            },

            cacheDom : function(){
                $sliderNav          =   $('.hoc-slider-nav');
                $sliderNavItems     =   $sliderNav.children();
                $heroSlider         =   $('#hero-slider');
            }


        }


    }();


    // Run the app :)
    window.App.init();

});



