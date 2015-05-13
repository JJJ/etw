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
	 * The URI base for the plugin (e.g., http://domain.com/wp-content/plugins/make-plus/my-component).
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
		// Remove space below section
		$clean_data = $this->save_remove_space( $clean_data, $original_data );

		// Return modified clean data
		return $clean_data;
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
			$priorities = array_keys( $args );
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
			ttfmake_get_css()->add( array(
				'selectors'    => array( '#builder-section-' . esc_attr( $id ) ),
				'declarations' => array(
					'margin-bottom' => 0
				),
			) );
		}
	}
}

TTFMP_Builder_Tweaks::instance()->init();