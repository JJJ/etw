<?php
/**
 * The main template file.
 *
 * @package Baseline
 */

get_header(); ?>

	<?php get_template_part( 'template-parts/content-featured-content' ); ?>

	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">
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

				else :

					get_template_part( 'template-parts/content-none' );

				endif;


				?>

			</div>

			<?php baseline_pagination(); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
