<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKPLUS_Component_FontWeight_Setup
 *
 * Enable granular font weight choices for fonts in the Customizer.
 *
 * @since 1.6.5.
 * @since 1.7.0. Changed class name from TTFMP_Font_Weight.
 */
final class MAKEPLUS_Component_FontWeight_Setup extends MAKEPLUS_Util_Modules implements MAKEPLUS_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'compatibility' => 'MAKEPLUS_Compatibility_MethodsInterface',
		'theme'         => 'MAKE_APIInterface',
	);

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

		// Update the font weight choices
		add_action( 'make_choices_loaded', array( $this, 'update_choices' ) );

		// Update the font weight settings
		add_action( 'make_settings_thememod_loaded', array( $this, 'update_thememod_settings' ) );

		// Update Customizer definitions
		add_filter( 'make_customizer_sections', array( $this, 'update_control_definitions' ) );

		// Enqueue scripts
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_customizer_controls_scripts' ) );
		add_action( 'customize_preview_init', array( $this, 'enqueue_customizer_preview_scripts' ) );

		// Register Ajax action for retrieving font weight choices
		add_action( 'wp_ajax_makeplus-fontweight-load', array( $this, 'get_font_weight_choices_ajax' ) );

		// Modify the variants for the Google Fonts URI
		add_filter( 'make_font_google_variants', array( $this, 'google_font_variants' ), 5, 2 );

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
	 * Array filter callback. Used to isolate the list of compatible font weight setting IDs.
	 *
	 * @param $string
	 *
	 * @return bool
	 */
	private function filter_fontweight( $string ) {
		$has_fontweight = 0 === strpos( $string, 'font-weight-' );
		$in_blacklist = in_array( $string, array( 'font-weight-body-link', 'font-weight-nav-current-item' ) );
		return $has_fontweight && ! $in_blacklist;
	}

	/**
	 * The expanded choice set for a font weight.
	 *
	 * @since 1.6.5.
	 *
	 * @return array
	 */
	private function get_choice_set() {
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
	 * Update the font weight choice set.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action make_choices_loaded
	 *
	 * @param MAKE_Choices_ManagerInterface $choices
	 *
	 * @return bool
	 */
	public function update_choices( MAKE_Choices_ManagerInterface $choices ) {
		return $choices->add_choice_sets( array(
			'font-weight-expanded' => $this->get_choice_set(),
		) );
	}

	/**
	 * Update compatible theme mod settings to use the new choice set.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action make_settings_thememod_loaded
	 *
	 * @param MAKE_Settings_ThemeModInterface $thememod
	 *
	 * @return void
	 */
	public function update_thememod_settings( MAKE_Settings_ThemeModInterface $thememod ) {
		$setting_ids = array_keys( $thememod->get_settings( 'is_style' ) );
		$compatible_settings = array_filter( $setting_ids, array( $this, 'filter_fontweight' ) );

		$thememod->add_settings(
			array_fill_keys( $compatible_settings, array() ),
			array(
				'choice_set_id'           => 'font-weight-expanded',
				'is_expanded_font_weight' => true,
			),
			true
		);
	}

	/**
	 * Modify the definitions for Font Weight controls in the Customizer.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked filter make_customizer_sections
	 *
	 * @param array $sections
	 *
	 * @return array
	 */
	public function update_control_definitions( array $sections ) {
		foreach ( $sections as $section_id => $data ) {
			if ( isset( $data['controls'] ) && is_array( $data['controls'] ) ) {
				// Get section's font weight keys
				$keys = array_filter( array_keys( $data['controls'] ), array( $this, 'filter_fontweight' ) );

				foreach ( $keys as $key ) {
					$element = str_replace( 'font-weight-', '', $key );
					$family = $this->theme()->thememod()->get_value( 'font-family-' . $element );
					$style = $this->theme()->thememod()->get_value( 'font-style-' . $element );

					//
					if ( ! is_null( $family ) && ! is_null( $style ) ) {
						// Remove custom control class
						if ( isset( $sections[ $section_id ]['controls'][ $key ]['control']['control_type'] ) ) {
							unset( $sections[ $section_id ]['controls'][ $key ]['control']['control_type'] );
						}

						// Change control type to select
						$sections[ $section_id ]['controls'][ $key ]['control']['type'] = 'select';

						// Add a description
						$sections[ $section_id ]['controls'][ $key ]['control']['description'] = __( 'Available weights are based on your selected Font Family and Font Style.', 'make-plus' );

						// Update the choices array
						$sections[ $section_id ]['controls'][ $key ]['control']['choices'] = $this->get_font_weight_choices( $family, $style );
					}
				}
			}
		}

		return $sections;
	}

	/**
	 * Get the array of raw weights available for a given font family/style combination.
	 *
	 * @since 1.6.5.
	 *
	 * @param string $family
	 * @param string $style
	 *
	 * @return array
	 */
	private function get_font_weights( $family, $style = 'normal' ) {
		$weights = array();

		$data = $this->theme()->font()->get_font_data( $family );
		if ( ! empty( $data ) && isset( $data['variants'] ) && is_array( $data['variants'] ) ) {
			// Font data has variants array
			$weights = $this->parse_font_variants( $data['variants'], $style );
		}

		// Default if no weights are specified
		if ( empty( $weights ) ) {
			$weights = array(
				'400',
				'700',
			);
		}

		// Check for deprecated filter
		if ( has_filter( 'ttfmp_font_weights' ) ) {
			$this->compatibility()->deprecated_hook(
				'ttfmp_font_weights',
				'1.7.0',
				__( 'Use the makeplus_font_weights hook instead.', 'make-plus' )
			);

			/**
			 * Filter: Modify the available font weights for a given font family.
			 *
			 * @since 1.6.5.
			 * @deprecated 1.7.0
			 *
			 * @param array  $weights The array of available font weights.
			 * @param string $family  The option value of the font family.
			 */
			$weights = apply_filters( 'ttfmp_font_weights', $weights, $family );
		}

		/**
		 * Filter: Modify the available font weights for a given font family.
		 *
		 * @since 1.7.0.
		 *
		 * @param array  $weights The array of available font weights.
		 * @param string $family  The option value of the font family.
		 */
		return apply_filters( 'makeplus_font_weights', $weights, $family );
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
	private function get_font_weight_choices( $family, $style = 'normal' ) {
		$weights = $this->get_font_weights( $family, $style );

		// Convert 400 and 700 to 'normal' and 'bold'
		foreach ( $weights as $index => $weight ) {
			$weights[ $index ] = $this->convert_weight( $weight, false );
		}

		$choice_set = $this->get_choice_set();
		$choices = array();

		// Get the right label for each weight
		foreach ( $weights as $value ) {
			if ( isset( $choice_set[ $value ] ) ) {
				$choices[ $value ] = $choice_set[ $value ];
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

	/**
	 * Enqueue the Customizer controls script and add relevant JS data.
	 *
	 * @since 1.6.5.
	 *
	 * @hooked action customize_controls_enqueue_scripts
	 *
	 * @return void
	 */
	public function enqueue_customizer_controls_scripts() {
		// Controls script
		wp_enqueue_script(
			'makeplus-fontweight-customizer-controls',
			makeplus_get_plugin_directory_uri() . 'js/fontweight/customizer-controls.js',
			array( 'jquery', 'customize-controls' ),
			MAKEPLUS_VERSION,
			true
		);

		// Add JS data
		wp_localize_script(
			'makeplus-fontweight-customizer-controls',
			'MakePlusFontWeight',
			$this->get_js_data()
		);
	}

	/**
	 * Enqueue the Customizer preview script and add relevant JS data.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action customize_preview_init
	 *
	 * @return void
	 */
	public function enqueue_customizer_preview_scripts() {
		// Preview script
		wp_enqueue_script(
			'makeplus-fontweight-customizer-preview',
			makeplus_get_plugin_directory_uri() . 'js/fontweight/customizer-preview.js',
			array( 'jquery', 'customize-preview', 'make-customizer-preview' ),
			MAKEPLUS_VERSION,
			true
		);

		// Add JS data
		wp_localize_script(
			'makeplus-fontweight-customizer-preview',
			'MakePlusFontWeight',
			$this->get_js_data()
		);
	}

	/**
	 * Generate a data array to pass to JS scripts.
	 *
	 * @since 1.7.0.
	 *
	 * @return array
	 */
	private function get_js_data() {
		// Define JS data
		$data = array(
			'ajaxurl'            => admin_url( 'admin-ajax.php' ),
			'typography-groups'  => array()
		);

		// Distill each typography "group" into a comma-separated list
		$weight_keys = array_keys( $this->theme()->thememod()->get_settings( 'is_expanded_font_weight' ) );
		foreach ( $weight_keys as $key ) {
			$data['typography-groups'][] = str_replace( 'font-weight-', '', $key );
		}

		return $data;
	}

	/**
	 * Handle the Ajax request for a list of font weights.
	 *
	 * @since 1.6.5.
	 *
	 * @hooked action wp_ajax_makeplus-fontweight-load
	 *
	 * @return void
	 */
	public function get_font_weight_choices_ajax() {
		// Only run this during an Ajax request.
		if ( 'wp_ajax_makeplus-fontweight-load' !== current_action() ) {
			return;
		}

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
	 * Determine which variants to include in the request for a given Google font.
	 *
	 * @since 1.6.5.
	 *
	 * @hooked filter make_font_google_variants
	 *
	 * @param array  $chosen_variants
	 * @param string $family
	 *
	 * @return array
	 */
	public function google_font_variants( $chosen_variants, $family ) {
		static $family_settings = null;

		// Initialize static variable
		if ( null === $family_settings ) {
			$family_settings = array_keys( $this->theme()->thememod()->get_settings( 'is_font' ) );
		}

		// Bucket for typography groups
		$groups = array();

		// Determine which typography groups use this font family
		foreach ( $family_settings as $family_setting ) {
			if ( $this->theme()->thememod()->get_value( $family_setting ) === $family ) {
				$groups[] = str_replace( 'font-family-', '', $family_setting );
			}
		}

		// Bucket for variants
		$new_variants = array();

		// Use the weight and style settings for each group to determine variants
		foreach ( $groups as $group ) {
			$style = $this->theme()->thememod()->get_value( 'font-style-' . $group );
			$base_weight = $this->theme()->thememod()->get_value( 'font-weight-' . $group );

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

		return ( ! empty( $new_variants ) ) ? array_unique( $new_variants ) : $chosen_variants;
	}
}