<?php
/**
 * @package Make Plus
 */

/**
 * Interface MAKEPLUS_Sidebars_ManagerInterface
 *
 * @since 1.7.0.
 */
interface MAKEPLUS_Sidebars_ManagerInterface {
	public function get_sidebars();

	public function has_sidebar( $id = null );

	public function add_sidebar( $id, $name, $description );

	public function remove_sidebar( $id );

	public function sanitize_sidebars( $sidebars );
}