<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_Sidebar_Manager
 *
 * Enhanced sidebar layout options when additional sidebars are available.
 *
 * @since 1.7.0.
 */
final class MAKEPLUS_Component_CustomSidebars_Setup extends MAKEPLUS_Util_Modules implements MAKEPLUS_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'sidebars' => 'MAKEPLUS_Sidebars_ManagerInterface',
		'theme'    => 'MAKE_APIInterface',
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

		// Add sidebars choice set
		add_action( 'make_choices_loaded', array( $this, 'add_sidebar_choices' ) );

		// Convert layout settings
		add_action( 'make_settings_thememod_loaded', array( $this, 'convert_layout_settings' ) );

		// Convert Customizer controls
		add_action( 'customize_register', array( $this, 'convert_layout_controls' ), 40 );

		// Convert sidebar test
		add_filter( 'make_has_sidebar', array( $this, 'convert_sidebar_test_result' ) );

		// Replace the normal sidebars where needed
		add_filter( 'make_sidebar_left', array( $this, 'display_custom_sidebar' ) );
		add_filter( 'make_sidebar_right', array( $this, 'display_custom_sidebar' ) );

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
	 * Add a choice set containing available sidebars.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action make_choices_loaded
	 *
	 * @param MAKE_Choices_ManagerInterface $choices
	 *
	 * @return bool
	 */
	public function add_sidebar_choices( MAKE_Choices_ManagerInterface $choices ) {
		$sidebars = $this->sidebars()->get_sidebars();
		if ( empty( $sidebars ) ) {
			return false;
		}

		$choices_base = array(
			'0' => __( 'None', 'make-plus' ),
		);

		$choice_left = array(
			'1' => __( 'Default Left Sidebar', 'make-plus' ),
		);

		$choice_right = array(
			'1' => __( 'Default Right Sidebar', 'make-plus' ),
		);

		$sidebar_choices = array_combine(
			array_keys( $sidebars ),
			wp_list_pluck( $sidebars, 'name' )
		);

		$choice_set_left = array_merge( $choices_base, $choice_left, $sidebar_choices );
		$choice_set_right = array_merge( $choices_base, $choice_right, $sidebar_choices );

		return $choices->add_choice_sets( array(
			'makeplus-sidebars-left'  => $choice_set_left,
			'makeplus-sidebars-right' => $choice_set_right,
		) );
	}

	/**
	 * Update sidebar-related layout settings to use choice sets.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action make_settings_thememod_loaded
	 *
	 * @param MAKE_Settings_ThemeModInterface $settings
	 *
	 * @return bool
	 */
	public function convert_layout_settings( MAKE_Settings_ThemeModInterface $settings ) {
		// Bail if the choice sets haven't been added
		if ( ! $settings->choices()->choice_set_exists( 'makeplus-sidebars-left' ) || ! $settings->choices()->choice_set_exists( 'makeplus-sidebars-right' ) ) {
			return false;
		}

		$views = array_keys( $this->theme()->view()->get_sorted_views() );
		$converted_settings = array();

		foreach ( $views as $view ) {
			foreach ( array( 'left', 'right' ) as $location ) {
				$setting_id = 'layout-' . $view . '-sidebar-' . $location;
				if ( $settings->setting_exists( $setting_id ) ) {
					$converted_settings[ $setting_id ] = array(
						'default'       => absint( $settings->get_default( $setting_id ) ),
						'sanitize'      => array( $this, 'sanitize_sidebars_choice' ),
						'choice_set_id' => 'makeplus-sidebars-' . $location,
					);
				}
			}
		}

		return $settings->add_settings( $converted_settings, array(), true );
	}

	/**
	 * Sanitize a sidebar choice.
	 *
	 * @since 1.7.0.
	 *
	 * @param bool|string $value
	 * @param string      $setting_id
	 *
	 * @return string
	 */
	public function sanitize_sidebars_choice( $value, $setting_id ) {
		if ( false === $value ) {
			$value = 0;
		} else if ( true === $value ) {
			$value = 1;
		}

		return $this->theme()->sanitize()->sanitize_choice( $value, $setting_id );
	}

	/**
	 * Update sidebar-related setting controls to be selects instead of checkboxes.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action customize_register
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @return void
	 */
	public function convert_layout_controls( WP_Customize_Manager $wp_customize ) {
		// Bail if the choice set hasn't been added
		if ( ! $this->theme()->choices()->choice_set_exists( 'makeplus-sidebars-left' ) || ! $this->theme()->choices()->choice_set_exists( 'makeplus-sidebars-right' ) ) {
			return;
		}

		$views = array_keys( $this->theme()->view()->get_sorted_views() );

		foreach ( $views as $view ) {
			foreach ( array( 'left', 'right' ) as $location ) {
				$setting_id = 'layout-' . $view . '-sidebar-' . $location;
				$control = $wp_customize->get_control( 'ttfmake_' . $setting_id );

				if ( $control instanceof WP_Customize_Control ) {
					$control->label   = ( 'left' === $location ) ? __( 'Left sidebar', 'make-plus' ) : __( 'Right sidebar', 'make-plus' );
					$control->type    = 'select';
					$control->choices = $this->theme()->thememod()->get_choice_set( $setting_id );
				}
			}
		}
	}

	/**
	 * Modify the output of the has_sidebar test to account for sidebar ID strings.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked filter make_has_sidebar
	 *
	 * @param mixed $has_sidebar
	 *
	 * @return bool
	 */
	public function convert_sidebar_test_result( $has_sidebar ) {
		if ( ! $has_sidebar ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Replace the normal sidebar ID with the custom one, if applicable.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked filter make_sidebar_left
	 * @hooked filter make_sidebar_right
	 *
	 * @param string $sidebar_id    The ID of the current sidebar.
	 *
	 * @return string
	 */
	public function display_custom_sidebar( $sidebar_id ) {
		$view = $this->theme()->view()->get_current_view();
		$location = str_replace( 'make_sidebar_', '', current_filter() );
		$sidebar_choice = $this->theme()->thememod()->get_value( 'layout-' . $view . '-sidebar-' . $location );

		// If the choice exists in the sidebar array, change the ID.
		if ( $this->sidebars()->has_sidebar( $sidebar_choice ) ) {
			$sidebar_id = $sidebar_choice;
		}

		return $sidebar_id;
	}
}