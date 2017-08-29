<?php
/**
 * Template Name: Homepage
 *
 * @package Ampersand
 * @since Ampersand 1.0
 */

get_header(); ?>

		<div id="main" class="site-main clearfix">
			<div id="primary" class="content-area">
				<div id="content" class="site-content clearfix" role="main">

					<!-- Portfolio Slider Section -->
					<?php
						$portfolio_list_args = array(
							'post_type'      => 'page',
							'key'            => '_wp_page_template',
							'meta_value'     => 'template-portfolio-item.php',
							'posts_per_page' => 9
						);
						$portfolio_list_posts = new WP_Query( $portfolio_list_args );

						if( $portfolio_list_posts->have_posts() ) {
							$count_posts = $portfolio_list_posts->found_posts;
							$slide_nav = ( $count_posts < 4 ) ? 'hide-nav' : 'show-nav';
					?>
						<div class="featured-content-section <?php echo $slide_nav; ?>">
							<div class="featured-content-inside">
								<div class="featured-content flexslider">
									<ul class="featured-content-slider slides">
										<?php while( $portfolio_list_posts->have_posts() ) : $portfolio_list_posts->the_post() ?>
											<li class="featured-item">
												<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
												<a class="featured-item-image" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'ampersand' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'portfolio-thumb' ); ?></a>
											</li>
										<?php endwhile; ?>
										<?php wp_reset_postdata(); ?>
									</ul>
								</div><!-- .featured-content -->
							</div><!-- .featured-content-wrap -->
						</div><!-- .featured-content-section -->
					<?php } ?>

					<!-- Blog Section -->
					<div class="blog-section clearfix">
						<div class="blog-section-inside clearfix">
							<!-- Count posts, add full-width class if only one post is published -->
							<?php $post_count = wp_count_posts()->publish; ?>
							<div class="blog-left <?php if ( $post_count == 1 ) { echo "blog-left-full"; } ?>">
								<?php global $more; $more = 0; ?>
								<?php
									$blog_list_args = array(
										'posts_per_page' 	=> 1,
										'post__not_in' => get_option("sticky_posts"),
									);
									$blog_list_posts = new WP_Query( $blog_list_args );
								?>

								<?php while( $blog_list_posts->have_posts() ) : $blog_list_posts->the_post() ?>

										<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
										<div class="blog-left-date"><?php echo get_the_date(); ?> <span class="date-sep">&mdash;</span> <a href="<?php the_permalink(); ?>#comments" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s comments', 'ampersand' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php comments_number( __( 'No Comments', 'ampersand' ), __( '1 Comment', 'ampersand' ), __( '% Comments','ampersand' ) ); ?></a></div>
										<div class="blog-left-excerpt">
											<?php the_excerpt(); ?>
											<a href="<?php the_permalink(); ?>" rel="bookmark" class="more-link"><?php _e( 'Read More', 'ampersand' ); ?></a>
										</div>

								<?php endwhile; ?>
								<?php wp_reset_postdata(); ?>
							</div><!-- .blog-left -->

							<div class="blog-right">
								<ul>
									<?php
										$blog_list_args = array(
											'posts_per_page' 	=> 3,
											'offset'			=> 1
										);
										$blog_list_posts = new WP_Query( $blog_list_args );
									?>

									<?php while( $blog_list_posts->have_posts() ) : $blog_list_posts->the_post() ?>
										<li>
											<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
											<div class="blog-right-date">
												<?php echo get_the_date(); ?> <span class="date-sep">&mdash;</span> <a href="<?php the_permalink(); ?>#comments" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s comments', 'ampersand' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php comments_number(__('No Comments','ampersand'),__('1 Comment','ampersand'),__( '% Comments','ampersand') );?></a>
											</div>
										</li>
									<?php endwhile; ?>
									<?php wp_reset_postdata(); ?>
								</ul>
							</div><!-- .blog-right -->
						</div><!-- .blog-section-inside -->
					</div><!-- .blog-section -->

				</div><!-- #content .site-content -->
			</div><!-- #primary .content-area -->
		</div><!-- #main .site-main -->

<?php get_footer(); ?>