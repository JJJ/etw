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
	public function js( $asset, $app = false ) {
    $app = ( $app ) ? '-app' : '';
		return $this->url( "assets/dist$app/js/$asset" . $this->component( 'Common' )->jsSuffix() );
	}

	/**
	 * Shortcut to getting css asset URLs.
	 * @param  string asset name. For example: "admin/builder"
	 * @return string URL to asset
	 */
	public function css( $asset, $app = false ) {
    $app = ( $app ) ? '-app' : '';
		return $this->url( "assets/dist$app/css/$asset.css" );
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

    CS()->loadComponent('Cleanup')->clean_generated_styles();

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
