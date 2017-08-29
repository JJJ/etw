<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Candid
 */
get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main blocks-page" role="main">
			<?php if ( have_posts() ) : ?>
				<header class="entry-header">
					<?php
						the_archive_title( '<h1 class="entry-title">', '</h1>' );
						the_archive_description( '<div class="entry-content"><div class="taxonomy-description">', '</div></div>' );
					?>

					<?php
					// Grab author description on author archive
					if ( is_author() ) { ?>
						<div class="entry-content">
							<div class="taxonomy-description">
								<?php the_author_archive_description(); ?>
							</div>
						</div>
					<?php } ?>

				</header><!-- .entry-header -->

				<div id="post-wrapper">
					<div class="gallery-wrapper">
					<?php
						// Get the post content
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/content-grid-item' );

						endwhile;
					?>
					</div><!-- .gallery-wrapper -->
				</div><!-- #post-wrapper -->

				<?php candid_paging_nav();

			else :

				get_template_part( 'template-parts/content-none' );

			endif; ?>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>
