<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Style_Manager
 *
 * @since 1.7.0.
 */
final class MAKE_Style_Manager extends MAKE_Util_Modules implements MAKE_Style_ManagerInterface, MAKE_Util_HookInterface, MAKE_Util_LoadInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'compatibility' => 'MAKE_Compatibility_MethodsInterface',
		'font'          => 'MAKE_Font_ManagerInterface',
		'thememod'      => 'MAKE_Settings_ThemeModInterface',
		'helper'        => 'MAKE_Style_DataHelperInterface',
		'css'           => 'MAKE_Style_CSSInterface',
	);


	private $file_action = 'make-css';


	private $inline_action = 'make-css-inline';

	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @var bool
	 */
	private static $hooked = false;

	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @var bool
	 */
	private $loaded = false;

	/**
	 * MAKE_Style_Manager constructor.
	 *
	 * @since 1.7.0.
	 *
	 * @param MAKE_APIInterface $api
	 * @param array             $modules
	 */
	public function __construct( MAKE_APIInterface $api = null, array $modules = array() ) {
		// Module defaults.
		$modules = wp_parse_args( $modules, array(
			'helper' => 'MAKE_Style_DataHelper',
			'css'    => 'MAKE_Style_CSS',
		) );

		// Load dependencies.
		parent::__construct( $api, $modules );
	}

	/**
	 * Hook into WordPress.
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	public function hook() {
		if ( $this->is_hooked() ) {
			return;
		}

		// Add styles as inline CSS in the document head.
		add_action( 'wp_head', array( $this, 'get_styles_as_inline' ), 11 );

		// Register Ajax handler for returning styles as inline CSS.
		add_action( 'wp_ajax_' . $this->inline_action, array( $this, 'get_styles_as_inline_ajax' ) );
		add_action( 'wp_ajax_nopriv_' . $this->inline_action, array( $this, 'get_styles_as_inline_ajax' ) );

		// Register Ajax handler for outputting styles as a file.
		add_action( 'wp_ajax_' . $this->file_action, array( $this, 'get_styles_as_file' ) );
		add_action( 'wp_ajax_nopriv_' . $this->file_action, array( $this, 'get_styles_as_file' ) );

		// Add styles file to TinyMCE.
		add_filter( 'mce_css', array( $this, 'mce_css' ), 99 );

		// Hooking has occurred.
		self::$hooked = true;
	}

	/**
	 * Check if the hook routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @return bool
	 */
	public function is_hooked() {
		return self::$hooked;
	}

	/**
	 * Load data files.
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	public function load() {
		if ( $this->is_loaded() ) {
			return;
		}

		/**
		 * Action: Fires before the Style class loads data files.
		 *
		 * This allows, for example, for filters to be added to thememod settings to change the values
		 * before the style definitions are loaded.
		 *
		 * @since 1.7.0.
		 */
		do_action( 'make_style_before_load' );

		$file_bases = array(
			'thememod-typography',
			'thememod-color',
			'thememod-background',
			'thememod-layout',
			'builder',
		);

		// Load the style includes.
		foreach ( $file_bases as $name ) {
			$file = dirname( __FILE__ ) . '/definitions/' . $name . '.php';
			if ( is_readable( $file ) ) {
				include_once $file;
			}
		}

		// Loading has occurred.
		$this->loaded = true;

		// Check for deprecated action.
		if ( has_action( 'make_css' ) ) {
			$this->compatibility()->deprecated_hook(
				'make_css',
				'1.7.0',
				sprintf(
					__( 'To add dynamic CSS rules, use the %s hook instead.', 'make' ),
					'<code>make_style_loaded</code>'
				)
			);

			/**
			 * The hook used to add CSS rules for the generated inline CSS.
			 *
			 * This hook is the correct hook to use for adding CSS styles to the group of selectors and properties that will be
			 * added to inline CSS that is printed in the head. Hooking elsewhere may lead to rules not being registered
			 * correctly for the CSS generation. Most Customizer options will use this hook to register additional CSS rules.
			 *
			 * @since 1.2.3.
			 * @deprecated 1.7.0.
			 */
			do_action( 'make_css' );
		}

		/**
		 * Action: Fires at the end of the Styles object's load method.
		 *
		 * This action gives a developer the opportunity to add or modify dynamic styles
		 * and run additional load routines.
		 *
		 * @since 1.2.3.
		 *
		 * @param MAKE_Style_Manager    $style    The styles object
		 */
		do_action( 'make_style_loaded', $this );
	}

	/**
	 * Check if the load routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @return bool
	 */
	public function is_loaded() {
		return $this->loaded;
	}


	public function get_styles_as_inline() {
		if ( ! $this->is_loaded() ) {
			$this->load();
		}

		/**
		 * Action: Fires before the inline CSS rules are rendered and output.
		 *
		 * @since 1.7.0.
		 */
		do_action( 'make_style_before_inline' );

		// Echo the rules.
		if ( $this->css()->has_rules() ) {
			echo "\n<!-- Begin Make Inline CSS -->\n<style type=\"text/css\">\n";

			echo stripslashes( wp_filter_nohtml_kses( $this->css()->build() ) );

			echo "\n</style>\n<!-- End Make Inline Custom CSS -->\n";
		}
	}


	public function get_styles_as_inline_ajax() {
		// Only run this in the proper hook context.
		if ( ! in_array( current_action(), array( 'wp_ajax_' . $this->inline_action, 'wp_ajax_nopriv_' . $this->inline_action ) ) ) {
			wp_die();
		}
		
		$this->get_styles_as_inline();

		// End the Ajax response.
		wp_die();
	}

	/**
	 *
	 *
	 * @return void
	 */
	public function get_styles_as_file() {
		// Only run this in the proper hook context.
		if ( ! in_array( current_action(), array( 'wp_ajax_' . $this->file_action, 'wp_ajax_nopriv_' . $this->file_action ) ) ) {
			wp_die();
		}

		if ( ! $this->is_loaded() ) {
			$this->load();
		}

		/**
		 * Action: Fires before the CSS rules are rendered and output as a file.
		 *
		 * @since 1.7.0.
		 */
		do_action( 'make_style_before_file' );

		/**
		 * Filter: Set whether the dynamic stylesheet will send headers telling the browser
		 * to cache the request. Set to false to turn off these headers.
		 *
		 * @since 1.7.0.
		 *
		 * @param bool    $cache_headers
		 */
		if ( ( ! defined( 'SCRIPT_DEBUG' ) || false === SCRIPT_DEBUG ) && true === apply_filters( 'make_style_file_cache_headers', true ) ) {
			// Set headers for caching
			// @link http://stackoverflow.com/a/15000868
			// @link http://www.mobify.com/blog/beginners-guide-to-http-cache-headers/
			$expires = HOUR_IN_SECONDS;
			header( 'Pragma: public' );
			header( 'Cache-Control: private, max-age=' . $expires );
			header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', time() + $expires ) . ' GMT' );
		}

		// Set header for content type.
		header( 'Content-type: text/css' );

		// Echo the rules.
		echo wp_filter_nohtml_kses( $this->css()->build() );

		// End the Ajax response.
		wp_die();
	}

	/**
	 * Generate a URL for accessing the dynamically-generated CSS file.
	 *
	 * @since 1.7.0.
	 *
	 * @return string
	 */
	public function get_file_url() {
		return add_query_arg( 'action', $this->file_action, admin_url( 'admin-ajax.php' ) );
	}

	/**
	 * Make sure theme option CSS is added to TinyMCE last, to override other styles.
	 *
	 * @since  1.0.0.
	 *
	 * @param  string    $stylesheets    List of stylesheets added to TinyMCE.
	 * @return string                    Modified list of stylesheets.
	 */
	function mce_css( $stylesheets ) {
		if ( $this->css()->has_rules() ) {
			$stylesheets .= ',' . $this->get_file_url();
		}

		return $stylesheets;
	}
}