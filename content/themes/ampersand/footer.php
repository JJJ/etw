<?php
/**
 * The template for displaying the footer.
 *
 * @package Ampersand
 * @since Ampersand 1.0
 */
?>

		</div><!-- #main .site-main -->
	</div><!-- fade in-->

	<footer id="colophon" class="site-footer clearfix">
		<div class="site-footer-inside">
			<div class="footer-widgets">
				<div class="footer-widget">
					<?php do_action( 'before_sidebar_left' ); ?>
					<?php if ( ! dynamic_sidebar( 'footer-left' ) ) : ?>
						<aside class="widget">
							<?php the_widget( 'WP_Widget_Recent_Posts', 'number=4' ); ?>
						</aside>
					<?php endif; // end left footer widget area ?>
				</div>

				<div class="footer-widget">
					<?php do_action( 'before_sidebar_center' ); ?>
					<?php if ( ! dynamic_sidebar( 'footer-center' ) ) : ?>
						<aside class="widget">
							<?php the_widget( 'WP_Widget_Archives', 'number=4' ); ?>
						</aside>
					<?php endif; // end center footer widget area ?>
				</div>

				<div class="footer-widget">
					<?php do_action( 'before_sidebar_right' ); ?>
					<?php if ( ! dynamic_sidebar( 'footer-right' ) ) : ?>
						<aside class="widget">
							<?php the_widget( 'WP_Widget_Recent_Comments', 'number=2' ); ?>
						</aside>

						<aside class="widget">
							<?php the_widget( 'WP_Widget_Search' ); ?>
						</aside>
					<?php endif; // end right footer widget area ?>
				</div>
			</div><!-- .footer-widgets -->

			<div class="footer-copy clearfix">
				<!-- Grab footer icons template -->
				<?php get_template_part( 'template-icons' ); ?>

				<!-- Footer Text -->
				<div class="copyright">
					<div class="site-info">
						<?php
						$footer_text = '&copy; ' . date("Y") . ' <a href="' . esc_url( home_url() ) . '">' . get_bloginfo( 'name' ) . '</a>';
						$footer_text .= '<span class="sep"> | </span>';
						$footer_text .= get_bloginfo( "description" ); ?>

						<?php echo apply_filters( 'ampersand_footer_text', $footer_text ); ?>

					</div><!-- .site-info -->
				</div><!-- .copyright -->
			</div><!-- .footer-copy -->
		</div><!-- .site-footer-inside -->
	</footer><!-- #colophon .site-footer -->

<?php wp_footer(); ?>

</body>
</html>