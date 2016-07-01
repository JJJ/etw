<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Setup_Mode
 *
 * Methods for determining which parts of the plugin can be activated.
 *
 * @since 1.7.0.
 */
class MAKEPLUS_Setup_Mode implements MAKEPLUS_Setup_ModeInterface {
	/**
	 * Run the tests to determine the plugin mode and return the mode name.
	 *
	 * @since 1.7.0.
	 *
	 * @return string
	 */
	public function get_mode() {
		if (
			$this->is_make_active_theme()
			&&
			$this->has_make_api()
		) {
			return 'active';
		} else {
			return 'passive';
		}
	}

	/**
	 * Determine if Make is the active theme.
	 *
	 * @since 1.7.0.
	 *
	 * @return bool
	 */
	public function is_make_active_theme() {
		return ( 'make' === strtolower( get_template() ) || defined( 'TTFMAKE_VERSION' ) );
	}

	/**
	 * Get the version of Make currently being used.
	 *
	 * @since 1.7.0.
	 *
	 * @return string
	 */
	public function get_make_version() {
		if ( $this->is_make_active_theme() ) {
			if ( defined( 'TTFMAKE_VERSION' ) ) {
				return TTFMAKE_VERSION;
			}
		}

		return '';
	}

	/**
	 * Determine if the global Make API object exists (introduced in Make 1.7.0).
	 *
	 * @since 1.7.0.
	 *
	 * @return bool
	 */
	public function has_make_api() {
		return ( function_exists( 'Make' ) && Make() instanceof MAKE_APIInterface );
	}

	/**
	 * Determine if a plugin is active from it's file path relative to the plugins directory.
	 *
	 * @since 1.7.0.
	 *
	 * @param string $plugin_relative_path
	 *
	 * @return bool
	 */
	public function is_plugin_active( $plugin_relative_path ) {
		$is_active = false;

		if ( is_multisite() ) {
			$active_network_plugins = (array) get_site_option( 'active_sitewide_plugins' );
			if ( isset( $active_network_plugins[ $plugin_relative_path ] ) ) {
				$is_active = true;
			}
		} else {
			$active_plugins = (array) get_option( 'active_plugins' );
			if ( in_array( $plugin_relative_path, $active_plugins ) ) {
				$is_active = true;
			}
		}

		return $is_active;
	}
}