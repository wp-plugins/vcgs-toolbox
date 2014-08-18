// JavaScript Document
(function() {
    tinymce.create('tinymce.plugins.vcgs', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
				 ed.addButton('piopialo', {
								title : 'Piopialo en Texto',
								cmd : 'piopialo',
								image : url + '/pi-icon.png'
							});
							
							ed.addCommand('piopialo', function() {
								var selected_text = ed.selection.getContent();
								var return_text = '';
								// Avisamos si hay más de 100 caracteres
								if (selected_text.length > 100) {
									if (confirm('¡Cuidado! - La frase seleccionada supera los 100 caracteres por lo que es posible que no quepa en Tuit. ¿Seguro que deseas hacerla piopiable?')) {
										return_text = '[piopialo]' + selected_text + '[/piopialo]';
										ed.execCommand('mceInsertContent', 0, return_text);
									}
								} 
								else {
									return_text = '[piopialo]' + selected_text + '[/piopialo]';
									ed.execCommand('mceInsertContent', 0, return_text);
								}
							});
							
						ed.addButton('piopialob', {
								title : 'Piopialo en Caja',
								cmd : 'piopialob',
								image : url + '/pi-iconB.png'
							});
							
							ed.addCommand('piopialob', function() {
								var selected_text = ed.selection.getContent();
								var return_text = '';
								// Avisamos si hay más de 100 caracteres
								if (selected_text.length > 100) {
									if (confirm('¡Cuidado! - La frase seleccionada supera los 100 caracteres por lo que es posible que no quepa en Tuit. ¿Seguro que deseas hacerla piopiable?')) {
										return_text = '[piopialo vcboxed="1"]' + selected_text + '[/piopialo]';
										ed.execCommand('mceInsertContent', 0, return_text);
									}
								} 
								else {
									return_text = '[piopialo vcboxed="1"]' + selected_text + '[/piopialo]';
									ed.execCommand('mceInsertContent', 0, return_text);
								}
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
                longname : 'Vcgs Toolbox Buttons',
                author : 'Victor Campuzano',
                authorurl : 'http://www.vcgs.net/blog',
                infourl : 'https://wordpress.org/plugins/vcgs-toolbox/',
                version : "0.1"
            };
        }
    });
 
    // Register plugin
    tinymce.PluginManager.add( 'vcgs', tinymce.plugins.vcgs );
})();