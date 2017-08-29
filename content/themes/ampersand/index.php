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
 * @package Ampersand
 * @since Ampersand 1.0
 */

get_header(); ?>

		<div id="main" class="site-main clearfix">
			<div id="primary" class="content-area">
				<div id="content" class="site-content container" role="main">

				<div id="posts" class="posts">
					<?php while ( have_posts() ) : the_post(); ?>

						<!-- Load post content from format-standard.php -->
						<?php get_template_part( 'format', 'standard' ); ?>

					<?php endwhile; // end of the loop. ?>
				</div>

				<?php if ( ampersand_page_has_nav() ) : ?>
					<?php ampersand_content_nav( 'nav-below' ); ?>
				<?php endif; ?>

				</div><!-- #content .site-content -->
			</div><!-- #primary .content-area -->

			<?php get_sidebar(); ?>

		</div><!-- #main .site-main -->

<?php get_footer(); ?>