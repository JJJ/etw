<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_ECommerce_Enhancement_ColorHighlight
 *
 * Add a Highlight color to Make's color settings. Used by the EDD component.
 *
 * @since 1.2.0.
 * @since 1.7.0. Moved to a separate class.
 */
final class MAKEPLUS_Component_ECommerce_Enhancement_ColorHighlight extends MAKEPLUS_Util_Modules implements MAKEPLUS_Util_HookInterface {
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
	 * The ID of the Highlight Color setting.
	 *
	 * @since 1.7.0.
	 *
	 * @var string
	 */
	private $setting_id = 'color-highlight';

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

		// Add the setting
		add_action( 'make_settings_thememod_loaded', array( $this, 'add_setting' ) );

		// Add the control
		add_action( 'customize_register', array( $this, 'add_control' ), 20 );

		// Convert old setting
		add_action( 'after_setup_theme', array( $this, 'convert_old_setting' ) );

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
	 * Register the Theme Mod setting.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action make_settings_thememod_loaded
	 *
	 * @param MAKE_Settings_ThemeModInterface $settings
	 *
	 * @return bool
	 */
	public function add_setting( MAKE_Settings_ThemeModInterface $settings ) {
		return $settings->add_settings( array(
			$this->setting_id => array(
				'default'  => '#289a00',
				'sanitize' => 'maybe_hash_hex_color',
				'is_style' => true,
			),
		) );
	}

	/**
	 * Add the Customizer control.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action customize_register
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @return void
	 */
	public function add_control( WP_Customize_Manager $wp_customize ) {
		// Highlight Color control
		$section_id = 'make_color';

		// Setting
		$setting_id = $this->setting_id;
		$wp_customize->add_setting( $setting_id, array(
			'default'              => $this->theme()->thememod()->get_default( $setting_id ),
			'transport'            => 'postMessage',
			'sanitize_callback'    => array( $this->theme()->customizer_controls(), 'sanitize' ),
			'sanitize_js_callback' => array( $this->theme()->customizer_controls(), 'sanitize_js' ),
		) );

		// Control
		$control_id = 'ttfmake_' . $setting_id;
		$args = array(
			'settings'     => $setting_id,
			'section'      => $section_id,
			'label'        => __( 'Highlight Color', 'make-plus' ),
			'description'  => '',
		);

		// Check for deprecated filter.
		if ( has_filter( 'ttfmp_color_highlight_description' ) ) {
			$this->compatibility()->deprecated_hook(
				'ttfmp_color_highlight_description',
				'1.7.0',
				sprintf(
					__( 'Use the %s hook instead.', 'make-plus' ),
					'<code>makeplus_ecommerce_colorhighlight_description</code>'
				)
			);

			/**
			 * Filter the description of the Highlight Color control.
			 *
			 * @since 1.5.0.
			 * @deprecated 1.7.0.
			 *
			 * @param string $description    The control description.
			 */
			$args['description'] = apply_filters( 'ttfmp_color_highlight_description', $args['description'] );
		}

		/**
		 * Filter: Change the description of the Highlight Color control in the Customizer.
		 *
		 * Useful for specifying which site elements are affected by the color choice.
		 *
		 * @since 1.7.0.
		 *
		 * @param string $description    The control description.
		 */
		$args['description'] = apply_filters( 'makeplus_ecommerce_colorhighlight_description', $args['description'] );

		// Position control right after the Detail Color, if possible
		if ( $wp_customize->get_control( 'ttfmake_color-detail' ) instanceof WP_Customize_Control ) {
			$args['priority'] = $wp_customize->get_control( 'ttfmake_color-detail' )->priority + 1;
		}

		// Add the control
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$control_id,
				$args
			)
		);
	}

	/**
	 * Look for the old WooCommerce-specific highlight color setting and convert it to the shared ecommerce one.
	 *
	 * This adds a flag to the theme mod array after it runs, so it should only run once.
	 *
	 * The old setting is preserved in the array in case of rollback to an earlier version.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action after_setup_theme
	 *
	 * @return void
	 */
	public function convert_old_setting() {
		// Bail if this conversion process has already been run.
		if ( true === get_theme_mod( 'makeplus-ecommerce-colorhighlight-converted' ) ) {
			return;
		}

		// Only convert if the old setting has a value and the new one doesn't
		if ( false !== $old_setting_value = get_theme_mod( 'color-woocommerce-highlight' ) && ! $this->theme()->thememod()->get_raw_value( $this->setting_id ) ) {
			$this->theme()->thememod()->set_value( $this->setting_id, $old_setting_value );
		}

		// Add a flag that the conversion has been run.
		set_theme_mod( 'makeplus-ecommerce-colorhighlight-converted', true );
	}
}