<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_Builder_Enhancements
 *
 * Container class for loading various Builder enhancements.
 *
 * @since 1.5.1.
 * @since 1.7.0. Renamed from TTFMP_Builder_Tweaks
 */
final class MAKEPLUS_Component_Builder_Enhancements extends MAKEPLUS_Util_Modules {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'mode'  => 'MAKEPLUS_Setup_ModeInterface',
	);

	/**
	 * MAKEPLUS_Component_Builder_Enhancements constructor.
	 *
	 * @since 1.7.0.
	 *
	 * @param MAKEPLUS_APIInterface $api
	 * @param array                 $modules
	 */
	public function __construct( MAKEPLUS_APIInterface $api, array $modules = array() ) {
		parent::__construct( $api, $modules );

		global $pagenow;

		$ajax = defined( 'DOING_AJAX' ) && DOING_AJAX;

		// Section ID
		if ( ! is_admin() || in_array( $pagenow, array( 'post-new.php', 'post.php' ) ) || $ajax ) {
			$this->add_module( 'section_id', new MAKEPLUS_Component_Builder_Enhancement_SectionID );
		}

		// Section Classes
		if ( ! is_admin() || in_array( $pagenow, array( 'post-new.php', 'post.php' ) ) || $ajax ) {
			$this->add_module( 'section_classes', new MAKEPLUS_Component_Builder_Enhancement_SectionClasses );
		}

		// Section Space
		if ( $this->mode()->has_make_api() ) {
			$this->add_module( 'section_space', new MAKEPLUS_Component_Builder_Enhancement_SectionSpace );
		}
	}
}