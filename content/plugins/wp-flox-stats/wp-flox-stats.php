<?php

/**
 * Plugin Name: Flox Stats
 * Plugin URI:  https://wordpress.org/plugins/wp-flox-stats/
 * Author:      John James Jacoby
 * Author URI:  https://profiles.wordpress.org/johnjamesjacoby/
 * Description: Connect to Flox's analytics & tracking
 * Version:     0.1.0
 * Text Domain: wp-flox-stats
 * Domain Path: /assets/lang/
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Include the Flox Stats files
 *
 * @since 0.1.0
 */
function _wp_flox_stats() {

	// Only include on site & network admin
	if ( ! is_admin() || is_user_admin() ) {
		return;
	}

	// Get the plugin path
	$plugin_path = plugin_dir_path( __FILE__ ) . 'wp-flox-stats/';

	// Pull in required files
	require_once $plugin_path . 'includes/admin.php';
	require_once $plugin_path . 'includes/functions.php';
	require_once $plugin_path . 'includes/hooks.php';
}
add_action( 'plugins_loaded', '_wp_flox_stats' );

/**
 * Return the plugin's URL
 *
 * @since 0.1.0
 *
 * @return string
 */
function wp_flox_stats_get_plugin_url() {
	return plugin_dir_url( __FILE__ );
}

/**
 * Return the asset version
 *
 * @since 0.1.0
 *
 * @return int
 */
function wp_flox_stats_get_asset_version() {
	return 201610120001;
}
