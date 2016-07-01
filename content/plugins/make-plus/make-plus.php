<?php
/**
 * @package Make Plus
 */

/**
 * Plugin Name: Make Plus
 * Plugin URI:  https://thethemefoundry.com/make/
 * Description: A powerful paid companion plugin for the Make WordPress theme.
 * Author:      The Theme Foundry
 * Version:     1.7.4
 * Author URI:  https://thethemefoundry.com
 */

/**
 * The current version of the plugin.
 */
define( 'MAKEPLUS_VERSION', '1.7.4' );

/**
 * The minimum version of WordPress required for the plugin.
 */
define( 'MAKEPLUS_MIN_WP_VERSION', '4.4' );

/**
 * Get the path to the Make Plus directory. Includes trailing slash.
 *
 * @since 1.7.0.
 *
 * @param bool $relative    Set to true to return Make Plus's path relative to the plugins directory.
 *
 * @return string           Absolute or relative path to Make Plus.
 */
function makeplus_get_plugin_directory( $relative = false ) {
	if ( $relative ) {
		return trailingslashit( dirname( plugin_basename( __FILE__ ) ) );
	}

	return plugin_dir_path( __FILE__ );
}

/**
 * Get the URL to the Make Plus directory. Includes trailing slash.
 *
 * @since 1.7.0.
 *
 * @return string
 */
function makeplus_get_plugin_directory_uri() {
	return plugin_dir_url( __FILE__ );
}

// Autoloader
require_once makeplus_get_plugin_directory() . 'autoload.php';

/**
 * Kick things off.
 *
 * @since 1.7.0.
 *
 * @hooked action plugins_loaded
 *
 * @return void
 */
function makeplus_initialize_plugin() {
	global $MakePlus;
	$MakePlus = new MAKEPLUS_API;
	$MakePlus->hook();

	/**
	 * Action: Fire when the Make Plus API has finished loading.
	 *
	 * @since 1.7.0.
	 *
	 * @param MAKEPLUS_API $MakePlus
	 */
	do_action( 'makeplus_api_loaded', $MakePlus );

	// Load the updater
	$updater_file = makeplus_get_plugin_directory() . 'updater/updater.php';
	if ( is_readable( $updater_file ) ) {
		require_once $updater_file;

		// Set the updater values
		add_filter( 'ttf_updater_config', 'makeplus_updater_config' );
	}
}

add_action( 'plugins_loaded', 'makeplus_initialize_plugin' );

/**
 * Register values for the updater.
 *
 * @since 1.3.0.
 *
 * @hooked filter ttf_updater_config
 *
 * @return array           Modified updater values.
 */
function makeplus_updater_config() {
	return array(
		'slug'            => 'make-plus',
		'type'            => 'plugin',
		'file'            => plugin_basename( __FILE__ ),
		'current_version' => MAKEPLUS_VERSION,
	);
}

/**
 * Get the global Make Plus API object.
 *
 * @since 1.7.0.
 *
 * @return MAKEPLUS_API|null
 */
function MakePlus() {
	global $MakePlus;

	if ( ! did_action( 'makeplus_api_loaded' ) || ! $MakePlus instanceof MAKEPLUS_APIInterface ) {
		trigger_error(
			__( 'The MakePlus() function should not be called before the makeplus_api_loaded action has fired.', 'make-plus' ),
			E_USER_WARNING
		);
		return null;
	}

	return $MakePlus;
}