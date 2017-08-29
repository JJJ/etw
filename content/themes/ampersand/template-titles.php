<?php
/**
 * Template for post and page titles.
 *
 * @package Ampersand
 * @since Ampersand 1.0
 */

?>

<?php if ( is_home() && is_front_page() ) { } else { ?>

<div class="hero-title animated fadeIn">
	<h1>
		<?php
			if ( is_category() ) :
				printf( __( 'Category: ', 'ampersand' ) ); single_cat_title();

			elseif ( is_tag() ) :
				printf( __( 'Tag: ', 'ampersand' ) ); single_tag_title();

			elseif ( is_author() ) :
				/* Queue the first post, that way we know
				 * what author we're dealing with (if that is the case).
				*/
				the_post();
				printf( __( 'Author: %s', 'ampersand' ), '' . get_the_author() . '' );
				/* Since we called the_post() above, we need to
				 * rewind the loop back to the beginning that way
				 * we can run the loop properly, in full.
				 */
				rewind_posts();

			elseif ( is_day() ) :
				printf( __( 'Day: %s', 'ampersand' ), '<span>' . get_the_date() . '</span>' );

			elseif ( is_month() ) :
				printf( __( 'Month: %s', 'ampersand' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

			elseif ( is_year() ) :
				printf( __( 'Year: %s', 'ampersand' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

			elseif ( is_404() ) :
				_e( '404 - Page Not Found', 'ampersand' );

			elseif ( is_search() ) :
				printf( __( 'Search Results for: %s', 'ampersand' ), '<span>' . get_search_query() . '</span>' );

			elseif ( is_archive() ) :
				the_archive_title();

			else :
				single_post_title();

			endif;
		?>
	</h1>

	<?php if ( is_page_template( 'homepage.php' ) && get_option( 'ampersand_customizer_header_subtitle_text' ) ) { ?>
		<p><?php echo get_option( 'ampersand_customizer_header_subtitle_text' ); ?></p>
	<?php } ?>

	<?php
    // Display post subtitles on self-hosted sites.
    if( function_exists( 'ampersand_do_subtitle' ) ) {
    	ampersand_do_subtitle();
    } ?>

	<!-- Homepage header call-to-action button -->
	<?php if ( is_page_template( 'homepage.php' ) && get_theme_mod( 'ampersand_customizer_header_page' ) ) { ?>
		<?php
			$button_page_id = get_theme_mod( 'ampersand_customizer_header_page' );
			$button_url = get_permalink( $button_page_id );
		?>

		<a class="cta-red animated fadeIn" href="<?php echo esc_url( $button_url ); ?>"><?php echo get_option( 'ampersand_customizer_header_text' ); ?> <i class="fa fa-arrow-circle-right"></i></a>
	<?php } ?>
</div>

<?php } ?>