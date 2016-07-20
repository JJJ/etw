# Genesis Framework Change Log

http://my.studiopress.com/themes/genesis/

This project does not follow semantic versioning. It follows the WordPress policy where updates of _x_ and _y_ in an _x.y.z_ version number means a major release, and updates to _z_ means a patch release.

## [2.3.0] - 2016-06-15

* Allow custom post classes on Ajax requests to account for endless scroll.
* Remove the top buttons (save and reset) from Genesis admin classes.
* Remove right float on admin buttons (settings screens, etc.).
* Change "Save Settings" to "Save Changes", as WordPress core does.
* Use version constant rather than database setting for reporting theme version in Settings.
* Use sfHover for superfish hover state.
* Apply identifying class to entry image link.
* Prevent empty footer widgets markup.
* Prevent empty spaces in entry footer of CPTs.
* Trim filtered value of entry meta.
* Add a toolbar link to edit CPT archive settings.
* Add filter for the viewport meta tag value.
* Add shortcodes for site title and home link.
* Update and simplify favicon markup for the modern web.
* Prevent author shortcode from outputting empty markup when no author is assigned.
* Disable author box on entries where post type doesn't support author.
* Change the label on the update setting to reflect what it actually does, check for updates.
* Add filters for Genesis default theme support items.
* Update theme tags.
* Enable after entry widget area for all post types via post type support.
* Hide layout selector when only one layout is supported.
* Disable author shortcode output if author is not supported by post type.
* Improve image size retreival function and usage.
* Add ability to specify post ID when using genesis_custom_field().
* Update to normalize.css 4.1.1
* Add admin notice when Genesis is activated directly.
* Removed unnecessary warning from theme description in style.css.
* Use TinyMCE for archive intro text input.
* Allow foreign language characters in content limit functions.
* Pass entry image link through markup API.
* Add a11y to the paginaged post navigation.
* Allow adjacent single entry navigation via post type support.
* Fix issue with no sitemap when running html5 and no a11y support for 404 page.
* Added relative_depth parameter to date shortcodes.
* Exclude posts page from page selection dropdown in Featured Page widget.


## [2.2.7] - 2016-03-04

* Fix issue with multisite installs where Genesis could technically upgrade before WordPress.
* Fix issue with Genesis using old style term meta method in some places.
* Remove Scribe nag.
* Limit entry class filters to the front end.

[Unreleased]: https://github.com/copyblogger/genesis/compare/2.2.7...HEAD
[2.2.7]: https://github.com/copyblogger/genesis/compare/2.2.6...2.2.7
