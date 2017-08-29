<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package North
 * @since 1.0
 */

get_header();

		if( is_front_page() ) {} else { ?>

		<header class="page-titles">
			<div class="container clearfix">
				<!-- titles -->
				<?php if( is_home() ) { ?>
					<h2 class="entry-title"><?php echo apply_filters( 'the_title', get_the_title( get_option( 'page_for_posts' ) ) ); ?></h2>
				<?php } else if( is_search() ) { ?>
					<h2 class="entry-title"><?php printf( __( 'Search Results for: %s', 'north' ), '' . get_search_query() . '' ); ?></h2>
				<?php } else if( is_tag() ) { ?>
					<h2 class="entry-title"><?php _e('Tag','north'); ?> / <?php single_tag_title(); ?></h2>
				<?php } else if( is_day() ) { ?>
					<h2 class="entry-title"><?php _e('Archive','north'); ?> / <?php echo get_the_date(); ?></h2>
				<?php } else if( is_month() ) { ?>
					<h2 class="entry-title"><?php _e('Archive','north'); ?> / <?php echo get_the_date('F Y'); ?></h2>
				<?php } else if( is_year() ) { ?>
					<h2 class="entry-title"><?php _e('Archive','north'); ?> / <?php echo get_the_date('Y'); ?></h2>
				<?php } else if( is_404() ) { ?>
					<h2 class="entry-title"><?php _e('Page Not Found!','north'); ?></h2>
				<?php } else if( is_category() ) { ?>
					<h2 class="entry-title"><?php _e('Category','north'); ?> / <?php single_cat_title(); ?></h2>
				<?php } else if( is_post_type_archive() ) { ?>
					<h2 class="entry-title"><?php _e('Category','north'); ?> / <?php post_type_archive_title(); ?></h2>
				<?php } else { ?>
					<h2 class="entry-title"><?php single_post_title(); ?></h2>
				<?php } ?>

				<?php
					if( is_singular() || is_home() ) {
						$page_object = get_queried_object();
						$page_id = get_queried_object_id();
						if ( get_post_meta($page_id, 'subtitle', true) ) {
							echo '<h3 class="entry-subtitle">' . get_post_meta($page_id, 'subtitle', true) . '</h3>';
						}
					}
				?>
			</div>
		</header>
		<?php } ?>

		<section class="main">
			<div class="container clearfix">
				<div id="content">
					<div class="posts">

						<!-- Grab the posts -->
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

						<article <?php post_class('post'); ?>>
							<div class="box-wrap">
								<div class="box">
									<!-- post content -->
									<div class="post-content">
											<?php get_template_part( 'template-gallery' ); ?>

											<?php if(is_single()) {} else { ?>
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
											<?php } ?>

											<?php if( is_search() ) {

												the_excerpt();

											} else {

												the_content( __( 'Read More', 'north' ) );

											} ?>

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