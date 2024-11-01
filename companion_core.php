<?php

add_action('admin_menu', 'companion_init_hooks');
add_action('admin_foot', 'companion_css_footer');

function companion_pluginfo($whichinfo = null) {
	global $companion_pluginfo;
	if (empty($companion_pluginfo) || $whichinfo == 'reset') {
		// need to create this config. NOW.
		$companion_pluginfo = '';
		$companion_coreinfo = wp_upload_dir();
		$companion_addinfo = array(
				'themeurl' => get_template_directory_uri(),
				'themepath' => get_template_directory(),
				'styleurl' => get_stylesheet_directory_uri(),
				'stylepath' => get_stylesheet_directory(),
				'plugindir' => plugin_dir_url(dirname (__FILE__)) . 'theme-companion',
				'pluginurl' => get_option('siteurl') . '/wp-content/plugins/theme-companion'
		);
		$companion_pluginfo = array_merge($companion_coreinfo, $companion_addinfo);
	}
	if ($whichinfo) return $companion_pluginfo[$whichinfo];
	return $companion_pluginfo;
}

function companion_is_multisite() {
	global $wpmu_version;
	if (function_exists('is_multisite'))
		if (is_multisite()) return true;
	if (!empty($wpmu_version)) return true;
	return false;
}

// Add menu page
function companion_init_hooks() {
	$companion_hook = add_submenu_page('themes.php', 'companion', __('Companion', 'companion'), 'manage_options', 'companion', 'companion_admin_page');
	add_action('admin_head-'.$companion_hook, 'companion_config_page_head');
	add_action('admin_print_scripts-'.$companion_hook, 'companion_load_scripts');
	add_action('admin_print_styles-'.$companion_hook, 'companion_load_styles');
}

function companion_load_scripts() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('edit_area_full', companion_pluginfo('pluginurl') . '/edit_area/edit_area_full.js');
	wp_enqueue_script('tabbed_pages', companion_pluginfo('pluginurl') . '/tabbed/tabbed_pages.js');
}

function companion_load_styles() {
	global $is_IE;
	if ($is_IE) {
		wp_enqueue_style('tabbed_style_ie', companion_pluginfo('pluginurl') . '/tabbed/tabbed_pages_ie.css');
	} else {
		wp_enqueue_style('tabbed_style', companion_pluginfo('pluginurl') . '/tabbed/tabbed_pages.css');
	}	
}

