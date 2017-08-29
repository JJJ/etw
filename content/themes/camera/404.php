<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Camera
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<article id="post-<?php the_ID(); ?>" class="post">
			<div class="container content-container">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Page Not Found', 'camera' ); ?></h1>
					<div class="entry-subtitle">
						<p><?php _e( 'It looks like nothing was found at this location. Please use the search box and links to the right to locate the content you were looking for.', 'camera' ); ?></p>
					</div>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<?php get_search_form(); ?>

					<?php
						if ( camera_check_posts() ) {
							echo "<hr/>";
							the_widget( 'WP_Widget_Recent_Posts' );
						}
					?>

					<?php if ( camera_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
					<hr/>
					<div class="widget widget_categories">
						<h2 class="widgettitle"><?php _e( 'Most Used Categories', 'camera' ); ?></h2>
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
					</div><!-- .widget -->
					<?php endif; ?>

					<hr/>

					<?php
					/* translators: %1$s: smiley */
					$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'camera' ), '' ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
					?>
				</div><!-- .entry-content -->
			</div>
		</article><!-- #post-## -->
	</div><!-- #primary -->

<?php get_footer(); ?>