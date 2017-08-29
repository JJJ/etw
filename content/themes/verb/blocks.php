<?php
/**
 * Template Name: Blocks
 *
 * Template for showing portfolio items on a responsive grid.
 *
 * @package Verb
 * @since Verb 1.0
 */

get_header(); ?>

		<div id="content">
			<?php if ( get_theme_mod( 'verb_customizer_blocks_title' ) || get_theme_mod( 'verb_customizer_blocks_subtitle' ) ) { ?>
				<div class="hero">
					<?php if ( $blocks_title = get_theme_mod( 'verb_customizer_blocks_title' ) ) { ?>
						<h2><?php echo esc_html( $blocks_title ); ?></h2>
					<?php } ?>

					<?php if ( $blocks_subtitle = get_theme_mod( 'verb_customizer_blocks_subtitle' ) ) { ?>
						<h3><?php echo esc_html( $blocks_subtitle ); ?></h3>
					<?php } ?>
				</div><!-- hero -->
			<?php } ?>

			<div class="posts">
				<div class="post-box-wrap">
					<!-- Grab Portfolio Items -->
					<?php
					global $paged;
					if( get_query_var( 'paged' ) )
						$paged = get_query_var( 'paged' );
					elseif ( get_query_var( 'page' ) )
						$paged = get_query_var( 'page' );
					else
						$paged = 1;

						$portfolio_posts = new WP_Query(
							array(
								'posts_per_page' => 12,
								'paged'          => $paged,
								'post_type'      => 'array-portfolio'
							)
						);

						if( $portfolio_posts->have_posts() ) : while( $portfolio_posts->have_posts() ) : $portfolio_posts->the_post();
					?>
					<article <?php post_class('post block-post'); ?>>
						<div class="post-inside">

							<a class="overlay-link" href="<?php the_permalink(); ?>"></a>

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

					<?php endwhile; endif; ?>
					<?php wp_reset_postdata(); ?>

					<!-- post navigation -->
					<?php verb_page_nav( $portfolio_posts ); ?>

				</div><!-- post box wrap -->
			</div><!-- posts -->
		</div><!-- content -->

		<!-- footer -->
		<?php get_footer(); ?>