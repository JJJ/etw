<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_ECommerce_Enhancements
 *
 * Various Ecommerce-related theme enhancements that can be enabled via theme support.
 *
 * @since 1.2.0.
 * @since 1.7.0. Changed class name from TTFMP_Shop_Settings.
 */
final class MAKEPLUS_Component_ECommerce_Enhancements extends MAKEPLUS_Util_Modules implements MAKEPLUS_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'mode'          => 'MAKEPLUS_Setup_ModeInterface',
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

		// Load enhancements
		add_action( 'makeplus_components_loaded', array( $this, 'load_enhancements' ), 20 );

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
	 * Load each Ecommerce enhancement module that the theme supports.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action makeplus_components_loaded
	 *
	 * @param MAKEPLUS_APIInterface $api
	 *
	 * @return void
	 */
	public function load_enhancements( MAKEPLUS_APIInterface $api ) {
		// Layout: Shop
		if ( current_theme_supports( 'makeplus-ecommerce-layoutshop' ) || current_theme_supports( 'ttfmp-shop-layout-shop' ) ) {
			if ( current_theme_supports( 'ttfmp-shop-layout-shop' ) ) {
				$this->compatibility()->doing_it_wrong(
					'ttfmp-shop-layout-shop',
					sprintf(
						__( 'Add theme support for %s instead.', 'make-plus' ),
						'<code>makeplus-ecommerce-layoutshop</code>'
					),
					'1.7.0'
				);
			}

			$this->add_module( 'layout_shop', new MAKEPLUS_Component_ECommerce_Enhancement_LayoutShop( $api ) );
		}

		// Layout: Product
		if ( current_theme_supports( 'makeplus-ecommerce-layoutproduct' ) || current_theme_supports( 'ttfmp-shop-layout-product' ) ) {
			if ( current_theme_supports( 'ttfmp-shop-layout-product' ) ) {
				$this->compatibility()->doing_it_wrong(
					'ttfmp-shop-layout-product',
					sprintf(
						__( 'Add theme support for %s instead.', 'make-plus' ),
						'<code>makeplus-ecommerce-layoutproduct</code>'
					),
					'1.7.0'
				);
			}

			$this->add_module( 'layout_product', new MAKEPLUS_Component_ECommerce_Enhancement_LayoutProduct( $api ) );
		}

		// Shop Sidebar
		if ( current_theme_supports( 'makeplus-ecommerce-sidebar' ) || current_theme_supports( 'ttfmp-shop-sidebar' ) ) {
			if ( current_theme_supports( 'ttfmp-shop-sidebar' ) ) {
				$this->compatibility()->doing_it_wrong(
					'ttfmp-shop-sidebar',
					sprintf(
						__( 'Add theme support for %s instead.', 'make-plus' ),
						'<code>makeplus-ecommerce-sidebar</code>'
					),
					'1.7.0'
				);
			}

			$this->add_module( 'shop_sidebar', new MAKEPLUS_Component_ECommerce_Enhancement_Sidebar( $api ) );
		}

		// Highlight Color
		if ( current_theme_supports( 'makeplus-ecommerce-colorhighlight' ) || current_theme_supports( 'ttfmp-shop-color-highlight' ) ) {
			if ( current_theme_supports( 'ttfmp-shop-color-highlight' ) ) {
				$this->compatibility()->doing_it_wrong(
					'ttfmp-shop-color-highlight',
					sprintf(
						__( 'Add theme support for %s instead.', 'make-plus' ),
						'<code>makeplus-ecommerce-colorhighlight</code>'
					),
					'1.7.0'
				);
			}

			$this->add_module( 'color_highlight', new MAKEPLUS_Component_ECommerce_Enhancement_ColorHighlight( $api ) );
		}
	}
}