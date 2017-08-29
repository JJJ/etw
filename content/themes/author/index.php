
<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Author
 * @since Author 1.0
 */

get_header(); ?>

		<div id="content-wrap" class="clearfix">
			<!-- excerpt slider -->
			<?php get_template_part( 'template-slider' ); ?>

			<div id="content">
				<!-- post navigation -->
				<?php get_template_part( 'template-title' ); ?>

				<div class="post-wrap">
					<!-- load the posts -->
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

						<div <?php post_class('post'); ?>>
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

								<div class="frame">
									<div class="title-wrap">
										<?php if( is_page() ) { } else { ?>
											<div class="title-meta">
												<?php the_author_posts_link(); ?>
												<span class="sep"><?php _e( '/', 'author' ); ?></span>
												<a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a>
												<span class="sep"><?php _e( '/', 'author' ); ?></span>
												<?php comments_popup_link( __( 'Leave a comment', 'author' ), __( '1 Comment', 'author' ), __( '% Comments', 'author' ) ); ?>
											</div><!-- title meta -->
										<?php } ?>

										<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
									</div><!-- title wrap -->

									<div class="post-content">
										<?php if( is_search() || is_archive() ) { ?>
											<?php the_excerpt(); ?>
											<p><a href="<?php the_permalink(); ?>"><?php _e( 'Read More', 'author' ); ?></a></p>
										<?php } else { ?>
											<?php the_content( __( 'Read More', 'author' ) ); ?>

											<?php if( is_single() || is_page() ) { ?>
												<div class="pagelink">
													<?php wp_link_pages(); ?>
												</div>
											<?php } ?>
										<?php } ?>
									</div><!-- post content -->
								</div><!-- frame -->

								<!-- post meta -->
								<?php get_template_part( 'template-meta' ); ?>
							</div><!-- box -->
						</div><!-- post-->

					<?php endwhile; ?>
				</div><!-- post wrap -->

				<!-- post navigation -->
				<?php get_template_part( 'template-nav' ); ?>

				<?php else: ?>
			</div><!-- content -->

			<?php endif; ?>
			<!-- end posts -->

			<!-- comments -->
			<?php if( is_single() && comments_open() ) {
				comments_template();
			} ?>
		</div><!--content-->

		<!-- load the sidebar -->
		<?php get_sidebar(); ?>
	</div><!-- content wrap -->

	<!-- load footer -->
	<?php get_footer(); ?>
