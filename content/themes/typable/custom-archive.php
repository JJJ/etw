<?php
/*
Template Name: Custom Archive
*/
?>

<?php get_header(); ?>

		<div id="content">
			<div class="posts">

				<!-- grab the posts -->
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<article <?php post_class( 'post' ); ?>>

					<div class="box-wrap">
						<div class="box">
							<header>
								<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
							</header>

							<!-- post content -->
							<div class="post-content">
								<?php the_content(); ?>

								<div id="archive">
									<div class="archive-col">
										<div class="archive-box">
											<h3><?php _e( 'Latest Posts', 'typable' ); ?></h3>
											<ul>
												<?php wp_get_archives( 'type=postbypost&limit=20' ); ?>
											</ul>
										</div>
									</div><!-- column -->

									<div class="archive-col">
										<div class="archive-box">
											<h3><?php _e( 'Daily', 'typable' ); ?></h3>
											<ul>
												<?php wp_get_archives( 'type=daily&limit=15' ); ?>
											</ul>
										</div>

										<div class="archive-box">
											<h3><?php _e( 'Monthly', 'typable' ); ?></h3>
											<ul>
												<?php wp_get_archives( 'type=monthly&limit=12' ); ?>
											</ul>
										</div>
									</div><!-- column -->

									<div class="archive-col">
										<div class="archive-box">
											<h3><?php _e( 'Pages', 'typable' ); ?></h3>
											<ul>
												<?php wp_list_pages( 'sort_column=menu_order&title_li=' ); ?>
											</ul>
										</div>

										<div class="archive-box">
											<h3><?php _e( 'Categories', 'typable' ); ?></h3>
											<ul>
												<?php wp_list_categories( 'orderby=name&title_li=' ); ?>
											</ul>
										</div>

										<div class="archive-box">
											<h3><?php _e( 'Contributors', 'typable' ); ?></h3>
											<ul>
												<?php wp_list_authors( 'show_fullname=1&orderby=post_count&order=DESC' ); ?>
											</ul>
										</div>
									</div><!-- column -->
								</div><!-- archive -->
							</div><!-- post content -->
						</div><!-- box -->
					</div><!-- box wrap -->
				</article><!-- post-->

				<?php endwhile; ?>
				<?php endif; ?>
			</div><!-- posts -->
		</div><!-- content -->

		<!-- footer -->
		<?php get_footer(); ?>