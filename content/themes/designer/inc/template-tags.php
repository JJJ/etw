<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Designer
 */

if ( ! function_exists( 'designer_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function designer_paging_nav( $query = false ) {

	global $wp_query;
	if( $query ) {
		$temp_query = $wp_query;
		$wp_query = $query;
	}

	// Return early if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	} ?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'designer' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
				<div class="nav-previous">
					<?php if ( 'jetpack-portfolio' == get_post_type() ) { ?>
						<!-- Paging text for portfolio items -->
						<?php next_posts_link( __( 'Older Projects', 'designer' ) ); ?>
					<?php } else { ?>
						<!-- Paging text for posts -->
						<?php next_posts_link( __( 'Older Posts', 'designer' ) ); ?>
					<?php } ?>
				</div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
				<div class="nav-next">
					<?php if ( 'jetpack-portfolio' == get_post_type() ) { ?>
						<!-- Paging text for portfolio items -->
						<?php previous_posts_link( __( 'Newer Projects', 'designer' ) ); ?>
					<?php } else { ?>
						<!-- Paging text for posts -->
						<?php previous_posts_link( __( 'Newer Posts', 'designer' ) ); ?>
					<?php } ?>
				</div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
	if( isset( $temp_query ) ) {
		$wp_query = $temp_query;
	}
}
endif;

if ( ! function_exists( 'designer_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function designer_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'designer' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">Previous Post</span> %title', 'Previous post link', 'designer' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '<span class="meta-nav">Next Post</span> %title', 'Next post link',     'designer' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'designer_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function designer_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( __( '<span class="posted-on">%1$s</span><span class="byline"> by </span> %2$s', 'designer' ),
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
function designer_categorized_blog() {
	if ( false === ( $designer_count_cats = get_transient( 'designer_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$designer_count_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$designer_count_cats = count( $designer_count_cats );

		set_transient( 'designer_categories', $designer_count_cats );
	}

	if ( $designer_count_cats > 1 ) {
		// This blog has more than 1 category so designer_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so designer_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in designer_categorized_blog.
 */
function designer_category_transient_flusher() {
	delete_transient( 'designer_categories' );
}
add_action( 'edit_category', 'designer_category_transient_flusher' );
add_action( 'save_post',     'designer_category_transient_flusher' );
