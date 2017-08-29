<?php
/**
 * Template Name: Full Width
 *
 * Template for displaying a full-width page.
 *
 * @package Verb
 * @since Verb 1.0
 */

get_header(); ?>

		<div id="content">
			<div class="posts">

				<!-- grab the posts -->
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<article <?php post_class('post'); ?>>
					<div class="box-wrap">
						<div class="box">
							<header>
								<?php if( is_singular() ) { ?>
									<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'verb' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
								<?php } else { ?>
									<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'verb' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
								<?php } ?>
							</header>

							<!-- grab the video -->
							<?php if ( get_post_meta( $post->ID, 'video', true ) ) { ?>
								<div class="fitvid">
									<?php echo get_post_meta( $post->ID, 'video', true ) ?>
								</div>

							<?php } else { ?>

								<!-- grab the featured image -->
								<?php if ( has_post_thumbnail() ) { ?>
									<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'verb' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'large-image' ); ?></a>
								<?php } ?>

							<?php } ?>

							<!-- post content -->
							<div class="post-content">
								<?php if( is_search() || is_archive() ) { ?>
									<div class="excerpt-more">
										<?php the_excerpt(); ?>
										<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'verb' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php _e( 'Read More', 'verb' ); ?></a>
									</div>
								<?php } else { ?>
									<?php the_content( __( 'Read More','verb' ) ); ?>

									<?php if( is_singular() ) { ?>
										<div class="pagelink">
											<?php wp_link_pages(); ?>
										</div>
									<?php } ?>

								<?php } ?>
							</div><!-- post content -->
						</div><!-- box -->
					</div><!-- box wrap -->
				</article><!-- post-->

				<?php endwhile; ?>
				<?php endif; ?>
			</div>

			<!-- comments -->
			<?php if( is_singular() && comments_open() ) { ?>
				<div id="comment-jump" class="comments">
					<?php comments_template(); ?>
				</div>
			<?php } ?>
		</div><!-- content -->

		<!-- footer -->
		<?php get_footer(); ?>