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
define( 'AUTHOR_SL_THEME_VERSION', wp_get_theme( 'author' )->get( 'Version' ) );

// Loads the updater classes
$updater = new Array_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'https://arraythemes.com', // Site where EDD is hosted
		'item_name'      => 'Author WordPress Theme', // Name of theme
		'theme_slug'     => 'author', // Theme slug
		'version'        => AUTHOR_SL_THEME_VERSION, // The current version of this theme
		'author'         => 'Array', // The author of this theme
		'download_id'    => '1995', // Optional, used for generating a license renewal link
		'renew_url'      => '' // Optional, allows for a custom license renewal link
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Getting Started', 'author' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'author' ),
		'license-key'               => __( 'Enter your license key', 'author' ),
		'license-action'            => __( 'License Action', 'author' ),
		'deactivate-license'        => __( 'Deactivate License', 'author' ),
		'activate-license'          => __( 'Activate License', 'author' ),
		'save-license'              => __( 'Save License', 'author' ),
		'status-unknown'            => __( 'License status is unknown.', 'author' ),
		'renew'                     => __( 'Renew?', 'author' ),
		'unlimited'                 => __( 'unlimited', 'author' ),
		'license-key-is-active'     => __( 'Theme updates have been enabled. You will receive a notice on your Themes page when a theme update is available.', 'author' ),
		'expires%s'                 => __( 'Your license for Author expires %s.', 'author' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'author' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'author' ),
		'license-key-expired'       => __( 'License key has expired.', 'author' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'author' ),
		'license-is-inactive'       => __( 'License is inactive.', 'author' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'author' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'author' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'author' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'author' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'author' )
	)

);