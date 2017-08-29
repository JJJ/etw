<?php
/**
 * The template for displaying search results.
 *
 * @package Ampersand
 * @since Ampersand 1.0
 */

get_header(); ?>

		<div id="main" class="site-main clearfix">
			<div id="primary" class="content-area">
				<div id="content" class="site-content container" role="main">

				<div class="posts">
					<?php if ( have_posts() ) : ?>
						<?php while ( have_posts() ) : the_post(); ?>

							<article <?php post_class(); ?>>
								<div class="post-content">
									<?php if ( '' != get_the_post_thumbnail() ) { ?>
										<a class="post-featured-image" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'ampersand' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'blog-thumb' ); ?></a>
									<?php } ?>

									<h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

									<div class="post-meta">
										<div class="post-date">
											<?php echo get_the_date(); ?><span class="date-sep"> / </span><?php the_author_posts_link(); ?><span class="date-sep"> / </span> <a href="<?php the_permalink(); ?>#comments" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s comments', 'ampersand' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php comments_number( __( 'No Comments', 'ampersand' ), __( '1 Comment', 'ampersand'), __( '% Comments','ampersand' ) ); ?></a>
										</div>
									</div>

									<div class="post-text">
										<?php the_excerpt( __( 'Read More','ampersand') ); ?>
									</div><!-- .post-text -->
								</div><!-- .post-content -->
							</article><!-- .post -->

						<?php endwhile; // end of the loop. ?>
					<?php else : ?>
						<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'ampersand' ); ?></p>
						<?php get_search_form() ?>
					<?php endif; ?>
				</div>

				<?php if ( ampersand_page_has_nav() ) : ?>
					<?php ampersand_content_nav( 'nav-below' ); ?>
				<?php endif; ?>

				</div><!-- #content .site-content -->
			</div><!-- #primary .content-area -->

			<?php get_sidebar(); ?>

		</div><!-- #main .site-main -->

<?php get_footer(); ?>