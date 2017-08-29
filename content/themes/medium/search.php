<?php
/**
 * The template for displaying search results
 *
 * @package Medium
 * @since 2.0
 */
get_header(); ?>

		<div id="content">
			<div class="posts">

				<h2 class="archive-title">
					<?php global $wp_query;
					printf( __( '%d results for "%s"', 'medium' ), $wp_query->found_posts, get_search_query( true ) ); ?>
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