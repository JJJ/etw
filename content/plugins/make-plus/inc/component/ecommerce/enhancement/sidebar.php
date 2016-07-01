<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_ECommerce_Enhancement_Sidebar
 *
 * Enable a "Shop" sidebar that can be used as an alternative to one of the default sidebars in various views.
 *
 * @since 1.7.0.
 */
final class MAKEPLUS_Component_ECommerce_Enhancement_Sidebar extends MAKEPLUS_Util_Modules implements MAKEPLUS_Util_HookInterface {
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
	 * The ID of the Shop Sidebar.
	 *
	 * @since 1.7.0.
	 *
	 * @var string
	 */
	private $sidebar_id = 'sidebar-shop';

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

		// Add the sidebar
		add_filter( 'makeplus_get_sidebars', array( $this, 'add_sidebar' ) );

		// Update settings
		add_action( 'make_settings_thememod_loaded', array( $this, 'update_settings' ), 30 );

		// Convert old settings
		add_action( 'after_setup_theme', array( $this, 'convert_old_settings' ) );

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
	 * Add the Shop Sidebar to the array of available sidebars.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked filter makeplus_get_sidebars
	 *
	 * @param array $sidebars
	 *
	 * @return array
	 */
	public function add_sidebar( array $sidebars ) {
		if ( ! isset( $sidebars[ $this->sidebar_id ] ) ) {
			$sidebars[ $this->sidebar_id ] = array(
				'name'        => esc_html__( 'Shop Sidebar', 'make-plus' ),
				'description' => esc_html__( 'A widget area for your Shop. Choose where this sidebar is displayed in the Layout panel of the Customizer.', 'make-plus' ),
				'context'     => 'makeplus-ecommerce-sidebar',
			);
		}

		return $sidebars;
	}

	/**
	 * Update the defaults for the right sidebar in shop-related views.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action make_settings_thememod_loaded
	 *
	 * @param MAKE_Settings_ThemeModInterface $settings
	 *
	 * @return bool
	 */
	public function update_settings( MAKE_Settings_ThemeModInterface $settings ) {
		if ( $settings->setting_exists( 'layout-shop-sidebar-right' ) && $settings->setting_exists( 'layout-product-sidebar-right' ) ) {
			return $settings->add_settings(
				array(
					'layout-shop-sidebar-right'    => array(),
					'layout-product-sidebar-right' => array(),
				),
				array(
					'default' => $this->sidebar_id
				),
				true // Update existing settings
			);
		}

		return false;
	}

	/**
	 * Look for old settings related to the Shop Sidebar and convert them when necessary.
	 *
	 * This adds a flag to the theme mod array after it runs, so it should only run once.
	 *
	 * The old settings are preserved in the array in case of rollback to an earlier version.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action after_setup_theme
	 *
	 * @return void
	 */
	public function convert_old_settings() {
		// Bail if this conversion process has already been run.
		if ( true === get_theme_mod( 'makeplus-ecommerce-sidebar-converted' ) ) {
			return;
		}

		$views = array_keys( $this->theme()->view()->get_sorted_views() );
		$theme_mods = get_theme_mods();

		foreach ( $views as $view ) {
			$old_key = 'layout-' . $view . '-shop-sidebar';

			if ( isset( $theme_mods[ $old_key ] ) ) {
				// Determine which sidebar location is involved.
				switch ( $theme_mods[ $old_key ] ) {
					case 'left' :
						$sidebar_key = 'layout-' . $view . 'sidebar-left';
						break;
					case 'right' :
						$sidebar_key = 'layout-' . $view . 'sidebar-right';
						break;
					default:
						$sidebar_key = '';
				}

				// Update the sidebar value
				if (
					$sidebar_key // valid sidebar location
					&&
					$this->theme()->thememod()->setting_exists( $sidebar_key ) // is a valid setting
					&&
					$this->theme()->thememod()->get_value( $sidebar_key ) // sidebar is set to display in this view
				) {
					// Update the sidebar value to the ID of the Shop Sidebar
					$this->theme()->thememod()->set_value( $sidebar_key, $this->sidebar_id );
				}
			}
		}

		// Migrate the old WooCommerce shop sidebar to the shared ecommerce shop sidebar
		$sidebars = get_option( 'sidebars_widgets' );
		if ( isset( $sidebars['sidebar-shop-woocommerce'] ) && ! isset( $sidebars[ $this->sidebar_id ] ) ) {
			$sidebars[ $this->sidebar_id ] = $sidebars['sidebar-shop-woocommerce'];
			unset( $sidebars['sidebar-shop-woocommerce'] );
			update_option( 'sidebars_widgets', $sidebars );
		}

		// Add a flag that the conversion has been run.
		set_theme_mod( 'makeplus-ecommerce-sidebar-converted', true );
	}
}