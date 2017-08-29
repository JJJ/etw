<?php
/**
 * The template used for displaying standard post content
 *
 * @package Atomic
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	// Get the post content
	$content = apply_filters( 'the_content', $post->post_content );

	// Check for video post format content
	$media = get_media_embedded_in_content( $content );

	// If it's a video format, get the first video embed from the post to replace the featured image
	if ( has_post_format( 'video' ) && ! empty( $media ) ) {

		echo '<div class="featured-video">';
			echo $media[0];
		echo '</div>';

	}
	// If it's a gallery format, get the first gallery from the post to replace the featured image
	else if ( has_post_format( 'gallery' ) ) {

		echo '<div class="featured-image featured-gallery">';
			echo get_post_gallery();
		echo '</div>';

	} else if ( has_post_thumbnail() ) {

	if ( is_single() ) { ?>
		<div class="featured-image">
			<?php
				if ( is_singular( 'jetpack-portfolio' ) ) {
					the_post_thumbnail( 'atomic-featured-image-portfolio' );
				} else {
					the_post_thumbnail( 'atomic-featured-image' );
				}
			?>
		</div>
	<?php } else { ?>
		<div class="featured-image"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'atomic-featured-image' ); ?></a>
		</div>
	<?php } } wp_reset_postdata(); ?>

	<?php
	// Post meta sidebar
	get_template_part( 'template-parts/content-left-sidebar' ); ?>

	<div class="content-right">
		<div class="entry-content">

			<?php
			// Remove Jetpack Sharing output
			if( ! is_single() ) {
				atomic_remove_sharing();
			}

			// If it's a video format, filter out the first embed and return the rest of the content
			if ( has_post_format( 'video' ) || has_post_format( 'gallery' ) ) {
				atomic_filtered_content();
			} else {
				the_content( esc_html__( 'Read More', 'atomic' ) );
			}

			// Post pagination links
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'atomic' ),
				'after'  => '</div>',
			) );

			if ( is_single()  ) {
	        	// Post meta sidebar
	        	get_template_part( 'template-parts/content-meta' );

				// Author profile box
				atomic_author_box();

				// Post navigations
				if( is_single() ) {
					if( get_next_post() || get_previous_post() ) {
						atomic_post_navs();
				} }

				// Comments template
				comments_template();
			} ?>
		</div><!-- .entry-content -->
	</div><!-- .content-right-->

</article><!-- #post-## -->
