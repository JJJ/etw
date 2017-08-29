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
define( 'ATOMIC_SL_THEME_VERSION', wp_get_theme( 'atomic' )->get( 'Version' ) );

// Loads the updater classes
$updater = new Array_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => esc_url( 'https://arraythemes.com' ),
		'item_name'      => __( 'Atomic WordPress Theme', 'atomic' ),
		'theme_slug'     => 'atomic',
		'version'        => ATOMIC_SL_THEME_VERSION,
		'author'         => __( 'Array', 'atomic' ),
		'download_id'    => '154841',
		'renew_url'      => ''
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Getting Started', 'atomic' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'atomic' ),
		'license-key'               => __( 'Enter your license key', 'atomic' ),
		'license-action'            => __( 'License Action', 'atomic' ),
		'deactivate-license'        => __( 'Deactivate License', 'atomic' ),
		'activate-license'          => __( 'Activate License', 'atomic' ),
		'save-license'              => __( 'Save License', 'atomic' ),
		'status-unknown'            => __( 'License status is unknown.', 'atomic' ),
		'renew'                     => __( 'Renew?', 'atomic' ),
		'unlimited'                 => __( 'unlimited', 'atomic' ),
		'license-key-is-active'     => __( 'Theme updates have been enabled. You will receive a notice on your Themes page when a theme update is available.', 'atomic' ),
		'expires%s'                 => __( 'Your license for Atomic expires %s.', 'atomic' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'atomic' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'atomic' ),
		'license-key-expired'       => __( 'License key has expired.', 'atomic' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'atomic' ),
		'license-is-inactive'       => __( 'License is inactive.', 'atomic' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'atomic' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'atomic' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'atomic' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'atomic' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'atomic' )
	)

);
