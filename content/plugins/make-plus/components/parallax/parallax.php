<?php
/**
 * @package Make Plus
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class TTFMP_Parallax
 *
 * Class to initialize the Parallax module, load files, and hook into WordPress.
 *
 * @since 1.6.1.
 */
class TTFMP_Parallax {
	/**
	 * Name of the component.
	 *
	 * @since 1.6.1.
	 *
	 * @var   string    The name of the component.
	 */
	var $component_slug = 'parallax';

	/**
	 * Path to the component directory (e.g., /var/www/mysite/wp-content/plugins/make-plus/components/my-component).
	 *
	 * @since 1.6.1.
	 *
	 * @var   string    Path to the component directory
	 */
	var $component_root = '';

	/**
	 * File path to the plugin main file (e.g., /var/www/mysite/wp-content/plugins/make-plus/components/my-component/my-component.php).
	 *
	 * @since 1.6.1.
	 *
	 * @var   string    Path to the plugin's main file.
	 */
	var $file_path = '';

	/**
	 * The URI base for the plugin (e.g., http://example.com/wp-content/plugins/make-plus/my-component).
	 *
	 * @since 1.6.1.
	 *
	 * @var   string    The URI base for the plugin.
	 */
	var $url_base = '';

	/**
	 * Array of other objects for the module.
	 *
	 * @since 1.6.1.
	 *
	 * @var    array    Array of other objects for the module.
	 */
	var $components = array();

	/**
	 * Set the class properties.
	 *
	 * @since 1.6.1.
	 *
	 * @return TTFMP_Parallax
	 */
	public function __construct() {
		// Set the main paths for the component
		$this->component_root = ttfmp_get_app()->component_base . '/' . $this->component_slug;
		$this->file_path      = $this->component_root . '/' . basename( __FILE__ );
		$this->url_base       = untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Hook into WordPress.
	 *
	 * @since 1.6.1.
	 *
	 * @return void
	 */
	public function init() {
		//
		add_filter( 'make_add_section', array( $this, 'add_input' ) );

		//
		add_filter( 'make_prepare_data_section', array( $this, 'save_input' ), 10, 2 );

		//
		add_filter( 'make_section_classes', array( $this, 'add_class' ), 10, 2 );

		//
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
	}

	/**
	 * Add the 'Enable parallax' checkbox to section configuration overlays.
	 *
	 * Only add it if the section supports a background image.
	 *
	 * @param  array    $args    The arguments defining the section.
	 *
	 * @return array             The modified arguments defining the section.
	 */
	public function add_input( $args ) {
		if ( isset( $args['config'] ) && is_array( $args['config'] ) ) {
			$names = wp_list_pluck( $args['config'], 'name' );
			if ( $priority = array_search( 'background-image', $names ) ) {
				$new_priority = $priority + 10;
				$args['config'][ $new_priority ] = array(
					'type'    => 'checkbox',
					'label'   => __( 'Enable parallax background effect', 'make-plus' ),
					'name'    => 'parallax-enable',
					'default' => 0,
				);
				ksort( $args['config'] );
			}
		}

		return $args;
	}

	/**
	 * Sanitize the 'parallax-enable' option.
	 *
	 * @since 1.6.1.
	 *
	 * @param  array    $clean_data       The section data that has already been sanitized.
	 * @param  array    $original_data    The original unsanitized section data.
	 *
	 * @return array                      The amended array of sanitized section data.
	 */
	public function save_input( $clean_data, $original_data ) {
		if ( isset( $original_data['parallax-enable'] ) ) {
			$clean_data['parallax-enable'] = absint( $original_data['parallax-enable'] );
		}

		return $clean_data;
	}

	/**
	 * Filter the section classes to add a parallax class if necessary.
	 *
	 * @since 1.6.1.
	 *
	 * @param  string    $classes         The space-separated list of classes for a particular section.
	 * @param  array     $section_data    The stored data for a particular section.
	 *
	 * @return string                     The modified list of classes.
	 */
	public function add_class( $classes, $section_data ) {
		if ( isset( $section_data['parallax-enable'] ) && 1 === $section_data['parallax-enable'] ) {
			$classes .= ' parallax';
		}

		return $classes;
	}

	/**
	 * Enqueue frontend scripts for Parallax if there is a section with it enabled.
	 *
	 * @since 1.6.1.
	 *
	 * @return void
	 */
	public function frontend_scripts() {
		if ( function_exists( 'ttfmake_is_builder_page' ) && ttfmake_is_builder_page() ) {
			$has_parallax = false;
			$sections = ttfmake_get_section_data( get_the_ID() );
			foreach ( $sections as $section_id => $data ) {
				if ( isset( $data['parallax-enable'] ) && 1 === absint( $data['parallax-enable'] ) ) {
					$has_parallax = true;
					break;
				}
			}

			// Only enqueue if parallax is enabled on at least one section
			if ( true === $has_parallax ) {
				// Stellar.js library
				wp_enqueue_script(
					'ttfmp-stellar',
					$this->url_base . '/js/lib/jquery.stellar.min.js',
					array( 'jquery' ),
					ttfmp_get_app()->version,
					true
				);

				// Initializer
				wp_enqueue_script(
					'ttfmp-parallax-frontend',
					$this->url_base . '/js/frontend.js',
					array( 'ttfmp-stellar' ),
					ttfmp_get_app()->version,
					true
				);

				/**
				 * Filter to access the frontend JS configuration for the Parallax feature.
				 *
				 * See: https://github.com/markdalgleish/stellar.js/blob/master/README.md#configuring-everything
				 *
				 * @since 1.6.1
				 *
				 * @param array $config The array of configuration options.
				 */
				$config = apply_filters( 'ttfmp_parallax_js_config', array(
					'backgroundRatio' => 0.3,
					'stellarConfig'   => array(
						'horizontalScrolling' => false,
						'parallaxElements'    => false,
					)
				) );
				$config['stellarConfig'] = json_encode( $config['stellarConfig'] );

				// Add JS data
				wp_localize_script(
					'ttfmp-parallax-frontend',
					'ttfmpParallax',
					$config
				);
			}
		}
	}
}

$ttfmp_parallax = new TTFMP_Parallax;
$ttfmp_parallax->init();