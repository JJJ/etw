<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Baseline
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
			<div class="featured-image"><div class="fallback-single"></div></div>

			<div class="container">
				<header class="entry-header">
					<h1 class="entry-title"><?php esc_html_e( 'Page Not Found', 'baseline' ); ?></h1>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Please use the search box and links below to locate the content you were looking for.', 'baseline' ); ?></p>

						<?php get_search_form(); ?>

						<!-- Page sitemap -->
						<h3><?php esc_html_e( 'Sitemap', 'baseline' ); ?></h3>
						<ul>
							<?php wp_list_pages( 'sort_column=menu_order&title_li=' ); ?>
						</ul>

						<hr/>

						<!-- Latest posts -->
						<h3><?php esc_html_e( 'Latest Posts', 'baseline' ); ?></h3>
						<ul>
							<?php wp_get_archives( 'type=postbypost&limit=10' ); ?>
						</ul>

						<hr/>

						<!-- Category archive -->
						<h3 class="widgettitle"><?php esc_html_e( 'Categories', 'baseline' ); ?></h3>
						<ul>
							<?php
								wp_list_categories( array(
									'orderby'    => 'count',
									'order'      => 'DESC',
									'show_count' => 1,
									'title_li'   => '',
									'number'     => 10,
								) );
							?>
						</ul>

						<hr/>

						<!-- Montly archive -->
						<h3><?php esc_html_e( 'Archives', 'baseline' ); ?></h3>
						<ul>
							<?php wp_get_archives( 'type=monthly&limit=12' ); ?>
						</ul>
				</div><!-- .entry-content -->
			</div><!-- .container-->
		</article><!-- #post-## -->

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>