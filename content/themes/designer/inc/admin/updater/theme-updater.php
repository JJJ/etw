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
define( 'DESIGNER_SL_THEME_VERSION', wp_get_theme( 'designer' )->get( 'Version' ) );

// Loads the updater classes
$updater = new Array_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => esc_url( 'https://arraythemes.com' ),
		'item_name'      => __( 'Designer WordPress Theme', 'designer' ),
		'theme_slug'     => 'designer',
		'version'        => DESIGNER_SL_THEME_VERSION,
		'author'         => __( 'Array', 'designer' ),
		'download_id'    => '60267',
		'renew_url'      => ''
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Getting Started', 'designer' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'designer' ),
		'license-key'               => __( 'Enter your license key', 'designer' ),
		'license-action'            => __( 'License Action', 'designer' ),
		'deactivate-license'        => __( 'Deactivate License', 'designer' ),
		'activate-license'          => __( 'Activate License', 'designer' ),
		'save-license'              => __( 'Save License', 'designer' ),
		'status-unknown'            => __( 'License status is unknown.', 'designer' ),
		'renew'                     => __( 'Renew?', 'designer' ),
		'unlimited'                 => __( 'unlimited', 'designer' ),
		'license-key-is-active'     => __( 'Theme updates have been enabled. You will receive a notice on your Themes page when a theme update is available.', 'designer' ),
		'expires%s'                 => __( 'Your license for Designer expires %s.', 'designer' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'designer' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'designer' ),
		'license-key-expired'       => __( 'License key has expired.', 'designer' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'designer' ),
		'license-is-inactive'       => __( 'License is inactive.', 'designer' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'designer' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'designer' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'designer' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'designer' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'designer' )
	)

);
