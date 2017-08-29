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
define( 'PUBLISHER_SL_THEME_VERSION', wp_get_theme( 'publisher' )->get( 'Version' ) );

// Loads the updater classes
$updater = new Array_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => esc_url( 'https://arraythemes.com' ),
		'item_name'      => __( 'Publisher WordPress Theme', 'publisher' ),
		'theme_slug'     => 'publisher',
		'version'        => PUBLISHER_SL_THEME_VERSION,
		'author'         => __( 'Array', 'publisher' ),
		'download_id'    => '4071',
		'renew_url'      => ''
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Getting Started', 'publisher' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'publisher' ),
		'license-key'               => __( 'Enter your license key', 'publisher' ),
		'license-action'            => __( 'License Action', 'publisher' ),
		'deactivate-license'        => __( 'Deactivate License', 'publisher' ),
		'activate-license'          => __( 'Activate License', 'publisher' ),
		'save-license'              => __( 'Save License', 'publisher' ),
		'status-unknown'            => __( 'License status is unknown.', 'publisher' ),
		'renew'                     => __( 'Renew?', 'publisher' ),
		'unlimited'                 => __( 'unlimited', 'publisher' ),
		'license-key-is-active'     => __( 'Theme updates have been enabled. You will receive a notice on your Themes page when a theme update is available.', 'publisher' ),
		'expires%s'                 => __( 'Your license for Publisher expires %s.', 'publisher' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'publisher' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'publisher' ),
		'license-key-expired'       => __( 'License key has expired.', 'publisher' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'publisher' ),
		'license-is-inactive'       => __( 'License is inactive.', 'publisher' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'publisher' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'publisher' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'publisher' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'publisher' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'publisher' )
	)

);
