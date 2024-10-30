<?php
/*
Kalooga plugin
*/


if (!function_exists('get_option')) {
	$wp_path = getWPBasePath();
	require_once($wp_path.'/wp-load.php');
}

	
/**
 * Recurse on directory to find the Wordpress base path
 * (i.e. the directory containing wp-config.php)
 * @return The base path or null on failure
 */	
function getWPBasePath() {
	$rel_path = '';
	for ($count = 1; $count <= 10; $count++) {
		$rel_path = $rel_path.'../';
		if (file_exists($rel_path . 'wp-config.php')) {
			return $rel_path;
		}
	}
	return null;
}
?>
