jQuery(document).ready(function($) {

    var c5ab_icons_button;

  tinymce.create('tinymce.plugins.C5AB_ICONS_BUTTON', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
           ed.addCommand('c5abIconButton', function() {
               var c5ab_icons_button;
               c5ab_icons_button = ed;
               var icons_list = $('.c5-icons-list-wrap-hidden').html();

               $('.c5-the-wp-editor-icons').html(icons_list);
               $('.c5-icons-wp-editor-wrap').css('display','block');
            });



            ed.addButton('c5abIconButton', {
                title : 'Insert icon',
                cmd : 'c5abIconButton',
                image : url + '/icon.png'
            });
        },

        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl : function(n, cm) {
            return null;
        },

        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                    longname : 'C5AB_ICONS_BUTTON',
                    author : 'Code125',
                    authorurl : 'https://themeforest.net/user/code125/portfolio?ref=code125',
                    infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/example',
                    version : "1.0"
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add('c5abPageBuilder', tinymce.plugins.C5AB_ICONS_BUTTON);

    $(document).on('click', '.c5-the-wp-editor-icons .c5_span_icon', function (e) {
		var icon_class = $(this).attr('data-class');
		response = '<i class="'+icon_class+'"> </i>';
        send_to_editor(response);
		$('.c5-icons-wp-editor-wrap').css('display' , 'none');

	});
    $(document).on('click', '.c5-the-wp-editor-icons .c5-close-panel', function (e) {

		$('.c5-icons-wp-editor-wrap').css('display' , 'none');

	});


});
