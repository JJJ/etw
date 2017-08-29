<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Ampersand
 * @since Ampersand 1.0
 */

get_header(); ?>

		<div id="main" class="site-main clearfix">
			<div id="primary">
				<div id="content" class="site-content container clearfix" role="main">

					<?php while ( have_posts() ) : the_post(); ?>
						<div class="post-content">
							<?php if ( '' != get_the_post_thumbnail() ) { ?>
								<div class="post-featured-image" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'ampersand' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'blog-thumb' ); ?></div>
							<?php } ?>

							<div class="post-meta">
								<div class="post-date">
									<?php echo get_the_date(); ?><span class="date-sep"> / </span><?php the_author_posts_link(); ?><span class="date-sep"> / </span> <a href="<?php the_permalink(); ?>#comments" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s comments', 'ampersand' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php comments_number( __( 'No Comments', 'ampersand' ), __( '1 Comment', 'ampersand' ), __( '% Comments','ampersand' ) ); ?></a>
								</div>
							</div>

							<div class="post-text">
								<?php the_content(); ?>
								<?php wp_link_pages(); ?>
								<?php edit_post_link( __( 'Edit', 'ampersand' ), '<span class="edit-link">', '</span>' ); ?>

								<div class="post-detail">
									<div class="post-detail-cat">
										<div class="post-detail-title"><?php _e( 'Category:','ampersand' ); ?></div>
										<?php the_category(', '); ?>
									</div>

									<?php $posttags = get_the_tags(); if ($posttags) { ?>
										<div class="post-detail-tags">
											<div class="post-detail-title"><?php _e( 'Tags:','ampersand' ); ?></div>
											<?php the_tags('', ', ', ''); ?>
										</div>
									<?php } ?>

									<div class="single-navigation">
										<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="post-detail-title">' . __( 'Previous Post:', 'ampersand' ) . '</span> %title' ); ?>

										<?php next_post_link( '<div class="nav-next">%link</div>', '<span class="post-detail-title">' . __( 'Next Post:', 'ampersand' ) . '</span> %title' ); ?>
									</div>
								</div><!-- .post-detail -->
							</div><!-- .post-text -->
						</div><!-- .post-content -->

						<!-- If comments are open or we have at least one comment, load up the comment template. -->
						<?php if ( comments_open() || '0' != get_comments_number() ) { ?>
							<div class="comments-section clearfix">
								<?php comments_template(); ?>
							</div><!-- comment section -->
						<?php } ?>

					<?php endwhile; // end of the loop. ?>

				</div><!-- #content .site-content -->
			</div><!-- #primary .content-area -->

			<?php get_sidebar(); ?>

		</div><!-- #main .site-main -->

<?php get_footer(); ?>