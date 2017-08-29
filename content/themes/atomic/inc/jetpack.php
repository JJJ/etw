<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Atomic
 */

/**
 * Add theme support for Jetpack Features.
 */
if ( ! function_exists( 'atomic_jetpack_setup' ) ) :
function atomic_jetpack_setup() {
	/**
	 * Add support for Infinite Scroll
	 */
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'post-wrapper',
		'footer'         => 'page',
		'footer_widgets' => array( 'footer-1', 'footer-2', 'footer-3' ),
		'render'         => 'atomic_render_infinite_posts',
		'wrapper'        => 'new-infinite-posts',
	) );

	/**
	 * Add support for Featured Content
	 */
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'atomic_featured_content',
		'max_posts'               => 4,
	) );

	/**
	 * Add support for Responsive Videos
	 */
	add_theme_support( 'jetpack-responsive-videos' );

	/**
	 * Add support for Testimonials
	 */
	add_theme_support( 'jetpack-testimonial' );

	/**
	 * Enable Jetpack Portfolio support
	 */
	add_theme_support( 'jetpack-portfolio' );
} endif;
add_action( 'after_setup_theme', 'atomic_jetpack_setup' );


/**
 * Adjust content width for tiled gallery
 */
function atomic_custom_tiled_gallery_width() {
    return '1600';
}
add_filter( 'tiled_gallery_content_width', 'atomic_custom_tiled_gallery_width' );


/**
 * Remove Related Posts CSS
 */
function atomic_rp_css() {
	wp_deregister_style( 'jetpack_related-posts' );
}
add_action( 'wp_print_styles', 'atomic_rp_css' );
add_filter( 'jetpack_implode_frontend_css', '__return_false' );


/**
 * Render infinite posts by using template parts
 */
function atomic_render_infinite_posts() {
	while ( have_posts() ) {
		the_post();

		if ( 'full-post' === get_option( 'atomic_layout_style', 'excerpt' ) ) {
			get_template_part( 'template-parts/content' );
		} else if ( has_post_format( array( 'gallery', 'video' ) ) ) {
			get_template_part( 'template-parts/content-index-media' );
		} else {
			get_template_part( 'template-parts/content-index' );
		}
	}
}


/**
 * Changes the text of the "Older posts" button in infinite scroll
 */
function atomic_infinite_scroll_button_text( $js_settings ) {
	$js_settings['text'] = esc_html__( 'Load more', 'atomic' );
	return $js_settings;
}
add_filter( 'infinite_scroll_js_settings', 'atomic_infinite_scroll_button_text' );


/**
 * Get our Featured Content posts
 */
function atomic_get_featured_content() {
	return apply_filters( 'atomic_featured_content', array() );
}


/**
 * Count the Featured Content posts
 */
function atomic_has_featured_posts( $minimum = 1 ) {

	$minimum = absint( $minimum );
	$featured_posts = apply_filters( 'atomic_featured_content', array() );

	if ( ! is_array( $featured_posts ) )
		return false;

	if ( $minimum > count( $featured_posts ) )
		return false;

	return true;
}


/**
 * Move Related Posts
 */
function atomic_remove_rp() {
    if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
        $jprp = Jetpack_RelatedPosts::init();
        $callback = array( $jprp, 'filter_add_target_to_dom' );
        remove_filter( 'post_flair', $callback, 40 );
        remove_filter( 'the_content', $callback, 40 );
    }
}
add_filter( 'wp', 'atomic_remove_rp', 20 );


/**
 * Show 4 related posts
 */
function atomic_more_related_posts( $options ) {
    $options['size'] = 4;
    return $options;
}
add_filter( 'jetpack_relatedposts_filter_options', 'atomic_more_related_posts' );


/**
 * Add featured content class to posts
 */
function atomic_featured_class( $classes ) {
	$featured_options = get_option( 'featured-content' );
	$featured_name    = $featured_options[ 'tag-name' ];
	$featured_id      = $featured_options[ 'tag-id' ];

	// Add featured tag class
	if( has_tag( $featured_id ) ) {
		$classes[] = 'featured-content';
	}

	return $classes;
}
add_filter( 'post_class', 'atomic_featured_class' );


/**
 * Remove flair from excerpts and content
 */
function atomic_remove_flair() {
	// Remove Poll
	remove_filter( 'the_content', 'polldaddy_show_rating' );
	remove_filter( 'the_excerpt', 'polldaddy_show_rating' );
	// Remove sharing
	remove_filter( 'the_content', 'sharing_display', 19 );
	remove_filter( 'the_excerpt', 'sharing_display', 19 );
}
add_action( 'loop_start', 'atomic_remove_flair' );


/**
 * Remove auto output of Sharing and Likes
 */
function atomic_remove_sharing() {
	if ( function_exists( 'sharing_display' ) ) {
		remove_filter( 'the_content', 'sharing_display', 19 );
		remove_filter( 'the_excerpt', 'sharing_display', 19 );
	}

	if ( class_exists( 'Jetpack_Likes' ) ) {
		remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
		remove_filter( 'the_excerpt', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
	}
}

/**
 * Add Gallery and Video support to Portfolio
 */
function atomic_add_portfolio_format() {
    add_post_type_support( 'jetpack-portfolio', 'post-formats' );
}
add_action( 'init', 'atomic_add_portfolio_format', 100 );
