<?php

/**
 * Flox Stats Hooks
 *
 * @package Plugins/Flox/Stats/Hooks
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

// Register settings
add_action( 'admin_init', 'wp_flox_stats_register_settings' );

// Stats code
add_action( 'wp_footer',    'wp_flox_stats_footer' );
add_action( 'login_footer', 'wp_flox_stats_footer' );
add_action( 'admin_footer', 'wp_flox_stats_footer' );
