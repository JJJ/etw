<?php
/**
 * The template used for displaying team members.
 *
 * @package Atomic
 */
 ?>

<div class="section-team clear">
    <?php
        atomic_remove_sharing();
        the_content();
    ?>

    <div class="team-area">
		<?php
            if ( is_front_page() && is_page_template( 'templates/template-homepage.php' ) ) {
                $posts_per_page = get_theme_mod( 'atomic_home_team_count', '9' );
            } else {
                $posts_per_page = -1;
            }

			// Get the team members
			$member_query = new WP_Query(
				array(
					'posts_per_page' => $posts_per_page,
					'paged'          => get_query_var( 'paged' ),
					'post_type'      => 'page',
					'post_parent'    => get_the_ID(),
                    'orderby' 		 => 'menu_order',
					'order'          => 'ASC'
				)
			);

			if ( $member_query->have_posts() ) : while( $member_query->have_posts() ) : $member_query->the_post();
		?>

			<article <?php post_class(); ?>>
				<div class="featured-image"><?php the_post_thumbnail( 'atomic-portfolio-square' ); ?></div>

				<h2 class="entry-title">
					<?php the_title(); ?>
				</h2>

				<div class="entry-excerpt">
					<?php
						atomic_remove_sharing();
						echo the_content();
					?>
				</div>
			</article><!-- .post -->

		<?php endwhile; ?>

        <?php else : if ( current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first team member? <a href="%1$s">Get started here</a>. Read more about out how to set up the Team section on your <a href="%2$s">Getting Started page</a>.', 'atomic' ), esc_url( admin_url( 'post-new.php?post_type=page' ) ), esc_url( admin_url( 'themes.php?page=atomic-license#team' ) ) ); ?></p>

		<?php else : ?>

			<p><?php _e( 'No team members have been added yet.', 'atomic' ); ?></p>

		<?php endif; endif; ?>

		<?php wp_reset_postdata(); ?>
    </div><!-- .team-area -->
</div><!-- .section-team -->
