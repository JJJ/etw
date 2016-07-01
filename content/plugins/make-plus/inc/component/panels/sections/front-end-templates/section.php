<?php
/**
 * @package Make Plus
 */

/**
 * Class TTFMP_Panels_Frontend_Section
 *
 * Process the data for a Panels section and render the frontend HTML for it.
 *
 * @since 1.6.0.
 */
class TTFMP_Panels_Frontend_Section {
	/**
	 * The section data provided by Builder core.
	 *
	 * @since 1.6.0.
	 *
	 * @var array
	 */
	var $section_data = array();

	/**
	 * The array of sections on the current page.
	 *
	 * @since 1.6.0.
	 *
	 * @var array
	 */
	var $sections = array();

	/**
	 * The injected instance of TTFMP_Panels_Settings.
	 *
	 * @since 1.6.0.
	 *
	 * @var TTFMP_Panels_Settings
	 */
	private $settings;

	/**
	 * The mode of the current Panels section, i.e. accordion or tabs.
	 *
	 * @since 1.6.0.
	 *
	 * @var string
	 */
	var $mode = '';

	/**
	 * The array of HTML attributes to add to the section wrapper.
	 *
	 * @since 1.6.0.
	 *
	 * @var array
	 */
	var $attributes = array();

	/**
	 * The array of section items.
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
	 * @param  array                    $section_data    The section data provided by Builder core.
	 * @param  array                    $sections        The array of sections on the current page.
	 * @param  TTFMP_Panels_Settings    $settings        The injected instance of TTFMP_Panels_Settings.
	 *
	 * @return TTFMP_Panels_Frontend_Section
	 */
	public function __construct( $section_data, $sections, $settings ) {
		// Store the given parameters
		$this->section_data = $section_data;
		$this->sections = $sections;
		$this->settings = $settings;

		// Sanitize and store the section's mode
		if ( isset( $this->section_data['mode'] ) ) {
			$this->mode = $this->settings->sanitize_value( array( $this->section_data['mode'], 'mode', 'panels' ), 'mode' );
		} else {
			$this->mode = ttfmake_get_section_default( 'mode', 'panels' );
		}

		// Parse the section data and generate the wrapper attributes
		$this->attributes = $this->get_attributes( $this->section_data, $this->sections );

		// Parse and sort the section items
		$this->items = $this->get_sorted_items( $this->section_data );
	}

	/**
	 * Parse the section data and generate an array of wrapper attributes.
	 *
	 * @since 1.6.0.
	 *
	 * @param  array    $section_data    The section data provided by Builder core.
	 * @param  array    $sections        The array of sections on the current page.
	 *
	 * @return array                     The array of attributes.
	 */
	private function get_attributes( $section_data, $sections ) {
		$data = (array) $section_data;
		$defaults = $this->settings->get_settings( 'default' );
		$data = wp_parse_args( $data, $defaults );

		$attributes = array();

		// Classes
		$attributes['class'] = 'builder-section';
		$attributes['class'] .= ' ' . ttfmake_get_builder_save()->section_classes( $section_data, $sections );
		$attributes['class'] .= ' ' . $this->mode . '-mode';
		if ( ! empty( $data['background-image'] ) || '' !== $data['background-color'] ) {
			$attributes['class'] .= ' has-background';
		}

		// Styles
		$attributes['style'] = '';
		if ( ! empty( $data['background-image'] ) ) {
			$image_id = $this->settings->sanitize_value( $data['background-image'], 'background-image' );
			$attributes['style'] .= 'background-image: url(' . addcslashes( $this->get_image_url( $image_id ), '"' ) . ');';
		}
		if ( '' !== $data['background-color'] ) {
			$attributes['style'] .= 'background-color: ' . $this->settings->sanitize_value( $data['background-color'], 'background-color' ) . ';';
		}
		switch ( $data['background-image-style'] ) {
			default :
			case 'tile' :
				$attributes['style'] .= 'background-repeat: repeat;';
				break;
			case 'cover' :
				$attributes['style'] .= 'background-size: cover;';
				break;
		}

		return $attributes;
	}

	/**
	 * Parse the array of attributes into a string.
	 *
	 * @since 1.6.0.
	 *
	 * @param  array    $attributes    The array of attributes.
	 *
	 * @return string                  The string of attributes for the HTML element.
	 */
	private function parse_attributes( $attributes ) {
		$output = '';

		foreach ( $attributes as $attr => $value ) {
			if ( '' !== $value ) {
				$string = ' ' . sanitize_title_with_dashes( $attr ) . '="%s"';
				$output .= sprintf(
					$string,
					esc_attr( $value )
				);
			}
		}

		return $output;
	}

