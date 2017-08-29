<?php
/**
 * Template Name: Full Width
 *
 * The template for displaying full-width pages.
 *
 * @package Author
 * @since Author 1.0
 */

get_header(); ?>

		<div id="content-wrap" class="clearfix">
			<div id="content">
				<!-- post navigation -->
				<?php get_template_part( 'template-title' ); ?>

				<div class="post-wrap">
					<!-- load the posts -->
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

						<div <?php post_class( 'post' ); ?>>
							<div class="box">

								<?php if ( has_post_format( 'gallery' , $post->ID ) ) { ?>
									<?php if ( function_exists( 'array_gallery' ) ) { array_gallery(); } ?>
								<?php } ?>

								<!-- load the video -->
								<?php if ( get_post_meta( $post->ID, 'arrayvideo', true ) ) { ?>
									<div class="arrayvideo">
										<?php echo get_post_meta( $post->ID, 'arrayvideo', true ) ?>
									</div>

								<?php } else { ?>

									<!-- load the featured image -->
									<?php if ( has_post_thumbnail() ) { ?>
										<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'large-image' ); ?></a>
									<?php } ?>

								<?php } ?>

								<div class="frame frame-full">
									<div class="title-wrap">
										<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
									</div><!-- title wrap -->

									<div class="post-content">
										<?php the_content( __( 'Read More', 'author' ) ); ?>

										<div class="pagelink">
											<?php wp_link_pages(); ?>
										</div>
									</div><!-- post content -->
								</div><!-- frame -->

								<!-- post meta -->
								<?php get_template_part( 'template-meta' ); ?>
							</div><!-- box -->
						</div><!-- post-->

					<?php endwhile; ?>
				</div><!-- post wrap -->

				<?php else: ?>
			</div><!-- content -->

			<?php endif; ?>

			<?php if( comments_open() ) {
				comments_template();
			} ?>
			<!-- end posts -->
		</div><!--content-->
	</div><!-- content wrap -->

	<!-- load footer -->
	<?php get_footer(); ?>
