<?php
/**
 * Template for the archive.
 *
 * @package Publisher
 * @since Publisher 1.0
 */

get_header(); ?>

		<div id="main" class="site-main blocks-page clearfix">
			<div class="archive-title">
				<h1>
					<?php
						if ( is_category() ) :
							single_cat_title();
						echo category_description();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :
							/* Queue the first post, that way we know
							 * what author we're dealing with (if that is the case).
							*/
							the_post();
							printf( __( 'Author: %s', 'publisher' ), '' . get_the_author() . '' );
							/* Since we called the_post() above, we need to
							 * rewind the loop back to the beginning that way
							 * we can run the loop properly, in full.
							 */
							rewind_posts();

						elseif ( is_day() ) :
							printf( __( 'Day: %s', 'publisher' ), '<span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :
							printf( __( 'Month: %s', 'publisher' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

						elseif ( is_year() ) :
							printf( __( 'Year: %s', 'publisher' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							_e( 'Asides', 'publisher' );

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( 'Images', 'publisher');

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( 'Videos', 'publisher' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							_e( 'Quotes', 'publisher' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							_e( 'Links', 'publisher' );

						else :
							_e( 'Archives', 'publisher' );

						endif;
					?>
				</h1>
			</div><!-- .archive-title -->

			<div id="primary">
				<div id="content" class="site-content" role="main">
					<!-- Grab Blocks Template -->
					<?php get_template_part( 'templates/template-blocks' ); ?>
				</div><!-- #content .site-content -->
			</div><!-- #primary .content-area -->
		</div><!-- #main .site-main -->

<?php get_footer(); ?>