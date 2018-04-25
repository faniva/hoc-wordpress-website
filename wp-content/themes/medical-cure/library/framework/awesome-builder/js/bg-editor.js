/**
* Code125 Background Editor UI
*
* Dependencies: jQuery, jQuery UI
*
* @author Code125(info@code125.com)
*/

;(function($) {
    Code125_Background_Editor = {
        background_object : false,
        options: {
            'background_type': 'no-fill',
            'background': {
                'background-repeat':'',
                'background-attachment':'',
                'background-position':'',
                'background-size':'',
                'background-image':'',
            },
            'background_color': '',
            'background_color_opacity': '1',
            'background_color_secondary': '',
            'background_color_hover': '',
            'background_color_opacity_hover': '',
            'background_color_secondary_hover': '',
            'background_gradient_orientation': '',
            'bg_mode': '',
            'video_background_mp4': '',
            'video_background_ogg': '',
            'video_background_webm': '',
        },
        background_type: false,
        background_color: false,
        background_color_opacity: false,
        background_color_secondary: false,
        background_color_hover: false,
        background_color_opacity_hover: false,
        background_color_secondary_hover: false,
        background_gradient_orientation: false,
        background_image: false,
        bg_mode: false,
        video_background_mp4: false,
        video_background_ogg: false,
        video_background_webm: false,

        widget_id : '',

        init: function() {


            this.defaut_actions();
            $(document).on('change', '.code125-background-editor #'+this.widget_id+'background_color', function(){
                console.log($(this).val());
            });

            $(document).on('blur keyup click change paste', '#'+this.widget_id+'background', function(){
                var parent_obj = $(this).closest('.format-settings');
                Code125_Background_Editor.update_preview_from_inputs(parent_obj);
            });
            $(document).on('blur keyup click change', '.code125-background-editor .format-settings', function(){
                var parent_obj = $(this).closest('.format-settings');
                Code125_Background_Editor.update_preview_from_inputs(parent_obj);
            });
            $(document).on('click', '.code125-preview-refresh', function(){
                Code125_Background_Editor.update_preview();
            });

        },
        update_preview_from_inputs: function(parent_obj){
            $('.code125-preview-loading').addClass('code125-show');
            var widget_id =  $('.code125-background-editor').attr('data-widget-id');
            if (parent_obj.hasClass('format-settings-background')) {
                var ajax_data = {
                    'action': 'code125_admin_image_single_color_generation',
                    'options': Code125_Background_Editor.get_options(),
                };
                $.ajax({
                    type: "post",
                    url: c5ab_ajax_object.ajax_url,
                    data: ajax_data,
                    success: function(data){
                        response =  $.parseJSON(data);
                        if (response['type'] == 'one-color') {
                            $('.code125-background-editor #'+widget_id+'background_color').val(response['main']).trigger('change');
                            $('.code125-background-editor #'+widget_id+'bg_mode').val(response['class']).trigger('change');
                        }else{
                            $('.code125-background-editor #'+widget_id+'background_color').val(response['left']).trigger('change');
                            $('.code125-background-editor #'+widget_id+'background_color_secondary').val(response['right']).trigger('change');
                            $('.code125-background-editor #'+widget_id+'bg_mode').val(response['class']).trigger('change');
                        }

                    }
                });
            }else if (parent_obj.hasClass('format-settings-background_color')) {
                var ajax_data = {
                    'action': 'code125_admin_color_class',
                    'options': Code125_Background_Editor.get_options(),
                };
                $.ajax({
                    type: "post",
                    url: c5ab_ajax_object.ajax_url,
                    data: ajax_data,
                    success: function(data){
                        console.log(data);
                        response =  $.parseJSON(data);
                        $('.code125-background-editor #'+widget_id+'bg_mode').val(response['class']).trigger('change');

                    }
                });
            }else if (parent_obj.hasClass('format-settings-background_type')) {
                var ajax_data = {
                    'action': 'code125_admin_color_opacity',
                    'options': Code125_Background_Editor.get_options(),
                };
                $.ajax({
                    type: "post",
                    url: c5ab_ajax_object.ajax_url,
                    data: ajax_data,
                    success: function(data){
                        console.log(data);
                        response =  $.parseJSON(data);
                        $('.code125-background-editor #'+widget_id+'background_color_opacity').val(response['opacity']).trigger('change');
                        var css_value = 100*parseFloat(response['opacity']);
                         css_value = css_value.toString() + '%';
                        $('.code125-background-editor .format-settings-background_color_opacity .ui-slider-handle').css('left', css_value );
                        $('.code125-background-editor .format-settings-background_color_opacity .ot-numeric-slider-helper-input').val(response['opacity']);

                    }
                });
            }
            Code125_Background_Editor.update_preview();
        },
        update_preview: function(){
            $('.code125-preview-loading').addClass('code125-show');
            Code125_Background_Editor.defaut_actions();

            var ajax_data = {
                'action': 'code125_admin_background_preview',
                'options': Code125_Background_Editor.get_options(),
            };

            $.ajax({
                type: "post",
                url: c5ab_ajax_object.ajax_url,
                data: ajax_data,
                success: function(data){
                    $('.code125-background-editor-preview-wrap').html(data);
                        $('.code125-preview-loading').removeClass('code125-show');
                }
            });
        },
        get_options: function (){
            this.background_object = $('.code125-background-editor');
            this.widget_id = $('.code125-background-editor').attr('data-widget-id');
            this.background_type = this.background_object.find('.format-settings-background_type');

            this.background_color = this.background_object.find('.format-settings-background_color');
            this.background_color_opacity = this.background_object.find('.format-settings-background_color_opacity');

            this.background_color_secondary = this.background_object.find('.format-settings-background_color_secondary');

            this.background_color_hover = this.background_object.find('.format-settings-background_color_hover');
            this.background_color_opacity_hover = this.background_object.find('.format-settings-background_color_opacity_hover');
            this.background_color_secondary_hover = this.background_object.find('.format-settings-background_color_secondary_hover');



            this.background_gradient_orientation = this.background_object.find('.format-settings-background_gradient_orientation');

            this.background_image = this.background_object.find('.format-settings-background');
            this.bg_mode = this.background_object.find('.format-settings-bg_mode');

            this.video_background_mp4 = this.background_object.find('.format-settings-video_background_mp4');
            this.video_background_ogg = this.background_object.find('.format-settings-video_background_ogg');
            this.video_background_webm = this.background_object.find('.format-settings-video_background_webm');

            this.options.background_type = this.background_type.find('.option-tree-ui-select ').val();
            this.options.background_color = this.background_color.find('#'+this.widget_id+'background_color').val();
            this.options.background_color_opacity = this.background_color_opacity.find('.ot-numeric-slider-hidden-input').val();

            this.options.background_color_hover =
            this.background_color_hover.find('#'+this.widget_id+'background_color_hover').val();

            this.options.background_color_secondary_hover =
            this.background_color_secondary_hover.find('#'+this.widget_id+'background_color_secondary_hover').val();
            this.options.background_color_opacity_hover = this.background_color_opacity_hover.find('.ot-numeric-slider-hidden-input').val();

            this.options.background_color_secondary = this.background_color_secondary.find('#'+this.widget_id+'background_color_secondary').val();
            this.options.background_gradient_orientation = this.background_gradient_orientation.find('.option-tree-ui-select').val();

            var background_image = {};
            background_image['background-repeat'] = this.background_image.find('#'+this.widget_id+'background-repeat').val();
            background_image['background-attachment'] = this.background_image.find('#'+this.widget_id+'background-attachment').val();
            background_image['background-position'] = this.background_image.find('#'+this.widget_id+'background-position').val();
            background_image['background-size'] = this.background_image.find('#'+this.widget_id+'background-size').val();
            background_image['background-image'] = this.background_image.find('#'+this.widget_id+'background').val();
            this.options.background = background_image;

            this.options.bg_mode = this.bg_mode.find('.option-tree-ui-select').val();
            this.options.video_background_mp4 = this.video_background_mp4.find('.option-tree-ui-upload-input').val();
            this.options.video_background_ogg = this.video_background_ogg.find('.option-tree-ui-upload-input').val();
            this.options.video_background_webm = this.video_background_webm.find('.option-tree-ui-upload-input').val();

            return this.options;


        },
        defaut_actions: function (){

            this.get_options();
            this.show_and_hide_options();
        },
        show_and_hide_options: function (){
            if (this.options.background_type == 'no-fill') {
                this.hide(this.background_color);
                this.hide(this.background_color_opacity);
                this.hide(this.background_color_hover);
                this.hide(this.background_color_secondary_hover);
                this.hide(this.background_color_opacity_hover);
                this.hide(this.background_color_secondary);
                this.hide(this.background_gradient_orientation);
                this.hide(this.background_image);
                this.hide(this.video_background_mp4);
                this.hide(this.video_background_ogg);
                this.hide(this.video_background_webm);
                this.hide(this.bg_mode);
            }else if (this.options.background_type == 'color-fill') {
                this.show(this.background_color);
                this.hide(this.background_color_opacity);
                this.hide(this.background_color_secondary);
                this.show(this.background_color_hover);
                this.hide(this.background_color_secondary_hover);
                this.show(this.background_color_opacity_hover);
                this.hide(this.background_gradient_orientation);
                this.hide(this.background_image);
                this.hide(this.video_background_mp4);
                this.hide(this.video_background_ogg);
                this.hide(this.video_background_webm);
                this.show(this.bg_mode);
            }else if (this.options.background_type == 'gradient-fill') {
                this.show(this.background_color);
                this.hide(this.background_color_opacity);
                this.show(this.background_color_hover);
                this.show(this.background_color_secondary_hover);
                this.hide(this.background_color_opacity_hover);
                this.show(this.background_color_secondary);
                this.show(this.background_gradient_orientation);
                this.hide(this.background_image);
                this.hide(this.video_background_mp4);
                this.hide(this.video_background_ogg);
                this.hide(this.video_background_webm);
                this.show(this.bg_mode);
            }else if (this.options.background_type == 'image-fill') {
                this.hide(this.background_color);
                this.hide(this.background_color_opacity);
                this.hide(this.background_color_hover);
                this.hide(this.background_color_secondary_hover);
                this.hide(this.background_color_opacity_hover);
                this.hide(this.background_color_secondary);
                this.hide(this.background_gradient_orientation);
                this.show(this.background_image);
                this.hide(this.video_background_mp4);
                this.hide(this.video_background_ogg);
                this.hide(this.video_background_webm);
                this.show(this.bg_mode);
            }else if (this.options.background_type == 'color-image-fill') {
                this.show(this.background_color);
                this.show(this.background_color_opacity);
                this.show(this.background_color_hover);
                this.show(this.background_color_opacity_hover);
                this.hide(this.background_color_secondary_hover);
                this.hide(this.background_color_secondary);
                this.hide(this.background_gradient_orientation);
                this.show(this.background_image);
                this.hide(this.video_background_mp4);
                this.hide(this.video_background_ogg);
                this.hide(this.video_background_webm);
                this.show(this.bg_mode);
            }else if (this.options.background_type == 'single-gradient-image-fill') {
                this.show(this.background_color);
                this.show(this.background_color_opacity);
                this.hide(this.background_color_hover);
                this.hide(this.background_color_secondary_hover);
                this.hide(this.background_color_opacity_hover);
                this.hide(this.background_color_secondary);
                this.hide(this.background_gradient_orientation);
                this.show(this.background_image);
                this.hide(this.video_background_mp4);
                this.hide(this.video_background_ogg);
                this.hide(this.video_background_webm);
                this.show(this.bg_mode);
            }else if (this.options.background_type == 'gradient-image-fill') {
                this.show(this.background_color);
                this.hide(this.background_color_opacity);
                this.hide(this.background_color_hover);
                this.hide(this.background_color_secondary_hover);
                this.hide(this.background_color_opacity_hover);
                this.show(this.background_color_secondary);
                this.hide(this.background_gradient_orientation);
                this.show(this.background_image);
                this.hide(this.video_background_mp4);
                this.hide(this.video_background_ogg);
                this.hide(this.video_background_webm);
                this.show(this.bg_mode);
            }else if (this.options.background_type == 'video-fill') {
                this.hide(this.background_color);
                this.hide(this.background_color_opacity);
                this.hide(this.background_color_hover);
                this.hide(this.background_color_secondary_hover);
                this.hide(this.background_color_opacity_hover);
                this.hide(this.background_color_secondary);
                this.hide(this.background_gradient_orientation);
                this.hide(this.background_image);
                this.show(this.video_background_mp4);
                this.show(this.video_background_ogg);
                this.show(this.video_background_webm);
                this.show(this.bg_mode);
            }else if (this.options.background_type == 'color-video-fill') {
                this.show(this.background_color);
                this.show(this.background_color_opacity);
                this.show(this.background_color_hover);
                this.hide(this.background_color_secondary_hover);
                this.show(this.background_color_opacity_hover);
                this.hide(this.background_color_secondary);
                this.hide(this.background_gradient_orientation);
                this.hide(this.background_image);
                this.show(this.video_background_mp4);
                this.show(this.video_background_ogg);
                this.show(this.video_background_webm);
                this.show(this.bg_mode);
            }else if (this.options.background_type == 'single-gradient-video-fill') {
                this.show(this.background_color);
                this.show(this.background_color_opacity);
                this.hide(this.background_color_hover);
                this.hide(this.background_color_secondary_hover);
                this.hide(this.background_color_opacity_hover);
                this.hide(this.background_color_secondary);
                this.hide(this.background_gradient_orientation);
                this.hide(this.background_image);
                this.show(this.video_background_mp4);
                this.show(this.video_background_ogg);
                this.show(this.video_background_webm);
                this.show(this.bg_mode);
            }else if (this.options.background_type == 'gradient-video-fill') {
                this.show(this.background_color);
                this.hide(this.background_color_opacity);
                this.hide(this.background_color_hover);
                this.hide(this.background_color_secondary_hover);
                this.hide(this.background_color_opacity_hover);
                this.show(this.background_color_secondary);
                this.hide(this.background_gradient_orientation);
                this.hide(this.background_image);
                this.show(this.video_background_mp4);
                this.show(this.video_background_ogg);
                this.show(this.video_background_webm);
                this.show(this.bg_mode);
            }
        },
        hide: function(the_object){
            the_object.css('display','none')
        },
        show: function(the_object){
            the_object.css('display','block')
        }
    }

})(jQuery);
