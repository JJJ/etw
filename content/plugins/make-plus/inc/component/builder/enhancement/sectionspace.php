<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_Builder_Enhancement_SectionSpace
 *
 * Add a configuration setting to all Builder sections to remove the extra spacing below the section.
 *
 * @since 1.5.1.
 * @since 1.7.0. Moved to a separate class.
 */
class MAKEPLUS_Component_Builder_Enhancement_SectionSpace implements MAKEPLUS_Util_HookInterface {
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

		// Modify sections
		add_filter( 'make_add_section', array( $this, 'modify_section' ), 20 );

		// Hook up save routine
		add_filter( 'make_prepare_data_section', array( $this, 'save_data' ), 20, 2 );

		// Render the "Remove space below section" option on the front end
		add_action( 'template_redirect', array( $this, 'render_remove_space' ) );

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
	 * Add a new control definition to a section's config array for the
	 * "Remove space after section" control.
	 *
	 * @since 1.5.1.
	 *
	 * @hooked filter make_add_section
	 *
	 * @param array $args    The section args.
	 *
	 * @return array         The modified section args.
	 */
	public function modify_section( $args ) {
		$controls = $args['config'];

		// Get the last priority of existing section controls
		if ( ! empty( $controls ) ) {
			$priorities = array_keys( $controls );
			sort( $priorities );
			$last_priority = (int) array_pop( $priorities );
		} else {
			$last_priority = 0;
		}

		// New priority
		$new_priority = $last_priority + 100;

		// Define new control
		$new_control = array(
			$new_priority => array(
				'type'    => 'checkbox',
				'label'   => __( 'Remove space below section', 'make-plus' ),
				'name'    => 'remove-space-below',
				'default' => 0
			)
		);

		// Add control to config
		$args['config'] = array_merge( $args['config'], $new_control );

		// Return
		return $args;
	}

	/**
	 * Sanitize the 'remove-space-below' section option.
	 *
	 * @since 1.5.1.
	 *
	 * @hooked filter make_prepare_data_section
	 *
	 * @param array $clean_data       The section data that has already been sanitized.
	 * @param array $original_data    The original unsanitized section data.
	 *
	 * @return array                  The amended array of sanitized section data.
	 */
	public function save_data( $clean_data, $original_data ) {
		if ( isset( $original_data['remove-space-below'] ) ) {
			$clean_data['remove-space-below'] = wp_validate_boolean( $original_data['remove-space-below'] );
		}

		return $clean_data;
	}

	/**
	 * Wrapper to add a CSS renderer for each Builder section's CSS hook.
	 *
	 * Determines the section types that are present on the current page and hooks
	 * the actual CSS function to each 'make_builder_' . $type . '_css' hook.
	 *
	 * @since 1.5.1.
	 *
	 * @return void
	 */
	public function render_remove_space() {
		if ( ! ttfmake_is_builder_page() ) {
			return;
		}

		// Get the available section types
		global $post;
		$sections = ttfmake_get_section_data( $post->ID );
		$section_types = wp_list_pluck( $sections, 'section-type' );
		sort( $section_types );
		$section_types = array_unique( $section_types );

		foreach ( $section_types as $type ) {
			add_action( 'make_builder_' . $type . '_css', array( $this, 'remove_space_css' ), 10, 3 );
		}
	}

	/**
	 * Add a CSS rule for a section to remove its bottom margin.
	 *
	 * @since 1.5.1.
	 *
	 * @param array                       $data     The section's option data.
	 * @param string                      $id       The section's unique ID.
	 * @param MAKE_Style_ManagerInterface $style    The theme's style object.
	 *
	 * @return void
	 */
	public function remove_space_css( $data, $id, MAKE_Style_ManagerInterface $style ) {
		if ( isset( $data['remove-space-below'] ) && 1 === absint( $data['remove-space-below'] ) ) {
			$prefix = 'builder-section-';
			$id = sanitize_key( $data['id'] );
			
			/** This filter is documented in Make, inc/builder/core/save.php */
			$section_id = apply_filters( 'make_section_html_id', $prefix . $id, $data );

			$style->css()->add( array(
				'selectors'    => array( '#' . esc_attr( $section_id ) ),
				'declarations' => array(
					'margin-bottom' => 0
				),
			) );
		}
	}
}