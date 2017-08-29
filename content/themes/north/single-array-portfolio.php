<?php
/**
 * The template for displaying portfolio posts
 *
 * @since 1.0
 */
get_header(); ?>

		<header class="page-titles">
			<div class="container clearfix">
				<div class="page-titles-wrap">
					<h1 class="entry-title"><?php the_title(); ?></h1>

					<!-- Page subtitle -->
					<?php if ( get_post_meta( $post->ID, 'subtitle', true ) ) { ?>
						<h3 class="entry-subtitle"><?php echo get_post_meta( $post->ID, 'subtitle', true ) ?></h3>
					<?php } ?>
				</div><!-- page titles wrap -->

				<!-- Grab the video -->
				<?php if ( get_post_meta( $post->ID, 'video', true ) ) { ?>
					<div class="fitvid">
						<?php echo get_post_meta( $post->ID, 'video', true ) ?>
					</div>
				<?php } else { ?>

					<!-- Otherwise grab the gallery -->
					<?php if ( 'gallery' == get_post_format() ) { ?>
						<?php if ( function_exists( 'array_gallery' ) ) { array_gallery(); } ?>
					<?php } else { ?>

						<!-- If there is no gallery, just grab the featured image -->
						<?php if ( has_post_thumbnail() ) { ?>
							<div class="gallery-wrap clearfix">
								<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'north' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'large-image' ); ?></a>
							</div>
						<?php } ?>

					<?php } ?>
				<?php } ?>
			</div><!-- container -->
		</header><!-- page titles -->

		<section class="main">
			<div class="container">
				<div id="content">
					<div class="posts">
						<!-- grab the posts -->
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

						<article <?php post_class('post'); ?>>
							<div class="post-content">
								<?php the_content(); ?>
							</div>
						</article>

						<?php endwhile; ?>
						<?php endif; ?>
					</div><!-- posts -->
				</div><!-- content -->

				<div id="sidebar" class="sidebar-portfolio">
					<div class="portfolio-details widget">
						<ul>
							<li><span><?php _e( 'Date:', 'north' ); ?></span> <?php echo get_the_date(); ?></li>

							<!-- portfolio categories -->
							<?php echo get_the_term_list( $post->ID, 'categories', '<li class="posted-in-cat"><span>' . __( 'Posted In:', 'north' ), ', ', '</span></li>' ); ?>

							<!-- portfolio navigation -->
							<?php next_post_link('%link', __('<li><span>Next:</span> %title </li>', 'north')) ?>
							<?php previous_post_link('%link', __('<li><span>Previous:</span> %title</li>', 'north')) ?>
						</ul>
					</div>
				</div><!-- sidebar -->
			</div><!-- container -->
		</section><!-- main -->

		<!-- footer -->
		<?php get_footer(); ?>