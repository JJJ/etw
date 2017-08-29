<?php
/**
 * Template for the post and page titles.
 *
 * @package Author
 * @since Author 1.0
 */
?>

<?php if ( is_front_page() || is_single() || is_page() ) {} else { ?>
	<div class="sub-title">
		<h1>
		<?php
			if ( is_category() ) :
				printf( __( 'Category / ', 'author' ) ); single_cat_title();

			elseif ( is_tag() ) :
				printf( __( 'Tag / ', 'author' ) ); single_tag_title();

			elseif ( is_author() ) :
				printf( __( 'Author / %s', 'author' ), '' . get_the_author() . '' );

			elseif ( is_day() ) :
				printf( __( 'Day / %s', 'author' ), '<span>' . get_the_date() . '</span>' );

			elseif ( is_month() ) :
				printf( __( 'Month / %s', 'author' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

			elseif ( is_year() ) :
				printf( __( 'Year / %s', 'author' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

			elseif ( is_404() ) :
				_e( '404 / Page Not Found', 'author' );

			elseif ( is_search() ) :
				printf( __( 'Search Results for: %s', 'author' ), '<span>' . get_search_query() . '</span>' );

			endif;
		?>
		</h1>
	</div>
<?php } ?>