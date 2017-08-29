<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Candid
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content' ); ?>

			<!-- Next and previous post links -->
			<div class="post-navigation">
				<div class="post-navigation-links">
					<?php previous_post_link( '%link', __( 'Previous', 'candid' ) ); ?>
					<?php next_post_link( '%link', __( 'Next', 'candid' ) ); ?>
				</div>

				<a class="button all-posts" href="<?php echo home_url( '/' ); ?>">
					<i class="fa fa-th"></i> <?php esc_html_e( 'View All', 'candid' ); ?>
				</a>
			</div>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;

		endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_sidebar();

get_footer(); ?>
