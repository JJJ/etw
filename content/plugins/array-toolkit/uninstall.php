<?php
/**
 * Uninstall Array Toolkit
 *
 * @since 1.0.0
 */

// Exit if access directly
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;


// Check user permissions
if ( ! current_user_can( 'activate_plugins' ) )
	return;

/**
 * Delete the plugin's options
 *
 * @since 1.0.0
 */
delete_option( 'arraysocial_options' );
delete_option( 'array_toolkit_legacy_portfolio_posts' );
delete_option( 'array_toolkit_legacy_slider_posts' );
delete_option( 'array_toolkit_legacy_postmeta' );
delete_option( 'array_toolkit_legacy_install' );
delete_option( 'array_toolkit_version' );
delete_option( 'array_toolkit_previous_version' );
