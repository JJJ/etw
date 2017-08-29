<?php
/**
 * @package Camera
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>

	<!-- Get the video, carousel gallery or featured image -->
	<?php if ( get_post_meta( $post->ID, 'array-video', true ) ) { ?>
		<div class="featured-video container">
			<?php echo get_post_meta( $post->ID, 'array-video', true ) ?>
		</div>
	<?php } else if ( has_post_format( 'gallery' ) && get_post_gallery() ) {
		get_template_part( 'content', 'carousel-gallery' );
	} else if ( has_post_thumbnail() ) { ?>
		<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'large-image' ); ?></a>
	<?php } ?>

	<div class="container content-container">
		<header class="entry-header">
			<?php if ( is_single() ) { ?>
				<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			<?php } else { ?>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php } ?>

			<?php camera_posted_on(); ?>

			<?php if ( $post->post_excerpt ) { ?>
				<div class="entry-subtitle">
					<?php
						// WP.com: Disable sharing and likes for this excerpt area
						if ( function_exists( 'post_flair_mute' ) )
							post_flair_mute();
					?>

					<?php the_excerpt(); ?>

					<?php
						// WP.com: Turn sharing and likes back on for all other loops.
						if ( function_exists( 'post_flair_unmute' ) )
							post_flair_unmute();
					?>
				</div>
			<?php } ?>

			<!-- Post meta (content-meta.php) -->
			<?php get_template_part( 'content', 'meta' ); ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php

			if( has_post_format( 'gallery' ) ) {

				if ( post_password_required() ) {

					the_content();

				} else {

					$content = get_the_content();

					/**
					 * Get the gallery data from the post.
					 * @see functions.php
					 */
					$gallery_data = camera_gallery_data();

					/**
					 * Grab the first shortcode in post content, strip it out, and
					 * display the post content without the first gallery.
					 */
					if( $gallery_data  && is_array( $gallery_data ) ) {
						$gallery = $gallery_data[0][0];
						$content = str_replace( $gallery, '', $content );
						$content = wp_kses_post( $content );
					}
					echo apply_filters( 'the_content', $content );

				}

			} else {

				// Display the normal post content on standard post format.
				the_content( __( 'Read More', 'camera' ) );
			} ?>

			<?php
				if ( is_single() ) {
					edit_post_link( __( 'Edit Post', 'camera' ) );
				}
			?>

			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'camera' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
	</div><!-- .entry-container -->

</article><!-- #post-## -->
