<?php
/**
 * Template Name: Full Width
 *
 * Template for displaying full width content
 *
 * @package Camera
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'page' ); ?>

			<div class="comments-wrap">
				<div class="comments-inside container">
					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
					?>
				</div><!-- .comments-inside -->
			</div><!-- .comments-wrap -->

		<?php endwhile; // end of the loop. ?>

	</div><!-- #primary -->

<?php get_footer(); ?>