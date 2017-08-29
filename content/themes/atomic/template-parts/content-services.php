<?php
/**
 * The template part for displaying sub-pages of a parent page.
 *
 * @package Atomic
 */
?>

<div class="section-services clear">
	<?php
		atomic_remove_sharing();
		the_content();
	?>

	<div class="service-posts">
		<?php
			if ( is_front_page() && is_page_template( 'templates/template-homepage.php' ) ) {
				$posts_per_page = get_theme_mod( 'atomic_home_services_count', '9' );
			} else {
				$posts_per_page = 9;
			}

			$services_query = new WP_Query(
				array(
					'posts_per_page' => $posts_per_page,
					'paged'          => get_query_var( 'paged' ),
					'post_type'      => 'page',
					'post_parent'    => get_the_ID(),
					'orderby' 		 => 'menu_order',
					'order'          => 'ASC'
				)
			);

			if ( $services_query->have_posts() ) : while( $services_query->have_posts() ) : $services_query->the_post();
		?>
			<article <?php post_class(); ?>>
				<?php if ( has_post_thumbnail() ) { ?>
	                <div class="featured-image"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'atomic-portfolio' ); ?></a></div>
	            <?php } ?>

				<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

				<?php
					add_filter( 'excerpt_length', 'atomic_portfolio_excerpt_length' ); ?>

					<div class="entry-excerpt">
						<?php
							atomic_remove_sharing();
							echo the_excerpt();
						?>
					</div>

					<?php remove_filter( 'excerpt_length', 'atomic_portfolio_excerpt_length' );
				?>

				<p class="more-link"><a href="<?php the_permalink() ?>" rel="bookmark"><?php esc_html_e( 'Read More', 'atomic' ); ?></a></p>
			</article><!-- .post -->

		<?php endwhile; ?>

		<?php else : if ( current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first service? <a href="%1$s">Get started here</a>. Read more about out how to set up the Services section on your <a href="%2$s">Getting Started page</a>.', 'atomic' ), esc_url( admin_url( 'post-new.php?post_type=page' ) ), esc_url( admin_url( 'themes.php?page=atomic-license#services' ) ) ); ?></p>

		<?php else : ?>

			<p><?php _e( 'No services have been added yet.', 'atomic' ); ?></p>

		<?php endif; endif; ?>

		<?php wp_reset_postdata(); ?>
	</div><!-- .service-posts -->
</div><!-- .section-services -->
