<?php
/**
 * Page not found template.
 *
 * @package North
 * @since 1.0
 */
get_header(); ?>

		<header class="page-titles">
			<div class="container clearfix">
				<!-- Page title -->
				<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php _e( 'Page Not Found', 'north' ); ?></a></h1>

				<!-- Subtitle -->
				<h3 class="entry-subtitle"><?php _e( 'Well this is pretty embarrassing, huh?', 'north' ); ?></h3>
			</div>
		</header>

		<section class="main">
			<div id="content">
				<div class="container clearfix">
					<div class="posts">
						<!-- Grab the posts -->
							<article <?php post_class( 'post' ); ?>>
								<div class="box-wrap">
									<div class="box">
										<!-- Post content -->
										<div class="post-content">
											<div class="intro"><?php _e( 'Sorry, but the page you are looking for has moved or no longer exists. Please use the search below, or the menu above to locate the missing page.', 'north' ); ?></div>

											<?php get_search_form();?>
										</div><!-- post content -->
									</div><!-- box -->
								</div><!-- box wrap -->
							</article><!-- post-->
					</div><!-- posts -->
				</div><!-- container -->
			</div><!-- content -->
		</section><!-- main -->

		<!-- Footer -->
		<?php get_footer(); ?>