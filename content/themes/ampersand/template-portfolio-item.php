<?php
/**
 * Template Name: Portfolio Item
 *
 * The template for displaying portfolio items in single view.
 *
 * @package Ampersand
 * @since Ampersand 1.0
 */

get_header(); ?>

		<div id="main" class="site-main portfolio-single clearfix">

			<?php while ( have_posts() ) : the_post(); ?>

				<div id="secondary" class="widget-area" role="complementary">
					<aside class="portfolio-content">
						<?php the_content(); ?>
						<?php edit_post_link( __( 'Edit', 'ampersand' ), '<span class="edit-link">', '</span>' ); ?>
					</aside>

					<!-- Child page navigation -->
					<aside class="widget portfolio-nav">
						<?php
							$pagelist = get_pages( "child_of=" . $post->post_parent . "&parent=" . $post->post_parent . "&sort_column=post_date&sort_order=asc" );
							$pages = array();
							foreach ( $pagelist as $page ) {
							   $pages[] += $page->ID;
							}

							$current = array_search( $post->ID, $pages );

							if ( isset( $pages[$current-1] ) ) {
								$prevID = $pages[$current-1];
							}

							if ( isset( $pages[$current+1] ) ) {
								$nextID = $pages[$current+1];
							}
						?>

						<div class="portfolio-navigation clearfix">

							<div class="port-next">
								<?php if ( !empty( $nextID ) ) { ?>
								<a href="<?php echo get_permalink( $nextID ); ?>" title="<?php echo get_the_title( $nextID ); ?>"><i class="fa fa-chevron-left"></i></a>
								<?php } else { ?>
									<i class="fa fa-chevron-left inactive-icon"></i>
								<?php } ?>
							</div>

							<!-- Link to Portfolio parent page -->
							<?php
								if ( $post->post_parent ) {
								$parent_link = get_permalink( $post->post_parent );
							?>
								<a class="port-archive" href="<?php echo $parent_link; ?>"><i class="fa fa-th"></i></a>
							<?php } ?>

							<div class="port-previous">
							<?php if ( !empty( $prevID ) ) { ?>
								<a href="<?php echo get_permalink( $prevID ); ?>" title="<?php echo get_the_title( $prevID ); ?>"><i class="fa fa-chevron-right"></i></a>
							<?php } else { ?>
								<i class="fa fa-chevron-right inactive-icon"></i>
							<?php } ?>
							</div>
						</div><!-- .portfolio-navigation -->
					</aside> <?php wp_reset_query(); ?>
				</div><!-- #secondary .widget-area -->

				<div id="primary" class="content-area">
					<div id="content" class="site-content container clearfix" role="main">

						<div class="post-content portfolio-gallery">
							<!-- If a gallery exists, show it. Otherwise, show the featured image. -->
							<?php if ( strpos( $post->post_content, '[gallery') !== false ) { ?>
								<div class="gallery-wrap clearfix"></div>
							<?php } else if ( '' != get_the_post_thumbnail() ) { ?>
								<a class="portfolio-image" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'ampersand' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'post-image' ); ?></a>
							<?php } ?>
						</div><!-- .post-content -->

						<!-- If comments are open or we have at least one comment, load up the comment template. -->
						<?php if ( comments_open() || '0' != get_comments_number() ) { ?>
							<div class="comments-section clearfix">
								<?php comments_template(); ?>
							</div><!-- comment section -->
						<?php } ?>
					</div><!-- #content .site-content -->
				</div><!-- #primary .content-area -->

			<?php endwhile; // end of the loop. ?>

		</div><!-- #main .site-main -->

<?php get_footer(); ?>
