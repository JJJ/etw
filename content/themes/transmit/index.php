<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Transmit
 * @since Transmit 1.0
 */

get_header(); ?>

		<div class="section">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class('box'); ?>>
					<h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

					<?php if ( has_post_thumbnail() ) { ?>
						<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'transmit' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'large-image' ); ?></a>
					<?php } ?>

					<div class="post-meta">
						<div class="post-date">
							<?php echo get_the_date(); ?><span class="date-sep"> / </span><?php the_author_posts_link(); ?><span class="date-sep"> / </span> <a href="<?php the_permalink(); ?>#comments" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s comments', 'transmit' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php comments_number(__('No Comments','transmit'),__('1 Comment','transmit'),__( '% Comments','transmit') );?></a>
						</div>
					</div>

					<?php the_content( __( 'Read More', 'transmit' ) ); ?>
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