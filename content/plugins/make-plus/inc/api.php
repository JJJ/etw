<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_API
 *
 * Class to manage and provide access to all of the modules and components that make up the Make Plus API.
 *
 * Access this class via the global MakePlus() function.
 *
 * @since 1.7.0.
 */
final class MAKEPLUS_API extends MAKEPLUS_Util_Modules implements MAKEPLUS_APIInterface, MAKEPLUS_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'mode'          => 'MAKEPLUS_Setup_ModeInterface',
		'l10n'          => 'MAKEPLUS_Setup_L10nInterface',
		'compatibility' => 'MAKEPLUS_Compatibility_MethodsInterface',
		'notice'        => 'MAKEPLUS_Admin_NoticeInterface',
		'sidebars'      => 'MAKEPLUS_Sidebars_ManagerInterface',
	);

	/**
	 * An associative array of the default classes to use for each dependency.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	private $defaults = array(
		'mode'          => 'MAKEPLUS_Setup_Mode',
		'l10n'          => 'MAKEPLUS_Setup_L10n',
		'compatibility' => 'MAKEPLUS_Compatibility_Methods',
		'notice'        => 'MAKEPLUS_Admin_Notice',
		'sidebars'      => 'MAKEPLUS_Sidebars_Manager',
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
	 * MAKEPLUS_API constructor.
	 *
	 * @since 1.7.0.
	 *
	 * @param array $modules
	 */
	public function __construct( array $modules = array() ) {
		$modules = wp_parse_args( $modules, $this->defaults );

		// Remove conditional dependencies
		if ( ! is_admin() ) {
			unset( $this->dependencies['notice'] );
		}

		parent::__construct( $this, $modules );
	}

	/**
	 * Magic method to handle some properties from the deprecated TTFMP_App class.
	 *
	 * @since 1.7.0.
	 *
	 * @param string $name
	 *
	 * @return bool|null|string
	 */
	public function __get( $name ) {
		switch ( $name ) {
			case 'version' :
				return MAKEPLUS_VERSION;
				break;

			case 'passive' :
				return 'passive' === $this->mode()->get_mode();
				break;

			default :
				trigger_error(
					sprintf(
						esc_html__( 'Undefined property: %1$s::%2$s', 'make-plus' ),
						get_class( $this ),
						esc_html( $name )
					)
				);
				return null;
				break;
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

		// Kick things off after the theme is set up.
		add_action( 'after_setup_theme', array( $this, 'load_theme_api' ), 1 );
		add_action( 'after_setup_theme', array( $this, 'load_components' ), 2 );

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
	 * Add the theme's API object as a module, if it exists.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action after_setup_theme
	 *
	 * @return bool
	 */
	public function load_theme_api() {
		// Get Make API
		if ( $this->mode()->has_make_api() ) {
			return $this->add_module( 'theme', Make() );
		}

		return false;
	}

	/**
	 * Return the list of components and their conditions for activation.
	 *
	 * @since 1.7.0.
	 *
	 * @return array
	 */
	private function get_component_list() {
		return array(
			// Builder Enhancements
			'builder_enhancements'   => array(
				'class'      => 'MAKEPLUS_Component_Builder_Enhancements',
				'conditions' => array(
					$this->mode()->is_make_active_theme(),
					true === version_compare( $this->mode()->get_make_version(), '1.4.5', '>=' ),
				),
			),
			// Column Size
			'columnsize'             => array(
				'class'      => 'MAKEPLUS_Component_ColumnSize_Setup',
				'conditions' => array(
					'active' === $this->mode()->get_mode(),
				),
			),
			// Custom Sidebars
			'customsidebars'         => array(
				'class'      => 'MAKEPLUS_Component_CustomSidebars_Setup',
				'conditions' => array(
					'active' === $this->mode()->get_mode(),
				),
			),
			// Duplicator
			'duplicator'             => array(
				'class'      => 'MAKEPLUS_Component_Duplicator_Setup',
				'conditions' => array(
					$this->mode()->is_make_active_theme(),
					true === version_compare( $this->mode()->get_make_version(), '1.0.6', '>=' ),
					is_admin(),
				),
			),
			// Font Weight
			'fontweight'             => array(
				'class'      => 'MAKEPLUS_Component_FontWeight_Setup',
				'conditions' => array(
					'active' === $this->mode()->get_mode(),
				),
			),
			// E-Commerce
			'ecommerce_enhancements' => array(
				'class'      => 'MAKEPLUS_Component_ECommerce_Enhancements',
				'conditions' => array(
					'active' === $this->mode()->get_mode(),
				),
			),
			// Easy Digital Downloads
			'edd'                    => array(
				'class'      => 'MAKEPLUS_Component_EDD_Setup',
				'conditions' => array(
					'active' === $this->mode()->get_mode(),
					( $this->mode()->is_plugin_active( 'easy-digital-downloads/easy-digital-downloads.php' ) || defined( 'EDD_VERSION' ) )
				),
			),
			// Panels
			'panels'                 => array(
				'class'      => 'MAKEPLUS_Component_Panels_Setup',
				'conditions' => array(
					'active' === $this->mode()->get_mode(),
				),
			),
			// Parallax
			'parallax'               => array(
				'class'      => 'MAKEPLUS_Component_Parallax_Setup',
				'conditions' => array(
					$this->mode()->is_make_active_theme(),
					true === version_compare( $this->mode()->get_make_version(), '1.6.1', '>=' ),
				),
			),
			// Per Page
			'perpage'                => array(
				'class'      => 'MAKEPLUS_Component_PerPage_Setup',
				'conditions' => array(
					'active' === $this->mode()->get_mode(),
				),
			),
			// Posts List
			'postslist'              => array(
				'class'      => 'MAKEPLUS_Component_PostsList_Setup',
				'conditions' => array(
					// This component includes a shortcode, so it should always be activated.
					true,
				),
			),
			// Sticky Header
			'stickyheader'           => array(
				'class'      => 'MAKEPLUS_Component_StickyHeader_Setup',
				'conditions' => array(
					'active' === $this->mode()->get_mode(),
				),
			),
			// Typekit
			'typekit'                => array(
				'class'      => 'MAKEPLUS_Component_Typekit_Setup',
				'conditions' => array(
					'active' === $this->mode()->get_mode(),
				),
			),
			// White Label
			'whitelabel'             => array(
				'class'      => 'MAKEPLUS_Component_WhiteLabel_Setup',
				'conditions' => array(
					'active' === $this->mode()->get_mode(),
				),
			),
			// Widget Areas
			'widgetareas'            => array(
				'class'      => 'MAKEPLUS_Component_WidgetAreas_Setup',
				'conditions' => array(
					// This component includes a shortcode, so it should always be activated.
					true,
				),
			),
			// WooCommerce
			'woocommerce'            => array(
				'class'      => 'MAKEPLUS_Component_WooCommerce_Setup',
				'conditions' => array(
					// This component includes a shortcode, so it should always be activated, as long as WooCommerce is also active.
					( $this->mode()->is_plugin_active( 'woocommerce/woocommerce.php' ) || defined( 'WC_VERSION' ) )
				),
			),
		);
	}

	/**
	 * Add components that meet activation conditions to the modules array.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action after_setup_theme
	 *
	 * @return void
	 */
	public function load_components() {
		$components = $this->get_component_list();

		foreach ( $components as $component_name => $component_data ) {
			if ( isset( $component_data['conditions'] ) && ! in_array( false, $component_data['conditions'] ) ) {
				$class_parents = class_parents( $component_data['class'] );

				if ( $class_parents && in_array( 'MAKEPLUS_Util_Modules', $class_parents ) ) {
					$component = $this->create_instance( $component_data['class'], array( $this ) );
				} else {
					$component = $this->create_instance( $component_data['class'] );
				}

				$module_name = 'component_' . $component_name;
				$this->add_module( $module_name, $component );
			}
		}

		/**
		 * Action: Fire when all components have been loaded.
		 *
		 * @since 1.7.0.
		 *
		 * @param MAKEPLUS_APIInterface $api
		 */
		do_action( 'makeplus_components_loaded', $this );
	}

	/**
	 * Wrapper function to check the existence of a component module.
	 *
	 * @param string $component_name
	 *
	 * @return bool
	 */
	public function has_component( $component_name ) {
		return $this->has_module( 'component_' . $component_name );
	}

	/**
	 * Wrapper function to get a component module.
	 *
	 * @param string $component_name
	 *
	 * @return mixed
	 */
	public function get_component( $component_name ) {
		return $this->get_module( 'component_' . $component_name );
	}

	/**
	 * Return the specified module without running its load routine.
	 *
	 * @since 1.7.0.
	 *
	 * @param $module_name
	 *
	 * @return null
	 */
	public function inject_module( $module_name ) {
		// Module exists.
		if ( $this->has_module( $module_name ) ) {
			return $this->modules[ $module_name ];
		}

		// Module doesn't exist. Use the get_module method to generate an error.
		else {
			return $this->get_module( $module_name );
		}
	}
}