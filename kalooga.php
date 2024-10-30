<?php
/*
Plugin Name: Kalooga
Plugin URI: http://integration.kalooga.com/integrations/wordpress/
Description: This plugin adds an interface for inserting Kalooga widgets in Wordpress posts. Works with Wordpress 2.5 - 2.8
Author: Ivor Bosloper & Jort Berends
Version: 2.1.4
Author URI: http://www.kalooga.com
*/

load_plugin_textdomain('kalooga','wp-content/plugins/kalooga/locale');

$publisher_url = "http://publisher.kalooga.com";
$publishing_url = "http://publishing.kalooga.com";

/**
 * This class is meant to avoid name collisions with existing WP functions
 */
class kalooga {
	
	/**
	 * Add the configuration page to the "Options" WP menu.
	 */
	function add_pages() {
		if ( current_user_can('manage_options') ) {
			// Settings page, not available in simple version
			add_options_page(__('Kalooga Configuration','kalooga'), 'Kalooga', 'manage_options', 'kalooga/kalooga_config.php');
		}
	}
	
	/**
	 * Add the plugin for the tinyMCE editor
	 * @param $plugin_array	Plugins array
	 * @return	Updated plugins array
	 */
	function extended_editor_mce_plugins($plugin_array) {
		$plugin_array['kalooga'] = get_bloginfo('wpurl') . '/' . PLUGINDIR . '/kalooga/tinymce/editor_plugin.js';
		return $plugin_array;
	}
	
	/**
	 * Add the button for the tinyMCE editor
	 * @param buttons	Buttons array
	 * @return	Updated buttons array
	 */
	function extended_editor_mce_buttons($buttons) {
		array_push($buttons, 'separator', 'kalooga');
    	return $buttons;
	}

	/**
	 */
	function add_plainTextEditor_js() {
		$url = get_bloginfo('wpurl') . '/' . PLUGINDIR . '/kalooga/tinymce';
		?>
		<script type="text/javascript">
			var qttoolbar = document.getElementById("ed_toolbar");

			if (qttoolbar) {
				var anchor = document.createElement("input");
				alt = "Kalooga"
				anchor.type = "button";
				anchor.value = alt;
				anchor.className = "ed_button";
				anchor.title = alt;
				anchor.id = "ed_" + alt;
				anchor.onclick = zp_open;
				qttoolbar.appendChild(anchor);
			}

			function zp_open() {
				var url = "<?php echo $url; ?>/popup_kalooga.php?tinyMCE=0";
				var name = "kalooga_popup";
				var w = 480;
				var h = 600;
				var valLeft = (screen.width) ? (screen.width-w)/2 : 0;
				var valTop = (screen.height) ? (screen.height-h)/2 : 0;
				var features = "width="+w+",height="+h+",left="+valLeft+",top="+valTop+",resizable=1,scrollbars=1";
				var kaloogaWindow = window.open(url, name, features);
				kaloogaWindow.focus();
			}
		</script>
		<?php
	}
	
	function extend_tinymce() {
		// Ckeck permissions
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;
		
		// Add only in Rich Editor mode
		if ( get_user_option('rich_editing') == 'true') {
			add_filter('mce_external_plugins', array('kalooga', 'extended_editor_mce_plugins'));
			add_filter('mce_buttons', array('kalooga','extended_editor_mce_buttons'));
		}
	}
	/**
	 * Replace the Kalooga shortcode with the widget
	 * @param $content the page content
	 * @return	Updated page content
	 */
	function filter_kalooga_url($content) {
		global $publishing_url;	
		//Advanced widget
		$content=preg_replace('/\[kalooga pid=(.*?) oid=(.*?) wid=(.*?) \/\]/is',"<script type=\"text/javascript\" src=\"". $publishing_url ."/overloadWidget?publisherId=$1&overloadId=$2\"> </script>",$content);
		$content=preg_replace('/\[kalooga wid=(.*?) \/\]/is',"<script type=\"text/javascript\" src=\"". $publishing_url ."/widget?code=$1\"> </script>",$content);
		//Simple widget
		$content=preg_replace('/\[kalooga q=(.*?) t=(.*?) \/\]/is',"<script type=\"text/javascript\" src=\"". $publishing_url ."/widget?code=$2&query=$1\"> </script>",$content);
	    return $content;
	}
}





// Add actions
add_action('admin_menu', array('kalooga','add_pages'));
add_action('init', array('kalooga','extend_tinymce'));

// Add filters
add_filter('admin_footer', array('kalooga','add_plainTextEditor_js'));
add_filter('the_content', array('kalooga','filter_kalooga_url'));
?>