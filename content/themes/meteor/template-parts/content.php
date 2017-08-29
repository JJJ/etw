<?php
/**
 * The template used for displaying standard post content
 *
 * @package Meteor
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php meteor_post_media(); ?>

	<div class="post-content">

		<?php if( ! is_single() ) { ?>
			<header class="entry-header">
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<?php meteor_post_byline(); ?>
			</header>
		<?php } ?>

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

			if ( is_single()  ) {
	        	// Post meta sidebar
	        	get_template_part( 'template-parts/content-meta' );

				// Author profile box
				meteor_author_box();

				// Post navigations
				if( is_single() ) {
					if( get_next_post() || get_previous_post() ) {
						meteor_post_navs();
				} }

				// Comments template
				comments_template();
			} ?>
		</div><!-- .entry-content -->
	</div><!-- .post-content-->

</article><!-- #post-## -->
