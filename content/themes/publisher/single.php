<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Publisher
 * @since Publisher 1.0
 */

get_header(); ?>

		<div id="main" class="site-main clearfix">
			<div id="primary">
				<div id="content" class="site-content container clearfix" role="main">

					<?php while ( have_posts() ) : the_post(); ?>
						<?php if( is_sticky() ) { ?>
							<div class="ribbon-wrap"><div class="ribbon"><i class="fa fa-thumb-tack"></i></div></div>
						<?php } ?>

						<!-- Get post format -->
						<?php
					  		$format = get_post_format();

							if( 'image' == $format || 'quote' == $format ) {
								get_template_part( 'post-formats/format', get_post_format() );
							} else {
								get_template_part( 'post-formats/format', 'standard' );
							};
						?>

						<div class="content-section">
							<div id="content-wrap">
								<div class="single-tab">
									<div id="single-tabs">
										<ul class="single-tab-nav">
											<?php if ( comments_open() || '0' != get_comments_number() ) { ?>
												<li><a href="#tab-1"><i class="fa fa-comment"></i> <span><?php _e( 'Comments', 'publisher' ); ?></span></a></li>
											<?php } ?>
											<li><a href="#tab-2"><i class="fa fa-user"></i> <span><?php _e( 'Author', 'publisher' ); ?></span></a></li>
											<li><a href="#tab-3"><i class="fa fa-list-ul"></i> <span><?php _e( 'Details', 'publisher' ); ?></span></a></li>
										</ul>

										<!-- If comments are open or we have at least one comment, load up the comment template. -->
										<?php if ( comments_open() || '0' != get_comments_number() ) { ?>
											<div id="tab-1" class="comments-section post-tab clearfix">
												<?php comments_template(); ?>
											</div><!-- comment section -->
										<?php } ?>

										<div id="tab-2" class="author-section post-tab clearfix">
											<div id="author-info">
												<!-- If author has a bio, show it. -->
												<?php
													$curauth = get_userdata( $post->post_author ); //get data for current post author
													if ( empty( $curauth->description ) ) { } else {
												?>
													<div class="author-profile">
														<div id="author-avatar">
															<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'publisher_author_bio_avatar_size', 100 ) ); ?>
														</div>

														<div id="author-description">
															<h2><?php printf( __( 'About %s', 'publisher' ), get_the_author() ); ?></h2>
															<?php the_author_meta( 'description' ); ?>
														</div>
														<div class="clear"></div>
													</div>
												<?php } ?>

												<div class="author-posts">
													<h3><?php printf( __( 'Latest Posts By %s', 'publisher' ), get_the_author() ); ?></h3>
													<?php echo publisher_author_posts(); ?>
												</div><!-- author-posts -->
											</div><!-- author-info -->
										</div><!-- author-section -->

										<div id="tab-3" class="post-detail-section post-tab clearfix">
											<?php publisher_content_nav( 'nav-below' ); ?>
											<div class="post-detail-col">
												<div class="post-detail-cat">
													<h3><?php _e( 'Category', 'publisher' ); ?></h3>
													<?php the_category( ', ' ); ?>
												</div>

												<?php $publisher_tags = get_the_tags(); if ( $publisher_tags ) { ?>
													<div class="post-detail-cat">
														<h3><?php _e( 'Tags', 'publisher' ); ?></h3>
														<?php the_tags( '', ', ', '' ); ?>
													</div>
												<?php } ?>
											</div><!-- post-detail-col -->
										</div><!-- detail-section-->
									</div><!-- #single-tabs -->
								</div><!-- .single-tab -->
							</div><!-- #content-wrap -->
						</div><!-- .content-section -->
					<?php endwhile; // end of the loop. ?>

				</div><!-- #content .site-content -->
			</div><!-- #primary .content-area -->

			<?php get_sidebar(); ?>

		</div><!-- #main .site-main -->


<?php get_footer(); ?>