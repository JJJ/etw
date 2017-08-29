<?php
/**
 * This template displays posts in a gallery layout on the homepage
 *
 * @package Candid
 */

get_header(); ?>

	<!-- Get the homepage title and intro text -->
	<?php if ( get_theme_mod( 'candid_customizer_homepage_title' ) || get_theme_mod( 'candid_customizer_homepage_text' ) ) { ?>
		<header class="entry-header">

			<?php if ( get_theme_mod( 'candid_customizer_homepage_title' ) ) {
				printf( '<h1 class="entry-title">%s</h1>', get_theme_mod( 'candid_customizer_homepage_title' ) );
			}

			if ( get_theme_mod( 'candid_customizer_homepage_text' ) ) {
				printf( '<div class="entry-content"><p>%s</p></div>', get_theme_mod( 'candid_customizer_homepage_text' ) );
			} ?>
		</header><!-- .entry-header -->
	<?php } ?>

	<?php do_action( 'candid_above_home_posts' ); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

				<?php if ( have_posts() ) : ?>
					<div id="post-wrapper">
						<div class="gallery-wrapper">
							<?php while ( have_posts() ) : the_post();

								get_template_part( 'template-parts/content-grid-item' );

							endwhile; ?>
						</div>
					</div>

					<?php candid_paging_nav();

				else :

					get_template_part( 'template-parts/content-none' );

				endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
