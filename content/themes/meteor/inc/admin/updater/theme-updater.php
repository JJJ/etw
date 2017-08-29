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
define( 'METEOR_SL_THEME_VERSION', wp_get_theme( 'meteor' )->get( 'Version' ) );

// Loads the updater classes
$updater = new Array_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => esc_url( 'https://arraythemes.com' ),
		'item_name'      => __( 'Meteor WordPress Theme', 'meteor' ),
		'theme_slug'     => 'meteor',
		'version'        => METEOR_SL_THEME_VERSION,
		'author'         => __( 'Array', 'meteor' ),
		'download_id'    => '173835',
		'renew_url'      => ''
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Getting Started', 'meteor' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'meteor' ),
		'license-key'               => __( 'Enter your license key', 'meteor' ),
		'license-action'            => __( 'License Action', 'meteor' ),
		'deactivate-license'        => __( 'Deactivate License', 'meteor' ),
		'activate-license'          => __( 'Activate License', 'meteor' ),
		'save-license'              => __( 'Save License', 'meteor' ),
		'status-unknown'            => __( 'License status is unknown.', 'meteor' ),
		'renew'                     => __( 'Renew?', 'meteor' ),
		'unlimited'                 => __( 'unlimited', 'meteor' ),
		'license-key-is-active'     => __( 'Theme updates have been enabled. You will receive a notice on your Themes page when a theme update is available.', 'meteor' ),
		'expires%s'                 => __( 'Your license for Meteor expires %s.', 'meteor' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'meteor' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'meteor' ),
		'license-key-expired'       => __( 'License key has expired.', 'meteor' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'meteor' ),
		'license-is-inactive'       => __( 'License is inactive.', 'meteor' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'meteor' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'meteor' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'meteor' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'meteor' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'meteor' )
	)

);
