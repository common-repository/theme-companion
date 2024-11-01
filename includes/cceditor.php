
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
					if (win_is_writable($companion_edit_file)) { ?>
						File exists and is writable.<br />
					<?php } else { 
						wp_mkdir_p(dirname($companion_edit_file)); ?>
						File Does *not* exist or is not writable, try to save the file.  If you still get this error check permissions.<br />
					<?php }
				} else {
					if (is_writable($companion_edit_file)) { ?>
						File Exists and is writable.<br />
					<?php } else { 
						wp_mkdir_p(dirname($companion_edit_file)); ?>
						File Does *not* exist or is not writable, try to save the file.  If you still get this error check permissions.<br />
						Loading information from Original.
					<?php }
				}
			}
			$base = admin_url();
		  ?>
			[<a href="<?php echo $base; ?>themes.php?page=companion&amp;file=original">Show Original Style.CSS</a>] | [<a href="<?php echo $base; ?>themes.php?page=companion&amp;file=custom">Edit Custom Style</a>]
			<?php global $wpmu_version; if (!$wpmu_version) { ?>
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
