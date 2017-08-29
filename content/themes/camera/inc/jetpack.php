<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Camera
 */

function camera_jetpack_setup() {
	/**
	 * Add theme support for Infinite Scroll.
	 */
	add_theme_support( 'infinite-scroll', array(
		'container' => 'primary',
		'render'    => 'camera_render_infinite_posts',
		'type'      => 'click'
	) );
}
add_action( 'after_setup_theme', 'camera_jetpack_setup' );

/* Render infinite posts by using template parts */
function camera_render_infinite_posts() {
	while ( have_posts() ) {
		the_post();

		get_template_part( 'content', get_post_format() );
	}
}

/**
 * Add theme support for Responsive Videos
 */
function camera_jetpackme_responsive_videos_setup() {
    add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'camera_jetpackme_responsive_videos_setup' );
