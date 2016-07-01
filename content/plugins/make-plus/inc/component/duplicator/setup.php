<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_Duplicator_Setup
 *
 * Load modules to enable duplicator functionality in the WP Admin.
 *
 * @since 1.1.0.
 * @since 1.7.0. Changed class name from TTFMP_Duplicator.
 */
final class MAKEPLUS_Component_Duplicator_Setup extends MAKEPLUS_Util_Modules {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'page_duplicator'    => 'MAKEPLUS_Component_Duplicator_Page',
		'section_duplicator' => 'MAKEPLUS_Component_Duplicator_Section',
	);

	/**
	 * MAKEPLUS_Component_Duplicator_Setup constructor.
	 *
	 * @since 1.7.0.
	 *
	 * @param MAKEPLUS_APIInterface|null $api
	 * @param array                      $modules
	 */
	public function __construct( MAKEPLUS_APIInterface $api = null, array $modules = array() ) {
		// Module defaults.
		$modules = wp_parse_args( $modules, array(
			'page_duplicator'    => 'MAKEPLUS_Component_Duplicator_Page',
			'section_duplicator' => 'MAKEPLUS_Component_Duplicator_Section',
		) );

		// Load dependencies
		parent::__construct( $api, $modules );
	}
}