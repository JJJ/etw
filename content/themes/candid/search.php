<?php
/**
 * The template for displaying Search results.
 *
 * @package Candid
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<header class="entry-header">
				<h1 class="entry-title">
					<?php printf( esc_html__( 'Results for: %s', 'watermark' ), '<span>' . get_search_query() . '</span>' ); ?>
				</h1>
			</header><!-- .entry-header -->

			<?php do_action( 'candid_above_home_posts' ); ?>

			<div id="post-wrapper">
				<div class="gallery-wrapper">
					<?php if ( have_posts() ) :

						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/content-grid-item' );

						endwhile;

						candid_paging_nav();

					else :

						get_template_part( 'template-parts/content-none' );

					endif; ?>
				</div><!-- .gallery-wrapper -->
			</div><!-- #post-wrapper -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
