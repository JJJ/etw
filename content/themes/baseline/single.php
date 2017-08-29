<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Baseline
 */

get_header();
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content' );

			baseline_post_navigation();
			?>
		</main><!-- #main -->

		<?php
		// If comments are open or we have at least one comment, load up the comment template
		if ( comments_open() || '0' != get_comments_number() ) :
			comments_template();
		endif;

		endwhile; ?>

	</div><!-- #primary -->

	<?php get_sidebar();

get_footer(); ?>
