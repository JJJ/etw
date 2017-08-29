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
define( 'TRANSMIT_SL_THEME_VERSION', wp_get_theme( 'transmit' )->get( 'Version' ) );

// Loads the updater classes
$updater = new Array_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'https://arraythemes.com', // Site where EDD is hosted
		'item_name'      => 'Transmit WordPress Theme', // Name of theme
		'theme_slug'     => 'transmit', // Theme slug
		'version'        => TRANSMIT_SL_THEME_VERSION, // The current version of this theme
		'author'         => 'Array', // The author of this theme
		'download_id'    => '9380', // Optional, used for generating a license renewal link
		'renew_url'      => '' // Optional, allows for a custom license renewal link
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Getting Started', 'transmit' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'transmit' ),
		'license-key'               => __( 'Enter your license key', 'transmit' ),
		'license-action'            => __( 'License Action', 'transmit' ),
		'deactivate-license'        => __( 'Deactivate License', 'transmit' ),
		'activate-license'          => __( 'Activate License', 'transmit' ),
		'save-license'              => __( 'Save License', 'transmit' ),
		'status-unknown'            => __( 'License status is unknown.', 'transmit' ),
		'renew'                     => __( 'Renew?', 'transmit' ),
		'unlimited'                 => __( 'unlimited', 'transmit' ),
		'license-key-is-active'     => __( 'Theme updates have been enabled. You will receive a notice on your Themes page when a theme update is available.', 'transmit' ),
		'expires%s'                 => __( 'Your license for Transmit expires %s.', 'transmit' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'transmit' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'transmit' ),
		'license-key-expired'       => __( 'License key has expired.', 'transmit' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'transmit' ),
		'license-is-inactive'       => __( 'License is inactive.', 'transmit' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'transmit' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'transmit' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'transmit' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'transmit' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'transmit' )
	)

);