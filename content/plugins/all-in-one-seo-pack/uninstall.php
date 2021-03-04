<?php
/**
 * Uninstall AIOSEO
 *
 * Remove:
 * - AIOSEO Notifications table
 * - AIOSEO Posts table
 * - AIOSEO Terms table
 *
 * @since 4.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Load plugin file.
require_once 'all_in_one_seo_pack.php';

// Disable Action Schedule Queue Runner.
if ( class_exists( 'ActionScheduler_QueueRunner' ) ) {
	ActionScheduler_QueueRunner::instance()->unhook_dispatch_async_request();
}

// Confirm user has decided to remove all data, otherwise stop.
if ( ! aioseo()->options->advanced->uninstall ) {
	return;
}

global $wpdb;

// Delete notifications table.
$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'aioseo_notifications' );

// Delete posts table.
$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'aioseo_posts' );

// Delete temrs table.
$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'aioseo_terms' );

// Delete all the plugin settings.
$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'aioseo\_%'" );

// Remove any transients we've left behind.
$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '\_aioseo\_%'" );
$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'aioseo\_%'" );

// Delete all entries from the action scheduler table.
$wpdb->query( "DELETE FROM {$wpdb->prefix}actionscheduler_actions WHERE hook LIKE 'aioseo\_%'" );
$wpdb->query( "DELETE FROM {$wpdb->prefix}actionscheduler_groups WHERE slug = 'aioseo'" );

global $wp_filesystem;

// Remove translation files.
$languages_directory = defined( 'WP_LANG_DIR' ) ? trailingslashit( WP_LANG_DIR ) : trailingslashit( WP_CONTENT_DIR ) . 'languages/';
$translations        = glob( wp_normalize_path( $languages_directory . 'plugins/aioseo-*' ) );
if ( ! empty( $translations ) ) {
	foreach ( $translations as $file ) {
		$wp_filesystem->delete( $file );
	}
}

$translations = glob( wp_normalize_path( $languages_directory . 'plugins/all-in-one-seo-*' ) );
if ( ! empty( $translations ) ) {
	foreach ( $translations as $file ) {
		$wp_filesystem->delete( $file );
	}
}