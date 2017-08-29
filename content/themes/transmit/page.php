<?php
/**
 * 
 * A page template for displaying page content.
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

					<?php the_content(); ?>

					<?php wp_link_pages(); ?>
				</div>
			<?php endwhile; ?>
			<?php endif; ?>
		</div><!-- section -->
		
	</div><!-- page -->
</div><!-- main -->

<?php get_footer(); ?>