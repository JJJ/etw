<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Atomic
 */
get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

			<!-- Load standard posts -->
			<?php if ( have_posts() ) : ?>

				<div class="content-left">
					<header class="entry-header">
						<?php
							if ( is_post_type_archive( 'jetpack-portfolio' ) ) {
								echo '<h1 class="entry-title">' . esc_html__( 'Portfolio', 'atomic' ) . '</h1>';
							}

							// Grab author profile box
							if ( is_author() ) {
								atomic_author_box();
							} else {
								// Grab the archive title and description
								the_archive_title( '<h1 class="entry-title">', '</h1>' );
								the_archive_description( '<div class="entry-subtitle">', '</div>' );
							} ?>
					</header>
				</div><!-- .content-left -->

				<div class="content-right">
					<div id="post-wrapper">
						<div class="index-posts">
						<?php
							// Get the post content
							while ( have_posts() ) : the_post();

								get_template_part( 'template-parts/content-index' );

							endwhile;
						?>
						</div><!-- .index-posts -->

						<?php atomic_page_navs(); ?>
					</div><!-- #post-wrapper -->
				</div><!-- .content-right -->

				<?php else :

				get_template_part( 'template-parts/content-none' );

			endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>
