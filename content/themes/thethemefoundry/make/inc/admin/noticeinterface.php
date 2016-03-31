<?php
/**
 * @package Make
 */

/**
 * Interface MAKE_Admin_NoticeInterface
 *
 * @since 1.7.0.
 */
interface MAKE_Admin_NoticeInterface {
	public function register_admin_notice( $id, $message, $args = array() );
}