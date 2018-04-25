jQuery(document).ready(function ($) {



    function c5_show_hide_box(value, target) {
        if(value == 'on'){
            $('.' + target).fadeIn();
        }else {
            $('.' + target).fadeOut();
        }
    }

    var use_color = $('.format-setting-inner input[name="use_custom_colors"]:checked').val();
    c5_show_hide_box(use_color, 'c5-color-settings-wrap');

    var use_layout = $('.format-setting-inner input[name="use_custom_layout"]:checked').val();
    c5_show_hide_box(use_layout, 'c5-layout-control-wrap');


    $(document).on('click', '.format-setting-inner input[name="use_custom_colors"]', function (e) {
        var value = $(this).val();
        c5_show_hide_box(value, 'c5-color-settings-wrap');
    });
    $(document).on('click', '.format-setting-inner input[name="use_custom_layout"]', function (e) {
        var value = $(this).val();
        c5_show_hide_box(value, 'c5-layout-control-wrap');
    });

    $(document).on('click', '.c5_span_icon', function (e) {
        $('.c5_span_icon').removeClass('selected');
        $(this).addClass('selected');
        $('#c5_icon').val($(this).attr('data-class'));
    });





});
