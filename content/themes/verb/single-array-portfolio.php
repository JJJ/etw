<?php
/**
 * Displays single portfolio items.
 *
 * @package Verb
 * @since Verb 1.0
 */

get_header(); ?>
		<!-- grab the posts -->
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<div id="sidebar" class="sidebar-portfolio">
			<div class="widget">
				<div class="portfolio-title">
					<h2><?php the_title(); ?></h2>
					<?php the_content(); ?>
				</div>
			</div>

			<?php echo get_the_term_list( $post->ID, 'categories', '<div class="widget"><ul><li>' . __( 'Posted In: ', 'verb' ), ', ', '</li></ul></div>' ); ?>

			<div class="widget">
				<ul class="next-prev-side">
					<li><?php next_post_link( '%link', __( '<span>Next:</span> %title', 'verb' ) ) ?></li>
					<li><?php previous_post_link( '%link', __( '<span>Previous:</span> %title', 'verb' ) ) ?></li>
				</ul>
			</div>
		</div>

		<div id="content">
			<div class="posts">
				<article <?php post_class('post'); ?>>
					<!-- grab the video -->
					<?php if ( get_post_meta( $post->ID, 'video', true ) ) { ?>
						<div class="fitvid">
							<?php echo get_post_meta( $post->ID, 'video', true ) ?>
						</div>
					<?php } ?>

					<div class="image-wrap">
						<?php
							// check if there are gallery images
							$gallery_imgs = get_post_meta( get_the_ID(), '_gallery_image_ids', true );

							if( ! empty( $gallery_imgs ) && function_exists( 'array_gallery' ) ) {
							  array_gallery();
							} else if ( has_post_thumbnail() ) {
							// if not, show the featured image if there is one

							$featured_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large-image' ); ?>
							<a class="view" rel="lightbox" href="<?php echo $featured_img[0]; ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'large-image' ); ?></a>
						<?php } ?>
					</div><!-- image wrap -->
				</article><!-- post-->
			</div>
		</div><!-- content -->

	<?php endwhile; ?>
	<?php endif; ?>

		<!-- footer -->
		<?php get_footer(); ?>
