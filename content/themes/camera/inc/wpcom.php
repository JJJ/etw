<?php
/**
 * WordPress.com-specific functions and definitions.
 *
 * This file is centrally included from `wp-content/mu-plugins/wpcom-theme-compat.php`.
 *
 * @package Camera
 */

/**
 * Adds support for wp.com-specific theme functions.
 *
 * @global array $themecolors
 */
function camera_wpcom_setup() {
	global $themecolors;

	// Set theme colors for third party services.
	if ( ! isset( $themecolors ) ) {
		$themecolors = array(
			'bg'     => 'FFFFFF',
			'border' => '55626D',
			'text'   => '55626D',
			'link'   => '3EB6E4',
			'url'    => '3EB6E4',
		);
	}
}
add_action( 'after_setup_theme', 'camera_wpcom_setup' );