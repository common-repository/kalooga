<?php
/*
Kalooga plugin
*/

require_once('../classes.php');
load_plugin_textdomain( 'kalooga', 'wp-content/plugins/kalooga/languages', 'kalooga/languages' );

$publisher_url = "http://publisher.kalooga.com";
$publishing_url = "http://publishing.kalooga.com";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php _e('Kalooga Widget Dialog','kalooga') ?></title>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<?php if ($_GET[tinyMCE]) {?>
	<script language='javascript' type='text/javascript' src='<?php echo get_bloginfo('wpurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js'></script>
	<?php } else { ?>
	<link rel='stylesheet' href='css/kalooga.css' type='text/css' />
	<?php } ?>
	<link rel='stylesheet' href='css/kalooga_additional.css' type='text/css' />
	<script src="../js/jquery.js"></script>
	<script src="../js/functions.js.php"></script>
</head>

<body onload="javascript:init();">  
	<div id="simple-mode">
		<div style="width:100%;padding:2px;background-color:#a0a0a0;color:#ffffff;valign:middle;font-weight:bold;"><?php _e('Simple mode', 'kalooga'); ?>
		<button onclick="switchDivs();" style="display:inline;float:right;margin:2px;">
		<?php _e('Advanced mode', 'kalooga'); ?>
		</button>
		</div>
		<?php _e('Welcome. If you want to customize your widgets to make them look beter on your website, please click on \'advanced mode\' and sign up as a publisher.<ol><li>Fill in a keyword and click on "preview".</li><li>Previews of photo galleries, relevant to the keyword, are shown default in a so-called "photostring" (a horizontal banner or widget, width 400 pixels and hight 113 pixels).</li><li>Select "widget type", you can choose from:<ul><li>Photostring (default)</li><li>3x3 (h 159, w 250)</li><li>4x2 (h 150, w 200)</li></ul></li><li>Click on "Send" en the banner/widget displayed on your article.</li></ol>','kalooga');?>
		<div id="simple-mode-extra">
			<?php printf(__('Tips:<ul><li>Try more  and several keywords to get the right photo gallery preview;</li><li>Go to <a href="%s" target="_BLANK">www.kalooga.com</a>, and discover millions of photo galleries.</li></ul>','kalooga'),'http://www.kalooga.com/');?>
			
		</div>
		<label for="kalooga-query"><?php _e('Keyword', 'kalooga'); ?>:
			<input type="text" name="kalooga-query" id="kalooga-query" />
		</label><br />
		<label for="kalooga-query"><?php _e('Widget type', 'kalooga'); ?>:
			<select name="kalooga-widget-type" id="kalooga-widget-type">
				<option id="3757" value="3757">Photostring</option>
				<option id="4305" value="4305">iCatcher 3x3</option>
				<option id="4303" value="4303">iCatcher 4x2</option>
			</select>
		</label>
		</div>
	</div>
	<div id="advanced-mode">
    	<div style="width:100%;padding:2px;background-color:#a0a0a0;color:#ffffff;valign:middle;font-weight:bold;"><?php _e('Advanced mode', 'kalooga'); ?>
		<button onclick="switchDivs();" style="float:right;margin:2px;"><?php _e('Simple mode', 'kalooga'); ?></button></div>
		<div id="advanced-mode-extra">
			<?php printf(__("If you want more functionality, for example;<ol><li>You want to make your own selection of previews to be show non the page;</li><li>You want a different display of your widget/banner (shape, colour, size);</li><li>Managing all your Kalooga widgets on your website in one place;</li></ol>Then you'll need:<ol><li>Your 'Publisher ID' (3 or 4 numbers)</li><li>Your 'API key' (a string of numbers and characters, f.e. 02c0b7a01895b7c622845c4c65ced385)</li></ol>You'll get these as soon as you're registered as a publisher.<br /><dl><dt>Step 1:</dt><dd>If you <a href='%s' target='_BLANK'>click here</a>, you'll go to the publisher application of Kalooga and register yourself as publisher (follow the instructions on your screen or <a href='%s' target='_BLANK'>download the manual here</a>).</dd><dt>Step 2:</dt><dd>Log in to the publisher, make your channels and widgets (see chapter 3 of the user manual).</dd><dt>Step 4:</dt><dd>As soon as you've finished the registration process, go to 'options' and click on the tab 'Get API key'. You'll find your 'API key' and your 'Publisher ID'. Remember your 'Publisher ID' and copy your 'API key' (select and ctrl+c)</dd>","kalooga"),"http://publisher.kalooga.com","http://company.kalooga.com/manuals/Kalooga.Manual_Publisher.v1.pdf");
			_e("<dt>Step 4:</dt><dd>Go to your Wordpress dashboard to 'configuration' and click on 'Kalooga'. Paste your 'API key' and fill in your 'Publisher ID'. Click on 'Save'.</dd><dt>Step 5:</dt><dd>When you click on the Kalooga icon within your WYSIWYG-editor, you'll be able to use the 'advanced mode' to.</dd><dt>Step 6:</dt><dd>Select your created widgets to place them in your blog post.</dd></dl>",'kalooga');?>
		</div>
		<div id="advanced-mode-form">
		<?php printf(__("<ol><li>Select your widget and click 'Preview'</li><li>Do you want to customize the widget?<ol><li>Click 'customize this widget', a new page will be openend.</li><li>Fill in your custom query and select the images you want to display.</li><li>Close the popup and click 'refresh'.</li></ol></li><li>Click the 'Add to post' button.</li></ol><br />Do you want more widgets? Login to the <a href=\"%s\" target=\"_BLANK\">Kalooga publisher</a> and make hundreds of them!","kalooga"),"http://publisher.kalooga.com");?><br /><br />
			<label for="kalooga-widget-id"><?php _e('Widget','kalooga');?>:
		    	<select name="kalooga-widget-id" id="kalooga-widget-id">
		    		<option>--Select--</option>
		    	</select>
	    	</label>
		<!-- <button class="button-primary" onclick="javascript:kaloogaConfigureCustom(); return false;"><?php _e('Configure', 'kalooga'); ?></button>-->
		</div>
	</div>
	<br />	
    <div id="preview-send-buttons" style="padding:2px;width:100%;background-color:#a0a0a0;color:#ffffff;valign:middle;font-weight:bold;">	
		<button id="show-example" onclick="javascript:kaloogaShowExample(); return false;"><?php _e('Preview', 'kalooga'); ?></button>		
		<button id="continue" style="float:right;" onclick="javascript:kaloogaSendCode(true);"><?php _e('Add to post', 'kalooga'); ?></button>
	</div>	
	<div style="display: none;float:middle;width:450px;height:100%;" ><iframe frameborder="0" width="100%" height="220" id="kalooga-example"></iframe>
	<div id="customWidgetButtons" style="display:none;">
	<button id="customizeWidget" style="float:middle;" onclick="javascript:kaloogaConfigureCustom();"><?php _e('Customize this widget', 'kalooga'); ?></button>
	<button id="refreshCustomWidget" style="float:middle;" onclick="javascript:refreshCustomWidget();"><?php _e('Refresh', 'kalooga'); ?></button>
	</div></div>
</body>
</html>