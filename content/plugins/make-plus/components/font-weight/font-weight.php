<?php
/**
 * @package Make Plus
 */

/**
 * Class TTFMP_Font_Weight
 *
 * Replace Make's default font weight options in the Customizer with numeric font weight options
 * that are dependent on which variants are available for a given font family/style combination.
 *
 * @since 1.6.5.
 */
class TTFMP_Font_Weight {
	/**
	 * Name of the component.
	 *
	 * @since 1.6.5.
	 *
	 * @var   string    The name of the component.
	 */
	var $component_slug = 'font-weight';

	/**
	 * Path to the component directory (e.g., /var/www/mysite/wp-content/plugins/make-plus/components/my-component).
	 *
	 * @since 1.6.5.
	 *
	 * @var   string    Path to the component directory
	 */
	var $component_root = '';

	/**
	 * File path to the plugin main file (e.g., /var/www/mysite/wp-content/plugins/make-plus/components/my-component/my-component.php).
	 *
	 * @since 1.6.5.
	 *
	 * @var   string    Path to the plugin's main file.
	 */
	var $file_path = '';

	/**
	 * The URI base for the plugin (e.g., http://example.com/wp-content/plugins/make-plus/my-component).
	 *
	 * @since 1.6.5.
	 *
	 * @var   string    The URI base for the plugin.
	 */
	var $url_base = '';

