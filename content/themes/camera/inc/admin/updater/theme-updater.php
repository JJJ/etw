<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package EDD Sample Theme
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'Array_Theme_Updater_Admin' ) ) {
	include( get_template_directory() . '/inc/admin/updater/theme-updater-admin.php' );
}

// The theme version to use in the updater
define( 'CAMERA_SL_THEME_VERSION', wp_get_theme( 'camera' )->get( 'Version' ) );

// Loads the updater classes
$updater = new Array_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => esc_url( 'https://arraythemes.com' ),
		'item_name'      => __( 'Camera WordPress Theme', 'camera' ),
		'theme_slug'     => 'camera',
		'version'        => CAMERA_SL_THEME_VERSION,
		'author'         => __( 'Array', 'camera' ),
		'download_id'    => '75699',
		'renew_url'      => ''
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Getting Started', 'camera' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'camera' ),
		'license-key'               => __( 'Enter your license key', 'camera' ),
		'license-action'            => __( 'License Action', 'camera' ),
		'deactivate-license'        => __( 'Deactivate License', 'camera' ),
		'activate-license'          => __( 'Activate License', 'camera' ),
		'save-license'              => __( 'Save License', 'camera' ),
		'status-unknown'            => __( 'License status is unknown.', 'camera' ),
		'renew'                     => __( 'Renew?', 'camera' ),
		'unlimited'                 => __( 'unlimited', 'camera' ),
		'license-key-is-active'     => __( 'Theme updates have been enabled. You will receive a notice on your Themes page when a theme update is available.', 'camera' ),
		'expires%s'                 => __( 'Your license for Camera expires %s.', 'camera' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'camera' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'camera' ),
		'license-key-expired'       => __( 'License key has expired.', 'camera' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'camera' ),
		'license-is-inactive'       => __( 'License is inactive.', 'camera' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'camera' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'camera' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'camera' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'camera' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'camera' )
	)

);
