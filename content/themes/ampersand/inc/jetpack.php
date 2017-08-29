<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Ampersand
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function ampersand_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'posts',
		'footer'    => 'page',
		'render'    => 'ampersand_render_infinite_posts'
	) );
}
add_action( 'after_setup_theme', 'ampersand_jetpack_setup' );


/* Render infinite posts by using format-standard.php */
function ampersand_render_infinite_posts() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'format', 'standard' );
	};
}