<?php
/**
 * Template Name: Resume
 *
 * @package Meteor
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php
				// Resume content
				get_template_part( 'template-parts/content-resume' );
			?>

		<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
