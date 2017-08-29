<?php
/**
 * Page not found template.
 *
 * @package Medium
 * @since 1.0
 */
get_header(); ?>

		<div id="content">
			<div class="posts">

				<article class="post">
					<div class="box-wrap">
						<div class="box">
							<div class="title-meta">
								<div class="title-meta-left">
									<?php _e( '404 - Page Not Found', 'medium' ); ?>
								</div>
							</div>

							<header>
								<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php _e( '404 - Page Not Found', 'medium' ); ?></a></h1>
							</header>

							<div class="post-content">
								<p><?php _e( 'Sorry, but the page you are looking for has moved or no longer exists. Please use the search or the archives below to try and locate the page you were looking for.', 'medium' ); ?></p>

								<?php get_search_form();?>

								<div id="archive">
									<div class="archive-col">
										<div class="archive-box">
											<h4><?php _e( 'Archive By Day', 'medium' ); ?></h4>
											<ul>
												<?php wp_get_archives( 'type=daily&limit=15' ); ?>
											</ul>
										</div>

										<div class="archive-box">
											<h4><?php _e( 'Archive By Month', 'medium' ); ?></h4>
											<ul>
												<?php wp_get_archives( 'type=monthly&limit=12' ); ?>
											</ul>
										</div>

										<div class="archive-box">
											<h4><?php _e( 'Archive By Year', 'medium' ); ?></h4>
											<ul>
												<?php wp_get_archives( 'type=yearly&limit=12' ); ?>
											</ul>
										</div>
									</div><!-- column -->

									<div class="archive-col">
										<div class="archive-box">
											<h4><?php _e( 'Latest Posts', 'medium' ); ?></h4>
											<ul>
												<?php wp_get_archives( 'type=postbypost&limit=20' ); ?>
											</ul>
										</div>
									</div><!-- column -->

									<div class="archive-col">
										<div class="archive-box">
											<h4><?php _e( 'Pages', 'medium' ); ?></h4>
											<ul>
												<?php wp_list_pages( 'sort_column=menu_order&title_li=' ); ?>
											</ul>
										</div>

										<div class="archive-box">
											<h4><?php _e( 'Categories', 'medium' ); ?></h4>
											<ul>
												<?php wp_list_categories( 'orderby=name&title_li=' ); ?>
											</ul>
										</div>

										<div class="archive-box">
											<h4><?php _e( 'Contributors', 'medium' ); ?></h4>
											<ul>
												<?php wp_list_authors( 'show_fullname=1&optioncount=1&orderby=post_count&order=DESC' ); ?>
											</ul>
										</div>
									</div><!-- column -->
								</div><!-- archive -->
							</div><!-- post content -->
						</div><!-- box -->
					</div><!-- box wrap -->
				</article><!-- post-->
			</div><!-- posts -->
		</div><!-- content -->

		<!-- footer -->
		<?php get_footer(); ?>