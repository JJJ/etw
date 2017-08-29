<?php
/**
 * Template for displaying archived posts.
 *
 * @package Transmit
 * @since Transmit 1.0
 */

get_header(); ?>

		<div class="section">
			<h1 class="archive-title">
				<?php
					if ( is_category() ) :
						printf( __( 'Category: ', 'transmit' ) ); single_cat_title();

					elseif ( is_tag() ) :
						printf( __( 'Tag: ', 'transmit' ) ); single_tag_title();

					elseif ( is_author() ) :
						/* Queue the first post, that way we know
						 * what author we're dealing with (if that is the case).
						*/
						the_post();
						printf( __( 'Author: %s', 'transmit' ), '' . get_the_author() . '' );
						/* Since we called the_post() above, we need to
						 * rewind the loop back to the beginning that way
						 * we can run the loop properly, in full.
						 */
						rewind_posts();

					elseif ( is_day() ) :
						printf( __( 'Day: %s', 'transmit' ), '<span>' . get_the_date() . '</span>' );

					elseif ( is_month() ) :
						printf( __( 'Month: %s', 'transmit' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

					elseif ( is_year() ) :
						printf( __( 'Year: %s', 'transmit' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

					elseif ( is_404() ) :
						_e( '404 - Page Not Found', 'transmit' );

					elseif ( is_search() ) :
						printf( __( 'Search Results for: %s', 'transmit' ), '<span>' . get_search_query() . '</span>' );

					else :
						single_post_title();

					endif;
				?>
			</h1>
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class('box'); ?>>
					<h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

					<?php if ( has_post_thumbnail() ) { ?>
						<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'transmit' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'post-image' ); ?></a>
					<?php } ?>

					<div class="post-meta">
						<div class="post-date">
							<?php echo get_the_date(); ?><span class="date-sep"> / </span><?php the_author_posts_link(); ?><span class="date-sep"> / </span> <a href="<?php the_permalink(); ?>#comments" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s comments', 'transmit' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php comments_number(__('No Comments','transmit'),__('1 Comment','transmit'),__( '% Comments','transmit') );?></a>
						</div>
					</div>

					<?php the_content(__( 'Read More','transmit')); ?>
				</div>
			<?php endwhile; ?>
			<?php endif; ?>

			<!-- post navigation -->
			<?php if ( transmit_page_has_nav() ) : ?>
				<div class="post-nav">
					<div class="post-nav-inside">
						<div class="prev-post"><?php previous_posts_link( __( 'Newer Posts', 'transmit' ) ) ?></div>
						<div class="next-post"><?php next_posts_link( __( 'Older Posts', 'transmit' ) ) ?></div>
					</div>
				</div>
			<?php endif; ?>
		</div><!-- section -->
	</div><!-- page -->
</div><!-- main -->

<?php get_footer(); ?>