<?php
/**
 * Template Name: Portfolio Masonry
 *
 * @package Meteor
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php the_post(); if( trim( $post->post_content ) != "" ) { ?>
				<div class="page-content">
					<?php the_content(); ?>
				</div>
			<?php } ?>

			<div class="section-portfolio section-portfolio-grid section-portfolio-masonry">

			    <?php
			        if ( get_query_var( 'paged' ) ) :
			            $paged = get_query_var( 'paged' );
			        elseif ( get_query_var( 'page' ) ) :
			            $paged = get_query_var( 'page' );
			        else :
			            $paged = 1;
			        endif;

			        $posts_per_page = get_theme_mod( 'meteor_portfolio_masonry_count', '10' );

			        $args = array(
			            'post_type'      => 'jetpack-portfolio',
			            'paged'          => $paged,
			            'posts_per_page' => $posts_per_page,
			        );

			        $project_query = new WP_Query ( $args );

			        if ( post_type_exists( 'jetpack-portfolio' ) && $project_query -> have_posts() ) :

			            while ( $project_query -> have_posts() ) : $project_query -> the_post();

							// Get the portfolio content
							get_template_part( 'template-parts/content-portfolio-masonry' );

						endwhile;

					else : if ( current_user_can( 'publish_posts' ) ) : ?>

						<?php
							// Check if Jetpack is activated
							if ( ! class_exists( 'Jetpack' ) ) { ?>
								<p class="not-found"><?php printf( __( 'Please install and activate the Jetpack plugin to add portfolio items. Once activated, go to Jetpack &rarr; Settings and activate Portfolios in the Custom Content Types settings.', 'meteor' ) ); ?></p>
						<?php } else {
							// Check if portfolios are activated
							if ( ! class_exists( 'Jetpack_Portfolio' ) ) { ?>
								<p class="not-found"><?php printf( __( 'To add portfolio items, you need to activate Portfolios in the Custom Content Types settings. <a href="%1$s">Click here</a> to go to the Jetpack settings page to activate Portfolios.', 'meteor' ), esc_url( admin_url( 'admin.php?page=jetpack#/settings?term=portfolios' ) ) ); ?></p>
							<?php } else { ?>
								<p class="not-found"><?php printf( __( 'Ready to publish your first portfolio item? <a href="%1$s">Get started here</a>.', 'meteor' ), esc_url( admin_url( 'post-new.php?post_type=jetpack-portfolio' ) ) ); ?></p>
							<?php } } ?>

					<?php else : ?>

						<p class="not-found"><?php _e( 'No portfolio items have been added yet.', 'meteor' ); ?></p>

					<?php endif;

					endif; ?>
			</div><!-- .section-portfolio -->

			<?php
			meteor_page_navs( $project_query );
			wp_reset_postdata();
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_footer(); ?>
