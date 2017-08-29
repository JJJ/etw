<?php
/**
 * Template Name: Portfolio
 *
 * Template for the Portfolio page, which displays all children of the Portfolio page.
 *
 * @package Ampersand
 * @since Ampersand 1.0
 */

get_header(); ?>

		<div id="main" class="site-main portfolio-columns clearfix">
			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">

					<!-- If there is post content, show it -->
					<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
	                    <?php $post_content = get_the_content(); ?>
	                    <?php if ( $post_content ) { ?>
	                        <div class="post-content">
								<div class="post-text">
									<?php
									// The loop for the content of the portfolio page itself. Mute the post flair on this page.
										if ( function_exists( 'post_flair_mute' ) )
										post_flair_mute();

										the_content();

										if ( function_exists( 'post_flair_unmute' ) )
										post_flair_unmute();

									?>
								</div><!-- .post-text -->
							</div><!-- .post-content -->
	                    <?php } ?>
                    <?php endwhile; endif; ?>
                    <?php wp_reset_postdata(); ?>

                    <!-- Get the portfolio pages -->
					<div class="posts">
						<?php
							$global_posts_query = new WP_Query(
								array(
									'posts_per_page' => 5,
									'paged'          => get_query_var( 'paged' ),
									'post_type'      => 'page',
									'key'            => '_wp_page_template',
									'meta_value'     => 'template-portfolio-item.php',
									'post_parent'    => get_the_ID(),
								)
							);

							// The loop for the portfolio items
							if ( $global_posts_query->have_posts() ) : while( $global_posts_query->have_posts() ) : $global_posts_query->the_post();
						?>
							<article <?php post_class(); ?>>
								<div class="portfolio-column-wrap clearfix">

										<a class="portfolio-featured-image" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'ampersand' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><span><?php the_post_thumbnail( 'portfolio-thumb' ); ?></span></a>


									<div class="portfolio-column-text">
										<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

										<div class="portfolio-column-text-excerpt">
											<?php the_excerpt(); ?>
										</div>

										<a class="more-link" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'ampersand' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php _e( 'Read More', 'ampersand' ); ?></a>
									</div><!-- .portfolio-column-text -->
								</div><!-- .post-content -->
							</article><!-- .post -->
						<?php endwhile; endif; ?>
						<?php wp_reset_postdata(); ?>
					</div><!-- .posts -->

					<div class="index-navigation">
						<div class="nav-previous"><?php next_posts_link( __( 'Older posts', 'ampersand' ) , $global_posts_query->max_num_pages ); ?></div>
						<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'ampersand' ), $global_posts_query->max_num_pages ); ?></div>
					</div>

				</div><!-- #content .site-content -->
			</div><!-- #primary .content-area -->
		</div><!-- #main .site-main -->

<?php get_footer(); ?>