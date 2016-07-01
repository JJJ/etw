<?php

/**
 * Plugin name: Flox - Simple Overrides
 * Description: Little Tweaks for Lots of Things
 * Author:      John James Jacoby
 * Author URI:  http://jjj.me
 * Version:     1.0.0
 */

// WordPress or bust
defined( 'ABSPATH' ) || exit();

// Activity Humility
add_filter( 'wp_user_activity_menu_humility', '__return_true' );
