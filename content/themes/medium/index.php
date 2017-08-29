<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Medium
 * @since 1.0
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
			if( is_single () && 'open' == $post->comment_status ) { ?>
				<div id="comment-jump" class="comments">
					<?php comments_template(); ?>
				</div>
			<?php } ?>
		</div><!-- content -->

		<!-- footer -->
		<?php get_footer(); ?>