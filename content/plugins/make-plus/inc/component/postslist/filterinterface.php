<?php
/**
 * @package Make Plus
 */

/**
 * Interface MAKEPLUS_Component_PostsList_FilterInterface
 *
 * @since 1.7.0.
 */
interface MAKEPLUS_Component_PostsList_FilterInterface {
	public function render_choice_list( $post_type, $current_value = null );

	public function sanitize_filter_choice( $value, $post_type );

	public function upgrade_filter_choice( $value );
}