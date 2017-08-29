<?php
/**
 * Page not found template.
 *
 * @package Typable
 * @since 1.0
 */
get_header(); ?>

		<div id="content">
			<div class="posts">
				<!-- grab the posts -->
				<article class="post">
					<div class="box-wrap">
						<div class="box">
							<header>
								<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">404 &mdash; <?php _e( 'Page Not Found', 'typable' ); ?></a></h1>
							</header>

							<!-- post content -->
							<div class="post-content">
								<p><?php _e( 'The page you are looking for has moved or no longer exists. Please use the menu above or check out the archives to locate the content you were looking for.', 'typable' ); ?></p>
							</div><!-- post content -->
						</div><!-- box -->
					</div><!-- box wrap -->
				</article><!-- post-->
			</div><!-- posts -->
		</div><!-- content -->

		<!-- footer -->
		<?php get_footer(); ?>