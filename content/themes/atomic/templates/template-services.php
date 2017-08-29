<?php
/**
 * Template Name: Services
 *
 * @package Atomic
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<?php while ( have_posts() ) : the_post();

			// Move Jetpack share links below author box
			if ( function_exists( 'sharing_display' ) ) {
				remove_filter( 'the_content', 'sharing_display', 19 );
				remove_filter( 'the_excerpt', 'sharing_display', 19 );
			} ?>

			<div class="content-left">
				<header class="entry-header">
					<!-- Post title -->
					<h2 class="entry-title"><?php the_title(); ?></h2>

					<?php if( is_single() ) { atomic_post_byline(); } ?>
				</header>

				<?php if ( has_excerpt() ) { ?>
					<div class="entry-subtitle">
						<?php
							// WP.com: Disable sharing and likes for this excerpt area
							if ( function_exists( 'post_flair_mute' ) )
								post_flair_mute();
						?>

						<?php the_excerpt(); ?>

						<?php
							// WP.com: Turn sharing and likes back on for all other loops.
							if ( function_exists( 'post_flair_unmute' ) )
								post_flair_unmute();
						?>
					</div>
				<?php } ?>
			</div><!-- .content-left -->

			<div class="content-right">
				<?php
					// Services content template
					get_template_part( 'template-parts/content-services' );
				?>
			</div><!-- .content-right -->

		<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
