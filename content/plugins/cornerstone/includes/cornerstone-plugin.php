<?php

class Cornerstone_Plugin extends Cornerstone_Plugin_Base {

	public static $instance;
	protected $init_priority = -1000;

	/**
	 * Common Component Accessor
	 * @return object reference to Cornerstone_Common instance
	 */
	public function common() {
		return $this->component( 'Common' );
	}

	/**
	 * Shortcut to getting javascript asset URLs.
	 * @param  string asset name. For example: "admin/builder"
	 * @return string URL to asset
	 */
	public function js( $asset ) {
		return $this->versioned_url( "assets/dist/js/$asset", 'js');
	}

	/**
	 * Shortcut to getting css asset URLs.
	 * @param  string asset name. For example: "admin/builder"
	 * @return string URL to asset
	 */
	public function css( $asset ) {
		return $this->versioned_url( "assets/dist/css/$asset", 'css' );
	}

	public function versioned_url( $asset, $ext ) {

		// Return matching asset rev file if it exists
		if ( defined('CS_ASSET_REV') && CS_ASSET_REV ) {
			$rev = CS_ASSET_REV;
			$path = "$asset.$rev.$ext";
			$filename = $this->path( $path );
			if (file_exists($filename)) {
				return array(
					'asset_rev' => true,
					'url' => $this->url($path),
					'version' => null
				);
			}
		}

		// Return a unversioned file if it exists
		$basepath = $this->path($asset);
		$unversioned = "$basepath.$ext";
		$version = defined('CS_APP_BUILD_TOOLS') && CS_APP_BUILD_TOOLS ? time() : null;

		if (file_exists($unversioned)) {
			return array(
				'unversioned' => true,
				'url' => $this->url("$asset.$ext"),
				'version' => $version
			);
		}

		// Try to detect a versioned file that wasn't declared
		$files = glob("$basepath.*.$ext", GLOB_NOSORT);

		if (count($files) > 0) {

			$urlpath = dirname($asset);
			$filename = basename($files[0]);

			return array(
				'versioned' => true,
				'url' => $this->url("$urlpath/$filename"),
				'version' => $version
			);
		}

		// If we can't find anything, return a fallback to the exact requested URL even though it will 404
		return array(
			'not_found' => true,
			'url' => $this->url("$asset.$ext"),
			'version' => $this->version()
		);

	}

	/**
	 * Get array of Cornerstone settings with defaults applied
	 * @return array
	 */
	public function settings() {
		return wp_parse_args( get_option( 'cornerstone_settings', array() ), $this->config_group( 'common/default-settings' ) );
	}

	/**
	 * Return plugin instance.
	 * @return object  Singleton instance
	 */
	public static function instance() {
		return ( isset( self::$instance ) ) ? self::$instance : false;
	}

	/**
	 * Run immediately after object instantiation, before anything else is loaded.
	 * @return void
	 */
	public function preinitBefore() {

		// Register class autoloader
    $classes = glob( self::$instance->path( 'includes/classes' ) . '/*' );
    $classic_classes = glob( self::$instance->path( 'includes/classes/classic' ) . '/*' );
    $this->autoload_directories = array_merge( $classes, $classic_classes );
		spl_autoload_register( array( __CLASS__, 'autoloader' ) );

    add_action( 'cornerstone_updated', array( $this, 'update' ) );
	}

	public function update( $prior ) {

		/**
		 * Run if coming from a version prior to Before 1.0.7
		 * if ( version_compare( $prior, '1.0.7', '<' ) ) {
		 * }
		 */

    // if ( ! is_null( $prior ) ) {
    //
    // }

    CS()->component('Cleanup')->clean_generated_styles();

	}

	/**
	 * Cornerstone class autoloader.
	 * @param  string $class_name
	 * @return void
	 */
	public static function autoloader( $class_name ) {

		if ( false === strpos( $class_name, self::$instance->name ) ) {
			return;
		}

		$class = str_replace( self::$instance->name . '_', '', $class_name );
		$file = 'class-' . str_replace( '_', '-', strtolower( $class ) ) . '.php';

		foreach ( self::$instance->autoload_directories as $directory ) {

			$path = $directory . '/' . $file;

			if ( ! file_exists( $path ) ) {
				continue;
			}

			require_once( $path );

		}

	}

}


/**
 * Access Cornerstone without a global variable
 * @return object  main Cornerstone instance.
 */
function CS() {
	return Cornerstone_Plugin::instance();
}