	/**
	 * Set the class properties.
	 *
	 * @since 1.6.5.
	 *
	 * @return TTFMP_Font_Weight
	 */
	public function __construct() {
		// Set the main paths for the component
		$this->component_root = ttfmp_get_app()->component_base . '/' . $this->component_slug;
		$this->file_path      = $this->component_root . '/' . basename( __FILE__ );
		$this->url_base       = untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Load files and hook into WordPress.
	 *
	 * @since 1.6.5.
	 *
	 * @return void
	 */
	public function init() {
		// Modify control definitions
		add_filter( 'make_customizer_typography_group_definitions', array( $this, 'modify_control_definitions' ), 10, 2 );

		// Modify possible font weight choices
		add_filter( 'make_setting_choices', array( $this, 'modify_choices' ), 10, 2 );

		// Register Ajax action for retrieving font weight choices
		add_filter( 'wp_ajax_ttfmp_font_weight', array( $this, 'ajax_get_font_weight_choices' ) );

		// Enqueue JS
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_customizer_scripts' ) );

		// Modify the variants for the Google Fonts URI
		add_filter( 'make_font_variants', array( $this, 'google_font_variants' ), 5, 2 );
	}

	/**
	 * The array of possible choices for a font weight.
	 *
	 * @since 1.6.5.
	 *
	 * @return array
	 */
	public function get_choice_list() {
		return array(
			'100'    => __( '100 - Thin', 'make-plus' ),
			'200'    => __( '200 - Extra Light', 'make-plus' ),
			'300'    => __( '300 - Light', 'make-plus' ),
			'normal' => __( '400 - Normal', 'make-plus' ),
			'500'    => __( '500 - Medium', 'make-plus' ),
			'600'    => __( '600 - Semi Bold', 'make-plus' ),
			'bold'   => __( '700 - Bold', 'make-plus' ),
			'800'    => __( '800 - Extra Bold', 'make-plus' ),
			'900'    => __( '900 - Black', 'make-plus' ),
		);
	}

	/**
	 * Modify the Customizer's font weight controls.
	 *
	 * @since 1.6.5.
	 *
	 * @param  array  $definitions
	 * @param  string $element
	 *
	 * @return mixed
	 */
	public function modify_control_definitions( $definitions, $element ) {
		$key = 'font-weight-' . $element;

		if ( isset( $definitions[ $key ] ) ) {
			// Remove custom control class
			if ( isset( $definitions[ $key ]['control']['control_type'] ) ) {
				unset( $definitions[ $key ]['control']['control_type'] );
			}

			// Change control type to select
			$definitions[ $key ]['control']['type'] = 'select';

			// Add a description
			$definitions[ $key ]['control']['description'] = __( 'Available weights are based on your selected Font Family and Font Style.', 'make-plus' );

			//
			$family = get_theme_mod( 'font-family-' . $element, ttfmake_get_default( 'font-family-' . $element ) );
			$style = get_theme_mod( 'font-style-' . $element, ttfmake_get_default( 'font-style-' . $element ) );
			$definitions[ $key ]['control']['choices'] = $this->get_font_weight_choices( $family, $style );
		}

		return $definitions;
	}

	/**
	 * Modify the choices for all font weight settings.
	 *
	 * Exception: font-weight-body-link is not associated with family and style options, so it is omitted.
	 *
	 * @since 1.6.5.
	 *
	 * @param  array  $choices
	 * @param  string $setting
	 *
	 * @return array
	 */
	public function modify_choices( $choices, $setting ) {
		if ( false !== strpos( $setting, 'font-weight-' ) && false === strpos( $setting, 'body-link' ) ) {
			$choices = $this->get_choice_list();
		}

		return $choices;
	}

	/**
	 * Get the array of available weight choices for a given font family/style combination.
	 *
	 * @since 1.6.5.
	 *
	 * @param string $family
	 * @param string $style
	 *
	 * @return array
	 */
	public function get_font_weight_choices( $family, $style = 'normal' ) {
		$weights = $this->get_font_weights( $family, $style );

		// Convert 400 and 700 to 'normal' and 'bold'
		foreach ( $weights as $index => $weight ) {
			$weights[ $index ] = $this->convert_weight( $weight, false );
		}

		$choice_list = $this->get_choice_list();
		$choices = array();

		// Get the right label for each weight
		foreach ( $weights as $value ) {
			if ( array_key_exists( $value, $choice_list ) ) {
				$choices[ $value ] = $choice_list[ $value ];
			}
		}

		// Add a simulated normal choice if there are no choices
		if ( empty( $choices ) ) {
			$choices['normal'] = __( '400 - Normal (simulated)', 'make-plus' );
		}

		// Add a simulated bold choice if no bold font weights are available
		$missing_bold_choices = array_diff( array( '600', 'bold', '800', '900' ), array_keys( $choices ) );
		if ( 4 === count( $missing_bold_choices ) ) {
			$choices['bold'] = __( '700 - Bold (simulated)', 'make-plus' );
		}

		// Sort choices by label
		asort( $choices );

		return $choices;
	}

	/**
	 * Convert between text and numeric font weights.
	 *
	 * normal <=> 400
	 * bold   <=> 700
	 *
	 * @since 1.6.5.
	 *
	 * @param string|int $value
	 * @param bool       $to_numeric
	 *
	 * @return string
	 */
	private function convert_weight( $value, $to_numeric = true ) {
		// e.g. 400 => normal
		if ( false === $to_numeric ) {
			switch ( (string) $value ) {
				case '400' :
					$value = 'normal';
					break;
				case '700' :
					$value = 'bold';
					break;
			}
		}
		// e.g. normal => 400
		else {
			switch ( $value ) {
				case 'normal' :
					$value = '400';
					break;
				case 'bold' :
					$value = '700';
					break;
			}
		}

		return $value;
	}

	/**
	 * Get the array of raw weights available for a given font family/style combination.
	 *
	 * @since 1.6.5.
	 *
	 * @param string $family
	 * @param string $style
	 *
	 * @return mixed|void
	 */
	public function get_font_weights( $family, $style = 'normal' ) {
		$weights = array();

		// Try standard fonts first
		if ( array_key_exists( $family, $fonts = ttfmake_get_standard_fonts() ) ) {
			$weights = array(
				'400',
				'700',
			);
		}
		// Then try Google fonts
		else if ( array_key_exists( $family, $fonts = ttfmake_get_google_fonts() ) ) {
			if ( isset( $fonts[ $family ]['variants'] ) && is_array( $fonts[ $family ]['variants'] ) ) {
				$weights = $this->parse_font_variants( $fonts[ $family ]['variants'], $style );
			}
		}
		// Then try Typekit fonts
		else if ( array_key_exists( $family, $fonts = ttfmp_get_typekit_customizer()->get_typekit_choices() ) ) {
			if ( isset( $fonts[ $family ]['variations'] ) && is_array( $fonts[ $family ]['variations'] ) ) {
				$weights = $this->parse_font_variants( $fonts[ $family ]['variations'], $style );
			}
		}

		/**
		 * Filter: Modify the available font weights for a given font family.
		 *
		 * @since 1.6.5.
		 *
		 * @param array  $weights The array of available font weights.
		 * @param string $family  The option value of the font family.
		 */
		return apply_filters( 'ttfmp_font_weights', $weights, $family );
	}

	/**
	 * Normalize each font variant in an array into a CSS-readable numeric font weight.
	 *
	 * @since 1.6.5.
	 *
	 * @param array  $variants
	 * @param string $style
	 *
	 * @return array
	 */
	private function parse_font_variants( $variants, $style = 'normal' ) {
		$parsed_variants = array();

		foreach ( $variants as $variant ) {
			switch ( $style ) {
				// "Normal" font style
				case 'normal' :
					// Google fonts equivalent of "normal"
					if ( 'regular' === $variant ) {
						$parsed_variants[] = '400';
					}
					// Google fonts, e.g. "300"
					else if ( 1 === preg_match( '/^[1-9]+00$/', $variant ) ) {
						$parsed_variants[] = $variant;
					}
					// Typekit, e.g. "n3"
					else if ( 1 === preg_match( '/^n[1-9]+$/', $variant ) ) {
						$parsed_variants[] = substr( $variant, 1 ) . '00';
					}
					break;
				// "Italic" font style
				case 'italic' :
					// Google fonts equivalent of "normal"
					if ( 'italic' === $variant ) {
						$parsed_variants[] = '400';
					}
					// Google fonts, e.g. "300italic"
					else if ( 1 === preg_match( '/^[1-9]+00italic$/', $variant ) ) {
						$parsed_variants[] = str_replace( 'italic', '', $variant );
					}
					// Typekit, e.g. "i3"
					else if ( 1 === preg_match( '/^i[1-9]+$/', $variant ) ) {
						$parsed_variants[] = substr( $variant, 1 ) . '00';
					}
					break;
			}
		}

		// De-dupe and return
		return array_unique( $parsed_variants );
	}

	/**
	 * Handle the Ajax request for a list of font weights.
	 *
	 * @since 1.6.5.
	 *
	 * @return void
	 */
	public function ajax_get_font_weight_choices() {
		$family         = ( isset( $_POST['family'] ) ) ? $_POST['family'] : '';
		$style          = ( isset( $_POST['style'] ) )  ? $_POST['style']  : 'normal';
		$current_value  = ( isset( $_POST['value'] ) )  ? $_POST['value']  : '';

		// Get the best available choice from the new weight list
		$available_weights = $this->get_font_weights( $family, $style );
		$converted_value = $this->convert_weight( $current_value );
		if ( ! in_array( $converted_value, $available_weights ) ) {
			$converted_value = $this->get_closest_available_weight( $converted_value, $available_weights );
			$current_value = $this->convert_weight( $converted_value, false );
		}

		$choices = $this->get_font_weight_choices( $family, $style );
		$html = '';

		foreach ( $choices as $value => $label ) {
			$html .= '<option value="' . esc_attr( $value ) . '"' . selected( $value, $current_value, false ) . '>' . esc_html( $label ) . '</option>';
		}

		if ( ! empty( $html ) ) {
			echo $html;
			exit();
		}

		echo '<option value="normal" selected="selected">' . esc_html__( '400 - Normal (simulated)', 'make-plus' ) . '</option>';
		exit();
	}

	/**
	 * Enqueue the Customizer script and add relevant JS data.
	 *
	 * @since 1.6.5.
	 *
	 * @return void
	 */
	public function enqueue_customizer_scripts() {
		wp_enqueue_script(
			'ttfmp-font-weight',
			$this->url_base . '/js/customizer.js',
			array( 'jquery', 'customize-controls' ),
			ttfmp_get_app()->version,
			true
		);

		// Define JS data
		$data = array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'groups' => array()
		);

		// Distill each typography "group" into a comma-separated list
		$weight_keys = ttfmake_get_font_property_option_keys( 'font-weight' );
		foreach ( $weight_keys as $key ) {
			// Don't include font-weight-body-link, as it is not a complete group.
			if ( false === strpos( $key, 'body-link' ) ) {
				$data['groups'][] = str_replace( 'font-weight-', '', $key );
			}
		}
		$data['groups'] = implode( ',', $data['groups'] );

		// Add JS data
		wp_localize_script(
			'ttfmp-font-weight',
			'ttfmpFontWeight',
			$data
		);
	}

