=== Plugin Name ===
Contributors: thethemefoundry, dstrojny, jupiterwise, scottrrollo, tollmanz
Donate link: https://thethemefoundry.com
Tags: woocommerce, sidebars, widgets, customizer, fonts, typekit, demo content, page builder
Requires at least: 4.0
Tested up to: 4.3
Stable tag: 1.6.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Make Plus is a premium upgrade for the Make WordPress theme that adds more features and flexibility to the theme.

== Description ==

Make Plus provides additional features to the [Make WordPress theme](https://thethemefoundry.com/make/). Additional features include:

* Quick Start templates for importing pre-configured builder layouts to a page
* WooCommerce integration which adds a new builder section for highlighting products
* Widget areas in Text sections allows you to turn any text column into a widget area
* Typekit integration provides premium font choices to the customizer
* Per page/post options allows you to override global options on a per post/page basis

Make gives you the flexibility to build the site that you want. Make Plus makes this experience even better by giving you even more flexibility and great features.

== Installation ==

1. Download and activate the [Make WordPress theme](https://thethemefoundry.com/make/)
1. Upload the `make-plus` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

For more information, please see the [Make Plus support page](https://thethemefoundry.com/docs/make-docs/).

== Changelog ==

= 1.6.4 =

* New feature: Support for Yoast SEO's breadcrumb functionality.
  * Enhances the breadcrumb functionality in the Make theme.
  * Toggle breadcrumb visibility for individual posts and pages.
  * Add breadcrumb options for WooCommerce and Easy Digital Downloads.

= 1.6.3 =

* Improved: Typekit font kits are now loaded asynchronously.
* Improved: Better handling of localization:
  * Improved translator notes for some strings.
  * Ensure that all translated strings are escaped for security hardening.
  * Added some missing text domains.
* Changed: The 'From' dropdown for Posts Lists will now include empty taxonomy terms.
* Bug fix: Posts Lists displaying posts from a certain taxonomy term would revert to showing all posts if that term became empty.
* Bug fix: Custom section classes could not contain multiple consecutive dashes or underscores.

= 1.6.2 =

* Posts List section/widget improvements:
  * Aspect ratio options for post item featured images.
  * Customize the length (in words) of the post item excerpts.
  * Added 'read more' links to the end of excerpts.
  * The 'From' control now displays different taxonomy options depending on the chosen post type.
  * If the chosen post type is hierarchical (e.g. Pages), the 'From' control includes options to show the children of a specific page/post.
  * Better labeling/organization of section and widget controls.
* Improved: Allow Typekit ID setting default to be filtered like other theme setting defaults.
* Improved: Layout for controls in Posts List, Products, and Downloads Builder sections.
* Bug fix: Accordion panels were expanding upward beyond the viewport, forcing users to scroll back up to begin reading them from the top.
* Bug fix: Layout settings for sidebar were incorrectly displaying in WooCommerce shop pages (e.g. Cart and Checkout).

= 1.6.1.1 =

* Bug fix: Fatal error on front end when Make Plus is activated but Make is not current theme.

= 1.6.1 =

* New feature: Parallax background effect on all Builder sections that support a background image.
* New feature: Background image/color options for Posts List, Products, and Downloads Builder sections.
* Improved: Posts List stylesheet only loads when a Posts List section or widget is present on the page.
* Bug fix: Panels script enqueue function will no longer throw an error if a published Builder page has no sections.
* Bug fix: Easy Digital Downloads' "Insert Download" button now works correctly in the Builder UI.

= 1.6.0 =

* New feature: Panels section for the Builder. Display a group of panels as an accordion or a group of tabs.
* New feature: All Builder sections now have a configuration option for adding a custom HTML id attribute and custom HTML classes.
* Improved: Columns in the Columns section can now be resized to different grid configurations by dragging the edges.
* Bug fix: Column sizes will no longer get reset when the section configuration overlay is opened.
* Bug fix: Column widget areas now only show a link to the Customizer if the current user has proper permissions.
* Bug fix: Text domain loader now uses the correct file path.
* New filter: `ttfmp_post_list_query_args` modifies the query arguments for Posts Lists.
* Changed: Make Plus now only supports WordPress 4.0 and higher.

= 1.5.1 =

* Added per page settings to remove header and footer boundary padding.
* Added Page Builder section configuration option to remove space below a section.
* Updated Posts List, WooCommerce, and Easy Digital Downloads section UIs to move the title field to the Section Configuration panel.

= 1.5.0 =

* Updated Style Kits, White Label, and Typekit modules for compatibility with Make 1.5.0's new Customizer options.
* Updated properties of some existing Style Kits.
* Improved code performance and structure.
* Updated WooCommerce module for compatibility with WooCommerce 2.3.x.
* Removed color scheme support for WooCommerce 2.3.x shop elements in favor of the WooCommerce Colors plugin.
* Added Russian translation.

= 1.4.8 =

* Fixed problem with the updater. If you are having trouble updating through the WordPress interface, please follow these steps to update manually: https://thethemefoundry.com/tutorials/updating-your-existing-theme/

= 1.4.7 =

* Added new "Hello" style kit.
* Added "Default" style kit that sets style-related options back to theme defaults.
* Improved backend code for Style Kits functionality.

= 1.4.6 =

* Improved functionality for load/reset buttons in Style Kits.

= 1.4.5 =

* Fixed minor compatibility issues with WordPress 4.1.
* Added package info to plugin files.
* Updated documentation links.

= 1.4.4 =

* Improved workflow for adding widgets to Column widget areas.
* Fixed the plugin appearing as both a plugin and a theme when an update is available.
* Fixed an issue between the Customizer and the WooCommerce module in some hosting environments.

= 1.4.3 =

* Added "passive mode" to allow shortcodes to continue working when Make is no longer the active theme.

= 1.4.2 =

* Fixed layout issues with the Posts List section.

= 1.4.1 =

* Added the ability to edit and delete widget in page edit screen.

= 1.4.0 =

* Updated Page Builder components to complement Make 1.4.0 Page Builder interface refresh.

= 1.3.4 =

* Fixed bug where automatic updates functionality was missing in some cases

= 1.3.3 =

* Updated to support WordPress 4.0 and Make 1.3

= 1.3.2 =

* Fixed admin notice caused by using get_the_ID() when the post object was not available

= 1.3.1 =

* Fixed bug that caused multiple text sections with different column layouts to be implemented incorrectly
* Fixed bug with widget area overlays resting above admin menu submenus

= 1.3.0 =

* Added text column layout options (requires Make 1.2.0)
* Fixed 'left' and 'right' thumbnail position options in Posts List builder section
* Fixed slashes added to sidebar labels

= 1.2.6 =

* Added additional layout setting overrides
* Added "offset" parameter to Posts List builder section and widget
* Fixed fatal error for PHP 5.2 users

= 1.2.5 =

* Fixed issue that caused false update notices

= 1.2.4 =

* Fixed issue that caused Typekit fonts to disappear

= 1.2.3 =

* Fixed fatal error for PHP 5.2 users

= 1.2.2 =

* Fixed issue that caused a false update notification

= 1.2.1 =

* Added plugin updater
* Fixed issue with the "all e-commerce items" option showing only a single item

= 1.2.0 =

* Added Section Duplicator feature
* Added Posts List builder section and widget
* Improved Easy Digital Downloads integration
* Improved handling of title when importing Quick Start content
* Fixed issue that turned on comments when importing Quick Start content

= 1.1.1 =

* Fixed issue that allowed duplicate page action to show on post edit screen

= 1.1.0 =

* Added Page Duplicator feature
* Added photography template
* Added shop template
* Added Style Kits feature
* Added Easy Digital Downloads integration

= 1.0.2 =

* Fixed string handling issue that caused a broken Customizer
* Fixed a broken link to documentation
* Updated plugin metadata

= 1.0.1 =

* Improved handling of $post object when filtering view values
* Fixed bug with hiding Quick Start interface when sections are removed
* Fixed bug with getting sidebars returning a non-array value
* Fixed broken link in readme.txt
* Added color enhancements for WooCommerce

= 1.0.0 =

* Initial release

== Upgrade Notice ==

= 1.6.4 =

Enhanced support for Yoast SEO's breadcrumb functionality.