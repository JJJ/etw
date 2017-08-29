<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Atomic
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="content-left">
					<header class="entry-header">
						<h1 class="entry-title"><?php esc_html_e( 'Page Not Found', 'atomic' ); ?></h1>
					</header>
				</div><!-- .content-left -->

				<div class="content-right">
					<div class="entry-content">
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Please use the search box or the sitemap to locate the content you were looking for.', 'atomic' ); ?></p>

						<?php get_search_form(); ?>

						<div class="archive-box">
							<h4><?php esc_html_e( 'Sitemap', 'atomic' ); ?></h4>
							<ul>
								<?php wp_list_pages('sort_column=menu_order&title_li='); ?>
							</ul>
						</div>
					</div><!-- .entry-content -->
				</div>
			</article><!-- #post-## -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
