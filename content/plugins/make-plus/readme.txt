=== Make Plus ===

Contributors: thethemefoundry, dstrojny, coreymckrill4ttf, scottrrollo, tollmanz
Donate link: https://thethemefoundry.com
Tags: woocommerce, sidebars, widgets, customizer, fonts, typekit, demo content, page builder
Requires at least: 4.4
Tested up to: 4.5.3
Stable tag: 1.7.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Make Plus is a premium upgrade for the Make WordPress theme that adds more features and flexibility to the theme.

== Description ==

Make Plus provides additional features to the [Make WordPress theme](https://thethemefoundry.com/make/). Additional features include:

* WooCommerce integration which adds a new builder section for highlighting products
* Widget areas in Text sections allows you to turn any text column into a widget area
* Typekit integration provides premium font choices to the customizer
* Per page/post options allows you to override global options on a per post/page basis

Make gives you the flexibility to build the site that you want. Make Plus makes this experience even better by giving you even more flexibility and great features.

== Installation ==

1. Download and activate the [Make WordPress theme](https://thethemefoundry.com/make/)
1. Upload the `make-plus` folder to the `wp-content/plugins` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

For more information, please see the [Make Plus support page](https://thethemefoundry.com/make-help/).

== Changelog ==

= 1.7.4 - June 22 2016 =
* Bug fix: Some typography styles in Columns section widget areas were not updating correctly with settings changes.
* Bug fix: The Section ID and Section Classes fields were not copied correctly on section duplication.
* Bug fix: Some add/edit post screens showed a Layout Settings box with an error in it.

= 1.7.3 - June 7 2016 =
* Changed: Make Plus now only supports WordPress 4.4 and higher.
* Improved: When an anchor link is clicked, window will now scroll so target is below the Sticky Header instead of beneath it.
* Bug fix: A duplicate header was visible beneath the Sticky Header when the background color was semi-transparent.
* Bug fix: Typekit kit validator was causing a fatal error in some situations.

= 1.7.2 - May 24 2016 =
* Improved: Query efficiency for the Products and Posts Lists sections on Builder pages.
* Changed: Wording changes in various parts of the UI.

= 1.7.1 - May 11 2016 =
* New filter: `makeplus_woocommerce_product_grid_image_size` allows modification of image size in Products section.
* Bug fix: Content in Panels sections was having paragraph tags stripped if content editor was in Text mode.
* Bug fix: Sticky header was triggering a Make Notice in some cases.
* Changed: A dismissable admin notice now appears if Make Plus has not been authorized for the current site.

= 1.7.0 - May 4 2016 =
* Changed: Big under-the-hood changes to the code for improved efficiency and maintainability. Many functions and hooks have been deprecated.
  * See the beta announcement for a complete list: https://thethemefoundry.com/blog/make-1-7-beta-1/
* New feature: Setting to make the Site Header sticky. Can either be the entire header or just the Header Bar.
* Improved: Overhaul of interface for loading Typekit font kits.
* Improved: Cleaner UI for post and page layout settings.
* Changed: Style Kits in the Customizer and Quick Start templates in the Builder have been removed.
* Changed: Added a notice that Make Plus will soon drop support for WP 4.2 and 4.3.

= 1.6.6 =
* New filter: `ttfmp_post_list_post_title_element` modifies the wrapper element for titles in Posts List items.
* Bug fix: Not all necessary weights were included in the Google font URL in some situations.
* Bug fix: "Ghost" widget areas were occasionally appearing on the Widgets screen after their associated Columns section had been deleted.
* Bug fix: Choosing a Quick Start template on a blank page that was already published caused the page to be duplicated.
* Bug fix: Incorrect button styles on individual columns that were converted to widget areas.
* Updated: new Dutch translation.
* Changed: Make Plus now only supports WordPress 4.2 and higher.

= 1.6.5 =
* New feature: Numeric font weight control for typography options in the Customizer.
  * Replaces the standard normal/bold font weight options in Make.
  * Available font weight options are determined by the chosen font family and font style options.
  * Works with Google fonts and Typekit fonts.
* Bug fix: Incorrect Typekit font family options were displayed if a kit ID was loaded but not saved.
* Bug fix: The default kit ID value was sometimes being ignored if it was changed by a child theme.
* Bug fix: Tab headers in the Panels section were styled with the wrong text color when in focus.
* Changed: Added an admin notice that Make Plus will soon drop support for WP 4.0 and 4.1.

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

= 1.7.4 =
Bug fixes.

= 1.7.0 =
Big under-the-hood changes to the code for improved efficiency and maintainability. Many functions and hooks have been deprecated.
See the beta announcement for a complete list: https://thethemefoundry.com/blog/make-1-7-beta-1/
