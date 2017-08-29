<?php
/**
 * The template for displaying portfolio category archives
 */
get_header(); ?>

		<header class="page-titles">
			<div class="container clearfix">
				<!-- Page title -->
				<h2 class="entry-title"><?php _e( 'Category', 'north' ); ?> / <?php single_cat_title(); ?></h2>
			</div>
		</header>

		<section class="main">
			<div id="content">
				<div class="container">
					<div class="posts">
						<div class="post-box-wrap clearfix">
							<!-- Grab Portfolio Items -->
							<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

							<article <?php post_class('post block-post'); ?>>
								<div class="post-inside">

									<a class="overlay-link" href="<?php the_permalink(); ?>"></a>

									<div class="box-wrap">
										<div class="box-wrap-title">
											<a class="box-title-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
											<?php echo get_the_term_list( $post->ID, 'categories', '<p><i class="fa fa-list"></i>', ', ', '</p>' ); ?>
										</div>

										<!-- grab the featured image -->
										<?php if ( has_post_thumbnail() ) { ?>
											<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'home-image' ); ?></a>
										<?php } ?>
									</div><!-- box wrap -->
								</div><!-- image post -->
							</article><!-- post-->

							<?php endwhile; ?>
							<?php endif; ?>

							<?php north_page_nav(); ?>

						</div><!-- post box wrap -->
					</div><!-- posts -->
				</div><!-- container -->
			</div><!-- content -->
		</section><!-- main -->

		<!-- footer -->
		<?php get_footer(); ?>