<?php
/**
 * @package Make Plus
 */

if ( ! class_exists( 'TTFMP_Text_Column_Layout' ) ) :
/**
 * Bootstrap the text section column layout.
 *
 * @since 1.3.0.
 */
class TTFMP_Text_Column_Layout {
	/**
	 * Name of the component.
	 *
	 * @since 1.3.0.
	 *
	 * @var   string    The name of the component.
	 */
	var $component_slug = 'text-column-layout';

	/**
	 * Path to the component directory (e.g., /var/www/mysite/wp-content/plugins/make-plus/components/my-component).
	 *
	 * @since 1.3.0.
	 *
	 * @var   string    Path to the component directory
	 */
	var $component_root = '';

	/**
	 * File path to the plugin main file (e.g., /var/www/mysite/wp-content/plugins/make-plus/components/my-component/my-component.php).
	 *
	 * @since 1.3.0.
	 *
	 * @var   string    Path to the plugin's main file.
	 */
	var $file_path = '';

	/**
	 * The URI base for the plugin (e.g., http://example.com/wp-content/plugins/make-plus/my-component).
	 *
	 * @since 1.3.0.
	 *
	 * @var   string    The URI base for the plugin.
	 */
	var $url_base = '';

	/**
	 * The one instance of TTFMP_Text_Column_Layout.
	 *
	 * @since 1.3.0.
	 *
	 * @var   TTFMP_Text_Column_Layout
	 */
	private static $instance;

