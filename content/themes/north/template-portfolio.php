<?php
/**
 * The template for displaying portfolio posts
 *
 */

						global $paged;
						if ( get_query_var( 'paged' ) )
							$paged = get_query_var( 'paged' );
						elseif ( get_query_var( 'page' ) )
							$paged = get_query_var( 'page' );
						else
							$paged = 1;

							$portfolio_posts = new WP_Query(
								array(
									'posts_per_page' => 9,
									'paged'          => $paged,
									'post_type'      => 'array-portfolio'
								)
							);

							if( class_exists( 'Array_Toolkit' ) && $portfolio_posts->have_posts() ) : while( $portfolio_posts->have_posts() ) : $portfolio_posts->the_post();
						?>

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

						<?php endwhile; endif; ?>
						<?php wp_reset_postdata(); ?>

						<?php north_page_nav( $portfolio_posts ); ?>
