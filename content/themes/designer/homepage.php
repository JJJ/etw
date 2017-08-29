<?php
/**
 * Template Name: Homepage Template
 *
 * This template brings in portfolio items and blog posts.
 *
 * @package Designer
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<!-- Get the portfolio page content -->
			<div class="portfolio-content">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

				<?php endwhile; // end of the loop. ?>
			</div>

			<!-- Get the portfolio items -->
			<?php
				if ( get_query_var( 'paged' ) ) :
					$paged = get_query_var( 'paged' );
				elseif ( get_query_var( 'page' ) ) :
					$paged = get_query_var( 'page' );
				else :
					$paged = 1;
				endif;

				$posts_per_page = get_option( 'designer_customizer_portfolio_number', '10' );
				$args = array(
					'post_type'      => 'jetpack-portfolio',
					'posts_per_page' => $posts_per_page,
					'paged'          => $paged,
				);
				$project_query = new WP_Query ( $args );
				if ( $project_query -> have_posts() ) :
			?>

				<div class="portfolio-wrapper <?php echo esc_attr( get_option( 'designer_customizer_portfolio', 'tile') ); ?>">

					<?php /* Start the Loop */ ?>
					<?php while ( $project_query -> have_posts() ) : $project_query -> the_post(); ?>

						<?php get_template_part( 'content', 'portfolio-thumbs' ); ?>

					<?php endwhile; ?>

				</div><!-- .portfolio-wrapper -->

			<?php else : ?>

				<section class="no-results">

					<div class="page-content">
						<?php if ( current_user_can( 'publish_posts' ) ) : ?>

							<p class="get-started"><?php printf( __( 'Ready to publish your first project? <a href="%1$s">Get started here</a>.', 'designer' ), esc_url( admin_url( 'post-new.php?post_type=jetpack-portfolio' ) ) ); ?></p>

						<?php endif; ?>
					</div><!-- .page-content -->
				</section><!-- .no-results -->

			<?php endif; ?>

			<?php wp_reset_query(); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>