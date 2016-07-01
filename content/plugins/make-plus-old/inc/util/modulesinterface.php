<?php
/**
 * @package Make
 */

/**
 * Interface MAKEPLUS_Util_ModulesInterface
 *
 * @since 1.7.0.
 */
interface MAKEPLUS_Util_ModulesInterface {
	public function get_module( $module_name );

	public function has_module( $module_name );
}