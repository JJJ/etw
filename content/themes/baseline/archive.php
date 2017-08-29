<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Baseline
 */
get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main blocks-page" role="main">
			<?php if ( have_posts() ) : ?>
				<header class="entry-header archive-header">
					<div class="container">
						<?php
							the_archive_title( '<h1 class="entry-title">', '</h1>' );
							the_archive_description( '<div class="entry-content"><div class="taxonomy-description">', '</div></div>' );
						?>
					</div><!-- .container -->
				</header><!-- .entry-header -->

				<div id="post-wrapper" class="grid-wrapper">
					<div class="gallery-wrapper">
					<?php
						// Get the post content
						while ( have_posts() ) : the_post();

							if ( 'one-column' === get_option( 'baseline_customizer_post_style', 'one-column' ) ) {
								get_template_part( 'template-parts/content' );
							} else {
								get_template_part( 'template-parts/content-grid-item' );
							}

						endwhile;
					?>
					</div><!-- .gallery-wrapper -->
				</div><!-- #post-wrapper -->

				<?php baseline_pagination();

			else :

				get_template_part( 'template-parts/content-none' );

			endif; ?>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>