function companion_config_page_head() { ?>
<script language="javascript" type="text/javascript">
	editAreaLoader.init({
	id : "newcontent"		// textarea id
	,syntax: "css"			// syntax to be uses for highlighting
	,start_highlight: true		// to display with highlight mode on start-up
});
</script>
<?php 
}

		
/**
 * options page
 * 
*/	
function companion_admin_page() {
	global $is_iis7;
?>
	<div class="wrap">
	<h2 class="alignleft">Theme Companion</h2>
	<br clear="all" />
	<?php
	if (isset($_REQUEST['file'])) {
		switch ( stripslashes($_REQUEST['file']) ) {
			case "style": 
				$edit_file = "custom_style";
				break;
			case "head":
				$edit_file = "header";
				break;
			default:
				$edit_file = "custom_style";
				break;
		}
	} else $edit_file = "custom_style";
	if ($edit_file == 'header') {
		$companion_edit_type = 'html';
	} else {
		$companion_edit_type = 'css';
	}

	$companion_edit_file = companion_pluginfo('basedir') . '/css/' . $edit_file . '.' . $companion_edit_type;
	$original = false;
	if (isset($_REQUEST['file']) && ($_REQUEST['file'] == 'original')) {
		$original = true;
		$companion_edit_file = companion_pluginfo('themepath') . '/style.css';
	} 

	if (isset($_REQUEST['newcontent'])) $companion_file_content = trim(stripslashes($_REQUEST['newcontent']));
	?>
	
	<?php
	
	if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'update-options') ) {
		
		if ('companion_css_save' == $_REQUEST['action'] ) {
			$companion_file_content = trim(stripslashes($_REQUEST['newcontent']));
			if (!file_exists($companion_edit_file)) wp_mkdir_p(dirname($companion_edit_file));
			if (empty($companion_file_content)) { 
				//						echo "Shows Empty";
				if (file_exists($companion_edit_file)) {
					unlink($companion_edit_file); ?>
					<div class="updated fade"><p><strong>File Deleted!</strong></p></div>
				<?php }
			} else {
				//						echo "Shows having content.";
				$ok = false;
				if (($fh = @fopen($companion_edit_file, "w")) !== false) {
					if (fwrite($fh, $companion_file_content) !== false) {
						$ok = true;
					}
					fclose($fh);
				}
				if ($ok) { ?>
					<div class="updated fade"><p><strong>Saved</strong></p></div>
				<?php } else { ?>
					<div class="updated fade"><p><strong>Fail: Could'nt Save the file.</strong></p></div>
				<?php }
			}
		}
	}
	if (file_exists($companion_edit_file)) {
		$f = fopen($companion_edit_file, 'r');
		$companion_file_content = fread($f, filesize($companion_edit_file));
		$companion_file_content = htmlspecialchars($companion_file_content);
	} else {
		global $current_theme, $themes;
		if ($companion_edit_type == 'css') {
			$companion_file_content = "/* Companion Custom CSS over-rides for [ ".get_bloginfo('name')." ]: $current_theme - ".$themes[$current_theme]['Version']." */\r\n";
		} else {
			$companion_file_content = "<!-- Companion Custom HTML Insert for [ ".get_bloginfo('name')." ]: $current_theme - ".$themes[$current_theme]['Version']." -->\r\n";
		}
	}
	?>
	
	<div id="ccadmin">
		<div class="on" title="cceditor"><span>CSS Override Editor</span></div>
		<div class="off" title="ccexamples"><span>Examples</span></div>
		<div class="off" title="cchelp"><span>Help</span></div>
	</div>
	<div id="cceditor" class="show">
		<div class="inside">

		<form method="post" id="template" name="template" action="">
		<?php wp_nonce_field('update-options') ?>
		<table style="width: auto">
		<tr>
			<td valign="top">
			<label>
			<?php if (!$original) { ?>
				Now editing: <?php echo basename($companion_edit_file); ?><br />
			<?php } else { ?>
				Now Viewing: style.css<br />
			<?php } ?>
			 <?php

				if (!$original) {
					if ( $is_iis7 ) {
						if (win_is_writable($companion_edit_file)) {
							echo 'WIN: File exists and is writable.<br />';
						} else { 
							wp_mkdir_p(dirname($companion_edit_file));
							echo '<i>WIN: File '.basename($companion_edit_file).' does *not* exist or is not writable, try to save the file.  If you still get this error check permissions.</i><br />';
						}
					} else {
						if (is_writable($companion_edit_file)) {
							echo 'NIX: File Exists and is writable.<br />';
						} else { 
							wp_mkdir_p(dirname($companion_edit_file));
							echo '<i>NIX: File '.basename($companion_edit_file).' does *not* exist or is not writable, try to save the file.  If you still get this error check permissions.</i><br />';
						}
					}
	} else {
		echo 'Loading Original Style.CSS, it is NOT writable, you are to use the custom editor area to add changes that you want to make, and only changes.<br />';
	}
				$base = admin_url();
			  ?>
				[<a href="<?php echo $base; ?>themes.php?page=companion&amp;file=original">Show Original Style.CSS</a>] | [<a href="<?php echo $base; ?>themes.php?page=companion&amp;file=custom">Edit Custom Style</a>]
				<?php if (!companion_is_multisite() || is_super_admin()) { ?>
					| [<a href="<?php echo $base; ?>themes.php?page=companion&amp;file=head">Add HTML code to the &lt;head&gt; area</a>]<br />
				<?php } ?>
				<textarea class="codepress <?php echo $companion_edit_type; ?>" rows="25" style="width: 100%;"  name="newcontent" id="newcontent"><?php echo $companion_file_content; ?></textarea><br />
			<br />
			</label>
			</td>
		</tr>
		</table>
			<?php if (!$original) { ?>
				<input name="submit" type="submit" class="button-primary" value="Save Custom CSS Overrides" />
				<input type="hidden" name="action" value="companion_css_save" />
			<?php } ?>
		</form>
		</div>
	</div>
	<?php
		require_once('includes/ccexamples.php');
		require_once('includes/cchelp.php');
	?>
	<div style="float: left;">Theme Companion is made by <a href="http://frumph.net/">Philip M. Hofer (Frumph)</a>.
	</div>
	<div style="clear: both;"></div>
	</div>
	
	</div>
	
	</div>
	
	
	<?php
}

?>