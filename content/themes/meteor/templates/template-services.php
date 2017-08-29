<?php
/**
 * Template Name: Services
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

		<div class="service-posts">
			<?php

				$services_query = new WP_Query(
					array(
						'posts_per_page' => -1,
						'paged'          => get_query_var( 'paged' ),
						'post_type'      => 'page',
						'post_parent'    => get_the_ID(),
						'orderby' 		 => 'menu_order'
					)
				);

				if ( $services_query->have_posts() ) : while( $services_query->have_posts() ) : $services_query->the_post();
			?>
				<article <?php post_class(); ?>>
					<?php if ( has_post_thumbnail() ) { ?>
		                <div class="featured-image"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'meteor-portfolio' ); ?></a></div>
		            <?php } ?>

					<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

					<?php add_filter( 'excerpt_length', 'meteor_service_excerpt_length' ); ?>

					<div class="entry-excerpt">
						<?php
							meteor_remove_sharing();
							echo the_excerpt();
						?>
					</div>

					<?php remove_filter( 'excerpt_length', 'meteor_service_excerpt_length' ); ?>

					<p class="more-link"><a href="<?php the_permalink() ?>" rel="bookmark"><?php esc_html_e( 'Read More', 'meteor' ); ?></a></p>
				</article><!-- .post -->

			<?php endwhile; ?>

			<?php else : if ( current_user_can( 'publish_posts' ) ) : ?>

				<p><?php printf( __( 'Ready to publish your first service? <a href="%1$s">Get started here</a>.', 'meteor' ), esc_url( admin_url( 'post-new.php?post_type=page' ) ) ); ?></p>

			<?php else : ?>

				<p><?php _e( 'No services have been added yet.', 'meteor' ); ?></p>

			<?php endif; endif; ?>

			<?php wp_reset_postdata(); ?>
		</div><!-- .service-posts -->

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
