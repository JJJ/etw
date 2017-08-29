<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package EDD Sample Theme
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'Array_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

// The theme version to use in the updater
define( 'CANDID_SL_THEME_VERSION', wp_get_theme( 'candid' )->get( 'Version' ) );

// Loads the updater classes
$updater = new Array_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'https://arraythemes.com', // Site where EDD is hosted
		'item_name'      => 'Candid WordPress Theme', // Name of theme
		'theme_slug'     => 'candid', // Theme slug
		'version'        => CANDID_SL_THEME_VERSION, // The current version of this theme
		'author'         => 'Array', // The author of this theme
		'download_id'    => '90834', // Optional, used for generating a license renewal link
		'renew_url'      => '' // Optional, allows for a custom license renewal link
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Getting Started', 'candid' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'candid' ),
		'license-key'               => __( 'Enter your license key', 'candid' ),
		'license-action'            => __( 'License Action', 'candid' ),
		'deactivate-license'        => __( 'Deactivate License', 'candid' ),
		'activate-license'          => __( 'Activate License', 'candid' ),
		'save-license'              => __( 'Save License', 'candid' ),
		'status-unknown'            => __( 'License status is unknown.', 'candid' ),
		'renew'                     => __( 'Renew?', 'candid' ),
		'unlimited'                 => __( 'unlimited', 'candid' ),
		'license-key-is-active'     => __( 'Typekit fonts and in-dash theme updates have been enabled. You will receive a notice in your dashboard when a theme update is available.', 'candid' ),
		'expires%s'                 => __( 'Your license for Candid expires %s.', 'candid' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'candid' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'candid' ),
		'license-key-expired'       => __( 'License key has expired.', 'candid' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'candid' ),
		'license-is-inactive'       => __( 'License is inactive.', 'candid' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'candid' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'candid' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'candid' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'candid' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'candid' )
	)

);