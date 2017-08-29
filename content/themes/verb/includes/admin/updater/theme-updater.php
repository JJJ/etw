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
define( 'VERB_SL_THEME_VERSION', wp_get_theme( 'verb' )->get( 'Version' ) );

// Loads the updater classes
$updater = new Array_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => esc_url( 'https://arraythemes.com' ),
		'item_name'      => __( 'Verb WordPress Theme', 'verb' ),
		'theme_slug'     => 'verb',
		'version'        => VERB_SL_THEME_VERSION,
		'author'         => __( 'Array', 'verb' ),
		'download_id'    => '2005',
		'renew_url'      => ''
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Getting Started', 'verb' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'verb' ),
		'license-key'               => __( 'Enter your license key', 'verb' ),
		'license-action'            => __( 'License Action', 'verb' ),
		'deactivate-license'        => __( 'Deactivate License', 'verb' ),
		'activate-license'          => __( 'Activate License', 'verb' ),
		'save-license'              => __( 'Save License', 'verb' ),
		'status-unknown'            => __( 'License status is unknown.', 'verb' ),
		'renew'                     => __( 'Renew?', 'verb' ),
		'unlimited'                 => __( 'unlimited', 'verb' ),
		'license-key-is-active'     => __( 'Theme updates have been enabled. You will receive a notice on your Themes page when a theme update is available.', 'verb' ),
		'expires%s'                 => __( 'Your license for Verb expires %s.', 'verb' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'verb' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'verb' ),
		'license-key-expired'       => __( 'License key has expired.', 'verb' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'verb' ),
		'license-is-inactive'       => __( 'License is inactive.', 'verb' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'verb' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'verb' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'verb' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'verb' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'verb' )
	)

);
