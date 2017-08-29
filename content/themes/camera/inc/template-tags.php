<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Camera
 */

if ( ! function_exists( 'camera_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function camera_paging_nav( $query = false ) {

	global $wp_query;
	if( $query ) {
		$temp_query = $wp_query;
		$wp_query = $query;
	}

	// Return early if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	} ?>
	<nav class="navigation paging-navigation container" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'camera' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
				<!-- Paging text for posts -->
				<?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older Posts', 'camera' ) ); ?>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
				<!-- Paging text for posts -->
				<?php previous_posts_link( __( 'Newer Posts <span class="meta-nav">&rarr;</span>', 'camera' ) ); ?>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
	if( isset( $temp_query ) ) {
		$wp_query = $temp_query;
	}
}
endif;

if ( ! function_exists( 'camera_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function camera_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	if ( $previous ) { ?>
		<li class="nav-previous">
			<span><?php _e( 'Previous Post', 'camera' ); ?></span>
			<?php previous_post_link( '%link', _x( '%title', 'Previous post link', 'camera' ) ); ?>
		</li>
	<?php }

	if ( $next ) { ?>
		<li class="nav-next">
			<span><?php _e( 'Next Post', 'camera' ); ?></span>
			<?php next_post_link( '%link', _x( '%title', 'Next post link', 'camera' ) ); ?>
		</li>
	<?php }

}
endif;

if ( ! function_exists( 'camera_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function camera_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( __( '<span class="posted-on"><i class="fa fa-clock-o"></i> %1$s</span>', 'camera' ),
		sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
			esc_url( get_permalink() ),
			$time_string
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		)
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function camera_categorized_blog() {
	if ( false === ( $camera_count_cats = get_transient( 'camera_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$camera_count_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$camera_count_cats = count( $camera_count_cats );

		set_transient( 'camera_categories', $camera_count_cats );
	}

	if ( $camera_count_cats > 1 ) {
		// This blog has more than 1 category so camera_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so camera_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in camera_categorized_blog.
 */
function camera_category_transient_flusher() {
	delete_transient( 'camera_categories' );
}
add_action( 'edit_category', 'camera_category_transient_flusher' );
add_action( 'save_post',     'camera_category_transient_flusher' );


/**
 * Check if there are any published posts
 */
function camera_check_posts() {
  return ( wp_count_posts()->publish > 0 ) ? true : false;
}
