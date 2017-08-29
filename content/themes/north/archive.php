<?php
/**
 * The template for display Archive pages.
 *
 * @package North
 * @since 3.2.2
 */

get_header(); ?>

		<header class="page-titles">
			<div class="container clearfix">
				<!-- titles -->
				<h2 class="entry-title">
				<?php
					if ( is_category() ) :
							single_cat_title( __( 'Category / ', 'north' ) );

						elseif ( is_tag() ) :
							single_tag_title( __( 'Tag / ', 'north' ) );

						elseif ( is_search() ):
							printf( __( 'Search Results for: %s', 'north' ), '' . get_search_query() . '' );

						elseif ( is_day() ) :
							printf( __( 'Day %s', 'north' ), ' / <span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :
							printf( __( 'Month %s', 'north' ), ' / <span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'north' ) ) . '</span>' );

						elseif ( is_year() ) :
							printf( __( 'Year %s', 'north' ), ' / <span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'north' ) ) . '</span>' );

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							_e( 'Asides', 'north' );

						elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
							_e( 'Galleries', 'north' );

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( 'Images', 'north' );

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( 'Videos', 'north' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							_e( 'Quotes', 'north' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							_e( 'Links', 'north' );

						elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
							_e( 'Statuses', 'north' );

						elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
							_e( 'Audios', 'north' );

						elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
							_e( 'Chats', 'north' );

						elseif( is_post_type_archive() ):
							printf( __( 'Category / %s', 'north' ) . post_type_archive_title() );

						else :
							_e( 'Archives', 'north' );

						endif;
					?>
				</h2>
			</div>
		</header>

		<section class="main">
			<div class="container clearfix">
				<div id="content">
					<div class="posts">

						<!-- Grab the posts -->
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

						<article <?php post_class('post'); ?>>
							<div class="box-wrap">
								<div class="box">
									<!-- post content -->
									<div class="post-content">
											<?php get_template_part( 'template-gallery' ); ?>

											<div class="blog-entry-title">
												<h2><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'north' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
												<div class="blog-entry-date">
													<span>
														<em><?php _e( 'By', 'north' ); ?></em> <?php the_author_posts_link(); ?>
													</span>
													<span>
														<em><?php _e( 'On', 'north' ); ?></em> <?php echo get_the_date(); ?>
													</span>
													<span>
														<em><?php _e( 'With', 'north' ); ?></em> <a href="<?php the_permalink(); ?>/#comment-jump" title=""><?php comments_number(__('No Comments','north'),__('1 Comment','north'),__( '% Comments','north') );?></a>
													</span>
												</div>
											</div>

										<?php the_excerpt(); ?>
									</div><!-- post content -->
								</div><!-- box -->
							</div><!-- box wrap -->
						</article><!-- post-->

						<?php endwhile; ?>
						<?php endif; ?>
					</div>

					<?php north_page_nav(); ?>

				</div><!-- content -->

				<?php get_sidebar(); ?>
			</div><!-- container -->
		</section><!-- main -->

		<!-- footer -->
		<?php get_footer(); ?>