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
define( 'TYPABLE_SL_THEME_VERSION', wp_get_theme( 'typable' )->get( 'Version' ) );

// Loads the updater classes
$updater = new Array_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'https://arraythemes.com', // Site where EDD is hosted
		'item_name'      => 'Typable WordPress Theme', // Name of theme
		'theme_slug'     => 'typable', // Theme slug
		'version'        => TYPABLE_SL_THEME_VERSION, // The current version of this theme
		'author'         => 'Array', // The author of this theme
		'download_id'    => '3125', // Optional, used for generating a license renewal link
		'renew_url'      => '' // Optional, allows for a custom license renewal link
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Getting Started', 'typable' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'typable' ),
		'license-key'               => __( 'Enter your license key', 'typable' ),
		'license-action'            => __( 'License Action', 'typable' ),
		'deactivate-license'        => __( 'Deactivate License', 'typable' ),
		'activate-license'          => __( 'Activate License', 'typable' ),
		'save-license'              => __( 'Save License', 'typable' ),
		'status-unknown'            => __( 'License status is unknown.', 'typable' ),
		'renew'                     => __( 'Renew?', 'typable' ),
		'unlimited'                 => __( 'unlimited', 'typable' ),
		'license-key-is-active'     => __( 'Theme updates have been enabled. You will receive a notice on your Themes page when a theme update is available.', 'typable' ),
		'expires%s'                 => __( 'Your license for Typable expires %s.', 'typable' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'typable' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'typable' ),
		'license-key-expired'       => __( 'License key has expired.', 'typable' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'typable' ),
		'license-is-inactive'       => __( 'License is inactive.', 'typable' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'typable' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'typable' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'typable' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'typable' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'typable' )
	)

);