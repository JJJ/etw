<?php
/**
 *
 * Template Name: Custom Archive
 *
 * Template for displaying a custom archives page, sorted by date, category and more.
 *
 * @package Author
 * @since Author 1.0
 */

get_header(); ?>

		<div id="content-wrap" class="clearfix">
			<div id="content">
				<!-- post navigation -->
				<?php get_template_part( 'template-title' ); ?>

				<div class="post-wrap">
					<!-- load the posts -->
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

						<div <?php post_class('post'); ?>>
							<div class="box">

								<!-- load the featured image -->
								<?php if ( has_post_thumbnail() ) { ?>
									<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'large-image' ); ?></a>
								<?php } ?>

								<div class="frame">
									<div class="title-wrap">
										<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
									</div><!-- title wrap -->

									<div class="post-content">
										<?php the_content( __( 'Read More', 'author' ) ); ?>

										<div id="archive">
											<div class="archive-column">
												<h4><?php _e( 'Recent Posts', 'author' ); ?></h4>
												<ul>
													<?php wp_get_archives( 'type=postbypost&limit=20' ); ?>
												</ul>
											</div><!-- archive column -->

											<div class="archive-column">
												<h4><?php _e( 'Pages', 'author' ); ?></h4>
												<ul>
													<?php wp_list_pages( 'sort_column=menu_order&title_li=' ); ?>
												</ul>
											</div><!-- archive column -->

											<div class="archive-column">
												<h4><?php _e( 'Categories', 'author' ); ?></h4>
												<ul>
													<?php wp_list_categories( 'orderby=name&title_li=' ); ?>
												</ul>
											</div><!-- archive column -->

											<div class="archive-column">
												<h4><?php _e( 'Contributors', 'author' ); ?></h4>
												<ul>
													<?php wp_list_authors( 'show_fullname=1&optioncount=1&orderby=post_count&order=DESC' ); ?>
												</ul>
											</div><!-- archive column -->

											<div class="archive-column">
												<h4><?php _e( 'By Day', 'author' ); ?></h4>
												<ul>
													<?php wp_get_archives( 'type=daily&limit=25' ); ?>
												</ul>
											</div><!-- archive column -->

											<div class="archive-column">
												<h4><?php _e( 'By Month', 'author' ); ?></h4>
												<ul>
													<?php wp_get_archives( 'type=monthly&limit=12' ); ?>
												</ul>
											</div><!-- archive column -->
										</div><!-- archive -->
									</div><!-- post content -->
								</div><!-- frame -->

								<!-- post meta -->
								<?php get_template_part( 'template-meta' ); ?>
							</div><!-- box -->
						</div><!-- post-->

					<?php endwhile; ?>
				</div><!-- post wrap -->

				<?php else: ?>
			</div><!-- content -->

			<?php endif; ?>
			<!-- end posts -->
		</div><!--content-->

		<!-- load the sidebar -->
		<?php get_sidebar(); ?>
	</div><!-- content wrap -->

	<!-- load footer -->
	<?php get_footer(); ?>
