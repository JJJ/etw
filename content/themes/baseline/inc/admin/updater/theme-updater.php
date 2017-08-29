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
define( 'BASELINE_SL_THEME_VERSION', wp_get_theme( 'baseline' )->get( 'Version' ) );

// Loads the updater classes
$updater = new Array_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => esc_url( 'https://arraythemes.com' ),
		'item_name'      => __( 'Baseline WordPress Theme', 'baseline' ),
		'theme_slug'     => 'baseline',
		'version'        => BASELINE_SL_THEME_VERSION,
		'author'         => __( 'Array', 'baseline' ),
		'download_id'    => '106055',
		'renew_url'      => ''
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Getting Started', 'baseline' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'baseline' ),
		'license-key'               => __( 'Enter your license key', 'baseline' ),
		'license-action'            => __( 'License Action', 'baseline' ),
		'deactivate-license'        => __( 'Deactivate License', 'baseline' ),
		'activate-license'          => __( 'Activate License', 'baseline' ),
		'save-license'              => __( 'Save License', 'baseline' ),
		'status-unknown'            => __( 'License status is unknown.', 'baseline' ),
		'renew'                     => __( 'Renew?', 'baseline' ),
		'unlimited'                 => __( 'unlimited', 'baseline' ),
		'license-key-is-active'     => __( 'Theme updates have been enabled. You will receive a notice on your Themes page when a theme update is available.', 'baseline' ),
		'expires%s'                 => __( 'Your license for Baseline expires %s.', 'baseline' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'baseline' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'baseline' ),
		'license-key-expired'       => __( 'License key has expired.', 'baseline' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'baseline' ),
		'license-is-inactive'       => __( 'License is inactive.', 'baseline' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'baseline' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'baseline' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'baseline' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'baseline' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'baseline' )
	)

);