	/**
	 * Instantiate or return the one TTFMP_Text_Column_Layout instance.
	 *
	 * @since  1.3.0.
	 *
	 * @return TTFMP_Text_Column_Layout
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Create a new section.
	 *
	 * @since  1.3.0.
	 *
	 * @return TTFMP_Text_Column_Layout
	 */
	public function __construct() {
		// Set the main paths for the component
		$this->component_root = ttfmp_get_app()->component_base . '/' . $this->component_slug;
		$this->file_path      = $this->component_root . '/' . basename( __FILE__ );
		$this->url_base       = untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Initialize hooks
	 *
	 * @since 1.6.0.
	 *
	 * @return void
	 */
	public function init() {
		// Add the JS/CSS
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

		// Add a blurb where the old Column Layout option used to be.
		add_filter( 'make_add_section', array( $this, 'add_configuration_inputs' ) );
		add_filter( 'make_configuration_overlay_input_wrap', array( $this, 'filter_column_layout_input' ), 10, 2 );

		// Add the inputs for the individual columns
		add_action( 'make_section_text_after_column', array( $this, 'add_column_inputs' ), 10, 2 );

		// Add the container for the column sizing sliders
		add_action( 'make_section_text_after_columns', array( $this, 'add_column_slider_container' ) );

		// Save the data
		add_filter( 'make_prepare_data_section', array( $this, 'save_data' ), 10, 3 );

		// Hook up layout CSS customizations
		add_action( 'make_css', array( $this, 'add_layout_css' ) );

		// Add classes to the text columns
		add_filter( 'ttfmake-text-column-classes', array( $this, 'add_classes' ), 10, 3 );
	}

	/**
	 * Add the extra config option to the overlay.
	 *
	 * @since  1.4.0
	 *
	 * @param  array    $section_data    The section data.
	 * @return array                     Modified section data.
	 */
	public function add_configuration_inputs( $section_data ) {
		if ( 'text' === $section_data['id'] ) {
			$controls = $section_data['config'];

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

			$section_data['config'][ $new_priority ] = array(
				'type'    => 'text',
				'name'    => 'text-column-layout-blurb',
				'label'   => __( 'Column layout', 'make-plus' ),
				'class'   => 'ttfmp-text-column-layout-blurb',
			);
		}
		return $section_data;
	}

	/**
	 * Filter the Column Layout input to just be a text blurb.
	 *
	 * Since there isn't a 'text blurb' input type.
	 *
	 * @since 1.6.0.
	 *
	 * @param  string    $wrap    The HTML to wrap the option input.
	 * @param  array     $args    The args for the input.
	 *
	 * @return string             The modified HTML wrap.
	 */
	public function filter_column_layout_input( $wrap, $args ) {
		if ( isset( $args['name'] ) && 'text-column-layout-blurb' === $args['name'] ) {
			$blurb = esc_html__( 'Looking for the Column Layout option? Now you can simply click and drag between the columns to change their grid layout. (2- and 3-column sections only.)', 'make-plus' );
			$wrap = str_replace( '%2$s', $blurb, $wrap );
		}

		return $wrap;
	}

	/**
	 * Add the hidden input to dictate the column size.
	 *
	 * @since  1.3.0.
	 *
	 * @param  array    $data             The section data.
	 * @param  int      $column_number    The column number.
	 * @return void
	 */
	public function add_column_inputs( $data, $column_number ) {
		global $ttfmake_is_js_template;
		$section_name  = ttfmake_get_section_name( $data, $ttfmake_is_js_template );
		$section_name .= '[columns][' . $column_number . ']';
		$size          = '';

		// Get the current size
		if ( true !== $ttfmake_is_js_template && isset( $data['data']['columns'][ $column_number ]['size'] ) ) {
			$size = $data['data']['columns'][ $column_number ]['size'];
		}
	?>
		<input type="hidden" class="ttfmp-column-size-input ttfmp-column-size-input-<?php echo $column_number; ?>" name="<?php echo $section_name; ?>[size]" value="<?php echo esc_attr( $size ); ?>" />
	<?php
	}

	/**
	 * Add the container HTML for the jQuery UI sliders.
	 *
	 * @since 1.6.0.
	 *
	 * @return void
	 */
	public function add_column_slider_container() { ?>
		<div class="ttfmp-column-size-container"></div>
	<?php }

	/**
	 * Save the layout and size data
	 *
	 * @since  1.3.0.
	 *
	 * @param  array     $clean_data       The cleaned up data.
	 * @param  array     $original_data    The $_POST data for the section.
	 * @param  string    $section_type     The ID for the section.
	 * @return array                       The additional data.
	 */
	public function save_data( $clean_data, $original_data, $section_type ) {
		if ( 'text' === $section_type ) {
			$allowed_sizes = array(
				'one-fourth',
				'one-third',
				'one-half',
				'two-thirds',
				'three-fourths',
			);

			// Save the individual column data
			if ( isset( $original_data['columns'] ) && is_array( $original_data['columns'] ) ) {
				foreach ( $original_data['columns'] as $id => $item ) {
					if ( isset( $item['size'] ) && in_array( $item['size'], $allowed_sizes ) ) {
						$clean_data['columns'][ $id ]['size'] = $item['size'];
					}
				}
			}
		}

		return $clean_data;
	}

	/**
	 * Add JS/CSS on page edit screen.
	 *
	 * @since  1.3.0.
	 *
	 * @param  string    $hook_suffix    The current page slug.
	 * @return void
	 */
	public function admin_enqueue_scripts( $hook_suffix ) {
		// Have to be careful with this test because this function was introduced in Make 1.2.0.
		$post_type_supports_builder = ( function_exists( 'ttfmake_post_type_supports_builder' ) ) ? ttfmake_post_type_supports_builder( get_post_type() ) : false;
		$post_type_is_page          = ( 'page' === get_post_type() );

		if ( ( 'post.php' !== $hook_suffix && 'post-new.php' !== $hook_suffix ) || ( ! $post_type_supports_builder && $post_type_is_page ) ) {
			return;
		}

		wp_enqueue_script(
			'ttfmp-column-size',
			$this->url_base . '/js/column-size.js',
			array( 'jquery', 'jquery-ui-slider' ),
			ttfmp_get_app()->version,
			true
		);

		wp_localize_script(
			'ttfmp-column-size',
			'ttfmpColumnSize',
			array(
				2 => array(
					-2 => 'one-fourth',
					-1 => 'one-third',
					 0 => 'one-half',
					 1 => 'two-thirds',
					 2 => 'three-fourths',
				),
				3 => array(
					-1 => 'one-fourth',
					 0 => 'one-third',
					 1 => 'one-half',
				),
			)
		);

		wp_enqueue_style(
			'ttfmp-text-column-layout',
			$this->url_base . '/css/text-column-layout.css',
			array( 'ttfmake-sections/css/sections.css' ),
			ttfmp_get_app()->version
		);
	}

	/**
	 * Enable color options for certain Post List styles
	 *
	 * @since  1.3.0.
	 *
	 * @return void
	 */
	public function add_layout_css() {
		$post = get_post();

		if ( is_admin() || empty( $post ) ) {
			return;
		}

		$sections = ttfmake_get_section_data( get_the_ID() );

		foreach ( $sections as $id => $data ) {
			if ( isset( $data['section-type'] ) && 'text' === $data['section-type'] && isset( $data['columns-number'] ) && isset( $data['columns-order'] ) ) {
				$prefix = 'builder-section-';
				$id = sanitize_title_with_dashes( $id );
				/**
				 * This filter is documented in Make, inc/builder/core/save.php
				 */
				$section_id = apply_filters( 'make_section_html_id', $prefix . $id, $data );

				$number_of_columns = absint( $data['columns-number'] );
				$selector_base     = '.builder-text-columns-' . $number_of_columns . ' .builder-text-column-';

				foreach ( $data['columns'] as $column_number => $column_data ) {
					if ( isset( $column_data['size'] ) ) {
						ttfmake_get_css()->add( array(
							'selectors'    => array(
								'#' . esc_attr( $section_id ) . $selector_base . $this->get_column_number( $data['columns-order'], $column_number )
							),
							'declarations' => array(
								'width' => $this->get_column_width( $column_data['size'], $number_of_columns ) . '%'
							),
							'media'        => 'screen and (min-width: 800px)'
						) );
					}
				}
			}
		}
	}

	/**
	 * Get the order number for a column.
	 *
	 * @since  1.3.0.
	 *
	 * @param  array    $columns_order    The listing of column order.
	 * @param  int      $column_number    The column number.
	 * @return int                        The column's order number.
	 */
	public function get_column_number( $columns_order, $column_number ) {
		return array_search( $column_number, $columns_order ) + 1;
	}

	/**
	 * Convert a column size label to an actual size based on label and number of columns.
	 *
	 * @since  1.3.0.
	 *
	 * @param  string       $size_label           The label for the size.
	 * @param  int          $number_of_columns    The number of columns.
 	 * @return float|int                          The size expressed as a percentage with the percent sign.
	 */
	public function get_column_width( $size_label, $number_of_columns ) {
		$margin_width_unit = 3.33333;

		// Determine the margin width, which affects the column width
		if ( 2 === $number_of_columns ) {
			$margin_width = $margin_width_unit;
		} else if ( 3 === $number_of_columns ) {
			$margin_width = $margin_width_unit * 2;
		} else {
			$margin_width = 0;
		}

		// Get the percentage amount that corresponds to the label
		switch ( $size_label ) {
			case 'one-fourth':
				$percentage = .25;
				break;

			case 'one-third':
				$percentage = 1 / 3;
				break;

			case 'one-half':
				$percentage = .5;
				break;

			case 'two-thirds':
				$percentage = 2 / 3;
				break;

			case 'three-fourths':
				$percentage = .75;
				break;

			default:
				$percentage = 1;
				break;
		}

		return ( 100 - $margin_width ) * $percentage;
	}

	/**
	 * Add classes to text columns in the builder template.
	 *
	 * @since  1.3.0.
	 *
	 * @param  string    $classes          The existing class string.
	 * @param  int       $column_number    The current column number.
	 * @param  array     $data             The section data.
	 * @return string                      The modified class string.
	 */
	public function add_classes( $classes, $column_number, $data ) {
		$size = ( isset( $data['data']['columns'][ $column_number ]['size'] ) ) ? $data['data']['columns'][ $column_number ]['size'] : '';

		if ( ! empty( $size ) ) {
			$classes .= ' ttfmake-column-width-' . $size;
		}

		return $classes;
	}
}
endif;

if ( ! function_exists( 'ttfmp_get_text_column_layout' ) ) :
/**
 * Instantiate or return the one TTFMP_Text_Column_Layout instance.
 *
 * @since  1.3.0.
 *
 * @return TTFMP_Text_Column_Layout
 */
function ttfmp_get_text_column_layout() {
	return TTFMP_Text_Column_Layout::instance();
}
endif;

ttfmp_get_text_column_layout()->init();