<?php
/*
Plugin Name: Theme Companion
Plugin URI: http://frumph.net/
Description: CSS Editor, Extra Options and Functions for themes.
Version: 1.0.2
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/

Copyright 2009-2014 Philip M. Hofer (Frumph)  (email : philip@frumph.net)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/
if (is_admin()) {
	@require_once(dirname (__FILE__) . '/companion_core.php');
}

add_action('wp_head', 'companion_html_header_load');
		
function companion_html_header_load() {
	$wp_dirs = wp_upload_dir();
	if (file_exists($wp_dirs['basedir'] . '/css/header.html')) { 
		$f = fopen($wp_dirs['basedir'] . '/css/header.html', 'r');
		$companion_file_contents = fread($f, filesize($wp_dirs['basedir']. '/css/header.html'));
		if (!empty($companion_file_contents)) {
			echo $companion_file_contents;
		}
	}

	if (file_exists($wp_dirs['basedir'] . '/css/custom_style.css')) { ?>
<link rel='stylesheet' id='custom_stylesheet'  href='<?php echo $wp_dirs['baseurl']; ?>/css/custom_style.css' type='text/css' media='all' />
		<?php
	}
}

?>