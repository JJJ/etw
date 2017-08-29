<?php
/**
 * 
 * A page template for displaying single post content.
 *
 * @package Transmit
 * @since Transmit 1.0
 */

get_header(); ?>

		<div class="section">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class('box'); ?>>
					<h2 class="post-title"><?php the_title(); ?></h2>

					<?php if ( has_post_thumbnail() ) { ?>
						<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'transmit' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'post-image' ); ?></a>
					<?php } ?>

					<div class="post-meta">
						<div class="post-date">
							<?php echo get_the_date(); ?><span class="date-sep"> / </span><?php the_author_posts_link(); ?><span class="date-sep"> / </span> <a href="<?php the_permalink(); ?>#comments" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s comments', 'transmit' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php comments_number(__('No Comments','transmit'),__('1 Comment','transmit'),__( '% Comments','transmit') );?></a>
						</div>
					</div><!-- post-meta -->
					
					<?php the_content(); ?>

					<ul class="categories">
						<li><span><?php _e('Category: ','transmit'); ?></span> <?php the_category(', '); ?></li>
						
						<?php $posttags = get_the_tags(); if ( $posttags ) { ?>									
							<li><span><?php _e('Tag: ','transmit'); ?></span> <?php the_tags('', ', ', ''); ?></li>
						<?php } ?>
					</ul>
				</div>
			<?php endwhile; ?>
			<?php endif; ?>

			<div class="post-nav post-nav-center">
				<div class="post-nav-inside">
					<div class="prev-post"><?php previous_post_link( '%link', __( 'Previous Post', 'transmit' ) ); ?></div>
					<div class="next-post"><?php next_post_link( '%link', __( 'Next Post', 'transmit' ) ); ?></div>
				</div>
			</div><!-- single-post-nav -->
		</div><!-- section -->

		<!-- If comments are open or we have at least one comment, load up the comment template. -->
		<?php if ( comments_open() || '0' != get_comments_number() ) { ?>
			<div class="comments-section clearfix">
				<?php comments_template(); ?>
			</div><!-- comment section -->
		<?php } ?>
		
	</div><!-- page -->
</div><!-- main -->

<?php get_footer(); ?>