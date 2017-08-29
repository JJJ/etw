<?php
/**
 * Template for displaying the footer.
 *
 * @package North
 * @since 1.0
 */
?>
		</div><!-- inside wrap -->
	</div><!-- wrapper -->

	<?php if ( is_active_sidebar( 'footer' ) ) { ?>
		<footer id="footer">
			<div class="container">
				<div class="footer-widgets">
					<?php dynamic_sidebar( 'footer' ); ?>
				</div>
			</div>
		</footer><!--footer-->
	<?php } ?>

	<div class="footer-bottom">
		<div class="container clearfix">
			<div class="copyright">&copy; <?php echo date("Y"); ?> <a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a> &mdash; <?php bloginfo( 'description' ); ?></div>

			<div class="social-icons">
				<?php dynamic_sidebar( 'footer-social-icons' ); ?>
			</div>
		</div>
	</div>

	<?php wp_footer(); ?>
</body>
</html>