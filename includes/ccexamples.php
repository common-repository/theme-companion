
<div id="ccexamples" class="hide">
	<div class="inside">
	<table class="form-table" style="width: auto">	
	<tr>

		<th scope="row"><strong>Modify anything related to design using CSS.</strong><br />
		<br />
		<span style="color: #ed1f24">Avoid modifying the original theme files and use this area instead to preserve changes.</span><br />
		<br />
		HINT: View the style.css file and find elements to change and put them here.<br />
		<br />
		</th>
		<td valign="top">
			<p><em style="color: #5db408">/* Change the background. */</em><br />body { background: #ccc; }</p>
			<p><em style="color: #5db408">/* Add a dotted line under the post. */</em><br />.post { border-bottom: dotted #ddd; }</p>
			<p><em style="color: #5db408">/* change the background of the author of the posts comments */</em><br />.bypostauthor { background: #fdfdf4; }</p>
			<p><em style="color: #5db408">/* Add Image to Header AND make it clickable back to home - adjust height width and location of image*/</em><br />
#header {width: 980px; height: 120px; background: url('/images/header.png') top center no-repeat; overflow: hidden;}<br />
#header h1 {padding: 0;}<br />
#header h1 a {display: block; width: 980px; height: 120px; text-indent: -9999px;}<br />
#header .description {display: none;}<br />
</p>
			<p><em style="color: #5db408">/* Hide the Text in the header. */</em><br />#header h1 a, #header .description { display: none; }</p>				
			<p><em style="color: #5db408">/* Rounded Corners (not in IE) */</em><br /></p>
			<p>
			.narrowcolumn {<br />
			-moz-border-radius: 10px;<br />
			-khtml-border-radius: 10px;<br />
			-webkit-border-radius: 10px;<br />
			border-radius: 10px;<br />
			}
			</p>
			<p>
			<em style="color: #5db408">/* make the html page not wobble when reloading to a new page. */</em><br />
			html { overflow-y: scroll; } <br />
			</p>
		</td>
	</tr>
	</table>
	</div>
</div>
