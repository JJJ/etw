<?php
/**
 * The template for displaying Search results.
 *
 * @package Baseline
 */

get_header(); ?>

 <div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<header class="entry-header archive-header">
			<div class="container">
				<h1 class="entry-title">
					<?php printf( esc_html__( 'Search results for: %s', 'baseline' ), '<span>' . get_search_query() . '</span>' ); ?>
				</h1>

				<p class="entry-content">
				<?php
					global $wp_query;
					echo $wp_query->found_posts . esc_html__( ' results found.', 'baseline' );
				?>
				</p>
			</div>
		</header><!-- .entry-header -->

		<div id="post-wrapper" class="grid-wrapper">

			<?php if ( have_posts() ) :

				echo '<div class="gallery-wrapper">';

				while ( have_posts() ) : the_post();

					if ( 'one-column' === get_option( 'baseline_customizer_post_style', 'one-column' ) ) {
						get_template_part( 'template-parts/content' );
					} else {
						get_template_part( 'template-parts/content-grid-item' );
					}

				endwhile;

				echo '</div>';

				baseline_pagination();

			else : ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
					<div class="container">
						<header class="entry-header entry-large">
							<div class="taxonomy-description">
								<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords, or use the menu to find the content you are looking for.', 'baseline' ); ?></p>
							</div>
						</header><!-- .entry-header -->

						<div class="entry-content">
							<?php get_search_form(); ?>
						</div><!-- .entry-content -->
					</div><!-- .container -->

				</article><!-- #post-## -->

			<?php endif; ?>

		</div><!-- .grid-wrapper -->
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
