<?php
/*
Plugin Name: Cornerstone
Plugin URI: http://theme.co/cornerstone
Description: The WordPress Page Builder
Author: Themeco
Author URI: http://theme.co/
Version: 3.0.4
Text Domain: cornerstone
Domain Path: lang
*/

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Setup Localization
function cornerstone_plugin_init() {
  load_plugin_textdomain( 'cornerstone', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
}

add_action( 'init', 'cornerstone_plugin_init' );

// Fire it up
require_once 'includes/boot.php';
cornerstone_boot( __FILE__ );
