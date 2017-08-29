<?php
/**
 *
 * A page template for the 404 - Page Not Found error.
 *
 * @package Transmit
 * @since Transmit 1.0
 */

get_header(); ?>

		<div class="section">
			<div id="post-<?php the_ID(); ?>" <?php post_class('box'); ?>>
				<h2 class="post-title"><?php _e( 'Page Not Found', 'transmit' ); ?></h2>

				<p><?php _e( 'It looks like nothing was found at this location. Try using the navigation menu or the search box to locate the page you were looking for.', 'transmit' ); ?></p>
				<hr />
				<?php the_widget( 'WP_Widget_Pages' ); ?>
				<?php the_widget( 'WP_Widget_Search' ); ?>
			</div>
		</div><!-- section -->

	</div><!-- page -->
</div><!-- main -->

<?php get_footer(); ?>