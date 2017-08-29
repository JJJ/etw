<?php
/**
 * Plugin installation
 *
 * @package Array Toolkit
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit();


/**
 * The Array_Toolkit_Install class.
 *
 * Actions that run on plugin activation.
 *
 * @since 1.0.0
 */
class Array_Toolkit_Install {


	// Variables
	private static $okvideo = 'okvideo';
	private static $arrayvideo = 'arrayvideo';


	/**
	 * Constructor
	 */
	function __construct() {

		add_action( 'array_toolkit_activate', array( $this, 'activation_utility' ), 10 );
	}


	/**
	 * Checks for legacy post types, saves options, and calls the upgraders.
	 *
	 * The options can be used to debug activation and conversion issues
	 * or target legacy installations in the future if needed. Otherwise
	 * we'd just skip this altogether.
	 */
	function activation_utility() {

		// Check for legacy portfolio posts and convert if necessary
		$okay_portfolio_posts = get_posts( array( 'post_type' => 'okay-portfolio', 'posts_per_page' => -1 ) );

		if( $okay_portfolio_posts ) {
			update_option( 'array_toolkit_legacy_portfolio_posts', 'yes' );
			self::convert_portfolio_posts( $okay_portfolio_posts );
		}



 		// Check for legacy slider posts and convert if necessary
		$okay_slider_posts = get_posts( array( 'post_type' => 'okay-slider', 'posts_per_page' => -1 ) );

		if( $okay_slider_posts ) {
			update_option( 'array_toolkit_legacy_slider_posts', 'yes' );
			self::convert_slider_posts( $okay_slider_posts );
		}



		// Check for legacy custom fields and convert if necessary
		global $wpdb;
		$okvideos = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->postmeta WHERE meta_key = %s", self::$okvideo ) );

		if( $okvideos ) {
			update_option( 'array_toolkit_legacy_postmeta', 'yes' );
			self::convert_postmeta();
		}



		// Save legacy option for later use if ever needed
		if( $okay_portfolio_posts || $okay_slider_posts || $okvideos ) {
			update_option( 'array_toolkit_legacy_install', 'yes' );
		}

		// Uncomment this line to revert for testing
		//self::array_toolkit_revert_upgrade();
	}



	/**
	 * Converts legacy portfolio posts
	 *
	 * @since 1.0.0
	 * @param array $okay_portfolio_posts List of WP_Post objects from get_posts
	 */
	function convert_portfolio_posts( $okay_portfolio_posts = false ) {

		if ( ! $okay_portfolio_posts )
			return;

		// Convert them
		foreach( $okay_portfolio_posts as $okay_portfolio_post ) {
			set_post_type( $okay_portfolio_post->ID, 'array-portfolio' );
		}

		update_option( 'array_toolkit_legacy_portfolio_posts', 'converted' );

	}



	/**
	 * Converts legacy slider posts
	 *
	 * @since 1.0.0
	 * @param array $okay_slider_posts List of WP_Post objects from get_posts
	 */
	function convert_slider_posts( $okay_slider_posts = false ) {

		if( ! $okay_slider_posts )
			return;

		// Convert them
		foreach( $okay_slider_posts as $okay_slider_post ) {
			set_post_type( $okay_slider_post->ID, 'array-slider' );
		}

		// Check for leftovers and update the legacy option
		update_option( 'array_toolkit_legacy_slider_posts', 'converted' );

	}



	/**
	 * Converts legacy custom fields
	 *
	 * @since 1.0.0
	 */
	function convert_postmeta() {

		global $wpdb;
		$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_key = %s WHERE meta_key = %s", self::$arrayvideo, self::$okvideo ) );

		update_option( 'array_toolkit_legacy_postmeta', 'converted' );

	}



	/**
	 * Reverts Array post types to Okay post types for TESTING ONLY!
	 *
	 * @since 1.0.0
	 */
	function array_toolkit_revert_upgrade() {

		// Revert portfolio post types
		$array_portfolio_args = array(
			'posts_per_page' => -1,
			'post_type'      => 'array-portfolio',
		);
		$array_portfolio_posts = get_posts( $array_portfolio_args );
		foreach( $array_portfolio_posts as $array_portfolio_post ) {
			set_post_type( $array_portfolio_post->ID, 'okay-portfolio' );
		}
		update_option( 'array_toolkit_legacy_portfolio_posts', 'yes' );


		// Revert slider post types
		$array_slider_args = array(
			'posts_per_page' => -1,
			'post_type'      => 'array-slider',
		);
		$array_slider_posts = get_posts( $array_slider_args );
		foreach( $array_slider_posts as $array_slider_post ) {
			set_post_type( $array_slider_post->ID, 'okay-slider' );
		}
		update_option( 'array_toolkit_legacy_slider_posts', 'yes' );


		// Revert custom fields
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_key = %s WHERE meta_key = %s", self::$okvideo, self::$arrayvideo ) );


		// Check for legacy custom fields.
		global $wpdb;
		$okvideos = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->postmeta WHERE meta_key = %s", self::$okvideo ) );
		if( $okvideos ) {
			update_option( 'array_toolkit_legacy_postmeta', 'yes' );
		}
	}



	/**
	 * Deactivates the Okay Toolkit plugin.
	 *
	 * Only runs on plugin activation.
	 * @wp-hook update_option_active_plugins
	 * @see array_toolkit_activation
	 *
	 * @since 1.0.0
	 */
	function deactivate_okay_toolkit() {

		$target = 'okay-toolkit/okay-toolkit.php';

		if( is_plugin_active( $target ) ) {
			deactivate_plugins( $target, true );
		}
	}

}

// Let's do this
$array_toolkit_install = new Array_Toolkit_Install;
