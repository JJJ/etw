<?php
/**
 * @package Make Plus
 */

/**
 * Class TTFMP_Panels_Builder_Section_Item
 *
 * Process the data for a Panels section item and render the Builder UI for it.
 *
 * @since 1.6.0.
 */
class TTFMP_Panels_Builder_Section_Item {
	/**
	 * The array of data for the item.
	 *
	 * @since 1.6.0.
	 *
	 * @var array
	 */
	var $item_data = array();

	/**
	 * Whether this instance is rendering a section item for a JS template or not.
	 *
	 * @since 1.6.0.
	 *
	 * @var bool
	 */
	var $is_js_template = false;

	/**
	 * The ID of the parent section.
	 *
	 * @since 1.6.0.
	 *
	 * @var int
	 */
	var $parent_id = 0;

	/**
	 * The injected instance of TTFMP_Panels_Settings.
	 *
	 * @since 1.6.0.
	 *
	 * @var TTFMP_Panels_Settings
	 */
	private $settings;

	/**
	 * The ID of the item.
	 *
	 * @since 1.6.0.
	 *
	 * @var int
	 */
	var $id = 0;

	/**
	 * Initialize the section item.
	 *
	 * @since 1.6.0.
	 *
	 * @param array                    $item_data         The array of data for the item.
	 * @param bool                     $is_js_template    Whether this instance is rendering a section item for a JS template or not.
	 * @param int                      $parent_id         The ID of the parent section.
	 * @param TTFMP_Panels_Settings    $settings          The injected instance of TTFMP_Panels_Settings.
	 *
	 * @return TTFMP_Panels_Builder_Section_Item
	 */
	public function __construct( $item_data, $is_js_template, $parent_id, $settings ) {
		// Store the given parameters
		$this->item_data = $item_data;
		$this->is_js_template = $is_js_template;
		$this->parent_id = $parent_id;
		$this->settings = $settings;

		// Sanitize and store the item ID
		$this->id = $this->get_item_id( $this->item_data );
	}

	/**
	 * Return the sanitized item ID, or a JS template if no ID is set.
	 *
	 * @since 1.6.0.
	 *
	 * @param  array    $data    The array of item data.
	 *
	 * @return int|string        The sanitized item ID.
	 */
	private function get_item_id( $data ) {
		$item_id = '{{{ id }}}';

		if ( isset( $data['id'] ) ) {
			$item_id = TTFMAKE_Builder_Save::clean_section_id( $data['id'] );
		}

		return $item_id;
	}

	/**
	 * Return the item's name attribute, for HTML/JS template markup.
	 *
	 * @since 1.6.0.
	 *
	 * @param  int     $parent_id         The item's parent ID.
	 * @param  int     $item_id           The item's ID.
	 * @param  bool    $is_js_template    Whether this instance is rendering a section item for a JS template or not.
	 *
	 * @return string                     The item's name attribute.
	 */
	private function get_item_name( $parent_id, $item_id, $is_js_template ) {
		$name = 'ttfmake-section';

		if ( $is_js_template ) {
			$name .= '[{{{ parentID }}}][panels-items][{{{ id }}}]';
		} else {
			$name .= "[$parent_id][panels-items][$item_id]";
		}

		return $name;
	}

	/**
	 * Get the current value of an item setting.
	 *
	 * @since 1.6.0.
	 *
	 * @param  string    $key     The key for the setting to get.
	 * @param  array     $data    The array of item data.
	 *
	 * @return mixed              The current value of the setting.
	 */
	private function get_item_value( $key, $data ) {
		$settings = $this->settings->get_settings();
		$value = null;

		if ( isset( $settings[ $key ] ) ) {
			// Start with the default value
			$value = $settings[ $key ]['default'];
			// Then get the sanitized value if it is in the data array
			if ( isset( $data[ $key ] ) ) {
				$value = $this->settings->sanitize_value( $data[ $key ], $key );
			}
		}

		return $value;
	}

