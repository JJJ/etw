<?php
/**
 * The template for displaying 404 pages.
 *
 * @package Ampersand
 * @since Ampersand 1.0
 */

get_header(); ?>

		<div id="main" class="site-main clearfix">
			<div id="primary" class="content-area">
				<div id="content" class="site-content container clearfix" role="main">
						<div class="block-text">
							<div class="content-section">
								<div id="content-wrap">
									<p><?php _e( 'It looks like nothing was found at this location. Try using the navigation menu or the search box to locate the page you were looking for.', 'ampersand' ); ?></p>

									<?php get_search_form(); ?>
								</div><!-- #content-wrap -->
							</div><!-- .content-section -->
						</div><!-- .block-text-->
				</div><!-- #content .site-content -->
			</div><!-- #primary .content-area -->

			<?php get_sidebar(); ?>
		</div><!-- #main .site-main -->

<?php get_footer(); ?>