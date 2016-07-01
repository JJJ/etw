<?php
/**
 * @package Make
 */

/**
 * Class MAKEPLUS_Compatibility_Methods
 *
 * Methods to support compatibility issues.
 *
 * @since 1.7.0.
 */
final class MAKEPLUS_Compatibility_Methods extends MAKEPLUS_Util_Modules implements MAKEPLUS_Compatibility_MethodsInterface, MAKEPLUS_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'mode' => 'MAKEPLUS_Setup_ModeInterface',
	);

	/**
	 * The available compatibility modes.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	private $modes = array(
		'full'    => array(
			'deprecated'    => array( '1.7' ),
		),
		'1.6'     => array(
			'deprecated'    => array( '1.7' ),
		),
		'1.7'     => array(
			'deprecated'    => false,
		),
		'current' => array(
			'deprecated'    => false,
		),
	);

	/**
	 * The current compatibility mode.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	private $mode = array();

	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @var bool
	 */
	private static $hooked = false;

	/**
	 * MAKE_Compatibility_Methods constructor.
	 *
	 * @since 1.7.0.
	 *
	 * @param MAKEPLUS_APIInterface|null $api
	 * @param array                      $modules
	 */
	public function __construct( MAKEPLUS_APIInterface $api = null, array $modules = array() ) {
		// Load dependencies.
		parent::__construct( $api, $modules );

		// Set the compatibility mode.
		$this->set_mode();
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

		// Deprecated files
		add_action( 'makeplus_api_loaded', array( $this, 'require_deprecated_files' ), 0 );

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
	 * Set the mode for compatibility.
	 *
	 * The compatibility mode determines which compatibility files and modules are loaded.
	 *
	 * @since 1.7.0.
	 *
	 * @return string    $mode    The mode that was set.
	 */
	private function set_mode() {
		$default_mode = 'full';

		/**
		 * Filter: Set the mode for compatibility.
		 *
		 * - 'full' will load all the files to enable back compatibility with deprecated code. (Default)
		 * - 'current' will not load any deprecated code. Use with caution! Could result in a fatal PHP error.
		 * - A minor release value, such as '1.6', will load files necessary for back compatibility with version 1.6.x.
		 *   Note that there are no separate modes for releases prior to 1.6.
		 *
		 * Example: If a site was originally customized with a child theme and Make Plus 1.6.x, setting the mode to 1.6
		 * will load files necessary to enable compatibility with changes made in 1.7.x, but will skip files for 1.6.
		 *
		 * @since 1.7.0.
		 *
		 * @param string $mode    The compatibility mode to run the theme in.
		 */
		$mode = apply_filters( 'makeplus_compatibility_mode', $default_mode );

		if ( ! isset( $this->modes[ $mode ] ) ) {
			$mode = $default_mode;
		}

		$this->mode = $this->modes[ $mode ];

		return $mode;
	}

	/**
	 * Load back compat files for deprecated functionality based on specified version numbers.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action makeplus_api_loaded
	 *
	 * @return void
	 */
	public function require_deprecated_files() {
		if ( isset( $this->mode['deprecated'] ) && is_array( $this->mode['deprecated'] ) ) {
			foreach ( $this->mode['deprecated'] as $version ) {
				$file = dirname( __FILE__ ) . '/deprecated/deprecated-' . $version . '.php';
				if ( is_readable( $file ) ) {
					require_once $file;
				}
			}
		}
	}

	/**
	 * Mark a function as deprecated and inform when it has been used.
	 *
	 * Based on _deprecated_function() in WordPress core.
	 *
	 * @since 1.7.0.
	 *
	 * @param string      $function    The function that was called.
	 * @param string      $version     The version of Make that deprecated the function.
	 * @param string|null $replacement Optional. The function that should have been called.
	 * @param string|null $message     Optional. Full error message in place of a replacement function.
	 * @param bool        $backtrace   Optional. True to include a backtrace in the error message.
	 *
	 * @return void
	 */
	public function deprecated_function( $function, $version, $replacement = null, $message = null, $backtrace = true ) {
		/**
		 * Fires when a deprecated function is called.
		 *
		 * @since 1.7.0.
		 *
		 * @param string $function    The function that was called.
		 * @param string $version     The version of Make that deprecated the function.
		 * @param string $replacement The function that should have been called.
		 * @param string $message     Explanatory text if there is no direct replacement available.
		 */
		do_action( 'makeplus_deprecated_function_run', $function, $version, $replacement, $message );

		$error_code = 'makeplus_deprecated_function';
		$error_message = __( '<strong>%1$s</strong> is deprecated since version %2$s of Make Plus. %3$s', 'make-plus' );

		// Add additional messages.
		if ( ! is_null( $replacement ) ) {
			$message2 = sprintf( __( 'Use <code>%s</code> instead.', 'make-plus' ), $replacement );
		} else if ( ! is_null( $message ) ) {
			$message2 = $message;
		} else {
			$message2 = __( 'No alternative is available.', 'make-plus' );
		}

		$error_message = sprintf(
			$error_message,
			$function,
			$version,
			$message2
		);

		// Use Make's error API
		if ( $this->mode()->has_make_api() ) {
			// Add a backtrace.
			if ( $backtrace ) {
				$error_message .= Make()->error()->generate_backtrace( array( get_class( $this ) ) );
			}

			// Add the error.
			Make()->error()->add_error( $error_code, $error_message );
		}
		// Trigger a PHP error
		else {
			trigger_error( $error_message );
		}
	}

	/**
	 * Mark an action or filter hook as deprecated and inform when it has been used.
	 *
	 * Based on _deprecated_argument() in WordPress core.
	 *
	 * @since 1.7.0.
	 *
	 * @param string $hook     The hook that was used.
	 * @param string $version  The version of WordPress that deprecated the hook.
	 * @param string $message  Optional. A message regarding the change. Default null.
	 *
	 * @return void
	 */
	public function deprecated_hook( $hook, $version, $message = null ) {
		/**
		 * Fires when a deprecated hook has an attached function/method.
		 *
		 * @since 1.7.0.
		 *
		 * @param string $hook        The hook that was called.
		 * @param string $version     The version of Make that deprecated the hook.
		 * @param string $message     Optional. A message regarding the change. Default null.
		 */
		do_action( 'makeplus_deprecated_hook_run', $hook, $version, $message );

		$error_code = 'makeplus_deprecated_hook';

		if ( is_null( $message ) ) {
			$message = __( 'No alternative is available.', 'make-plus' );
		}

		$error_message = sprintf(
			__( 'The <strong>%1$s</strong> hook is deprecated since version %2$s of Make Plus. %3$s', 'make-plus' ),
			$hook,
			$version,
			$message
		);

		// Use Make's error API
		if ( $this->mode()->has_make_api() ) {
			Make()->error()->add_error( $error_code, $error_message );
		}
		// Trigger a PHP error
		else {
			trigger_error( $error_message );
		}
	}

	/**
	 * Mark something as being incorrectly called.
	 *
	 * Based on _doing_it_wrong() in WordPress core.
	 *
	 * @since 1.7.0.
	 *
	 * @param string $function  The function that was called.
	 * @param string $message   A message explaining what has been done incorrectly.
	 * @param string $version   Optional. The version of WordPress where the message was added.
	 * @param bool   $backtrace Optional. True to include a backtrace in the error message.
	 *
	 * @return void
	 */
	public function doing_it_wrong( $function, $message, $version = null, $backtrace = true ) {
		/**
		 * Fires when the given function is being used incorrectly.
		 *
		 * @since 1.7.0.
		 *
		 * @param string $function The function that was called.
		 * @param string $message  A message explaining what has been done incorrectly.
		 * @param string $version  The version of Make where the message was added.
		 */
		do_action( 'makeplus_doing_it_wrong_run', $function, $message, $version );

		$error_code = 'makeplus_doing_it_wrong';

		// Add a version.
		if ( ! is_null( $version ) ) {
			$message = sprintf(
				__( '%1$s (This message was added in version %2$s.)', 'make-plus' ),
				$message,
				$version
			);
		}

		$error_message = sprintf(
			__( '<strong>%1$s</strong> was called incorrectly. %2$s', 'make-plus' ),
			$function,
			$message
		);

		// Use Make's error API
		if ( $this->mode()->has_make_api() ) {
			// Add a backtrace.
			if ( $backtrace ) {
				$error_message .= Make()->error()->generate_backtrace( array( get_class( $this ) ) );
			}

			// Add the error.
			Make()->error()->add_error( $error_code, $error_message );
		}
		// Trigger a PHP error
		else {
			trigger_error( $error_message );
		}
	}
}