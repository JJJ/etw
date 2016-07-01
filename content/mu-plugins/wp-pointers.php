<?php

/**
 * Plugin name: Flox - No Pointers
 * Description: Unhook WordPress admin area pointers
 * Author:      John James Jacoby
 * Author URI:  http://jjj.me
 * Version:     1.0.0
 */

// WordPress or bust
defined( 'ABSPATH' ) || exit();

/**
 * Unhook WordPress admin area pointers
 *
 * This prevents `dismissed_wp_pointers` usermeta entries and completely
 * disables the WP_Internal_Pointers API.
 *
 * @author jjj
 */
function flox_no_pointers() {
	remove_action( 'admin_enqueue_scripts', array( 'WP_Internal_Pointers', 'enqueue_scripts'                ) );
	remove_action( 'user_register',         array( 'WP_Internal_Pointers', 'dismiss_pointers_for_new_users' ) );
}
add_action( 'admin_init', 'flox_no_pointers' );
