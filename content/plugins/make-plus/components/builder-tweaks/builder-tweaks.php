<?php
/**
 * @package Make Plus
 */

/**
 * Class TTFMP_Builder_Tweaks
 */
class TTFMP_Builder_Tweaks {
	/**
	 * Name of the component.
	 *
	 * @since 1.5.1.
	 *
	 * @var   string    The name of the component.
	 */
	var $component_slug = 'builder-tweaks';

	/**
	 * Path to the component directory (e.g., /var/www/mysite/wp-content/plugins/make-plus/components/my-component).
	 *
	 * @since 1.5.1.
	 *
	 * @var   string    Path to the component directory
	 */
	var $component_root = '';

	/**
	 * File path to the plugin main file (e.g., /var/www/mysite/wp-content/plugins/make-plus/components/my-component/my-component.php).
	 *
	 * @since 1.5.1.
	 *
	 * @var   string    Path to the plugin's main file.
	 */
	var $file_path = '';

	/**
	 * The URI base for the plugin (e.g., http://example.com/wp-content/plugins/make-plus/my-component).
	 *
	 * @since 1.5.1.
	 *
	 * @var   string    The URI base for the plugin.
	 */
	var $url_base = '';

	/**
	 * The one instance of TTFMP_Builder_Tweaks.
	 *
	 * @since 1.5.1.
	 *
	 * @var   TTFMP_Builder_Tweaks
	 */
	private static $instance;

