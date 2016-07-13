==== Advanced Text Widget ====
Contributors: Max Chirkov
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=JRA6WSKH3MSPG
Tags: text, php, plugin, widget, sidebar, conditions
Requires at least: 2.8
Tested up to: 4.3
Stable tag: 2.0.10

Text widget with raw PHP support and conditional visibility settings. Flexible conditional options with ability to edit and add custom conditions.

== Description ==
Advanced Text Widget is a text widget that allows you to execute raw PHP code and specify on which pages it should be displayed. It comes with 10 default visibility conditions. You can edit and/or add your own visibility conditions as well. Conditions support arguments which could be strings and/or arrays.

**Features:**

* 10 Default widget visibility conditions with over 20 application possibilities.
* Add unlimited custom conditions.
* “Advanced Text” widget with raw PHP support and shortcodes execution.

**PRO Version:**

* Apply visibility conditions to ANY widget.
* Add custom CSS IDs/Classes to ANY widget.
* Import/Export your visibility conditions to re-use on other sites.

[Check out PRO Version](http://simplerealtytheme.com/plugins/atw-pro/ "Advanced Text Widget PRO")

**Credits:**

* Author: Max Chirkov
* Author URI: [http://simplerealtytheme.com](http://SimpleRealtyTheme.com "Real Estate Themes for WordPress")
* Copyright: Released under GNU GENERAL PUBLIC LICENSE


== Installation ==

**Install like any other basic plugin:**

1.	Copy the advanced-text-widget folder to your /wp-content/plugins/ folder

2.	Activate the Advanced Text Widget on your plugin-page.

3.	Drag the Advanced Text Widget to your sidebar and add your own content including php code if needed. Optionally specify whether to display only on home, pages, posts, posts in category (-ies) or category archives. Specify even more if you like with slug/ID/title.

The plugins settings are located under Settings => ATW Plugin. From there you can edit/add visibility conditions as well as opt-out from applying conditions to all widgets.

**Notes:**

* *When selecting to show widget on **Home** page - it will show up on the Blog's index (main) page. If you have a static front page where you would like to show your widget, select the **Front page** option.*


== Changelog ==

= 2.0.10 =
- WP 4.3. compatibility update.

= 2.0.9 =
- WP 4.1. compatibility update.

= 2.0.8 =
- Added settings reset button.

= 2.0.7 =
- Fixed: default settings weren't getting imported on initial plugin activation.

= 2.0.6 =
- Added support for [embed] shortcodes.
- Updated deprecated functions usage and removed php notices.

= 2.0.5 =
- WP 3.9 compatibility update.

= 2.0.4 =
- Bug Fix: after plugin activation existing widgets had to be re-saved, otherwise they were displayed with default settings. No data loss there - just the output issue.

= 2.0.3 =
- Changed widget's content filter to atw_widget_content instead of the default widget_text.
- Bug Fix: atw shortcode filter wasn't using the right handle.

= 2.0.2 =
- Updated all get method operations with esc_attr() to improve security.

= 2.0.1 =
- Fix for possible security vulnerability.

== Upgrade Notice ==

= 2.0.3 =
Fixed a bug that prevented shortcode execution within Advanced Text widget.

= 2.0.2 =
Important security update. Upgrade immediately!
