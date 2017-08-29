<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Baseline
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function baseline_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'post-wrapper',
		'footer'    => 'page',
		'render'    => 'baseline_render_infinite_posts',
		'wrapper'   => 'new-infinite-posts',
	) );
}
add_action( 'after_setup_theme', 'baseline_jetpack_setup' );

/* Render infinite posts by using template parts */
function baseline_render_infinite_posts() {
	while ( have_posts() ) {
		the_post();

		if ( 'one-column' === get_option( 'baseline_customizer_post_style', 'one-column' ) ) {
			get_template_part( 'template-parts/content' );
		} else {
			get_template_part( 'template-parts/content-grid-item' );
		}
	}
}

/**
 * Add theme support for Responsive Videos
 */
function baseline_jetpackme_responsive_videos_setup() {
    add_theme_support( 'jetpack-responsive-videos' );
}


/**
 * Add support for Featured Content
 */
if ( ! function_exists( 'baseline_featured_content_support' ) ) :
function baseline_featured_content_support() {
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'baseline_featured_content',
		'max_posts'               => 10,
	) );
}
add_action( 'after_setup_theme', 'baseline_featured_content_support' );
endif;


/**
 * Changes the text of the "Older posts" button in infinite scroll
 * for portfolio related views.
 */
function baseline_infinite_scroll_button_text( $js_settings ) {

	$js_settings['text'] = esc_html__( 'Load more', 'baseline' );

	return $js_settings;
}
add_filter( 'infinite_scroll_js_settings', 'baseline_infinite_scroll_button_text' );


/**
 * Move Sharing and Likes
 */
function baseline_remove_share() {
	if( is_single() ) {
		remove_filter( 'post_flair', 'sharing_display', 20 );
		remove_filter( 'the_content', 'sharing_display', 19 );
    		remove_filter( 'the_excerpt', 'sharing_display', 19 );

    		if ( class_exists( 'Jetpack_Likes' ) ) {
			remove_filter( 'post_flair', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
			remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
		}
	}
}
add_action( 'loop_start', 'baseline_remove_share' );


/**
 * Get our Featured Content posts
 */
function baseline_get_featured_content() {
	return apply_filters( 'baseline_featured_content', array() );
}


/**
 * Count the Featured Content posts
 */
function baseline_has_featured_posts( $minimum = 1 ) {
	if ( is_paged() )
		return false;

	$minimum        = absint( $minimum );
	$featured_posts = apply_filters( 'baseline_featured_content', array() );

	if ( ! is_array( $featured_posts ) )
		return false;

	if ( $minimum > count( $featured_posts ) )
		return false;

	return true;
}


/**
 * Move Related Posts
 */
function baseline_remove_rp() {
    if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
        $jprp = Jetpack_RelatedPosts::init();
        $callback = array( $jprp, 'filter_add_target_to_dom' );
        remove_filter( 'post_flair', $callback, 40 );
        remove_filter( 'the_content', $callback, 40 );
    }
}
add_filter( 'wp', 'baseline_remove_rp', 20 );
