<?php
/*
Template Name: Custom Archive
*/


		get_header(); ?>

		<header class="page-titles">
			<div class="container clearfix">
				<!-- Page title -->
				<h2 class="entry-title"><?php the_title(); ?></h2>

				<!-- Subtitle -->
				<?php if ( get_post_meta($post->ID, 'subtitle', true) ) { ?>
					<h3 class="entry-subtitle"><?php echo get_post_meta($post->ID, 'subtitle', true) ?></h3>
				<?php } ?>
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
										<!-- Post content -->
										<div class="post-content clearfix">
											<?php the_content(__( 'Read More','north')); ?>

											<div id="archive">
												<div class="archive-col">
													<div class="archive-box">
														<h3><?php _e('Latest Posts','north'); ?></h3>
														<ul>
															<?php wp_get_archives('type=postbypost&limit=10'); ?>
														</ul>
													</div>

													<div class="archive-box">
														<h3><?php _e('Portfolio Items','north'); ?></h3>
														<ul>
															<?php
																if ( get_query_var('paged') ) {
																    $paged = get_query_var('paged');
																} else if ( get_query_var('page') ) {
																    $paged = get_query_var('page');
																} else {
																    $paged = 1;
																}

																$args = array('post_type' => 'array-portfolio', 'posts_per_page' => 10, 'paged' => $paged );

																$temp = $wp_query;
																$wp_query = null;
																$wp_query = new WP_Query();
																$wp_query->query( $args );

																while ($wp_query->have_posts()) : $wp_query->the_post();
															?>
															<li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
															<?php endwhile; ?>

															<?php
															  $wp_query = null;
															  $wp_query = $temp;  // Reset
															?>
														</ul>
													</div>

													<div class="archive-box">
														<h3><?php _e('Categories','north'); ?></h3>
														<ul>
															<?php wp_list_categories('orderby=name&title_li='); ?>
														</ul>
													</div>

													<div class="archive-box">
														<h3><?php _e('Archive By Day','north'); ?></h3>
														<ul>
															<?php wp_get_archives('type=daily&limit=15'); ?>
														</ul>
													</div>

													<div class="archive-box">
														<h3><?php _e('Archive By Month','north'); ?></h3>
														<ul>
															<?php wp_get_archives('type=monthly&limit=12'); ?>
														</ul>
													</div>

													<div class="archive-box">
														<h3><?php _e('Archive By Year','north'); ?></h3>
														<ul>
															<?php wp_get_archives('type=yearly&limit=12'); ?>
														</ul>
													</div>

													<div class="archive-box">
														<h3><?php _e('Contributors','north'); ?></h3>
														<ul>
															<?php wp_list_authors('show_fullname=1&optioncount=0&orderby=post_count&order=DESC'); ?>
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

				<!-- Sidebar -->
				<?php get_sidebar(); ?>

			</div><!-- container -->
		</section><!-- main -->

		<!-- Footer -->
		<?php get_footer(); ?>