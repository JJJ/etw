<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Designer
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function designer_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'post-wrapper',
		'footer'    => 'page',
		'render'    => 'designer_render_infinite_posts',
		'wrapper'   => 'new-infinite-posts',
		'type'      => 'click'
	) );
}
add_action( 'after_setup_theme', 'designer_jetpack_setup' );

/* Render infinite posts by using template parts */
function designer_render_infinite_posts() {
	while ( have_posts() ) {
		the_post();

		if ( 'jetpack-portfolio' == get_post_type() ) {
 			get_template_part( 'content', 'portfolio-thumbs' );
		} elseif( 'minimal' == get_option( 'designer_customizer_blog_style' ) ) {
			get_template_part( 'content', 'minimal' );
 		} else {
 			get_template_part( 'content', get_post_format() );
 		}
	}
}

/**
 * Add theme support for Responsive Videos
 */
function designer_jetpackme_responsive_videos_setup() {
    add_theme_support( 'jetpack-responsive-videos' );
}