	/**
	 * Render the section item UI HTML.
	 *
	 * @since 1.6.0.
	 *
	 * @return void
	 */
	public function render() {
		$combined_id = ( $this->is_js_template ) ? '{{{ parentID }}}-{{{ id }}}' : $this->parent_id . '-' . $this->id;
		$overlay_id  = 'ttfmake-overlay-' . $combined_id;

		$item_name = $this->get_item_name( $this->parent_id, $this->id, $this->is_js_template );
		$content = $this->get_item_value( 'item-content', $this->item_data );
		?>
		<?php if ( ! $this->is_js_template ) : ?>
			<div id="ttfmp-panels-item-<?php echo esc_attr( $this->id ); ?>" class="ttfmp-panels-item" data-id="<?php echo esc_attr( $this->id ); ?>" data-section-type="panelsItem">
		<?php endif; ?>

		<div title="<?php esc_attr_e( 'Drag-and-drop this panel into place', 'make-plus' ); ?>" class="ttfmake-sortable-handle">
			<div class="sortable-background"></div>
		</div>

		<div class="wrapper-panels-item-links">
			<a href="#" class="configure-panels-item-link ttfmake-section-configure ttfmake-overlay-open" title="<?php esc_attr_e( 'Configure panel', 'make-plus' ); ?>" data-overlay="#<?php echo $overlay_id; ?>">
				<span>
					<?php esc_html_e( 'Configure panel', 'make-plus' ); ?>
				</span>
			</a>
			<a href="#" class="edit-content-link edit-panels-item-link<?php if ( ! empty( $content ) ) : ?> item-has-content<?php endif; ?>" title="<?php esc_attr_e( 'Edit content', 'make-plus' ); ?>" data-textarea="ttfmake-content-<?php echo $combined_id; ?>">
				<span>
					<?php esc_html_e( 'Edit content', 'make-plus' ); ?>
				</span>
			</a>
			<a href="#" class="remove-panels-item-link ttfmp-panels-item-remove" title="<?php esc_attr_e( 'Delete panel', 'make-plus' ); ?>">
				<span>
					<?php esc_html_e( 'Delete panel', 'make-plus' ); ?>
				</span>
			</a>
		</div>

		<?php
		// Add the content editor
		ttfmake_get_builder_base()->add_frame( $combined_id, $item_name . '[item-content]', $content, true ); ?>

		<?php
		// Add the setting overlay
		$this->render_overlay( $overlay_id, $item_name, $this->item_data ); ?>

		<?php if ( ! $this->is_js_template ) : ?>
			</div>
		<?php endif; ?>
	<?php
	}

	/**
	 * Render the HTML for the item configuration overlay.
	 *
	 * @since 1.6.0.
	 *
	 * @param  string    $overlay_id    The HTML ID for the overlay container.
	 * @param  string    $item_name     The HTML name for the item.
	 * @param  array     $item_data     The array of item data.
	 *
	 * @return void
	 */
	private function render_overlay( $overlay_id, $item_name, $item_data ) {
		global $ttfmake_overlay_class, $ttfmake_overlay_id, $ttfmake_overlay_title;
		$ttfmake_overlay_class = 'ttfmake-configuration-overlay';
		$ttfmake_overlay_id    = $overlay_id;
		$ttfmake_overlay_title = __( 'Configure panel', 'make-plus' );

		get_template_part( '/inc/builder/core/templates/overlay', 'header' );

		$inputs = $this->get_overlay_inputs();

		// Print the inputs
		$output = '';

		foreach ( $inputs as $input ) {
			if ( isset( $input['type'] ) && isset( $input['name'] ) ) {
				$output .= ttfmake_create_input( $item_name, $input, $item_data );
			}
		}

		echo $output;

		get_template_part( '/inc/builder/core/templates/overlay', 'footer' );
	}

	/**
	 * Define the inputs for the item configuration overlay.
	 *
	 * @since 1.6.0.
	 *
	 * @return array    The array of input definitions.
	 */
	private function get_overlay_inputs() {
		/**
		 * Filter the definitions of the panel configuration inputs.
		 *
		 * @since 1.6.0.
		 *
		 * @param array    $inputs    The input definition array.
		 */
		$inputs = apply_filters( 'ttfmp_panels_item_configuration', array(
			100 => array(
				'type'  => 'section_title',
				'name'  => 'item-title',
				'label' => __( 'Enter panel title', 'make-plus' ),
				'class' => 'ttfmake-configuration-title',
				'default' => ttfmake_get_section_default( 'item-title', 'panels' ),
			),
		) );

		// Sort the config in case 3rd party code added another input
		ksort( $inputs, SORT_NUMERIC );

		return $inputs;
	}
}
