<?php
/**
 * The template for displaying single posts
 *
 * @since 1.0
 */
get_header(); ?>

		<header class="page-titles">
			<div class="container clearfix">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<!-- Post title -->
					<h1 class="entry-title"><?php the_title(); ?></h1>

					<!-- Subtitle -->
					<?php if ( get_post_meta( $post->ID, 'subtitle', true ) ) { ?>
						<h3 class="entry-subtitle"><?php echo get_post_meta( $post->ID, 'subtitle', true ) ?></h3>
					<?php } ?>

					<!-- Post meta -->
					<h3 class="entry-subtitle">
						<span class="blog-entry-date">
							<span>
								<em><?php _e( 'by', 'north' ); ?></em> <?php the_author_posts_link(); ?>
							</span>
							<span>
								<em><?php _e( 'on', 'north' ); ?></em> <?php echo get_the_date(); ?>
							</span>
							<span>
								<em><?php _e( 'with', 'north' ); ?></em> <?php comments_popup_link( __( 'No Comments', 'north' ), __( '1 Comment', 'north' ), __( '% Comments', 'north' ) ); ?></a>
							</span>
						</span>
					</h3>
				<?php endwhile; ?>
				<?php endif; ?>
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
										<!-- Grab featured image, gallery, or video embed -->
										<?php get_template_part( 'template-gallery' ); ?>

										<?php the_content( __( 'Read More','north' ) ); ?>

										<div class="pagelink">
											<?php wp_link_pages(); ?>
										</div>

										<!-- Grab meta template -->
										<?php get_template_part( 'template-meta' ); ?>
									</div><!-- post content -->
								</div><!-- box -->
							</div><!-- box wrap -->
						</article><!-- post-->

						<?php endwhile; ?>
						<?php endif; ?>
					</div><!-- posts -->

					<!-- post navigation -->
					<?php if( is_single() ) { ?>
						<div class="post-navigation-wrap">
							<ul class="post-navigation clearfix">
								<li class="prev-nav"><?php previous_post_link('%link', '%title'); ?></li>
								<li class="next-nav"><?php next_post_link('%link', '%title'); ?></li>
							</ul>
						</div>
					<?php } ?>

					<!-- comments -->
					<?php if ( 'open' == $post->comment_status ) { ?>
						<div id="comment-jump" class="comments">
							<?php comments_template(); ?>
						</div>
					<?php } ?>
				</div><!-- content -->

				<!-- Sidebar -->
				<?php get_sidebar(); ?>
			</div><!-- container -->
		</section><!-- main -->

		<!-- footer -->
		<?php get_footer(); ?>