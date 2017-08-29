<?php
/**
 * The search template file.
 *
 * @package Transmit
 * @since Transmit 1.0
 */

get_header(); ?>

		<div class="section">
			<h1 class="archive-title"><?php printf( __( 'Search Results for: %s', 'transmit' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class('box'); ?>>
					<h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

					<div class="post-meta">
						<div class="post-date">
							<?php echo get_the_date(); ?><span class="date-sep"> / </span><?php the_author_posts_link(); ?><span class="date-sep"> / </span> <a href="<?php the_permalink(); ?>#comments" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s comments', 'transmit' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php comments_number(__('No Comments','transmit'),__('1 Comment','transmit'),__( '% Comments','transmit') );?></a>
						</div>
					</div>

					<?php if ( has_post_thumbnail() ) { ?>
						<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'transmit' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'large-image' ); ?></a>
					<?php } ?>

					<?php the_excerpt(__( 'Read More','transmit')); ?>
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