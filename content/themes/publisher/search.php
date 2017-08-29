<?php
/**
 * The template for displaying search results.
 *
 * @package Publisher
 * @since Publisher 1.0
 */

get_header(); ?>

		<div id="main" class="site-main blocks-page clearfix">
			<div class="archive-title">
				<h1><?php printf( __( 'Search Results for: %s', 'publisher' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</div><!-- .archive-title -->

			<div id="primary">
				<div id="content" class="site-content" role="main">
					<!-- Grab Blocks Template -->
					<?php get_template_part( 'templates/template-blocks' ); ?>
				</div><!-- #content .site-content -->
			</div><!-- #primary .content-area -->
		</div><!-- #main .site-main -->

<?php get_footer(); ?>