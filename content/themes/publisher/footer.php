<?php
/**
 * The template for displaying the footer.
 *
 * @package Publisher
 * @since Publisher 1.0
 */
?>

	</div><!-- #main .site-main -->

	<footer id="colophon" class="site-footer clearfix">
		<!-- Blocks Post Navigation -->
		<?php if( publisher_page_has_nav() ) : ?>
			<div class="blocks-nav clearfix">
				<div class="blocks-nav-inside">
					<div class="blocks-nav-right"><?php previous_posts_link( __( 'Newer Posts', 'publisher' ) ); ?></div>
					<div class="blocks-nav-left"><?php next_posts_link( __( 'Older Posts', 'publisher' ) ); ?></div>
				</div>
			</div>
		<?php endif; ?>

		<!-- Footer Text -->
		<div class="copyright">
			<div class="site-info">
				<?php
				$footer_text = '&copy; ' . date("Y") . ' <a href="' . esc_url( home_url() ) . '">' . get_bloginfo( 'name' ) . '</a>';
				$footer_text .= '<span class="sep"> | </span>';
				$footer_text .= get_bloginfo( "description" ); ?>

				<?php echo apply_filters( 'publisher_footer_text', $footer_text ); ?>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

</body>
</html>