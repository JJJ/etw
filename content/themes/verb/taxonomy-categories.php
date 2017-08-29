<?php
/**
 * Archive page for portfolio categories.
 *
 * @package Verb
 * @since Verb 1.0
 */

get_header(); ?>

		<div id="content">
			<div class="posts">
				<div class="post-box-wrap">
					<h2 class="archive-title"><?php _e( 'Category', 'verb' ); ?> / <?php single_cat_title(); ?></h2>

					<!-- Grab Portfolio Items -->
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

					<article <?php post_class('post block-post'); ?>>
						<div class="post-inside">
							<a class="overlay-link" href="<?php the_permalink(); ?>" title=""></a>

							<div class="box-wrap">
								<!-- grab the featured image -->
								<?php if ( has_post_thumbnail() ) { ?>
									<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'home-image' ); ?></a>
								<?php } ?>

								<div class="box">
									<header>
										<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
										<?php echo get_the_term_list( $post->ID, 'categories', '<h3 class="entry-by">' . __( 'Posted In: ', 'verb' ), ', ', '</h3>' ); ?>
									</header>
								</div><!-- box -->
							</div><!-- box wrap -->
						</div><!-- image post -->
					</article><!-- post-->

					<?php endwhile; ?>
					<?php endif; ?>

					<!-- post navigation -->
					<?php verb_page_nav(); ?>

				</div><!-- post box wrap -->
			</div><!-- posts -->
		</div><!-- content -->

		<!-- footer -->
		<?php get_footer(); ?>