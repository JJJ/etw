<?php
/**
 * The template used for displaying testimonials.
 *
 * @package Atomic
 */
?>

<div class="section-testimonials clear">
    <?php
        atomic_remove_sharing();
        the_content();
    ?>

	<div class="testimonial-posts">

		<?php
	        if ( get_query_var( 'paged' ) ) :
	            $paged = get_query_var( 'paged' );
	        elseif ( get_query_var( 'page' ) ) :
	            $paged = get_query_var( 'page' );
	        else :
	            $paged = 1;
	        endif;

            if ( is_front_page() && is_page_template( 'templates/template-homepage.php' ) ) {
                $posts_per_page = get_theme_mod( 'atomic_home_testimonial_count', '4' );
            } else {
                $posts_per_page = get_option( 'posts_per_page' );
            }

	        $args = array(
	            'post_type'      => 'jetpack-testimonial',
	            'paged'          => $paged,
	            'posts_per_page' => $posts_per_page,
	        );

	        $testimonial_query = new WP_Query ( $args );

	        if ( post_type_exists( 'jetpack-testimonial' ) && $testimonial_query -> have_posts() ) :

	            while ( $testimonial_query -> have_posts() ) : $testimonial_query -> the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'testimonial-entry testimonial-entry-column-1' ); ?>>

					<div class="testimonial-entry-content">
						<?php
							atomic_remove_sharing();
							the_content();
						?>
					</div>

					<div class="testimonial-cite">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="testimonial-featured-image">
								<?php the_post_thumbnail( 'atomic-testimonial-avatar' ); ?>
							</div>
						<?php endif; ?>

						<h2 class="testimonial-entry-title">
							<?php the_title(); ?>
						</h2>
					</div>
				</article>

	            <?php endwhile; ?>
	</div><!-- .testimonial-posts -->

	<?php atomic_page_navs( $testimonial_query ); ?>

    <?php else : if ( current_user_can( 'publish_posts' ) ) : ?>

		<p><?php printf( __( 'Ready to publish your first testimonial? <a href="%1$s">Get started here</a>. Read more about out how to set up the Testimonial section on your <a href="%2$s">Getting Started page</a>.', 'atomic' ), esc_url( admin_url( 'post-new.php?post_type=jetpack-testimonial' ) ), esc_url( admin_url( 'themes.php?page=atomic-license#testimonials' ) ) ); ?></p>

    <?php else : ?>

        <p><?php _e( 'No testimonials have been added yet.', 'atomic' ); ?></p>

    <?php endif; endif; ?>

</div><!-- .section-testimonials -->
