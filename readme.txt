=== Theme Companion ===
Contributors: Frumph
Tags: css, editor, plugin, multisite, theme, companion
Requires at least: 3.0
Tested up to: 4.0
Stable tag: 1.0.2
Donate link: http://frumph.net/

This plugin is used to assist in designing sites without editing the original style.css

== Description ==

Companion is intended to assist users designing their sites without editing their original style.css files.

Companion's features include:

* Editing CSS stylesheets that override the original style.css in the theme.
* Add custom information into the head area of your site/page for non-wpmu sites. - Does NOT activate for Multisite
  
= Please do *not* copy the entire style.css into the editor, the editor is used for placing specific element changes. If you want to change the background of your entire site you do =

body { background: #333333; }

#333333 being swapped for the color that you want to use.  
Notice that you do *not* need to replace the entire CSS element but just the portion you want to override / change.

== Changelog == 
= 1.0.2 =
Fixed plugin path

= 1.0.1 =
Update to readme.txt

= 1.0 =
Re-Release


== Installation ==

1. Upload the `theme-companion` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to Appearance -> Companion to start using the Companion.
1. Add CSS code that overrides your current style.css, add only the changed elements.

== Frequently Asked Questions ==

= My change isn't being seen on the site =

Some CSS might need the !important flag on it, depends what order this plugin get's executed - before or after other CSS that is made on the site.

= The edit screen keeps saying that the file does not exist or the directory is not writeable even after I click save. =

Check the permissions on the plugin directory theme-companion/custom - For more information on this, contact your Webhost.  If you are
running WPMU make sure that the blogs.dir for the current blog's /files directory has the proper permissions as well (again as your webhost).

= I'm having another problem. =

If it's a serious problem, such as WordPress becoming non-functional or blank screens/errors after you perform certain operations, you will be asked to provide error logs for your server.  If you don't know how to get access to these, talk with your Webhost.  At that time just remove the plugin from the plugins/ directory.  If it still
continue's it is probably not a Theme Companion problem.

== License ==

Companion is released under the GNU GPL version 3.0 or later.

