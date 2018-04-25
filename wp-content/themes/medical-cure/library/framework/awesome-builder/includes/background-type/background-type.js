/**
* Code125 Background Editor UI
*
* Dependencies: jQuery, jQuery UI
*
* @author Code125(info@code125.com)
*/

;(function($) {
    Code125_OT_Background_Editor = {

        init: function(main_class_id) {


            this.defaut_actions();

            var this_form = $(main_class_id).find('.code125-cpt-background-form');
            this.show_and_hide_options(this_form);

            $(document).on('change', '.code125-cpt-background-form input', function(){
                var this_form = $(this).closest('.code125-cpt-background-form');
                Code125_OT_Background_Editor.preview(this_form);
            });
            $(document).on('click', '.code125-cbgep-preview-refresh', function(){
                var this_form = $(this).closest('.code125-type-custom-background').find('.code125-cpt-background-form');
                Code125_OT_Background_Editor.preview(this_form);
            });

            $(document).on('click', '.code125-switch-background-colors', function(){
                var this_form = $(this).closest('.code125-type-custom-background').find('.code125-cpt-background-form');

                var element_id = this_form.find('.code125-custom-background-field-id').attr('name');

                var color_1 = this_form.find('#' + element_id + '-code125-color-1').val();
                var color_1_hover = this_form.find('#' + element_id + '-code125-color-1-hover').val();

                var color_2 = this_form.find('#' + element_id + '-code125-color-3').val();
                var color_2_hover = this_form.find('#' + element_id + '-code125-color-3-hover').val();

                Code125_OT_Background_Editor.set_color(this_form.find('#' + element_id + '-code125-color-1'), color_2);
                Code125_OT_Background_Editor.set_color(this_form.find('#' + element_id + '-code125-color-1-hover'), color_2_hover);

                Code125_OT_Background_Editor.set_color(this_form.find('#' + element_id + '-code125-color-3'), color_1);
                Code125_OT_Background_Editor.set_color(this_form.find('#' + element_id + '-code125-color-3-hover'), color_1_hover);

                Code125_OT_Background_Editor.preview(this_form);
            });




            $(document).on('click', 'ul.c5cbg-tabs li', function (e) {
        		var this_li = $(this);
                var this_content = $('.pane-' +  this_li.attr('data-tab'));
                var this_parent = this_li.parent().parent();
                this_parent.find('.c5cbg-pane').css('display','none');
                this_parent.find('ul.c5cbg-tabs li').removeClass('selected');
                this_li.addClass('selected');
                this_content.css('display','block');
        	});



            $(document).on('change', '.code125-cpt-background-form select', function(){
                var this_form = $(this).closest('.code125-cpt-background-form');
                Code125_OT_Background_Editor.preview(this_form);
            });

            $(document).on('click', '.code125-custom-bg-select-element', function(){
                var this_obj = $(this);
                var parent_obj = $(this).closest('.code125-custom-bg-select-wrap');
                var this_value = this_obj.attr('data-value');

                var this_form = parent_obj.closest('.code125-cpt-background-form');

                parent_obj.find('.code125-custom-bg-select-input').val(this_value).trigger('change');
                parent_obj.find('.code125-custom-bg-select-element').removeClass('current');
                this_obj.addClass('current');

                Code125_OT_Background_Editor.show_and_hide_options(this_form);
                Code125_OT_Background_Editor.preview(this_form);
            });

            $(document).on('click' , '.c5-custom-bg-delete', function(){

                var parent_obj = $(this).parent();
                parent_obj.find('input').val('').trigger('change');
                parent_obj.removeClass('delete-input-active');
            });

            $(document).on('click' , '.code125-row-seperator-demo', function(){

                var ul_object = $(this).parent().children('.code125-seperator-wrap');
                if (ul_object.hasClass('code125-show')) {
                    ul_object.removeClass('code125-show');
                }else{
                    ul_object.addClass('code125-show');
                }

            });
            $(document).on('click' , 'ul.code125-seperator-wrap li', function(){
                var this_object = $(this);

                this_object.parent().parent().children('input').val(this_object.attr('data-choice'));

                this_object.parent().parent().children('.code125-row-seperator-demo').html(this_object.html());

                this_object.parent().parent().children('.code125-seperator-wrap').removeClass('code125-show');

                var this_form = this_object.closest('.code125-cpt-background-form');
                Code125_OT_Background_Editor.preview(this_form);
            });


            $(document).on('click' , '.c5cbg-copy-btn', function(){

                var parent_obj = $(this).parent();
                var export_textarea = parent_obj.children('.code125-background-export');
                var result = Code125_OT_Background_Editor.copyToClipboard(export_textarea[0]);
                if (result) {
                    $(this).find('.fa').removeClass('fa-copy').addClass('fa-check');
                    var sp_timer;
                    clearTimeout(sp_timer);
                    sp_timer = setTimeout(Code125_OT_Background_Editor.return_copy_icon, 1000, $(this));
                }
            });


            $(document).on('click' , '.c5-custom-bg-upload', function(){
                var parent_obj = $(this).parent();
                var frame;

                frame = wp.media({
                    title: 'Select or Upload Media Of Your Chosen Persuasion',
                    button: {
                        text: 'Use this media'
                    },
                    multiple: false
                });

                frame.on( 'select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    parent_obj.find('input').val(attachment.url).trigger('change');
                    parent_obj.addClass('delete-input-active');
                });

                frame.open();
            });

            $(document).on('click' , '.c5cbg-import-btn', function(){
                var this_button = $(this);
                this_button.find('.fa').removeClass('fa-download').addClass('fa-spin fa-spinner');
                var this_form = $(this).closest('.code125-type-custom-background').find('.code125-cpt-background-form');
                var import_data = $(this).parent().find('.code125-background-import').val();

                this_form.find('.c5cbg-hidden-value').val(import_data);
                var ajax_data = {
                    'action': 'c5cbg_import_settings',
                    'import_data': import_data,
                };
                $.ajax({
                    type: "post",
                    url: c5ab_ajax_object.ajax_url,
                    data: ajax_data,
                    success: function(data){
                        var options = $.parseJSON(data);
                        Code125_OT_Background_Editor.import_data(this_form, options);
                        Code125_OT_Background_Editor.show_and_hide_options(this_form);
                        Code125_OT_Background_Editor.preview(this_form);
                        this_button.find('.fa').removeClass('fa-spin fa-spinner').addClass('fa-download');
                    }
                });
            });

            $(document).on('click' , '.c5cbg-suggestion-single', function(){
                $('.code125-cbgep-preview-loading').addClass('code125-show');
                $('.code125-cbgep-preview-refresh').addClass('code125-hide');
                var this_form = $(this).closest('.code125-type-custom-background').find('.code125-cpt-background-form');
                var import_data = $(this).attr('data-import');

                this_form.find('.c5cbg-hidden-value').val(import_data);
                var ajax_data = {
                    'action': 'c5cbg_import_settings',
                    'import_data': import_data,
                };
                $.ajax({
                    type: "post",
                    url: c5ab_ajax_object.ajax_url,
                    data: ajax_data,
                    success: function(data){
                        var options = $.parseJSON(data);
                        Code125_OT_Background_Editor.import_data(this_form, options);
                        Code125_OT_Background_Editor.show_and_hide_options(this_form);
                        Code125_OT_Background_Editor.preview(this_form);
                    }
                });
            });

        },
        preview: function (this_form){
            $('.code125-cbgep-preview-loading').addClass('code125-show');
            $('.code125-cbgep-preview-refresh').addClass('code125-hide');
            //update main option
            var ajax_data = {
                'action': 'c5cbg_update_main_option',
                'options': this_form.find('select, input').serialize(),
            };
            $.ajax({
                type: "post",
                url: c5ab_ajax_object.ajax_url,
                data: ajax_data,
                success: function(data){
                    this_form.closest('.code125-type-custom-background').find('.code125-background-export').val(data);

                }
            });

            var ajax_data = {
                'action': 'c5cbg_preview_update',
                'options': this_form.find('select, input').serialize(),
                'option_id' : this_form.find('.code125-custom-background-field-id').attr('name'),
            };
            $.ajax({
                type: "post",
                url: c5ab_ajax_object.ajax_url,
                data: ajax_data,
                success: function(data){
                    $('.c5cbg-preview-div').html(data);
                    $('.code125-cbgep-preview-loading').removeClass('code125-show');
                    $('.code125-cbgep-preview-refresh').removeClass('code125-hide');
                }
            });
        },
        defaut_actions: function (){
            var sp_timer;
            $('.code125-type-custom-background .code125-color-input').wpColorPicker({
                defaultColor: false,
                change: function(event, ui){
                    clearTimeout(sp_timer);
                    sp_timer = setTimeout(Code125_OT_Background_Editor.preview, 1000, $(this).closest('.code125-cpt-background-form'));

                },
                clear: function() {},
            });
        },
        show_and_hide_options(this_form){
            var option_id = this_form.find('.code125-custom-background-field-id').attr('name');
            option_id = '#' + option_id + '-';
            console.log(option_id);
            this_form.find('.code125-cpt-bg-ui-common').addClass('code125-hide').removeClass('code125-hover-hide');

            this_form.children('.code125-background-type-wrap').removeClass('code125-hide');
            var this_type = this_form.find(option_id + 'code125-background-type').val();
            if(this_type  == 'color'){
                this_form.children('.code125-color-overlay-type-wrap').removeClass('code125-hide');
                var overlay_type =  $(option_id + 'code125-color-overlay-type').val();
                if (overlay_type == 'full' ) {
                    this_form.children('.code125-image-color-overlay-type-wrap').removeClass('code125-hide');
                    var color_overlay =  $(option_id + 'code125-image-color-overlay-type').val();
                    if (color_overlay == 'solid') {
                        this_form.children('.code125-color-1-wrap').removeClass('code125-hide');
                        this_form.children('.code125-background-lum-wrap').removeClass('code125-hide');
                        this_form.children('.code125-seperator-top-wrap').removeClass('code125-hide');
                        this_form.children('.code125-seperator-bottom-wrap').removeClass('code125-hide');
                    }else{
                        if (color_overlay == 'gradient-three') {
                            this_form.children('.code125-color-2-wrap').removeClass('code125-hide');
                        }
                        this_form.children('.code125-switch-background-colors').removeClass('code125-hide');
                        this_form.children('.code125-background-gradient-orientation-wrap').removeClass('code125-hide');
                        this_form.children('.code125-color-1-wrap').removeClass('code125-hide');
                        this_form.children('.code125-color-3-wrap').removeClass('code125-hide');
                        this_form.children('.code125-background-lum-wrap').removeClass('code125-hide');
                    }
                }else{
                    this_form.children('.code125-color-1-wrap').removeClass('code125-hide');
                    this_form.children('.code125-color-3-wrap').removeClass('code125-hide');
                    this_form.children('.code125-background-lum-wrap').removeClass('code125-hide');
                }
            }else if( this_type  == 'image'){
                this_form.children('.code125-custom-background-ui').removeClass('code125-hide');
                this_form.children('.code125-image-overlay-type-wrap').removeClass('code125-hide');
                this_form.children('.code125-background-lum-wrap').removeClass('code125-hide');
                this_form.children('.code125-background-animation-wrap').removeClass('code125-hide');

                var overlay_type =  $(option_id + 'code125-image-overlay-type').val();
                if (overlay_type == 'full' || overlay_type  == 'half' ) {
                    this_form.children('.code125-image-color-overlay-type-wrap').removeClass('code125-hide');
                    if (overlay_type == 'half') {
                        this_form.children('.code125-image-half-overlay-type-wrap').removeClass('code125-hide');
                    }

                    var color_overlay = $(option_id + 'code125-image-color-overlay-type').val();
                    if (color_overlay == 'solid') {
                        this_form.children('.code125-color-1-wrap').removeClass('code125-hide');
                    }else {
                        if (color_overlay == 'gradient-three') {
                            this_form.children('.code125-color-2-wrap').removeClass('code125-hide');
                        }
                        this_form.children('.code125-switch-background-colors').removeClass('code125-hide');

                        this_form.children('.code125-background-gradient-orientation-wrap').removeClass('code125-hide');
                        this_form.children('.code125-color-1-wrap').removeClass('code125-hide');
                        this_form.children('.code125-color-3-wrap').removeClass('code125-hide');
                    }
                }else if(overlay_type == 'container'){
                    this_form.children('.code125-color-1-wrap').removeClass('code125-hide').addClass('code125-hover-hide');
                    this_form.children('.code125-color-2-wrap').removeClass('code125-hide');
                    this_form.children('.code125-color-3-wrap').removeClass('code125-hide').addClass('code125-hover-hide');
                }
            }else if( this_type  == 'video'){
                this_form.children('.code125-custom-background-video-ui').removeClass('code125-hide');
                this_form.children('.code125-video-overlay-type-wrap').removeClass('code125-hide');
                this_form.children('.code125-background-lum-wrap').removeClass('code125-hide');
                var overlay_type =  $(option_id + 'code125-video-overlay-type').val();
                if (overlay_type == 'full' ) {
                    this_form.children('.code125-image-color-overlay-type-wrap').removeClass('code125-hide');
                    var color_overlay = $(option_id + 'code125-image-color-overlay-type').val();
                    if (color_overlay == 'solid') {
                        this_form.children('.code125-color-1-wrap').removeClass('code125-hide');
                    }else {
                        if (color_overlay == 'gradient-three') {
                            this_form.children('.code125-color-2-wrap').removeClass('code125-hide');
                        }
                        this_form.children('.code125-switch-background-colors').removeClass('code125-hide');
                        this_form.children('.code125-background-gradient-orientation-wrap').removeClass('code125-hide');
                        this_form.children('.code125-color-1-wrap').removeClass('code125-hide');
                        this_form.children('.code125-color-3-wrap').removeClass('code125-hide');
                    }
                }else if(overlay_type == 'container'){
                    this_form.children('.code125-color-1-wrap').removeClass('code125-hide');
                    this_form.children('.code125-color-2-wrap').removeClass('code125-hide');
                    this_form.children('.code125-color-3-wrap').removeClass('code125-hide');
                }
            }
        },
        show: function(the_object){
            the_object.removeClass('code125-hide');
        },
        hide: function(the_object){
            the_object.addClass('code125-hide');
        },
        return_copy_icon: function(elem){
            elem.find('.fa').removeClass('fa-check').addClass('fa-copy');
        },
        import_data: function(this_form , options){
            this.set_visual_select(this_form.find('.code125-background-type-wrap') , options['code125-background-type']);
            this.set_upload(this_form.find('.code125-background-image') , options['code125-background-image']);
            this.set_select(this_form.find('.code125-background-attachment') , options['code125-background-attachment']);
            this.set_select(this_form.find('.code125-background-position') , options['code125-background-position']);
            this.set_select(this_form.find('.code125-background-repeat') , options['code125-background-repeat']);
            this.set_input(this_form.find('.code125-background-size') , options['code125-background-size']);

            this.set_upload(this_form.find('.code125-background-video-mp4') , options['code125-background-video-mp4']);
            this.set_upload(this_form.find('.code125-background-video-ogg') , options['code125-background-video-ogg']);
            this.set_upload(this_form.find('.code125-background-video-webm') , options['code125-background-video-webm']);

            this.set_visual_select(this_form.find('.code125-color-overlay-type-wrap') , options['code125-color-overlay-type']);
            this.set_visual_select(this_form.find('.code125-image-overlay-type-wrap') , options['code125-image-overlay-type']);
            this.set_visual_select(this_form.find('.code125-video-overlay-type-wrap') , options['code125-video-overlay-type']);
            this.set_visual_select(this_form.find('.code125-color-overlay-type-wrap') , options['code125-color-overlay-type']);

            this.set_visual_select(this_form.find('.code125-image-half-overlay-type-wrap') , options['code125-image-half-overlay-type']);
            this.set_visual_select(this_form.find('.code125-image-color-overlay-type-wrap') , options['code125-image-color-overlay-type']);
            this.set_visual_select(this_form.find('.code125-background-gradient-orientation-wrap') , options['code125-background-gradient-orientation']);

            this.set_color(this_form.find('.code125-color-1') , options['code125-color-1']);
            this.set_select(this_form.find('.code125-color-1-opacity') , options['code125-color-1-opacity']);

            this.set_color(this_form.find('.code125-color-1-hover') , options['code125-color-1-hover']);
            this.set_select(this_form.find('.code125-color-1-hover-opacity') , options['code125-color-1-hover-opacity']);

            this.set_color(this_form.find('.code125-color-2') , options['code125-color-2']);
            this.set_select(this_form.find('.code125-color-2-opacity') , options['code125-color-2-opacity']);

            this.set_color(this_form.find('.code125-color-2-hover') , options['code125-color-2-hover']);
            this.set_select(this_form.find('.code125-color-2-hover-opacity') , options['code125-color-2-hover-opacity']);

            this.set_color(this_form.find('.code125-color-3') , options['code125-color-3']);
            this.set_select(this_form.find('.code125-color-3-opacity') , options['code125-color-3-opacity']);

            this.set_color(this_form.find('.code125-color-3-hover') , options['code125-color-3-hover']);
            this.set_select(this_form.find('.code125-color-3-hover-opacity') , options['code125-color-3-hover-opacity']);

            this.set_visual_select(this_form.find('.code125-background-lum-wrap') , options['code125-background-lum']);

        },
        set_visual_select: function(element_id, value){
            element_id.find('.code125-custom-bg-select-element').removeClass('current');
            element_id.find('input').val(value);
            element_id.find('.code125-custom-bg-select-element[data-value="'+value+'"]').addClass('current');

        },
        set_select: function(element_id, value){
            element_id.val(value);
            element_id.parent().children('span').html(value);
        },
        set_input: function(element_id, value){
            element_id.val(value);
        },
        set_upload: function(element_id, value){
            element_id.val(value);
            element_id.parent().removeClass('delete-input-active');
            if (value != '') {
                element_id.parent().addClass('delete-input-active');
            }
        },
        set_color: function(element_id, value){
            var this_parent = element_id.closest('.wp-picker-container');
            this_parent.find('input.wp-color-picker').val(value);
            this_parent.find('.wp-color-result').css('background-color', value);
        },
        copyToClipboard: function(elem){
            // create hidden text element, if it doesn't already exist
            var targetId = "_hiddenCopyText_";
            var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";

            var origSelectionStart, origSelectionEnd;
            if (isInput) {
                // can just use the original source element for the selection and copy
                target = elem;
                origSelectionStart = elem.selectionStart;
                origSelectionEnd = elem.selectionEnd;
            } else {
                // must use a temporary form element for the selection and copy
                target = document.getElementById(targetId);
                if (!target) {
                    var target = document.createElement("textarea");
                    target.style.position = "absolute";
                    target.style.left = "-9999px";
                    target.style.top = "0";
                    target.id = targetId;
                    document.body.appendChild(target);
                }
                target.textContent = elem.textContent;
            }
            // select the content
            var currentFocus = document.activeElement;
            target.focus();
            target.setSelectionRange(0, target.value.length);

            // copy the selection
            var succeed;
            try {
                succeed = document.execCommand("copy");
            } catch(e) {
                succeed = false;
            }
            // restore original focus
            if (currentFocus && typeof currentFocus.focus === "function") {
                currentFocus.focus();
            }

            if (isInput) {
                // restore prior selection
                elem.setSelectionRange(origSelectionStart, origSelectionEnd);
            } else {
                // clear temporary content
                target.textContent = "";
            }
            return succeed;

        }
    }

})(jQuery);