	/**
	 * Determine which variants to include in the request for a given Google font.
	 *
	 * @since 1.6.5.
	 *
	 * @param array $variants
	 * @param string $family
	 *
	 * @return array
	 */
	public function google_font_variants( $variants, $family ) {
		static $family_options = null;

		// Initialize static variables
		if ( null === $family_options ) {
			$family_options = ttfmake_get_font_property_option_keys( 'font-family' );
		}

		// Bucket for typography groups
		$groups = array();

		// Determine which typography groups use this font family
		foreach ( $family_options as $family_option ) {
			if ( get_theme_mod( $family_option, false ) === $family ) {
				$groups[] = str_replace( 'font-family-', '', $family_option );
			}
		}

		// Bucket for variants
		$new_variants = array();

		// Use the weight and style settings for each group to determine variants
		foreach ( $groups as $group ) {
			$style = ttfmake_sanitize_choice( get_theme_mod( 'font-style-' . $group, ttfmake_get_default( 'font-style-' . $group ) ), 'font-style-' . $group );
			$base_weight = preg_replace( '/[^a-z0-9]+/', '', get_theme_mod( 'font-weight-' . $group, ttfmake_get_default( 'font-weight-' . $group ) ) );

			// Convert text weights to numbers, e.g. 'normal' => 400
			$base_weight = $this->convert_weight( $base_weight );

			// Choose an alternative weight if the given weight is not available
			$available_weights = $this->get_font_weights( $family, $style );
			if ( ! in_array( $base_weight, $available_weights ) ) {
				$base_weight = $this->get_closest_available_weight( $base_weight, $available_weights );
			}

			if ( 'italic' === $style ) {
				// If group is already styled italic, only include italic
				$new_variants[] = ( '400' == $base_weight ) ? 'italic' : $base_weight . 'italic';
			} else if ( 'normal' === $style ) {
				// If group is styled normal, include italic also, if available, to accommodate possible inline styles
				$new_variants[] = ( '400' == $base_weight ) ? 'regular' : $base_weight;
				if ( in_array( $base_weight, $this->get_font_weights( $family, 'italic' ) ) ) {
					$new_variants[] = ( '400' === $base_weight ) ? 'italic' : $base_weight . 'italic';
				}
			}
		}

		return ( ! empty( $new_variants ) ) ? array_unique( $new_variants ) : $variants;
	}

