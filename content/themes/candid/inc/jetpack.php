<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Candid
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function candid_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'post-wrapper',
		'footer'    => 'page',
		'render'    => 'candid_render_infinite_posts',
		'wrapper'   => 'new-infinite-posts',
		'type'      => 'click'
	) );
}
add_action( 'after_setup_theme', 'candid_jetpack_setup' );

/* Render infinite posts by using template parts */
function candid_render_infinite_posts() {
	while ( have_posts() ) {
		the_post();

		get_template_part( 'template-parts/content', 'grid-item' );
	}
}

/**
 * Add theme support for Responsive Videos
 */
function candid_jetpackme_responsive_videos_setup() {
    add_theme_support( 'jetpack-responsive-videos' );
}


/**
 * Changes the text of the "Older posts" button in infinite scroll
 * for portfolio related views.
 */
function candid_infinite_scroll_button_text( $js_settings ) {

	$js_settings['text'] = esc_html__( 'Load more', 'candid' );

	return $js_settings;
}
add_filter( 'infinite_scroll_js_settings', 'candid_infinite_scroll_button_text' );
