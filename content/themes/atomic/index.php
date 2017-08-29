<?php
/**
 * The main template file.
 *
 * @package Atomic
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">
			<?php
				if ( have_posts() ) :

				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content' );

				endwhile;

				atomic_page_navs();

				else :

				get_template_part( 'template-parts/content-none' );

				endif;
			?>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>
