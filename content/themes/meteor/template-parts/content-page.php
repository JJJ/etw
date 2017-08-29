<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Meteor
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php meteor_post_media(); ?>

	<div class="post-content">
		<div class="entry-content">

			<?php
			// Remove Jetpack Sharing output
			if( ! is_single() ) {
				meteor_remove_sharing();
			}

			// If it's a video format, filter out the first embed and return the rest of the content
			if ( has_post_format( 'video' ) || has_post_format( 'gallery' ) ) {
				meteor_filtered_content();
			} else {
				the_content( esc_html__( 'Read More', 'meteor' ) );
			}

			// Post pagination links
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'meteor' ),
				'after'  => '</div>',
			) );

			// Comments template
			comments_template(); ?>
		</div><!-- .entry-content -->
	</div><!-- .post-content-->

</article><!-- #post-## -->
