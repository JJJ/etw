<?php
/**
 * @package Make Plus
 */

/**
 * Interface MAKEPLUS_Component_Panels_SettingsInterface
 *
 * @since 1.7.0.
 */
interface MAKEPLUS_Component_Panels_SettingsInterface {
	public function get_settings( $property = 'all' );

	public function sanitize_value( $value, $setting_id );
}