<?php
/**
 * The main template file.
 *
 * @package Candid
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">
			<div id="post-wrapper">
				<?php if ( have_posts() ) :

					while ( have_posts() ) : the_post();

						get_template_part( 'template-parts/content-grid-item' );

					endwhile;

					candid_paging_nav();

				else :

					get_template_part( 'template-parts/content-none' );

				endif; ?>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
