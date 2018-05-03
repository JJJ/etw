<?php
/**
 * Cornerstone is quite akin to X Shortcodes (legacy plugin)
 * For seamless compatibility until X Shortcodes is delteted,
 * we're "hotswapping the boot process", preventing X Shortcodes
 * functionality from loading.
 *
 * For exisiting sites, we alias old X Shortcode names to Cornerstone
 */

class Cornerstone_Integration_X_Shortcodes {

	/**
	 * Each integration class should provide a shouldLoad static method
	 * This allows the integration loader to determine whether or not
	 * to instantiate the integration
	 * @return bool
	 */
	public static function should_load() {
		return defined( 'X_SHORTCODES_VERSION' );
	}

	public function __construct() {
		include_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		deactivate_plugins( array( 'x-shortcodes/x-shortcodes.php' ) );
		remove_action( 'init', 'x_shortcodes_init' );
		Cornerstone_Admin_Notice::updated( csi18n('admin.x-shortcodes-notice'), true );
	}

}
