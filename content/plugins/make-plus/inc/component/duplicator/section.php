<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_Duplicator_Section
 *
 * Enable duplication of individual Builder sections.
 *
 * @since 1.2.0.
 * @since 1.7.0. Changed class name from TTFMP_Section_Duplicator.
 */
class MAKEPLUS_Component_Duplicator_Section implements MAKEPLUS_Util_HookInterface {
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

		// Add necessary scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

		// Add a duplicate link
		add_filter( 'make_builder_section_links', array( $this, 'builder_section_footer_links' ) );

		// Add callback for AJAX function
		add_action( 'wp_ajax_ttf_duplicate_section', array( $this, 'duplicate_section' ) );

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
	 * Enqueue the JS and CSS for the admin.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action admin_enqueue_scripts
	 *
	 * @param string $hook_suffix    The suffix for the screen.
	 *
	 * @return void
	 */
	public function admin_enqueue_scripts( $hook_suffix ) {
		// Only load resources if they are needed on the current page
		if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) || 'page' !== get_post_type() ) {
			return;
		}

		wp_enqueue_script(
			'ttfmp-duplicate-section-utils',
			makeplus_get_plugin_directory_uri() . 'js/duplicator/utils.js',
			array(
				'jquery',
				'ttfmake-builder',
			),
			MAKEPLUS_VERSION,
			true
		);

		wp_enqueue_script(
			'ttfmp-duplicate-section',
			makeplus_get_plugin_directory_uri() . 'js/duplicator/section.js',
			array(
				'jquery',
				'ttfmake-builder',
				'ttfmp-duplicate-section-utils',
			),
			MAKEPLUS_VERSION,
			true
		);

		wp_localize_script(
			'ttfmp-duplicate-section',
			'ttfmpDuplicateSection',
			array(
				'nonce'        => wp_create_nonce( 'duplicate' ),
				'defaultError' => esc_html__( 'An unexpected error occurred.', 'make-plus' ),
			)
		);

		wp_enqueue_style(
			'ttfmp-duplicate-section',
			makeplus_get_plugin_directory_uri() . 'css/duplicator/section.css',
			array(),
			MAKEPLUS_VERSION
		);
	}

	/**
	 * Add a link to duplicate the section.
	 *
	 * @since 1.2.0.
	 *
	 * @hooked filter make_builder_section_links
	 *
	 * @param array $links    The existing links.
	 *
	 * @return array          The new links.
	 */
	public function builder_section_footer_links( $links ) {
		// Add the duplicate link
		$links[60] = array(
			'class' => 'ttfmp-duplicate-section',
			'href'  => '#',
			'label' => __( 'Duplicate', 'make-plus' ),
			'title' => __( 'Duplicate section', 'make-plus' ),
		);

		return $links;
	}

	/**
	 * AJAX callback function for generating a duplicated section.
	 *
	 * @since 1.2.0.
	 *
	 * @hooked action wp_ajax_ttf_duplicate_section
	 *
	 * @return void
	 */
	public function duplicate_section() {
		// Only run this during an Ajax request.
		if ( 'wp_ajax_ttf_duplicate_section' !== current_action() ) {
			return;
		}

		if ( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'duplicate' ) ) {
			if ( isset( $_POST['data'] ) && isset( $_POST['sectionType'] ) && isset( $_POST['id'] ) ) {
				$id = $_POST['id'];
				$section_type = $_POST['sectionType'];

				parse_str( $_POST['data'], $data );

				if ( isset( $data['ttfmake-section'][ $id ] ) ) {
					$sections = ttfmake_get_sections();
					$section = $sections[ $section_type ];
					$parent_id = $incrementor = time();

					// Sanitize all of the data
					$data = ttfmake_get_builder_save()->prepare_data( $data['ttfmake-section'], $data['ttfmake-section-order'] );

					// Update the duplicated sections ID to make it unique
					$data[ $parent_id ] = $data[ $id ];
					unset( $data[ $id ] );
					$data[ $parent_id ]['id'] = $parent_id;

					$id = $parent_id;

					array_walk_recursive( $data, array( $this, 'recursive_stripslashes' ) );

					// Update the banner slide IDs to something unique
					if ( isset( $data[ $id ]['banner-slide-order'] ) ) {
						$new_banner_slides      = array();
						$new_banner_slide_order = array();

						foreach ( $data[ $id ]['banner-slide-order'] as $slide_id ) {
							if ( isset( $data[ $id ]['banner-slides'][ $slide_id ] ) ) {
								// Create a unique ID for the slide
								$incrementor++;

								// Add the new ID to the order collector
								$new_banner_slide_order[] = $incrementor;

								// Append the slide to the collector with the new ID
								$new_banner_slides[ $incrementor ] = $data[ $id ]['banner-slides'][ $slide_id ];
							}
						}

						// Set the collectors to the data array
						$data[ $id ]['banner-slides']      = $new_banner_slides;
						$data[ $id ]['banner-slide-order'] = $new_banner_slide_order;
					}

					if ( isset( $data[ $id ]['gallery-item-order'] ) ) {
						$new_gallery_items      = array();
						$new_gallery_item_order = array();

						foreach ( $data[ $id ]['gallery-item-order'] as $item_id ) {
							if ( isset( $data[ $id ]['gallery-items'][ $item_id ] ) ) {
								// Create a unique ID for the slide
								$incrementor++;

								// Add the new ID to the order collector
								$new_gallery_item_order[] = $incrementor;

								// Append the gallery item to the collector with the new ID
								$new_gallery_items[ $incrementor ] = $data[ $id ]['gallery-items'][ $item_id ];
							}
						}

						// Set the collectors to the data array
						$data[ $id ]['gallery-items']      = $new_gallery_items;
						$data[ $id ]['gallery-item-order'] = $new_gallery_item_order;
					}

					// Panels section
					if ( isset( $data[ $id ]['item-order'] ) && 'panels' === $section_type ) {
						$new_items      = array();
						$new_item_order = array();

						foreach ( $data[ $id ]['item-order'] as $item_id ) {
							if ( isset( $data[ $id ]['panels-items'][ $item_id ] ) ) {
								// Create a unique ID for the slide
								$incrementor++;

								// Add the new ID to the order collector
								$new_item_order[] = $incrementor;

								// Append the item to the collector with the new ID
								$new_items[ $incrementor ] = $data[ $id ]['panels-items'][ $item_id ];
							}
						}

						// Set the collectors to the data array
						$data[ $id ]['panels-items'] = $new_items;
						$data[ $id ]['item-order']   = $new_item_order;
					}

					// Append "(Copy)" to widget area labels
					if ( isset( $data[ $id ]['columns'] ) && is_array( $data[ $id ]['columns'] ) ) {
						foreach ( $data[ $id ]['columns'] as $key => $column ) {
							if ( isset( $column['widget-area'] ) && 1 === (int) $column['widget-area'] && isset( $column['sidebar-label'] ) ) {
								$data[ $id ]['columns'][ $key ]['sidebar-label'] .= ' ' . __( '(Copy)', 'make-plus' );
								$data[ $id ]['columns'][ $key ]['sidebar-label'] = trim( $data[ $id ]['columns'][ $key ]['sidebar-label'] );
							}
						}
					}

					// Append "(Copy)" to the section title
					$data[ $id ]['label'] .= ' ' . __( '(Copy)', 'make-plus' );

					ob_start();
					ttfmake_get_builder_base()->load_section( $section, $data[ $id ] );
					$html = ob_get_clean();

					wp_send_json_success( array(
						'result'  => 'success',
						'section' => trim( $html ),
					) );
				}
			} else {
				wp_send_json_error( array(
					'result'  => 'error',
					'message' => esc_html__( 'An unexpected error occurred.', 'make-plus' ),
				) );
			}
		}

		wp_send_json_error( array(
			'result'  => 'error',
			'message' => esc_html__( 'An unexpected error occurred.', 'make-plus' ),
		) );
	}

	/**
	 * Remove slashes from each value in a multidimensional array.
	 *
	 * Used as a callback for array_walk_recursive().
	 *
	 * @since 1.2.0.
	 *
	 * @param string $item    Current array value item to process.
	 * @param string $key     Current array key to process.
	 *                        
	 * @return void
	 */
	private function recursive_stripslashes( &$item, $key ) {
		$item = stripslashes( $item );
	}
}