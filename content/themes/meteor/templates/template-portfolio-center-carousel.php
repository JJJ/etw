<?php
/**
 * Template Name: Portfolio Carousel
 * Template Post Type: jetpack-portfolio
 * @package Meteor
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php while ( have_posts() ) : the_post();

			// Post content template
			get_template_part( 'template-parts/content-portfolio-carousel-centered' );

		endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
