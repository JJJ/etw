<?php
/**
 * Template for the post excerpt slider on the homepage.
 *
 * @package Author
 * @since Author 1.0
 */
?>

<!-- excerpt scroller -->
<?php if( is_home() && get_option( 'author_customizer_slider_disable' ) == 'enable' ) { ?>

	<div class="scroll">
		<div class="ribbon"></div>

		<div class="flexslider">
			<ul class="slides">
				<?php
					$featured_list_args  = array(
						'posts_per_page' => 5,
						'post__in'       => get_option( 'sticky_posts' )
					);
					$featured_list_posts = new WP_Query( $featured_list_args );
				?>

				<?php while( $featured_list_posts->have_posts() ) : $featured_list_posts->the_post() ?>
					<li>
						<div class="scroll-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</div>
						<div class="scroll-excerpt">
							<?php the_excerpt(); ?>
						</div>
						<div class="scroll-post">
							<div class="title-meta">
								<?php the_author_posts_link(); ?>
								<span class="sep"><?php _e( '/', 'author' ); ?></span>
								<a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a>
								<span class="sep"><?php _e( '/', 'author' ); ?></span>
								<?php comments_popup_link( __( 'Leave a comment', 'author' ), __( '1 Comment', 'author' ), __( '% Comments', 'author' ) ); ?>
							</div>
						</div>
					</li>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</ul><!-- slides -->
		</div><!-- flexslider -->
	</div><!-- scroll -->
<?php } ?>