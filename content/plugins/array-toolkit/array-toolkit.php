<?php
/*
Plugin Name: Array Toolkit
Plugin URI: https://array.is
Description: Various social widgets and elements for your Array powered WordPress site.
Version: 1.1.6
Author: Array
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit();

// Toolkit version
define( 'ARRAY_TOOLKIT_VERSION', '1.1.5' );

// Toolkit root directory
define( 'ARRAY_TOOLKIT_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

// Includes directory
define( 'ARRAY_TOOLKIT_INCLUDES', trailingslashit( ARRAY_TOOLKIT_DIR ) . 'includes/' );

// Plugin root file
define( 'ARRAY_TOOLKIT_PLUGIN_FILE', __FILE__ );

// Toolkit URI
define( 'ARRAY_TOOLKIT_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );


/**
 * The Array_Toolkit class.
 *
 * @since 1.0.0
 */
class Array_Toolkit {

	/**
	 * The constructor method for the Array_Toolkit class.
	 * Adds other methods to WordPress hooks.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Define textdomain
		load_plugin_textdomain( 'array-toolkit', false, 'ARRAY_TOOLKIT_INCLUDES' . 'languages/' );

		// Includes
		add_action( 'after_setup_theme', array( $this, 'includes' ), 11 );

		// Admin scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_scripts' ) );

		// Front end styles
		add_action( 'wp_enqueue_scripts', array( $this, 'plugin_styles' ) );

		// Activation hook
		register_activation_hook( __FILE__ , array( $this, 'toolkit_activation' ) );
	}



	/**
	 * Loads the required files for the Toolkit and specified by themes.
	 *
	 * @since 1.0.0
	 */
	function includes() {

		/**
		 * Loads custom post type and taxonomy functions.
		 */
		require_once( ARRAY_TOOLKIT_INCLUDES . 'post-types.php' );


		/**
		 * Loads testimonial post type and taxonomy functions when supported.
		 */
		if( current_theme_supports( 'testimonials' ) ) {
			require_once( ARRAY_TOOLKIT_INCLUDES . 'testimonials/post-types.php' );
			require_once( ARRAY_TOOLKIT_INCLUDES . 'testimonials/taxonomies.php' );
		}


		/**
		 * Loads gallery functions when needed.
		 */
		require_if_theme_supports( 'array_themes_gallery_support', ARRAY_TOOLKIT_INCLUDES . 'gallery/gallery.php' );


		/**
		 * Loads video functions when needed.
		 */
		require_if_theme_supports( 'array_themes_video_support', ARRAY_TOOLKIT_INCLUDES . 'video/video.php' );


		/**
		 * Loads EDD demo functions when needed.
		 */
		require_if_theme_supports( 'array_themes_demo_link_support', ARRAY_TOOLKIT_INCLUDES . 'edd/demo.php' );


		/**
		 * Loads legacy widgets when needed.
		 */
		if( current_theme_supports( 'array_toolkit_legacy_widgets' ) ) {

			// Dribbble widget
			include_once ARRAY_TOOLKIT_INCLUDES . 'widgets/dribbble/dribbble.php';

			// Flickr widget
			include_once ARRAY_TOOLKIT_INCLUDES . 'widgets/flickr/flickr.php';

			// Icons widget
			include_once ARRAY_TOOLKIT_INCLUDES . 'widgets/icons/icons.php';
		}


		/**
		 * Loads the admin functions.
		 */
		if( is_admin() ) {
			require_once( ARRAY_TOOLKIT_INCLUDES . 'admin/admin.php' );
		}

	}



	/**
	 * Loads plugin scripts and styles in the admin
	 *
	 * @since 1.0.0
	 */
	function load_admin_scripts() {

		// Register and enqueue custom admin stylesheet
		wp_register_style( 'arraysocial_admin_css', ARRAY_TOOLKIT_URI . 'includes/css/admin-style.css', false, '1.0.0' );
		wp_enqueue_style( 'arraysocial_admin_css' );

	}



	/**
	 * Loads styles on the front end
	 *
	 * @since 1.0.0
	 */
	function plugin_styles() {
		if( current_theme_supports( 'array_toolkit_legacy_widgets' ) ) {
			wp_register_style( 'arraysocial_style', ARRAY_TOOLKIT_URI . 'includes/css/social-style.css', false, '1.0.0' );
			wp_enqueue_style( 'arraysocial_style' );

			wp_register_style( 'arraysocial_icon_style', ARRAY_TOOLKIT_URI . 'includes/css/social-icons.css', false, '1.0.0' );
			wp_enqueue_style( 'arraysocial_icon_style' );

			wp_register_style( 'arraysocial_icon_font', ARRAY_TOOLKIT_URI . 'includes/css/fonts/fontello/array.css', false, '1.0.0' );
			wp_enqueue_style( 'arraysocial_icon_font' );
		}
	}



	/**
	 * Actions that run on plugin activation.
	 *
	 * Registers post types supported by themes.
	 * Saves current Toolkit version and version upgraded from for future use.
	 *
	 * @since 1.0.0
	 */
	function toolkit_activation() {


		// Load theme activation functions
		require_once( ARRAY_TOOLKIT_INCLUDES . 'install.php' );


		// Add hook to convert legacy post types
		// See Array_Toolkit_Install::activation_utility() in includes/admin/install.php
		do_action( 'array_toolkit_activate' );


		// Add hook to deactivate Okay Toolkit
		add_action( 'update_option_active_plugins', array( 'Array_Toolkit_Install', 'deactivate_okay_toolkit' ) );


		// Register portfolio post type if theme adds support
		if( current_theme_supports( 'array_themes_portfolio_support' ) ) {

			require_once( ARRAY_TOOLKIT_INCLUDES. 'post-types.php' );
			$atpt = new Array_Toolkit_Post_Types;
			$atpt->register_portfolio_post_type();
			$atpt->register_portfolio_taxonomies();
			flush_rewrite_rules();
		}


		// Register slider post type if theme adds support
		if( current_theme_supports( 'array_themes_slider_support' ) ) {

			require_once( ARRAY_TOOLKIT_INCLUDES . 'post-types.php' );
			$atpt = new Array_Toolkit_Post_Types;
			$atpt->register_slider_post_type();
			flush_rewrite_rules();
		}


		// Register the testimonial post type if needed.
		if( current_theme_supports( 'testimonials' ) ) {

			require_once( ARRAY_TOOLKIT_INCLUDES . 'testimonials/post-types.php' );
			require_once( ARRAY_TOOLKIT_INCLUDES . 'testimonials/taxonomies.php' );
			flush_rewrite_rules();
		}


		// Save the previous version we're upgrading from
		$current_version = get_option( 'array_toolkit_version' );
		if ( $current_version )
			update_option( 'array_toolkit_previous_version', $current_version );

		// Save current version
		update_option( 'array_toolkit_version', ARRAY_TOOLKIT_VERSION );
	}


}

// Let's do this
$array_toolkit = new Array_Toolkit;
