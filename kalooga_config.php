<?php
/*
Kalooga Plugin
*/
 
require_once('./admin.php');
load_plugin_textdomain( 'kalooga', 'wp-content/plugins/kalooga/languages', 'kalooga/languages' );

$publisher_url = "http://publisher.kalooga.com";
$publishing_url = "http://publishing.kalooga.com";

if (isset($_POST['info_update'])) {
	// ****** Update operation
	// Set values
	update_option('kalooga_api_key', $_POST['kalooga_api_key']);
	update_option('kalooga_publisher_id', $_POST['kalooga_publisher_id']);
	
	echo '<div id="message" class="updated fade"><p><strong>';
	_e('Kalooga API Key updated successfully.', 'kalooga');
	echo '</strong></p></div>';
}
?>
<div class="wrap">
<h2><?php _e('Kalooga configuration','kalooga') ?></h2><p>
<?php _e('This is the advanced configuration tab for Kalooga widgets. Leave these field empty to use the plugin in basic mode.','kalooga');
_e(' In basic mode, the sidebar widget is a 190x225 pixels <i>iCatcher</i> widget with 3x3 thumbnails. The kalooga widget that goes with your posts is a 400x83 pixels <i>photostring</i> widget with 8 thumbnails.', 'kalooga');?></p>
<p><?php _e('For custom widgets (other dimensions, colors or types), for which you can optimize your search results, please take the following steps:', 'kalooga');?>
    <ol>
	    <li><?php printf(__('<a href="%s" target="_BLANK">Create an account</a> and follow the instructions or <a href="%s" target="_BLANK">download the manual here</a>.', 'kalooga'),"{$publisher_url}/accounts/register/1/","http://company.kalooga.com/manuals/Kalooga.Manual_Publisher.v1.pdf");?></li>
	    <li><?php printf(__('Create a new widget in the <a href="%s" target="_BLANK">publisher tool</a> (e.g. <i>My Widgets-&gt;Create new widget-&gt;icatcher</i>).', 'kalooga'), $publisher_url);?></li>
	    <li><?php printf(__('Get your API Key and Publisher ID, in the <a href="%s" target="_BLANK">publisher tool</a> go to "options" and click on the tab "Get API key". You\'ll find your "API key" and your "Publisher ID". ', 'kalooga'), "{$publisher_url}");?></li>
	    <li><?php _e('Fill out these details in the form below, and press Save.', 'kalooga');?></li>
	    <li><?php _e("When you click on the Kalooga icon within your WYSIWYG-editor, you'll be able to use the 'advanced mode' to. ", 'kalooga');?></li>
    </ol>
		 

<form method="post" action="">
	
	<table class="form-table">
		<tr valign="top">
		<th scope="row"><?php _e('API Key','kalooga') ?>:</th>
		<td>
			<input name="kalooga_api_key" type="text" id="kalooga_api_key" value="<?php form_option('kalooga_api_key'); ?>" size="40" />
		</td>
		</tr>
		<tr valign="top">
		<th scope="row"><?php _e('Publisher id','kalooga') ?>:</th>
		<td>
			<input name="kalooga_publisher_id" type="text" id="kalooga_publisher_id" value="<?php form_option('kalooga_publisher_id'); ?>" size="40" />
		</td>
		</tr>
	</table>

	<p class="submit">
		<input type="submit" name="info_update" value="<?php _e('Save','kalooga') ?> &raquo;" />
	</p>
</form>

</div>
