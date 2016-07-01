<?php
/**
 * @package Make Plus
 */

/**
 * Interface MAKEPLUS_Component_PerPage_MetaboxInterface
 *
 * @since 1.7.0.
 */
interface MAKEPLUS_Component_PerPage_MetaboxInterface extends MAKEPLUS_Util_ModulesInterface {
	public function control_heading( $label, $class = '' );

	public function control_item( WP_Post $post, $type, $setting_id, $label = '', $class = '' );

	public function control_override( $setting_id, $value );

	public function control_setting_checkbox( $setting_id, $value, $label, $override );

	public function control_setting_select( $setting_id, $value, $deprecated, $override );
}