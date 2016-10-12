<?php

/**
 * Flox Stats Admin
 *
 * @package Plugins/Flox/Stats/Admin
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Register settings
 *
 * @since 0.1.0
 */
function wp_flox_stats_register_settings() {

	// Setting
	register_setting(
		'general',
		'wp_flox_stats_site_id',
		'wp_flox_stats_site_id_validate'
	);

	// Field
	add_settings_field(
		'wp_flox_stats_site_id',
		esc_html__( 'Stats ID', 'wp-flox-stats' ),
		'wp_flox_stats_site_id_settings_field',
		'general',
		'default'
	);
}

/**
 * Make sure the site ID being saved is an integer
 *
 * @since 0.1.0
 *
 * @param  int $value
 * @return int
 */
function wp_flox_stats_site_id_validate( $value = '' ) {
	return (int) $value;
}

/**
 * Output the field used for setting the site ID
 *
 * @since 0.1.0
 */
function wp_flox_stats_site_id_settings_field() {
?>

	<input id="wp_flox_stats_site_id" type="number" value="<?php echo wp_flox_stats_get_site_id(); ?>" name="wp_flox_stats_site_id" />

<?php
}
