<?php
/**
 * The template containing the Featured Posts area.
 * The Featured Posts category is set up in Appearance -> Customize -> Theme Options.
 *
 * @package Editor
 */
?>

				<?php if ( get_theme_mod( 'editor_featured_cat' ) ) { ?>
					<div id="tab-2" class="widget-area tab-content animated fadeIn">
						<div class="widget featured-posts-widget">
							<h2 class="widget-title"><?php echo get_cat_name( get_theme_mod( 'editor_featured_cat' ) ) ?></h2>

							<div class="featured-posts">
							    <?php
									$featured_posts_args = array(
										'posts_per_page' => 10,
										'cat'            => get_theme_mod( 'editor_featured_cat' )
									);
									$featured_posts_posts = new WP_Query( $featured_posts_args );
								?>

								<?php while( $featured_posts_posts->have_posts() ) : $featured_posts_posts->the_post() ?>
									<div class="featured-post">
										<?php if ( '' != get_the_post_thumbnail() ) { ?>
							            	<a class="featured-post-image" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'featured-post-image' ); ?></a>
							            <?php } ?>
							            <h3><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>

							            <div class="featured-post-meta">
								            <div class="featured-post-date">
								            	<i class="fa fa-clock-o"></i>
								            	<?php editor_posted_on(); ?>
								            </div>
							            </div>
									</div>
								<?php endwhile; ?>
								<?php wp_reset_postdata(); ?>
							</div><!-- .featured-posts -->
						</div><!-- .featured-posts-widget -->
					</div><!-- #tab-2 .widget-area -->
				<?php } ?>