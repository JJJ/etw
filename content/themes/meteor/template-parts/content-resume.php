<?php
/**
 * The template part for displaying sub-pages of a parent page.
 *
 * @package Meteor
 */
?>

<div class="resume">
	<?php
		$resume_query = new WP_Query(
			array(
				'posts_per_page' => -1,
				'paged'          => get_query_var( 'paged' ),
				'post_type'      => 'page',
				'post_parent'    => get_the_ID(),
				'orderby'		 => 'menu_order',
				'order'			 => 'ASC',
			)
		);

		if ( $resume_query->have_posts() ) : while( $resume_query->have_posts() ) : $resume_query->the_post();
	?>
		<article <?php post_class(); ?>>
			<div class="resume-left"><?php the_title( '<h3 class="entry-title">', '</h3>' ); ?></div>

			<div class="resume-right">
				<div class="entry-excerpt">
					<?php
						meteor_remove_sharing();
						the_content();
					?>
					<?php edit_post_link(); ?>
				</div>
			</div>
		</article><!-- .post -->

	<?php endwhile; ?>

	<?php else : if ( current_user_can( 'publish_posts' ) ) : ?>

		<p><?php printf( __( 'Ready to publish your first service? <a href="%1$s">Get started here</a>. Read more about out how to set up the Services section on your <a href="%2$s">Getting Started page</a>.', 'meteor' ), esc_url( admin_url( 'post-new.php?post_type=page' ) ), esc_url( admin_url( 'themes.php?page=meteor-license#services' ) ) ); ?></p>

	<?php else : ?>

		<p><?php _e( 'No services have been added yet.', 'meteor' ); ?></p>

	<?php endif; endif; ?>

	<?php wp_reset_postdata(); ?>
</div><!-- .service-posts -->