	/**
	 * Sanitize and return the section ID.
	 *
	 * @since 1.6.0.
	 *
	 * @param  array    $section_data    The section data.
	 *
	 * @return int|string
	 */
	private function get_id( $section_data ) {
		$id = 0;

		if ( isset( $section_data['id'] ) ) {
			$id = TTFMAKE_Builder_Save::clean_section_id( $section_data['id'] );
		}

		return $id;
	}

	/**
	 * Get the image URL from the attachment ID.
	 *
	 * @since 1.6.0.
	 *
	 * @param  int    $image_id    The attachment ID.
	 *
	 * @return string              The URL of the image.
	 */
	private function get_image_url( $image_id ) {
		$image_url = '';

		if ( $image_id ) {
			$image_src = ttfmake_get_image_src( (int) $image_id, 'large' );
			if ( isset( $image_src[0] ) ) {
				$image_url = esc_url_raw( $image_src[0] );
			}
		}

		return $image_url;
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

	/**
	 * Render the section's frontend HTML.
	 *
	 * @since 1.6.0.
	 *
	 * @return void
	 */
	public function render() {
		// Section ID
		$section_id = 'builder-section-' . $this->section_data['id'];
		if ( method_exists( 'TTFMAKE_Builder_Save', 'section_html_id' ) ) :
			$section_id = ttfmake_get_builder_save()->section_html_id( $this->section_data );
		endif;
		?>
		<section id="<?php echo esc_attr( $section_id ); ?>"<?php echo $this->parse_attributes( $this->attributes ); ?>>
		<?php if ( '' !== $this->section_data['title'] ) : ?>
			<h3 class="builder-banner-section-title">
				<?php echo $this->settings->sanitize_value( $this->section_data['title'], 'title' ); ?>
			</h3>
		<?php endif; ?>
		<?php if ( ! empty( $this->items ) ) :
			$heightStyle = esc_js( $this->settings->sanitize_value( array( $this->section_data['height-style'], 'height-style', 'panels' ), 'height-style' ) );
			?>
			<div class="builder-section-content">
				<div class="ttfmp-<?php echo esc_attr( $this->mode ); ?>-container" data-height-style="<?php echo esc_attr( $heightStyle ); ?>">
					<?php
					if ( 'accordion' === $this->mode ) :
						$this->render_accordion( $this->items );
					elseif ( 'tabs' === $this->mode ) :
						$this->render_tabs( $this->items );
					endif;
					?>
				</div>
			</div>
		<?php endif; ?>
		<?php if ( 0 !== $this->settings->sanitize_value( $this->section_data['background-image-darken'], 'background-image-darken' ) ) : ?>
			<div class="builder-section-overlay"></div>
		<?php endif; ?>
		</section>
	<?php
	}

	/**
	 * Render the item HTML for an accordion section.
	 *
	 * @since 1.6.0.
	 *
	 * @param  array    $items    The array of items.
	 *
	 * @return void
	 */
	private function render_accordion( $items ) {
		foreach ( $items as $item ) : ?>
			<div id="ttfmp-panels-item-title-<?php echo esc_attr( $item['id'] ); ?>" class="ttfmp-panels-item-title">
				<?php echo $this->settings->sanitize_value( $item['item-title'], 'item-title' ); ?>
			</div>
			<div id="ttfmp-panels-item-content-<?php echo esc_attr( $item['id'] ); ?>" class="ttfmp-panels-item-content">
				<?php ttfmake_get_builder_save()->the_builder_content( $this->settings->sanitize_value( $item['item-content'], 'item-content' ) ); ?>
			</div>
	<?php endforeach;
	}

	/**
	 * Render the item HTML for a tabs section.
	 *
	 * @since 1.6.0.
	 *
	 * @param  array    $items    The array of items.
	 *
	 * @return void
	 */
	private function render_tabs( $items ) {
		?>
		<ul class="ttfmp-panels-item-titles">
		<?php foreach ( $items as $item ) : ?>
			<li id="ttfmp-panels-item-title-<?php echo esc_attr( $item['id'] ); ?>" class="ttfmp-panels-item-title">
				<a href="#ttfmp-panels-item-content-<?php echo esc_attr( $item['id'] ); ?>"><?php echo $this->settings->sanitize_value( $item['item-title'], 'item-title' ); ?></a>
			</li>
		<?php endforeach; ?>
		</ul>
		<?php foreach ( $items as $item ) : ?>
		<div id="ttfmp-panels-item-content-<?php echo esc_attr( $item['id'] ); ?>" class="ttfmp-panels-item-content">
			<?php ttfmake_get_builder_save()->the_builder_content( $this->settings->sanitize_value( $item['item-content'], 'item-content' ) ); ?>
		</div>
		<?php endforeach; ?>
	<?php
	}
}
