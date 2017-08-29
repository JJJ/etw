<?php
/**
 * The template for displaying single posts.
 *
 *
 * @package Medium
 * @since 2.0
 */
get_header(); ?>

		<div id="content">
			<div class="posts">

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<article <?php post_class('post'); ?>>
					<?php
						if( 'gallery' == get_post_format() ) {
							get_template_part( 'format', 'gallery' );
						} else {
							get_template_part( 'format', 'standard' );
						};
					?>
				</article><!-- post-->

				<?php endwhile; endif; ?>
			</div>

			<?php
			// Pagination
			medium_page_nav();

			// Comments
			if ( comments_open() ) { ?>
				<div id="comment-jump" class="comments">
					<?php comments_template(); ?>
				</div>
			<?php } ?>
		</div><!-- content -->

		<!-- footer -->
		<?php get_footer(); ?>