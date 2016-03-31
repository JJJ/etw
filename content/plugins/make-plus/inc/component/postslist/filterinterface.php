<?php
/**
 * @package Make Plus
 */


interface MAKEPLUS_Component_PostsList_FilterInterface {
	public function render_choice_list( $post_type, $current_value = null );

	public function sanitize_filter_choice( $value, $post_type );

	public function upgrade_filter_choice( $value );
}