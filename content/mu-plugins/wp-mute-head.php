<?php

/**
 * Plugin name: Flox - Mute Head
 * Description: Prevent a few common WordPress head actions
 * Author:      John James Jacoby
 * Author URI:  https://flox.io
 * Version:     1.0.0
 */

// WordPress or bust
defined( 'ABSPATH' ) || exit();

/**
 * Remove a few commonly annoying `wp_head` actions
 */
add_action( 'init', function() {
	remove_action( 'wp_head', 'rsd_link'                               );
	remove_action( 'wp_head', 'wp_generator'                           );
	remove_action( 'wp_head', 'wlwmanifest_link'                       );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
} );
