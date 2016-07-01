<?php
/**
 * @package Make Plus
 */


class MAKEPLUS_Component_PerPage_Setup extends MAKEPLUS_Util_Modules implements MAKEPLUS_Util_HookInterface {
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
		'settings'      => 'MAKEPLUS_Component_PerPage_SettingsInterface',
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
	 * MAKEPLUS_Component_PerPage_Setup constructor.
	 *
	 * @since 1.7.0.
	 *
	 * @param MAKEPLUS_APIInterface|null $api
	 * @param array                      $modules
	 */
	public function __construct( MAKEPLUS_APIInterface $api = null, array $modules = array() ) {
		// Module defaults.
		$modules = wp_parse_args( $modules, array(
			'settings' => 'MAKEPLUS_Component_PerPage_Settings',
		) );

		// Load dependencies
		parent::__construct( $api, $modules );

		// Add metabox module
		if ( is_admin() ) {
			$this->add_module( 'metabox', new MAKEPLUS_Component_PerPage_Metabox( $api, array( 'settings' => $this->settings() ) ) );
		}
	}

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

		// Update views
		add_action( 'make_view_loaded', array( $this, 'update_views' ), 20 );

		// Override applicable global settings
		if ( ! is_admin() ) {
			add_action( 'wp', array( $this, 'add_mod_filters' ) );
		}

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


	private function get_enabled_views() {
		// Check for deprecated filter.
		if ( has_filter( 'ttfmp_perpage_allowed_keys' ) ) {
			$this->compatibility()->deprecated_hook(
				'ttfmp_perpage_allowed_keys',
				'1.7.0'
			);
		}

		// Check for deprecated filter.
		if ( has_filter( 'ttfmp_perpage_keys' ) ) {
			$this->compatibility()->deprecated_hook(
				'ttfmp_perpage_keys',
				'1.7.0'
			);
		}

		// Check for deprecated filter.
		if ( has_filter( 'ttfmp_perpage_view' ) ) {
			$this->compatibility()->deprecated_hook(
				'ttfmp_perpage_view',
				'1.7.0'
			);
		}

		return array(
			'post'    => array(
				'callback_admin'            => array( $this, 'view_callback_admin_post' ),
				'is_perpage_view'           => true,
				'makeplus_perpage_settings' => array(
					'layout-post-hide-header',
					'layout-post-hide-footer',
					'layout-post-sidebar-left',
					'layout-post-sidebar-right',
					'header-hide-padding-bottom',
					'footer-hide-padding-top',
					'layout-post-featured-images',
					'layout-post-featured-images-alignment',
					'layout-post-post-date',
					'layout-post-post-date-location',
					'layout-post-post-author',
					'layout-post-post-author-location',
					'layout-post-show-categories',
					'layout-post-show-tags',
					'layout-post-comment-count',
					'layout-post-comment-count-location',
					'layout-post-yoast-breadcrumb',
				),
			),
			'page'    => array(
				'callback_admin'            => array( $this, 'view_callback_admin_page' ),
				'is_perpage_view'           => true,
				'makeplus_perpage_settings' => array(
					'layout-page-hide-header',
					'layout-page-hide-footer',
					'layout-page-sidebar-left',
					'layout-page-sidebar-right',
					'header-hide-padding-bottom',
					'footer-hide-padding-top',
					'layout-page-featured-images',
					'layout-page-featured-images-alignment',
					'layout-page-post-date',
					'layout-page-post-date-location',
					'layout-page-post-author',
					'layout-page-post-author-location',
					'layout-page-comment-count',
					'layout-page-comment-count-location',
					'layout-page-hide-title',
					'layout-page-yoast-breadcrumb',
				),
			),
		);
	}


	public function view_callback_admin_post() {
		global $typenow;

		if ( isset( $typenow ) ) {
			return 'post' === $typenow;
		}

		return false;
	}


	public function view_callback_admin_page() {
		global $typenow;

		if ( isset( $typenow ) ) {
			return 'page' === $typenow;
		}

		return false;
	}


	public function update_views( MAKE_Layout_ViewInterface $view ) {
		// Only run this in the proper hook context.
		if ( 'make_view_loaded' !== current_action() ) {
			return;
		}

		// View IDs to update
		$enabled_views = $this->get_enabled_views();

		// Update the view definitions
		foreach ( $enabled_views as $view_id => $properties ) {
			if ( $view->view_exists( $view_id ) ) {
				$view->add_view( $view_id, $properties, true );
			}
		}
	}

	/**
	 * Add the setting overrides for the current view.
	 *
	 * @since  1.0.0.
	 *
	 * @return void
	 */
	public function add_mod_filters() {
		// Only run this in the proper hook context.
		if ( 'wp' !== current_action() ) {
			return;
		}

		global $post;

		$perpage_views = array_keys( $this->theme()->view()->get_views( 'is_perpage_view' ), true );
		$current_view = $this->theme()->view()->get_current_view();

		// Only do this for certain views.
		if ( $post instanceof WP_Post && in_array( $current_view, $perpage_views ) ) {
			$settings = $this->settings()->get_post_settings( $post, false );

			if ( ! empty( $settings ) ) {
				foreach ( array_keys( $settings ) as $setting_id ) {
					add_filter( 'theme_mod_' . $setting_id, array( $this, 'filter_mod' ) );
				}
			}
		}
	}

	/**
	 * Filter a theme mod to override its value.
	 *
	 * @since  1.0.0.
	 *
	 * @param  mixed    $value    The original value of the theme mod
	 * @return mixed              The modified value of the theme mod
	 */
	public function filter_mod( $value ) {
		// Only run this in the proper hook context.
		if ( 0 !== strpos( current_filter(), 'theme_mod_' ) ) {
			return $value;
		}

		global $post;

		$perpage_views = array_keys( $this->theme()->view()->get_views( 'is_perpage_view' ), true );
		$current_view = $this->theme()->view()->get_current_view();

		// Reverse-engineer the setting key from the filter
		$filter = current_filter();
		$setting_id = str_replace( 'theme_mod_', '', $filter );

		// Only do this for certain views.
		if ( $post instanceof WP_Post && in_array( $current_view, $perpage_views ) ) {
			$settings = $this->settings()->get_post_settings( $post, false );

			if ( isset( $settings[ $setting_id ] ) ) {
				$value = $this->theme()->thememod()->sanitize_value( $settings[ $setting_id ], $setting_id );
			}
		}

		return $value;
	}
}