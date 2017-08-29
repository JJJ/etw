<?php
/**
 * The template for displaying archive pages
 *
 * @package Medium
 * @since 2.0
 */
get_header(); ?>

		<div id="content">
			<div class="posts">

				<h2 class="archive-title">
				<?php if( is_search() ) {
					global $wp_query;
					printf( __( '%d results for "%s"', 'medium' ), $wp_query->found_posts, get_search_query( true ) );

				} else if( is_tag() ) {
					single_tag_title();

				} else if( is_day() ) {
					_e( 'Archive:', 'medium' ); echo get_the_date();

				} else if( is_month() ) {
					echo get_the_date( 'F Y' );

				} else if( is_year() ) {
					echo get_the_date( 'Y' );

				} else if( is_category() ) {
					single_cat_title();

				} else if( is_author() ) {
					printf( __( 'Author: %s', 'medium' ), '' . get_the_author() . '' );

				} ?>
				</h2>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<article <?php post_class('post'); ?>>
					<?php
						if( 'gallery' == get_post_format() ) {
							get_template_part( 'format', 'gallery' );
						} else {
							get_template_part( 'format', 'standard' );
						};
					?>
				</article><!-- post-->

				<?php endwhile; endif; ?>
			</div>

			<?php
			// Pagination
			medium_page_nav(); ?>

		</div><!-- content -->

		<!-- footer -->
		<?php get_footer(); ?>