	/**
	 * Instantiate or return the one TTFMP_Builder_Tweaks instance.
	 *
	 * @since  1.5.1.
	 *
	 * @return TTFMP_Builder_Tweaks
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 *
	 */
	public function __construct() {
		// Set the main paths for the component
		$this->component_root = ttfmp_get_app()->component_base . '/' . $this->component_slug;
		$this->file_path      = $this->component_root . '/' . basename( __FILE__ );
		$this->url_base       = untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Hook up actions and filters.
	 *
	 * @since 1.5.1.
	 *
	 * @return void
	 */
	public function init() {
		// Modify sections
		add_filter( 'make_add_section', array( $this, 'modify_section' ), 20 );

		// Hook up save routines
		add_filter( 'make_prepare_data_section', array( $this, 'save_data' ), 20, 3 );

		// Add custom html id to sections
		add_filter( 'make_section_html_id', array( $this, 'add_section_html_id' ), 10, 2 );

		// Add custom classes to sections
		add_filter( 'make_section_classes', array( $this, 'add_section_classes' ), 10, 2 );

		// Render the "Remove space below section" option on the front end
		add_action( 'template_redirect', array( $this, 'render_remove_space' ) );
	}

	/**
	 * Container for functions that filter the make_add_section hook.
	 *
	 * @since 1.5.1.
	 *
	 * @param  array    $args    The array of args for a Builder section.
	 *
	 * @return array             The modified array of args.
	 */
	public function modify_section( $args ) {
		// Add custom section id
		$args = $this->control_section_id( $args );

		// Add custom section classes
		$args = $this->control_section_classes( $args );

		// Remove space below section
		$args = $this->control_remove_space( $args );

		// Return modified args
		return $args;
	}

	/**
	 * Container for functions that filter the make_prepare_data_section hook.
	 *
	 * @since 1.5.1.
	 *
	 * @param  array     $clean_data       The section data that has already been sanitized.
	 * @param  array     $original_data    The original unsanitized section data.
	 * @param  string    $section_type     The type of section.
	 *
	 * @return array                       The amended array of sanitized section data.
	 */
	public function save_data( $clean_data, $original_data, $section_type ) {
		// Section id
		$clean_data = $this->save_section_id( $clean_data, $original_data );

		// Section classes
		$clean_data = $this->save_section_classes( $clean_data, $original_data );

		// Remove space below section
		$clean_data = $this->save_remove_space( $clean_data, $original_data );

		// Return modified clean data
		return $clean_data;
	}

	/**
	 * Add a new control definition to a section's config array for the
	 * "Section HTML ID" control.
	 *
	 * @since 1.6.0.
	 *
	 * @param  array    $args    The section args.
	 *
	 * @return array             The modified section args.
	 */
	private function control_section_id( $args ) {
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
	 * Add a new control definition to a section's config array for the
	 * "Section HTML classes" control.
	 *
	 * @since 1.6.0.
	 *
	 * @param  array    $args    The section args.
	 *
	 * @return array             The modified section args.
	 */
	private function control_section_classes( $args ) {
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
	 * Add a new control definition to a section's config array for the
	 * "Remove space after section" control.
	 *
	 * @since 1.5.1.
	 *
	 * @param  array    $args    The section args.
	 *
	 * @return array             The modified section args.
	 */
	private function control_remove_space( $args ) {
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
	 * Sanitize the 'section-html-id' section option.
	 *
	 * @since 1.6.0.
	 *
	 * @param  array    $clean_data       The section data that has already been sanitized.
	 * @param  array    $original_data    The original unsanitized section data.
	 *
	 * @return array                      The amended array of sanitized section data.
	 */
	private function save_section_id( $clean_data, $original_data ) {
		if ( isset( $original_data['section-html-id'] ) ) {
			$clean_data['section-html-id'] = sanitize_title_with_dashes( $original_data['section-html-id'] );
		}

		return $clean_data;
	}

	/**
	 * Sanitize the 'section-classes' section option.
	 *
	 * @since 1.6.0.
	 *
	 * @param  array    $clean_data       The section data that has already been sanitized.
	 * @param  array    $original_data    The original unsanitized section data.
	 *
	 * @return array                      The amended array of sanitized section data.
	 */
	private function save_section_classes( $clean_data, $original_data ) {
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
	 * @param  string    $original_classes    Space-separated list of classes.
	 *
	 * @return string                         Sanitized classes.
	 */
	private function sanitize_classes( $original_classes ) {
		$classes = explode( ' ', $original_classes );
		$clean_classes = array_map( 'sanitize_key', $classes );
		return implode( ' ', $clean_classes );
	}

	/**
	 * Sanitize the 'remove-space-below' section option.
	 *
	 * @since 1.5.1.
	 *
	 * @param  array    $clean_data       The section data that has already been sanitized.
	 * @param  array    $original_data    The original unsanitized section data.
	 *
	 * @return array                      The amended array of sanitized section data.
	 */
	private function save_remove_space( $clean_data, $original_data ) {
		if ( isset( $original_data['remove-space-below'] ) ) {
			$clean_data['remove-space-below'] = absint( $original_data['remove-space-below'] );
		}

		return $clean_data;
	}

	/**
	 * Filter the section html ID to replace it with a custom user-specified one.
	 *
	 * @since 1.6.0.
	 *
	 * @param  string    $id              The HTML id attribute for a particular section.
	 * @param  array     $section_data    The stored data for a particular section.
	 *
	 * @return string                     The modified id.
	 */
	public function add_section_html_id( $id, $section_data ) {
		if ( isset( $section_data['section-html-id'] ) && ! empty( $section_data['section-html-id'] ) ) {
			$id = sanitize_title_with_dashes( $section_data['section-html-id'] );
		}

		return $id;
	}

	/**
	 * Filter the section classes to add custom user-specified ones.
	 *
	 * @since 1.6.0.
	 *
	 * @param  string    $classes         The space-separated list of classes for a particular section.
	 * @param  array     $section_data    The stored data for a particular section.
	 *
	 * @return string                     The modified list of classes.
	 */
	public function add_section_classes( $classes, $section_data ) {
		if ( isset( $section_data['section-classes'] ) && ! empty( $section_data['section-classes'] ) ) {
			$new_classes = $this->sanitize_classes( $section_data['section-classes'] );
			$classes .= " $new_classes";
		}

		return $classes;
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
			add_action( 'make_builder_' . $type . '_css', array( $this, 'remove_space_css' ), 10, 2 );
		}
	}

	/**
	 * Add a CSS rule for a section to remove its bottom margin.
	 *
	 * @since 1.5.1.
	 *
	 * @param array     $data    The section's option data.
	 * @param string    $id      The section's unique ID.
	 *
	 * @return void
	 */
	public function remove_space_css( $data, $id ) {
		if ( isset( $data['remove-space-below'] ) && 1 === absint( $data['remove-space-below'] ) ) {
			$prefix = 'builder-section-';
			$id = sanitize_title_with_dashes( $data['id'] );
			/**
			 * This filter is documented in Make, inc/builder/core/save.php
			 */
			$section_id = apply_filters( 'make_section_html_id', $prefix . $id, $data );

			ttfmake_get_css()->add( array(
				'selectors'    => array( '#' . esc_attr( $section_id ) ),
				'declarations' => array(
					'margin-bottom' => 0
				),
			) );
		}
	}
}

TTFMP_Builder_Tweaks::instance()->init();