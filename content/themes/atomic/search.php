<?php
/**
 * The template for displaying Search results.
 *
 * @package Atomic
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">


				<div class="content-left">
					<header class="entry-header">
						<h1 class="entry-title"><?php printf( esc_html__( 'Results for: %s', 'atomic' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					</header>
				</div><!-- .content-left -->

				<div class="content-right">
					<?php if ( have_posts() ) : ?>
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
					<?php else : ?>
						<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'atomic' ); ?></p>
						<?php get_search_form(); ?>
					<?php endif; ?>
				</div><!-- .content-right -->


		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>
