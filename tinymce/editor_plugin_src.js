/**
 * Copyright 2006/2009  Alessandro Morandi  (email : webmaster@simbul.net)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */


//tinyMCE.importPluginLanguagePack('zenphotopress', 'en');

(function() {
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('kalooga');

	tinymce.create('tinymce.plugins.kalooga', {
		
		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname  : 'Zenphoto Gallery Plugin for WordPress',
				author    : 'Alessandro Morandi',
				authorurl : 'http://www.simbul.net',
				infourl   : 'http://www.simbul.net/zenphotopress',
				version   : "1.5"
			};
		},
		
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			
			// Register the command
			ed.addCommand('mceZenphotoPress', function() {
				ed.windowManager.open({
					file : url + '/popup_zp.php?tinyMCE=1',
					width : 480,
					height : 480,
					inline : 1
				});
			});
			
			// Register button
			ed.addButton('zenphotopress', {
				title : 'zenphotopress.title',
				cmd : 'mceZenphotoPress',
				image : url + '/img/zenphotopress.gif'
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
		}
	});

	// Register plugin
	tinymce.PluginManager.add('zenphotopress', tinymce.plugins.zenphotopress);
})();