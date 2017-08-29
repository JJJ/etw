<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package EDD Sample Theme
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'Array_Theme_Updater_Admin' ) ) {
	include( get_template_directory() . '/includes/admin/updater/theme-updater-admin.php' );
}

// The theme version to use in the updater
define( 'NORTH_SL_THEME_VERSION', wp_get_theme( 'north' )->get( 'Version' ) );

// Loads the updater classes
$updater = new Array_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => esc_url( 'https://arraythemes.com' ),
		'item_name'      => __( 'North WordPress Theme', 'north' ),
		'theme_slug'     => 'north',
		'version'        => NORTH_SL_THEME_VERSION,
		'author'         => __( 'Array', 'north' ),
		'download_id'    => '2007',
		'renew_url'      => ''
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Getting Started', 'north' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'north' ),
		'license-key'               => __( 'Enter your license key', 'north' ),
		'license-action'            => __( 'License Action', 'north' ),
		'deactivate-license'        => __( 'Deactivate License', 'north' ),
		'activate-license'          => __( 'Activate License', 'north' ),
		'save-license'              => __( 'Save License', 'north' ),
		'status-unknown'            => __( 'License status is unknown.', 'north' ),
		'renew'                     => __( 'Renew?', 'north' ),
		'unlimited'                 => __( 'unlimited', 'north' ),
		'license-key-is-active'     => __( 'Theme updates have been enabled. You will receive a notice on your Themes page when a theme update is available.', 'north' ),
		'expires%s'                 => __( 'Your license for North expires %s.', 'north' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'north' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'north' ),
		'license-key-expired'       => __( 'License key has expired.', 'north' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'north' ),
		'license-is-inactive'       => __( 'License is inactive.', 'north' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'north' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'north' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'north' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'north' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'north' )
	)

);
