<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Ampersand
 * @since Ampersand 1.0
 */

if ( ! function_exists( 'ampersand_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since Ampersand 1.0
 */
function ampersand_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';

	?>
	<div class="index-navigation">
		<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
			<h1 class="assistive-text"><?php _e( 'Post navigation', 'ampersand' ); ?></h1>

		<?php if ( is_single() ) : // navigation links for single posts ?>

			<?php previous_post_link( '<div class="nav-previous">%link</div>', '' . __( 'Previous Post', 'ampersand' ) . '' ); ?>
			<?php next_post_link( '<div class="nav-next">%link</div>', '' . __( 'Next Post', 'ampersand' ) . '' ); ?>

		<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( 'Older posts', 'ampersand' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'ampersand' ) ); ?></div>
			<?php endif; ?>

		<?php endif; ?>

		</nav><!-- #<?php echo $nav_id; ?> -->
	</div>
	<?php
}
endif; // ampersand_content_nav