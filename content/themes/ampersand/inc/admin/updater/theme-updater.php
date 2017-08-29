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
define( 'AMPERSAND_SL_THEME_VERSION', wp_get_theme( 'ampersand' )->get( 'Version' ) );

// Loads the updater classes
$updater = new Array_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => esc_url( 'https://arraythemes.com' ),
		'item_name'      => __( 'Ampersand WordPress Theme', 'ampersand' ),
		'theme_slug'     => 'ampersand',
		'version'        => AMPERSAND_SL_THEME_VERSION,
		'author'         => __( 'Array', 'ampersand' ),
		'download_id'    => '5937',
		'renew_url'      => ''
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Getting Started', 'ampersand' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'ampersand' ),
		'license-key'               => __( 'Enter your license key', 'ampersand' ),
		'license-action'            => __( 'License Action', 'ampersand' ),
		'deactivate-license'        => __( 'Deactivate License', 'ampersand' ),
		'activate-license'          => __( 'Activate License', 'ampersand' ),
		'save-license'              => __( 'Save License', 'ampersand' ),
		'status-unknown'            => __( 'License status is unknown.', 'ampersand' ),
		'renew'                     => __( 'Renew?', 'ampersand' ),
		'unlimited'                 => __( 'unlimited', 'ampersand' ),
		'license-key-is-active'     => __( 'Theme updates have been enabled. You will receive a notice on your Themes page when a theme update is available.', 'ampersand' ),
		'expires%s'                 => __( 'Your license for Ampersand expires %s.', 'ampersand' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'ampersand' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'ampersand' ),
		'license-key-expired'       => __( 'License key has expired.', 'ampersand' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'ampersand' ),
		'license-is-inactive'       => __( 'License is inactive.', 'ampersand' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'ampersand' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'ampersand' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'ampersand' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'ampersand' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'ampersand' )
	)

);
