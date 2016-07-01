<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_WhiteLabel_Setup
 *
 * Add a theme setting to hide the credit line in the site footer.
 *
 * @since 1.5.0.
 * @since 1.7.0. Changed class name from TTFMP_Customizer_White_Label.
 */
final class MAKEPLUS_Component_WhiteLabel_Setup extends MAKEPLUS_Util_Modules implements MAKEPLUS_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'theme' => 'MAKE_APIInterface',
	);

	/**
	 * The ID of the White Label setting.
	 *
	 * @since 1.7.0.
	 *
	 * @var string
	 */
	private $setting_id = 'footer-hide-credit';

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

		// Register the setting
		add_action( 'make_settings_thememod_loaded', array( $this, 'add_setting' ) );

		// Add the Customizer control
		add_action( 'customize_register', array( $this, 'add_control' ), 20 );

		// Hook into the template
		add_filter( 'make_show_footer_credit', array( $this, 'show_credit' ) );

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
	 * @param MAKE_Settings_ThemeMod $thememod
	 *
	 * @return bool
	 */
	public function add_setting( MAKE_Settings_ThemeMod $thememod ) {
		return $thememod->add_settings( array(
			$this->setting_id => array(
				'default'  => false,
				'sanitize' => 'wp_validate_boolean'
			),
		) );
	}

	/**
	 * Add the Customizer section and control.
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
		// White Label section
		$panel_id = 'ttfmake_general';
		$section_id = 'ttfmake_whitelabel';
		$section_args = array(
			'title' => __( 'White Label', 'make-plus' ),
		);
		if ( $wp_customize->get_panel( $panel_id ) ) {
			$panel_sections = $this->theme()->customizer_controls()->get_panel_sections( $wp_customize, $panel_id );
			$last_priority = (int) $this->theme()->customizer_controls()->get_last_priority( $panel_sections );

			$section_args['panel'] = $panel_id;
			$section_args['priority'] = $last_priority + 5;
		}
		$wp_customize->add_section( $section_id, $section_args );

		// Setting
		$setting_id = $this->setting_id;
		$wp_customize->add_setting( $setting_id, array(
			'default'              => $this->theme()->thememod()->get_default( $setting_id ),
			'sanitize_callback'    => array( $this->theme()->customizer_controls(), 'sanitize' ),
			'sanitize_js_callback' => array( $this->theme()->customizer_controls(), 'sanitize_js' ),
		) );

		// Control
		$control_id = 'ttfmake_' . $setting_id;
		$wp_customize->add_control( $control_id, array(
			'settings' => $setting_id,
			'section'  => $section_id,
			'label'    => __( 'Hide theme credit', 'make-plus' ),
			'type'     => 'checkbox',
		) );
	}

	/**
	 * Determine whether or not to show the theme credit.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked filter make_show_footer_credit
	 *
	 * @return bool
	 */
	public function show_credit() {
		return ! $this->theme()->thememod()->get_value( $this->setting_id );
	}
}