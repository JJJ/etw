<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_Builder_Enhancement_SectionClasses
 *
 * Add a Section Classes configuration setting to all Builder sections.
 *
 * @since 1.6.0.
 * @since 1.7.0. Moved to a separate class.
 */
final class MAKEPLUS_Component_Builder_Enhancement_SectionClasses implements MAKEPLUS_Util_HookInterface {
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

		// Add custom classes to sections
		add_filter( 'make_section_classes', array( $this, 'add_section_classes' ), 10, 2 );

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
	 * "Section HTML classes" control.
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
				'label'   => __( 'Section HTML classes', 'make-plus' ),
				'name'    => 'section-classes',
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
	 * Sanitize the 'section-classes' section option.
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
		if ( isset( $original_data['section-classes'] ) ) {
			$clean_data['section-classes'] = $this->sanitize_classes( $original_data['section-classes'] );
		}

		return $clean_data;
	}

	/**
	 * Sanitize a space-separated list of HTML classes.
	 *
	 * @since 1.6.0.
	 *
	 * @param string $original_classes    Space-separated list of classes.
	 *
	 * @return string                     Sanitized classes.
	 */
	private function sanitize_classes( $original_classes ) {
		$classes = explode( ' ', $original_classes );
		$clean_classes = array_map( 'sanitize_key', $classes );

		return implode( ' ', $clean_classes );
	}

	/**
	 * Filter the section classes to add custom user-specified ones.
	 *
	 * @since 1.6.0.
	 *
	 * @param string $classes         The space-separated list of classes for a particular section.
	 * @param array  $section_data    The stored data for a particular section.
	 *
	 * @return string                 The modified list of classes.
	 */
	public function add_section_classes( $classes, $section_data ) {
		if ( isset( $section_data['section-classes'] ) && ! empty( $section_data['section-classes'] ) ) {
			$new_classes = $this->sanitize_classes( $section_data['section-classes'] );
			$classes .= " $new_classes";
		}

		return $classes;
	}
}