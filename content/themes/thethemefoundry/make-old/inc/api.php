<?php
/**
 * @package Make
 */

/**
 * Class MAKE_API
 *
 * @since 1.7.0.
 */
class MAKE_API extends MAKE_Util_Modules implements MAKE_APIInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'l10n'                => 'MAKE_Setup_L10nInterface',
		'error'               => 'MAKE_Error_CollectorInterface',
		'compatibility'       => 'MAKE_Compatibility_MethodsInterface',
		'plus'                => 'MAKE_Plus_MethodsInterface',
		'notice'              => 'MAKE_Admin_NoticeInterface',
		'choices'             => 'MAKE_Choices_ManagerInterface',
		'font'                => 'MAKE_Font_ManagerInterface',
		'view'                => 'MAKE_Layout_ViewInterface',
		'thememod'            => 'MAKE_Settings_ThemeModInterface',
		'widgets'             => 'MAKE_Setup_WidgetsInterface',
		'scripts'             => 'MAKE_Setup_ScriptsInterface',
		'style'               => 'MAKE_Style_ManagerInterface',
		'builder'             => 'MAKE_Builder_SetupInterface',
		'formatting'          => 'MAKE_Formatting_ManagerInterface',
		'galleryslider'       => 'MAKE_GallerySlider_SetupInterface',
		'logo'                => 'MAKE_Logo_MethodsInterface',
		'socialicons'         => 'MAKE_SocialIcons_ManagerInterface',
		'customizer_controls' => 'MAKE_Customizer_ControlsInterface',
		'customizer_preview'  => 'MAKE_Customizer_PreviewInterface',
		'integration'         => 'MAKE_Integration_ManagerInterface',
		'setup'               => 'MAKE_Setup_MiscInterface',
		'head'                => 'MAKE_Setup_HeadInterface',
	);

	/**
	 * An associative array of the default classes to use for each dependency.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	private $defaults = array(
		'l10n'                => 'MAKE_Setup_L10n',
		'error'               => 'MAKE_Error_Collector',
		'compatibility'       => 'MAKE_Compatibility_Methods',
		'plus'                => 'MAKE_Plus_Methods',
		'notice'              => 'MAKE_Admin_Notice',
		'choices'             => 'MAKE_Choices_Manager',
		'font'                => 'MAKE_Font_Manager',
		'view'                => 'MAKE_Layout_View',
		'thememod'            => 'MAKE_Settings_ThemeMod',
		'widgets'             => 'MAKE_Setup_Widgets',
		'scripts'             => 'MAKE_Setup_Scripts',
		'style'               => 'MAKE_Style_Manager',
		'builder'             => 'MAKE_Builder_Setup',
		'formatting'          => 'MAKE_Formatting_Manager',
		'galleryslider'       => 'MAKE_GallerySlider_Setup',
		'logo'                => 'MAKE_Logo_Methods',
		'socialicons'         => 'MAKE_SocialIcons_Manager',
		'customizer_controls' => 'MAKE_Customizer_Controls',
		'customizer_preview'  => 'MAKE_Customizer_Preview',
		'integration'         => 'MAKE_Integration_Manager',
		'setup'               => 'MAKE_Setup_Misc',
		'head'                => 'MAKE_Setup_Head',
	);

	/**
	 * MAKE_API constructor.
	 *
	 * @since 1.7.0.
	 *
	 * @param array $modules
	 */
	public function __construct( array $modules = array() ) {
		$modules = wp_parse_args( $modules, $this->get_default_modules() );

		// Remove conditional dependencies
		if ( ! is_admin() ) {
			unset( $this->dependencies['notice'] );

			if ( ! is_customize_preview() ) {
				unset( $this->dependencies['customizer_controls'] );
				unset( $this->dependencies['customizer_preview'] );
			}
		}

		parent::__construct( $this, $modules );
	}

	/**
	 * Getter for the private defaults array.
	 *
	 * @since 1.7.0.
	 *
	 * @return array
	 */
	private function get_default_modules() {
		return $this->defaults;
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