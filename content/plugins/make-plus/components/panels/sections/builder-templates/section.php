<?php
/**
 * @package Make Plus
 */

/**
 * Class TTFMP_Panels_Builder_Section
 *
 * Process the data for a Panels section and render the Builder UI for it.
 *
 * @since 1.6.0.
 */
class TTFMP_Panels_Builder_Section {
	/**
	 * The section data provided by Builder core.
	 *
	 * @since 1.6.0.
	 *
	 * @var array
	 */
	var $section_data = array();

	/**
	 * Whether this instance is rendering a section for a JS template or not.
	 *
	 * @since 1.6.0.
	 *
	 * @var bool
	 */
	var $is_js_template = false;

	/**
	 * The injected instance of TTFMP_Panels_Settings.
	 *
	 * @since 1.6.0.
	 *
	 * @var TTFMP_Panels_Settings
	 */
	private $settings;

	/**
	 * The section type.
	 *
	 * @since 1.6.0.
	 *
	 * @var string
	 */
	var $type = 'panels';

	/**
	 * The section ID.
	 *
	 * @since 1.6.0.
	 *
	 * @var int
	 */
	var $id = 0;

	/**
	 * The state of the section in the Builder UI.
	 *
	 * @since 1.6.0.
	 *
	 * @var string
	 */
	var $state = 'open';

	/**
	 * The array of items in the section.
	 *
	 * @since 1.6.0.
	 *
	 * @var array
	 */
	var $items = array();

	/**
	 * Initialize the section.
	 *
	 * @since 1.6.0.
	 *
	 * @param array                    $section_data      The section data provided by Builder core.
	 * @param bool                     $is_js_template    Whether this instance is rendering a section for a JS template or not.
	 * @param TTFMP_Panels_Settings    $settings          The injected instance of TTFMP_Panels_Settings.
	 *
	 * @return TTFMP_Panels_Builder_Section
	 */
	public function __construct( $section_data, $is_js_template, $settings ) {
		// Store the given parameters
		$this->section_data = $section_data;
		$this->is_js_template = $is_js_template;
		$this->settings = $settings;

		// Sanitize and store the section ID
		if ( isset( $this->section_data['data']['id'] ) ) {
			$this->id = TTFMAKE_Builder_Save::clean_section_id( $this->section_data['data']['id'] );
		}

		// Store the section state
		if ( isset( $this->section_data['data']['state'] ) ) {
			$this->state = $this->section_data['data']['state'];
		}

		// Process and store the section items
		$this->items = $this->get_sorted_items( $this->section_data['data'] );

		// Load the file for the section item class
		$item_template = trailingslashit( dirname( __FILE__ ) ) . 'section-item.php';
		require_once( $item_template );
	}

	/**
	 * Render the section UI HTML.
	 *
	 * @since 1.6.0.
	 *
	 * @return void
	 */
	public function render() {
		$section_name = ttfmake_get_section_name( $this->section_data, $this->is_js_template );
		$item_order = $this->get_item_order( $this->section_data['data'] );

		ttfmake_load_section_header();
		?>
			<div class="ttfmp-panels">
				<div class="ttfmp-panels-stage">
					<?php
					foreach ( $this->items as $item ) :
						// Render each item
						$template = new TTFMP_Panels_Builder_Section_Item( $item, $this->is_js_template, $this->id, $this->settings );
						$template->render();
					endforeach;
					?>
				</div>
				<a href="#" class="ttfmp-add-panels-item ttfmp-panels-add-item-link" title="<?php esc_attr_e( 'Add new panel', 'make-plus' ); ?>">
					<div class="ttfmp-panels-add-item">
						<span>
							<?php esc_html_e( 'Add panel', 'make-plus' ); ?>
						</span>
					</div>
				</a>
				<input type="hidden" value="<?php echo esc_attr( implode( ',', $item_order ) ); ?>" name="<?php echo esc_attr( $section_name ); ?>[item-order]" class="ttfmp-panels-item-order" />
			</div>
			<input type="hidden" class="ttfmake-section-state" name="<?php echo esc_attr( $section_name ); ?>[state]" value="<?php echo esc_attr( $this->state ); ?>" />
	<?php
		ttfmake_load_section_footer();
	}

	/**
	 * Sort the array of items based on the item-order setting.
	 *
	 * @since 1.6.0.
	 *
	 * @param  array    $data    The section data.
	 *
	 * @return array             The array of sorted items.
	 */
	private function get_sorted_items( $data ) {
		$item_order = $this->get_item_order( $data );
		$items = array();
		$sorted_items = array();

		if ( isset( $data['panels-items'] ) ) {
			$items = $data['panels-items'];
		}

		if ( ! empty( $item_order ) && ! empty( $items ) ) {
			foreach ( $item_order as $order => $key ) {
				if ( isset( $items[ $key ] ) ) {
					$items[ $key ]['id'] = $key;
					$sorted_items[ $order ] = $items[ $key ];
				}
			}
		}

		return $sorted_items;
	}

	/**
	 * Get the item order setting, if it exists.
	 *
	 * @since 1.6.0.
	 *
	 * @param  array    $data    The section data.
	 *
	 * @return array             The ordered array of item IDs.
	 */
	private function get_item_order( $data ) {
		$item_order = array();

		if ( isset( $data['item-order'] ) && is_array( $data['item-order'] ) ) {
			$item_order = $data['item-order'];
		}

		return $item_order;
	}
}