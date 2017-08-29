<?php
/**
 * Template Name: Homepage
 *
 * @package Atomic
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<main id="main" class="site-main">

			<?php
			// Get each of our panels and show the post data.
			if ( 0 !== atomic_panel_count() || is_customize_preview() ) : // If we have pages to show.

				/**
				 * Filter number of front page sections
				 */
				$num_sections = apply_filters( 'atomic_front_page_sections', 6 );
				global $atomiccounter;

				// Create a setting and control for each of the sections available in the theme.
				for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
					$atomiccounter = $i;
					atomic_front_page_section( null, $i );
				}

				else :

					if ( current_user_can( 'customize' ) ) { ?>
					    <div class="container placeholder-container">
					        <h2><?php _e( 'No sections available to display.', 'atomic' ); ?></h2>
					        <p><?php printf(
					            __( '<a class="button" href="%s">Set up your homepage sections &rarr;</a>', 'atomic' ),
					            admin_url( 'customize.php?autofocus[section]=atomic_front_page' )
					        ); ?></p>
					    </div>
					<?php }


			endif; // The if ( 0 !== atomic_panel_count() ) ends here. ?>


		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_footer(); ?>
