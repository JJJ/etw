<?php
/**
 * @package Make Plus
 */

/**
 * Interface MAKEPLUS_Component_PerPage_SettingsInterface
 *
 * @since 1.7.0.
 */
interface MAKEPLUS_Component_PerPage_SettingsInterface extends MAKEPLUS_Util_ModulesInterface {
	public function get_global_settings( $view_id );

	public function get_post_settings( WP_Post $post = null );

	public function get_post_overrides( WP_Post $post = null );
}