<?php
/**
 * @package Make
 */

/**
 * Interface MAKEPLUS_Compatibility_MethodsInterface
 *
 * @since 1.7.0.
 */
interface MAKEPLUS_Compatibility_MethodsInterface extends MAKEPLUS_Util_ModulesInterface {
	public function deprecated_function( $function, $version, $replacement = null );

	public function deprecated_hook( $hook, $version, $message = null );

	public function doing_it_wrong( $function, $message, $version = null, $backtrace = null );
}