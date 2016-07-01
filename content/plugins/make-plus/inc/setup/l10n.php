<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Setup_L10n
 *
 * Methods for loading text domains.
 *
 * @since 1.7.0.
 */
final class MAKEPLUS_Setup_L10n implements MAKEPLUS_Setup_L10nInterface, MAKEPLUS_Util_HookInterface {
	/**
	 * The text domain for the plugin.
	 *
	 * @since 1.7.0.
	 *
	 * @var string
	 */
	private $domain = 'make-plus';

	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @var bool
	 */
	private static $hooked = false;

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

		// Filter to increase flexibility of .mo file location.
		add_filter( 'load_textdomain_mofile', array( $this, 'mofile_path' ), 10, 2 );

		// Load translation file.
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ), 20 );

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
	 * Search for a file, first in a child theme, and then in the plugin.
	 *
	 * @since 1.7.0.
	 *
	 * @param array $file_names
	 *
	 * @return string
	 */
	private function locate_file( array $file_names ) {
		$located = '';

		foreach ( $file_names as $file ) {
			// Look in a child theme first.
			if ( is_readable( get_stylesheet_directory() . '/' . $file ) ) {
				$located = get_stylesheet_directory() . '/' . $file;
				break;
			}
			// Then look in the plugin.
			else if ( is_readable( makeplus_get_plugin_directory() . $file ) ) {
				$located = makeplus_get_plugin_directory() . $file;
				break;
			}
		}

		return $located;
	}

	/**
	 * Get the preferred path of a given .mo file.
	 *
	 * Filters the .mo file path so that child themes can include plugin .mo files that won't
	 * be overwritten when the plugin is updated.
	 *
	 * If the child theme is including a plugin .mo file, the file names should be prefixed with the domain, e.g. make-plus-en_US.mo
	 *
	 * @link https://github.com/justintadlock/hybrid-core/blob/7bc900fd5635c9fcdde3c3b240c4ec43a0704ccf/inc/functions-i18n.php#L218-L249
	 *
	 * @since 1.7.0.
	 *
	 * @hooked filter load_textdomain_mofile
	 *
	 * @param $mofile
	 * @param $domain
	 *
	 * @return string
	 */
	public function mofile_path( $mofile, $domain ) {
		if ( $this->domain === $domain ) {
			$locale = get_locale();

			// Get the relative path for the mofile
			$mofile_short = str_replace( makeplus_get_plugin_directory(), '', $mofile );
			$mofile_short = str_replace( "{$locale}.mo", "{$domain}-{$locale}.mo", $mofile_short );

			// Attempt to find the correct mofile.
			$locate_mofile = $this->locate_file( array( $mofile_short ) );

			// Return the mofile.
			return $locate_mofile ? $locate_mofile : $mofile;
		}

		return $mofile;
	}

	/**
	 * Load translation strings for the plugin.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action plugins_loaded
	 *
	 * @return bool
	 */
	public function load_textdomain() {
		return load_plugin_textdomain( $this->domain, false, makeplus_get_plugin_directory( true ) . 'languages' );
	}
}