<?php
/**
 * The template for displaying all pages.
 *
 * @package Publisher
 * @since Publisher 1.0
 */

get_header(); ?>

		<div id="main" class="site-main clearfix">
			<div id="primary" class="content-area">
				<div id="content" class="site-content container clearfix" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

						<div class="block-titles">
							<div class="block-date">
							<?php echo get_the_date(); ?> <div class="span-slash">/</div> <?php the_author_posts_link(); ?>
						</div>

							<h1 class="block-entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
						</div><!-- .block-titles -->

						<div class="block-text">
							<div class="content-section">
								<div id="content-wrap">
									<div class="entry-attachment">
										<?php if ( wp_attachment_is_image() ) :
											$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
											foreach ( $attachments as $k => $attachment ) {
												if ( $attachment->ID == $post->ID )
													break;
											}
											$k++;
											// If there is more than 1 image attachment in a gallery
											if ( count( $attachments ) > 1 ) {
												if ( isset( $attachments[ $k ] ) )
													// get the URL of the next image attachment
													$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
												else
													// or get the URL of the first image attachment
													$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
											} else {
												// or, if there's only 1 image attachment, get the URL of the image
												$next_attachment_url = wp_get_attachment_url();
											}
										?>
										<p class="attachment">
											<a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
												<?php
													$attachment_width  = apply_filters( 'publisher_attachment_size', 900 );
													$attachment_height = apply_filters( 'publisher_attachment_height', 900 );
													echo wp_get_attachment_image( $post->ID, array( $attachment_width, $attachment_height ) );
												?>
											</a>
										</p>

										<div id="nav-below" class="navigation">
											<div class="nav-previous"><?php previous_image_link( false ); ?></div>
											<div class="nav-next"><?php next_image_link( false ); ?></div>
										</div><!-- #nav-below -->
										<?php else : ?>
										<a href="<?php echo esc_url( wp_get_attachment_url() ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php echo basename( get_permalink() ); ?></a>
										<?php endif; ?>

										<!-- Image dimensions -->
										<div class="attachment-dimensions">
											<?php
											if ( wp_attachment_is_image() ) {
												$metadata = wp_get_attachment_metadata();
												printf( __( 'Full size is %s pixels', 'publisher' ),
													sprintf( '<a href="%1$s" title="%2$s">%3$s &times; %4$s</a>',
														esc_url( wp_get_attachment_url() ),
														esc_attr( __( 'Link to full-size image', 'publisher' ) ),
														$metadata['width'],
														$metadata['height']
													)
												);
											}
											?>
										</div>
									</div><!-- .entry-attachment -->
								</div><!-- #content-wrap -->
							</div><!-- content section -->
						</div>
				<?php endwhile; // end of the loop. ?>

				</div><!-- #content .site-content -->
			</div><!-- #primary .content-area -->

			<?php get_sidebar(); ?>

		</div><!-- #main .site-main -->

<?php get_footer(); ?>