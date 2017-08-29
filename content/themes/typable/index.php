<?php get_header(); ?>

		<div id="content">
            <div class="posts">

				<!-- titles -->
				<?php if( is_tag() ) { ?>
					<h2 class="archive-title"><i class="fa fa-tag"></i> <?php single_tag_title(); ?></h2>
				<?php } else if( is_day() ) { ?>
					<h2 class="archive-title"><i class="fa fa-clock-o"></i> <?php _e( 'Archive:', 'typable' ); ?> <?php echo get_the_date(); ?></h2>
				<?php } else if( is_month() ) { ?>
					<h2 class="archive-title"><i class="fa fa-clock-o"></i> <?php echo get_the_date('F Y'); ?></h2>
				<?php } else if( is_year() ) { ?>
					<h2 class="archive-title"><i class="fa fa-clock-o"></i> <?php echo get_the_date('Y'); ?></h2>
				<?php } else if( is_404() ) { ?>
					<h2 class="archive-title"><i class="fa fa-warning"></i> <?php _e( 'Page Not Found!', 'typable' ); ?></h2>
				<?php } else if( is_category() ) { ?>
					<h2 class="archive-title"><i class="fa fa-file-o"></i> <?php single_cat_title(); ?></h2>
				<?php } else if( is_author() ) { ?>
					<h2 class="archive-title"><i class="fa fa-file-o"></i> <?php printf( get_the_author() ); ?></h2>
				<?php } else if( is_search() ) { ?>
				<h2 class="archive-title"><i class="fa fa-search"></i> <?php printf( __( 'Search Results for: %s', 'typable' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
				<?php } ?>

				<!-- grab the posts -->
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<article <?php post_class( 'post' ); ?>>
					<div class="box-wrap">
						<div class="box">

							<header>
								<div class="date-title post-date updated"><?php echo get_the_date(); ?> <span class="date-space">&mdash;</span> <a class="lower-jump" href="<?php the_permalink(); ?>#lower-jump"><i class="fa fa-comment-o"></i> <?php comments_number( __( '0', 'typable' ), __( '1', 'typable' ), __( '%', 'typable' ) ); ?></a></div>
								<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
							</header>

							<!-- grab the featured image -->
							<?php if ( has_post_thumbnail() ) { ?>
								<a class="featured-image <?php if ( get_option( 'typable_customizer_enable_bw' ) == 'enabled' ) { echo 'featured-image-bw'; } ?>" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'featured-image' ); ?></a>
							<?php } ?>

							<!-- post content -->
							<div class="post-content">
								<!-- show excerpt on search, archive, homepage -->
								<?php if( is_search() || is_archive() || $post->post_excerpt ) { ?>
									<div class="excerpt-more">
										<?php the_excerpt(); ?>
										<a class="excerpt-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php _e( 'Read More', 'typable' ); ?></a>
									</div>
								<?php } else { ?>
									<!-- otherwise show all content -->
									<?php the_content( __( 'Read More' ) ); ?>
								<?php } ?>
							</div><!-- post content -->
						</div><!-- box -->
					</div><!-- box wrap -->
				</article><!-- post -->

				<?php endwhile; ?>
				<?php endif; ?>

			</div><!-- posts -->
		</div><!-- content -->

		<!-- post navigation -->
		<?php if( typable_page_has_nav() ) : ?>
			<div class="post-nav">
				<div class="post-nav-inside">
					<div class="post-nav-right"><?php previous_posts_link( __( 'Newer Posts', 'typable' ) ) ?></div>
					<div class="post-nav-left"><?php next_posts_link( __( 'Older Posts', 'typable' ) ) ?></div>
				</div>
			</div>
		<?php endif; ?>

		<!-- footer -->
		<?php get_footer(); ?>