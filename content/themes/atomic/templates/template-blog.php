<?php
/**
 * Template Name: Blog
 *
 * @package Atomic
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php while ( have_posts() ) : the_post();

				// Move Jetpack share links below author box
				if ( function_exists( 'sharing_display' ) ) {
					remove_filter( 'the_content', 'sharing_display', 19 );
					remove_filter( 'the_excerpt', 'sharing_display', 19 );
				}

				// Get the blog posts for the homepage
				get_template_part( 'template-parts/content-blog' );

			endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_footer(); ?>
