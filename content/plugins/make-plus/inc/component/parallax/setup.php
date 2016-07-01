<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_Parallax_Setup
 *
 * Enable a parallax effect for section background images in the Builder.
 *
 * @since 1.6.1
 * @since 1.7.0 Changed class name from TTFMP_Parallax.
 */
final class MAKEPLUS_Component_Parallax_Setup implements MAKEPLUS_Util_HookInterface {
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

		// Add Builder input
		add_filter( 'make_add_section', array( $this, 'add_input' ) );

		// Add input save routine
		add_filter( 'make_prepare_data_section', array( $this, 'save_input' ), 10, 2 );

		// Add section class
		add_filter( 'make_section_classes', array( $this, 'add_class' ), 10, 2 );

		// Front end script
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );

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
	 * Add the 'Enable parallax' checkbox to section configuration overlays.
	 *
	 * Only add it if the section supports a background image.
	 *
	 * @since 1.6.1.
	 *
	 * @hooked filter make_add_section
	 *
	 * @param array $args    The arguments defining the section.
	 *
	 * @return array         The modified arguments defining the section.
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
	 * @hooked filter make_prepare_data_section
	 *
	 * @param array $clean_data       The section data that has already been sanitized.
	 * @param array $original_data    The original unsanitized section data.
	 *
	 * @return array                  The amended array of sanitized section data.
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
	 * @hooked filter make_section_classes
	 *
	 * @param string $classes         The space-separated list of classes for a particular section.
	 * @param array  $section_data    The stored data for a particular section.
	 *
	 * @return string                 The modified list of classes.
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
	 * @hooked action wp_enqueue_scripts
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
					'stellar',
					makeplus_get_plugin_directory_uri() . 'js/parallax/lib/jquery.stellar.min.js',
					array( 'jquery' ),
					'0.6.2',
					true
				);

				// Initializer
				wp_enqueue_script(
					'makeplus-parallax-frontend',
					makeplus_get_plugin_directory_uri() . 'js/parallax/frontend.js',
					array( 'stellar' ),
					MAKEPLUS_VERSION,
					true
				);

				/**
				 * Filter: Modify the frontend JS configuration for the Parallax feature.
				 *
				 * See: https://github.com/markdalgleish/stellar.js/blob/master/README.md#configuring-everything
				 *
				 * @since 1.6.1
				 *
				 * @param array $config    The array of configuration options.
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
					'makeplus-parallax-frontend',
					'MakePlusParallax',
					$config
				);
			}
		}
	}
}