<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_ECommerce_Enhancement_LayoutProduct
 *
 * Adds a new "Product" view and related layout settings. Used by the EDD and WooCommerce components.
 *
 * @since 1.7.0.
 */
final class MAKEPLUS_Component_ECommerce_Enhancement_LayoutProduct extends MAKEPLUS_Util_Modules implements MAKEPLUS_Util_HookInterface {
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

		// Add the view
		add_action( 'make_view_loaded', array( $this, 'add_view' ) );

		// Add the settings
		add_action( 'make_settings_thememod_loaded', array( $this, 'add_settings' ), 20 );

		// Add the controls
		add_action( 'customize_register', array( $this, 'add_controls' ) );

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
	 * Add a new view.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action make_view_loaded
	 *
	 * @param MAKE_Layout_ViewInterface $view
	 *
	 * @return bool
	 */
	public function add_view( MAKE_Layout_ViewInterface $view ) {
		return $view->add_view( 'product', array(
			'label'                     => __( 'Product', 'make-plus' ),
			'priority'                  => 50,
			'callback'                  => array( $this, 'view_callback' ),
			'callback_admin'            => array( $this, 'view_callback_admin' ),
			'is_perpage_view'           => true,
			'makeplus_perpage_settings' => array(
				'layout-product-hide-header',
				'layout-product-hide-footer',
				'layout-product-sidebar-left',
				'layout-product-sidebar-right',
				'header-hide-padding-bottom',
				'footer-hide-padding-top',
				'layout-product-yoast-breadcrumb',
			),
		) );
	}

	/**
	 * Determine if the current view qualifies as Product.
	 *
	 * Note that this will always return false unless a filter is added to the hook.
	 *
	 * This allows various ecommerce platforms to define the Product view separately.
	 *
	 * @since 1.7.0.
	 *
	 * @return bool
	 */
	public function view_callback() {
		/**
		 * Filter: Modify the result of the check to see if the current view is "product".
		 *
		 * @since 1.7.0.
		 *
		 * @param bool $is_product
		 */
		return apply_filters( 'makeplus_view_is_product', false );
	}

	/**
	 * Determine if the current admin view qualifies as Product.
	 *
	 * Note that this will always return false unless a filter is added to the hook.
	 *
	 * This allows various ecommerce platforms to define the Product view separately.
	 *
	 * @since 1.7.0.
	 *
	 * @return bool
	 */
	public function view_callback_admin() {
		/**
		 * Filter: Modify the result of the check to see if the current admin view is "product".
		 *
		 * @since 1.7.0.
		 *
		 * @param bool $is_product
		 */
		return apply_filters( 'makeplus_admin_view_is_product', false );
	}

	/**
	 * Wrapper function to test if the current view is Product.
	 *
	 * @since 1.7.0.
	 *
	 * @return bool
	 */
	public function is_product_view() {
		return 'product' === $this->theme()->view()->get_current_view();
	}

	/**
	 * Register new settings.
	 *
	 * Copy the layout setting definitions for the "Post" view.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action make_settings_thememod_loaded
	 *
	 * @param MAKE_Settings_ThemeModInterface $settings
	 *
	 * @return bool
	 */
	public function add_settings( MAKE_Settings_ThemeModInterface $settings ) {
		$existing_settings = $settings->get_settings();
		$new_setting_ids = $this->get_setting_ids();
		$new_settings = array();

		foreach ( $new_setting_ids as $new_id ) {
			// Get the ID of the existing setting to copy from
			$copy_id = str_replace( 'product', 'post', $new_id );

			if ( $settings->setting_exists( $copy_id ) ) {
				$new_settings[ $new_id ] = $existing_settings[ $copy_id ];

				// Keep the right sidebar on Product views.
				if ( 'layout-product-sidebar-right' === $new_id ) {
					$new_settings[ $new_id ]['default'] = true;
				}
			}
		}

		if ( ! empty( $new_settings ) ) {
			return $settings->add_settings( $new_settings );
		}

		return false;
	}

	/**
	 * Helper function that provides a list of new setting IDs.
	 *
	 * @since 1.7.0.
	 *
	 * @return array
	 */
	private function get_setting_ids() {
		return array(
			'layout-product-hide-header',
			'layout-product-hide-footer',
			'layout-product-sidebar-left',
			'layout-product-sidebar-right',
			'layout-product-yoast-breadcrumb',
		);
	}

	/**
	 * Add a new section and controls.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action customize_register
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @return void
	 */
	public function add_controls( WP_Customize_Manager $wp_customize ) {
		$setting_ids = $this->get_setting_ids();

		// Layout > Shop section
		$panel_id = 'ttfmake_layout';
		$section_id = 'ttfmake_layout-product';
		$section_args = array(
			'title'           => __( 'Products', 'make-plus' ),
			'description'     => '',
		);

		// Check for deprecated filter.
		if ( has_filter( 'ttfmp_shop_layout_product_description' ) ) {
			$this->compatibility()->deprecated_hook(
				'ttfmp_shop_layout_product_description',
				'1.7.0',
				sprintf(
					__( 'Use the %s hook instead.', 'make-plus' ),
					'<code>makeplus_ecommerce_layoutproduct_description</code>'
				)
			);

			/**
			 * Filter the description of the Layout: Product section.
			 *
			 * @since 1.5.0.
			 * @deprecated 1.7.0.
			 *
			 * @param string $description    The control description.
			 */
			$section_args['description'] = apply_filters( 'ttfmp_shop_layout_product_description', $section_args['description'] );
		}

		/**
		 * Filter: Change the description of the Layout: Product section in the Customizer.
		 *
		 * Useful for specifying what constitutes the "Product" view.
		 *
		 * @since 1.7.0.
		 *
		 * @param string $description
		 */
		$section_args['description'] = apply_filters( 'makeplus_ecommerce_layoutproduct_description', $section_args['description'] );

		if ( $wp_customize->get_panel( $panel_id ) ) {
			$panel_sections = $this->theme()->customizer_controls()->get_panel_sections( $wp_customize, $panel_id );
			$last_priority = (int) $this->theme()->customizer_controls()->get_last_priority( $panel_sections );

			$section_args['panel'] = $panel_id;
			$section_args['priority'] = $last_priority + 5;
		}

		// Add the section
		$wp_customize->add_section( $section_id, $section_args );

		foreach ( $setting_ids as $setting_id ) {
			// Skip settings that don't exist
			if ( ! $this->theme()->thememod()->setting_exists( $setting_id ) ) {
				continue;
			}

			// Setting
			$wp_customize->add_setting( $setting_id, array(
				'default'              => $this->theme()->thememod()->get_default( $setting_id ),
				'sanitize_callback'    => array( $this->theme()->customizer_controls(), 'sanitize' ),
				'sanitize_js_callback' => array( $this->theme()->customizer_controls(), 'sanitize_js' ),
			) );

			// Control
			$control_id = 'ttfmake_' . $setting_id;
			$control_copy = $wp_customize->get_control( 'ttfmake_' . str_replace( 'product', 'post', $setting_id ) ); // Get an existing control to copy properties from
			if ( $control_copy instanceof WP_Customize_Control ) {
				$wp_customize->add_control( $control_id, array(
					'settings' => $setting_id,
					'section'  => $section_id,
					'label'    => $control_copy->label,
					'type'     => $control_copy->type,
				) );
			}
		}
	}
}