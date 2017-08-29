<?php
/**
 * The template for displaying author archives.
 *
 * @package North
 * @since 3.2.3
 */

get_header(); ?>

		<header class="page-titles">
			<div class="container clearfix">
				<h2 class="entry-title"><?php _e('Author','north'); ?> / <?php printf( get_the_author() ); ?></h2>
			</div>
		</header>

		<section class="main">
			<div class="container clearfix">
				<div id="content">
					<div class="posts">

						<!-- Grab the posts -->
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

						<article <?php post_class('post'); ?>>
							<div class="box-wrap">
								<div class="box">
									<div class="post-content">
										<?php get_template_part( 'template-gallery' ); ?>

											<div class="blog-entry-title">
												<h2><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'north' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
												<div class="blog-entry-date">
													<span>
														<em><?php _e( 'By', 'north' ); ?></em> <?php the_author_posts_link(); ?>
													</span>
													<span>
														<em><?php _e( 'On', 'north' ); ?></em> <?php echo get_the_date(); ?>
													</span>
													<span>
														<em><?php _e( 'With', 'north' ); ?></em> <a href="<?php the_permalink(); ?>/#comment-jump" title=""><?php comments_number(__('No Comments','north'),__('1 Comment','north'),__( '% Comments','north') );?></a>
													</span>
												</div>
											</div>

										<?php the_excerpt(); ?>

									</div><!-- post content -->
								</div><!-- box -->
							</div><!-- box wrap -->
						</article><!-- post-->

						<?php endwhile; ?>
						<?php endif; ?>
					</div>

					<?php north_page_nav(); ?>

				</div><!-- content -->

				<?php get_sidebar(); ?>
			</div><!-- container -->
		</section><!-- main -->

		<!-- footer -->
		<?php get_footer(); ?>