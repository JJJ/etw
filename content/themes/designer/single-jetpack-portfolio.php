<?php
/**
 * The template for displaying all single projects
 *
 * @package Designer
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div class="portfolio-main">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'portfolio-single' ); ?>

				<?php endwhile; // end of the loop. ?>
			</div>

			<!-- Next/Prev links for portfolio items -->
			<div class="portfolio-nav">
				<div class="portfolio-links">
					<?php previous_post_link( '%link', __( 'Previous Project', 'designer' ) . '' ) ?>
					<?php Next_post_link( '%link', __( 'Next Project', 'designer' ) . '' ) ?>
				</div>

				<a class="button all-projects" href="<?php echo esc_url( get_post_type_archive_link( 'jetpack-portfolio' ) ); ?>">
					<?php _e( 'All Projects', 'designer' ); ?>
				</a>
			</div>

			<!-- Get the portfolio items -->
			<?php

				$posts_per_page = get_option( 'jetpack_portfolio_posts_per_page', '10' );
				$args = array(
					'post_type'      => 'jetpack-portfolio',
					'posts_per_page' => $posts_per_page,
					'post__not_in'   => array( get_the_ID() ),
					'orderby'        => 'rand'
				);
				$project_query = new WP_Query ( $args );
				if ( $project_query -> have_posts() ) :
			?>

				<div class="portfolio-wrapper <?php echo esc_attr( get_option( 'designer_customizer_portfolio', 'tile' ) ); ?>">

					<?php while ( $project_query -> have_posts() ) : $project_query -> the_post();

						get_template_part( 'content', 'portfolio-thumbs' );

					endwhile;
					wp_reset_postdata();
					?>

				</div><!-- .portfolio-wrapper -->
			<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>