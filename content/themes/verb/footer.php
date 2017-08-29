<?php
/**
 *
 * Template for displaying the footer.
 *
 * @package Verb
 * @since Verb 1.0
 */
?>

			</div><!-- inside wrap -->
		</div><!-- wrapper -->

		<footer id="footer">
			<div id="footer-inside">
				<div class="copyright">&copy; <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo('name'); ?></a> &mdash; <?php bloginfo('description'); ?></div>
			</div>
		</footer><!--footer-->

	</div><!-- container -->
	<?php wp_footer(); ?>
</body>
</html>