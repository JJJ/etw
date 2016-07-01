<?php

/**
 * Plugin name: Flox - Mute Updates
 * Description: Prevent WordPress from checking for core, theme, and plugin updates
 * Author:      The Flox Team
 * Author URI:  https://flox.io
 * Version:     0.0.1
 */

/**
 * Unhook update and maintenance nags from admin notices
 *
 * @author jjj
 */
function flox_mute_updates() {

	// Remove update nags
	remove_action( 'admin_notices',         'update_nag', 3 );
	remove_action( 'network_admin_notices', 'update_nag', 3 );

	// Remove maintenance nags
	remove_action( 'admin_notices',         'maintenance_nag' );
	remove_action( 'network_admin_notices', 'maintenance_nag' );

	// Remove core update version checks
	remove_action( 'wp_version_check', 'wp_version_check' );

	// No checks for themes
	remove_action( 'load-themes.php',      'wp_update_themes' );
	remove_action( 'load-update.php',      'wp_update_themes' );
	remove_action( 'load-update-core.php', 'wp_update_themes' );
	remove_action( 'wp_update_themes',     'wp_update_themes' );

	// No checks for plugins
	remove_action( 'load-plugins.php',     'wp_update_plugins' );
	remove_action( 'load-update.php',      'wp_update_plugins' );
	remove_action( 'load-update-core.php', 'wp_update_plugins' );
	remove_action( 'wp_update_plugins',    'wp_update_plugins' );

	// Remove upgrade completion checks
	remove_action( 'upgrader_process_complete', 'wp_version_check',  10, 0 );
	remove_action( 'upgrader_process_complete', 'wp_update_themes',  10, 0 );
	remove_action( 'upgrader_process_complete', 'wp_update_plugins', 10, 0 );

	// Maybe-not update themes or plugins
	remove_action( 'admin_init', '_maybe_update_core'    );
	remove_action( 'admin_init', '_maybe_update_themes'  );
	remove_action( 'admin_init', '_maybe_update_plugins' );

	// Remove the core updater text
	remove_filter( 'update_footer', 'core_update_footer' );
}
add_action( 'admin_init', 'flox_mute_updates', 2 );

/**
 * Disable WordPress core update version check
 *
 * @author jjj
 */
function flox_no_version_check() {

	// Init
	remove_action( 'init', 'wp_version_check'          );
	remove_action( 'init', 'wp_schedule_update_checks' );

	// Cron
	remove_action( 'wp_maybe_auto_update', 'wp_maybe_auto_update' );
}
add_action( 'init', 'flox_no_version_check', 2 );

/**
 * Do not allow plugin, theme, or core updates at the user capability level.
 *
 * This will globally prevent checks and UI nags through-out the interface for
 * all users.
 *
 * @author jjj
 *
 * @param  array  $caps
 * @param  string $cap
 * @return array
 */
function flox_do_not_allow_updates( $caps = array(), $cap = '' ) {
	switch ( $cap ) {
		case 'update_plugins':
		case 'delete_plugins':
		case 'install_plugins':
		case 'upload_plugins':
		case 'update_themes':
		case 'delete_themes':
		case 'install_themes':
		case 'upload_themes':
		case 'update_core':
			$caps = array( 'do_not_allow' );
	}
	return $caps;
}
add_filter( 'map_meta_cap', 'flox_do_not_allow_updates', 10, 2 );

// Noop core update transients and options
add_filter( 'pre_option_update_core',         '__return_null' );
add_filter( 'pre_transient_update_core',      '__return_null' );
add_filter( 'pre_site_transient_update_core', '__return_null' );