	/**
	 * Use heuristics to choose an alternative weight when the given weight isn't available.
	 *
	 * These criteria are based on MDN's description of font weight fallbacks.
	 *
	 * @link https://developer.mozilla.org/en-US/docs/Web/CSS/font-weight
	 *
	 * @since 1.6.5.
	 *
	 * @param string|int $current_weight
	 * @param array      $weights
	 *
	 * @return int|mixed
	 */
	private function get_closest_available_weight( $current_weight, array $weights ) {
		$current_weight = absint( $current_weight );
		$weights = array_map( 'absint', $weights );

		if ( 400 === $current_weight && false !== array_search( 500, $weights ) ) {
			return '500';
		}

		if ( 500 === $current_weight && false !== array_search( 400, $weights ) ) {
			return '400';
		}

		if ( ( $current_weight >= 500 && $current_weight < 900 ) || 100 === $current_weight ) {
			$possibilities = $this->get_larger_weights( $current_weight, $weights );
			if ( empty( $possibilities ) ) {
				$possibilities = $this->get_smaller_weights( $current_weight, $weights );
			}
		}

		else if ( ( $current_weight <= 400 && $current_weight > 100 ) || 900 === $current_weight ) {
			$possibilities = $this->get_smaller_weights( $current_weight, $weights );
			if ( empty( $possibilities ) ) {
				$possibilities = $this->get_larger_weights( $current_weight, $weights );
			}
		}

		if ( ! empty( $possibilities ) ) {
			return (string) array_shift( $possibilities );
		}

		return '400';
	}

	/**
	 * Get a subset of an array of available weights that are smaller than a specific weight.
	 *
	 * @since 1.6.5.
	 *
	 * @param int   $current_weight
	 * @param array $weights
	 *
	 * @return array
	 */
	private function get_smaller_weights( $current_weight, $weights ) {
		return array_intersect( range( $current_weight - 100, 100, 100 ), $weights );
	}

	/**
	 * Get a subset of an array of available weights that are larger than a specific weight.
	 *
	 * @since 1.6.5.
	 *
	 * @param int   $current_weight
	 * @param array $weights
	 *
	 * @return array
	 */
	private function get_larger_weights( $current_weight, $weights ) {
		return array_intersect( range( $current_weight + 100, 900, 100 ), $weights );
	}
}

$ttfmp_fontweight = new TTFMP_Font_Weight;
$ttfmp_fontweight->init();