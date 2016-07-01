<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_Builder_Enhancement_SectionID
 * 
 * Add a Section ID configuration setting to all Builder sections.
 *
 * @since 1.6.0.
 * @since 1.7.0. Moved to a separate class.
 */
final class MAKEPLUS_Component_Builder_Enhancement_SectionID implements MAKEPLUS_Util_HookInterface {
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

		// Add custom html id to sections
		add_filter( 'make_section_html_id', array( $this, 'add_section_html_id' ), 10, 2 );

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
	 * "Section HTML ID" control.
	 *
	 * @since 1.6.0.
	 *
	 * @hooked filter make_add_section
	 *
	 * @param array $args    The section args.
	 *
	 * @return array         The modified section args.
	 */
	public function modify_section( $args ) {
		// Bail if Make doesn't have the required method
		if ( ! method_exists( 'TTFMAKE_Builder_Save', 'section_html_id' ) ) {
			return $args;
		}

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
				'type'    => 'text',
				'label'   => __( 'Section HTML id', 'make-plus' ),
				'name'    => 'section-html-id',
				'default' => '',
				'class'   => 'monospace',
			)
		);

		// Add control to config
		$args['config'] = array_merge( $args['config'], $new_control );

		// Return
		return $args;
	}

	/**
	 * Sanitize the 'section-html-id' section option.
	 *
	 * @since 1.6.0.
	 *
	 * @hooked filter make_prepare_data_section
	 *
	 * @param array $clean_data       The section data that has already been sanitized.
	 * @param array $original_data    The original unsanitized section data.
	 *
	 * @return array                  The amended array of sanitized section data.
	 */
	public function save_data( $clean_data, $original_data ) {
		if ( isset( $original_data['section-html-id'] ) ) {
			$clean_data['section-html-id'] = sanitize_key( $original_data['section-html-id'] );
		}

		return $clean_data;
	}

	/**
	 * Filter the section html ID to replace it with a custom user-specified one.
	 *
	 * @since 1.6.0.
	 *
	 * @param string $id              The HTML id attribute for a particular section.
	 * @param array  $section_data    The stored data for a particular section.
	 *
	 * @return string                 The modified id.
	 */
	public function add_section_html_id( $id, $section_data ) {
		if ( isset( $section_data['section-html-id'] ) && ! empty( $section_data['section-html-id'] ) ) {
			$id = sanitize_key( $section_data['section-html-id'] );
		}

		return $id;
	}
}