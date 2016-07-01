<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_StickyHeader_Setup
 *
 * Enable a theme setting to make the site header sticky.
 *
 * @since 1.7.0.
 */
final class MAKEPLUS_Component_StickyHeader_Setup extends MAKEPLUS_Util_Modules implements MAKEPLUS_Util_HookInterface {
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

		// Add setting
		add_action( 'make_settings_thememod_loaded', array( $this, 'add_setting' ) );

		// Add choice set
		add_action( 'make_choices_loaded', array( $this, 'add_choice_set' ) );

		// Add Customizer control
		add_action( 'customize_register', array( $this, 'add_control' ), 20 );

		// Add class to site header
		add_filter( 'make_site_header_class', array( $this, 'header_class' ) );

		// Add front end styles
		add_action( 'make_style_loaded', array( $this, 'add_styles' ) );

		// Enqueue front end
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend' ) );

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
	 * Register a Theme Mod setting for the sticky header.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action make_settings_thememod_loaded
	 *
	 * @param MAKE_Settings_ThemeModInterface $thememod
	 *
	 * @return bool
	 */
	public function add_setting( MAKE_Settings_ThemeModInterface $thememod ) {
		return $thememod->add_settings( array(
			'sticky-header' => array(
				'default'       => 'none',
				'sanitize'      => array( $this->theme()->sanitize(), 'sanitize_choice' ),
				'choice_set_id' => 'sticky-header',
				'is_style'      => true,
			),
		) );
	}

	/**
	 * Add a choice set for the sticky header options.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action make_choices_loaded
	 *
	 * @param MAKE_Choices_ManagerInterface $choices
	 *
	 * @return bool
	 */
	public function add_choice_set( MAKE_Choices_ManagerInterface $choices ) {
		return $choices->add_choice_sets( array(
			'sticky-header' => array(
				'none'        => __( 'None', 'make-plus' ),
				'header-bar'  => __( 'Header Bar', 'make-plus' ),
				'site-header' => __( 'Site Header', 'make-plus' ),
			),
		) );
	}

	/**
	 * Add the Sticky Header setting and control to the Customizer.
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
		// Look for the Header section before adding anything
		$section_id = 'ttfmake_header';
		$section = $wp_customize->get_section( $section_id );

		if ( $section instanceof WP_Customize_Section && class_exists( 'MAKE_Customizer_Control_Radio' ) ) {
			$section_controls = $this->theme()->customizer_controls()->get_section_controls( $wp_customize, $section_id );
			$last_priority = (int) $this->theme()->customizer_controls()->get_last_priority( $section_controls );
			$header_layout = $wp_customize->get_control( 'ttfmake_header-layout' );
			$priority = ( $header_layout instanceof WP_Customize_Control ) ? $header_layout->priority + 1 : $last_priority;

			// Add setting
			$setting_id = 'sticky-header';
			$wp_customize->add_setting( $setting_id, array(
				'default'              => $this->theme()->thememod()->get_default( $setting_id ),
				'sanitize_callback'    => array( $this->theme()->customizer_controls(), 'sanitize' ),
				'sanitize_js_callback' => array( $this->theme()->customizer_controls(), 'sanitize_js' ),
			) );

			// Add control
			$control_id = 'ttfmake_' . $setting_id;
			$wp_customize->add_control( new MAKE_Customizer_Control_Radio( $wp_customize, $control_id, array(
				'settings'     => $setting_id,
				'section'      => $section_id,
				'label'        => __( 'Sticky Header', 'make-plus' ),
				'mode'         => 'buttonset',
				'choices'      => $this->theme()->thememod()->get_choice_set( 'sticky-header' ),
				'priority'     => $priority,
			) ) );
		}
	}

	/**
	 * Add classes to the site header if sticky header is enabled.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked filter make_site_header_class
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	public function header_class( array $classes ) {
		// Get the setting value
		$sticky = $this->theme()->thememod()->get_value( 'sticky-header' );

		switch ( $sticky ) {
			case 'header-bar' :
			case 'site-header' :
				$classes[] = 'makeplus-sticky-header';
				$classes[] = 'sticky-' . $sticky;
				break;
		}

		return $classes;
	}

	/**
	 * Add inline styles for the sticky header if it's enabled.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action make_style_loaded
	 *
	 * @param MAKE_Style_ManagerInterface $style
	 *
	 * @return void
	 */
	public function add_styles( MAKE_Style_ManagerInterface $style ) {
		$sticky_header = $style->thememod()->get_value( 'sticky-header' );

		if ( 'none' !== $sticky_header ) {
			$style->css()->add( array(
				'selectors' => '.makeplus-is-sticky',
				'declarations' => array(
					'position' => 'absolute',
					'z-index'  => 9999,
				),
			) );
			$style->css()->add( array(
				'selectors' => '.makeplus-is-sticky',
				'declarations' => array(
					'position' => 'fixed',
				),
				'media' => 'screen and (min-width: 600px)',
			) );
			$style->css()->add( array(
				'selectors' => '.boxed .makeplus-is-sticky',
				'declarations' => array(
					'max-width' => '1024px',
				),
			) );
			$style->css()->add( array(
				'selectors' => '.boxed .makeplus-is-sticky',
				'declarations' => array(
					'max-width' => '1144px',
				),
				'media' => 'screen and (min-width: 800px)',
			) );
			$style->css()->add( array(
				'selectors' => array( '.sticky-site-header:not(.makeplus-is-sticky)', '.sticky-header-bar .header-bar:not(.makeplus-is-sticky)' ),
				'declarations' => array(
					'visibility' => 'hidden'
				),
			) );
		}
	}

	/**
	 * Enqueue the sticky header script if sticky header is enabled.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action wp_enqueue_scripts
	 *
	 * @return void
	 */
	public function enqueue_frontend() {
		$view = $this->theme()->view()->get_current_view();
		$show_header = ! $this->theme()->thememod()->get_value( 'layout-' . $view . '-hide-header' );
		$sticky_header = $this->theme()->thememod()->get_value( 'sticky-header' );

		if ( $show_header && 'none' !== $sticky_header ) {
			wp_enqueue_script(
				'makeplus-stickyheader-frontend',
				makeplus_get_plugin_directory_uri() . 'js/stickyheader/frontend.js',
				array( 'jquery' ),
				MAKEPLUS_VERSION,
				true
			);
		}
	}
}