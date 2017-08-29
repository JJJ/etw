<?php
/**
 * The template for displaying the Testimonials archive page.
 *
 * @package Atomic
 */

$jetpack_options = get_theme_mod( 'jetpack_testimonials' );

get_header(); ?>

<section id="primary" class="content-area">
	<main id="main" class="site-main">

		<!-- Load standard posts -->
		<?php if ( have_posts() ) : ?>

			<div class="content-left">
				<header class="entry-header">
					<?php
						if ( isset( $jetpack_options['page-title'] ) && '' != $jetpack_options['page-title'] )
							echo '<h1 class="entry-title">' . esc_html( $jetpack_options['page-title'] ) . '</h1>';
						else
							echo '<h1 class="entry-title">' . esc_html__( 'Portfolio', 'atomic' ) . '</h1>';
					?>
				</header>
			</div><!-- .content-left -->

			<div class="content-right">
				<?php echo convert_chars( convert_smilies( wptexturize( stripslashes( wp_filter_post_kses( addslashes( $jetpack_options['page-content'] ) ) ) ) ) ); ?>

				<?php get_template_part( 'template-parts/content-testimonials' ); ?>
			</div><!-- .content-right -->

			<?php else :

			get_template_part( 'template-parts/content-none' );

		endif; ?>

	</main><!-- #main -->
</section><!-- #primary -->

<?php get_footer(); ?>
