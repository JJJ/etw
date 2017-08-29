<?php
/**
 * Template for displaying the footer.
 *
 * @package Author
 * @since Author 1.0
 */
?>

			<div id="footer" class="clearfix">
				<div class="footer-inside">
					<div class="footer-copy">
						<div class="menu-footer-wrapper">
							<?php wp_nav_menu( array( 'menu_id' => 'menu-footer', 'theme_location' => 'footer', 'menu_class' => 'footernav', 'fallback_cb' => false, ) ); ?>
						</div>

						<p class="copyright">&copy; <?php echo date("Y"); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a> | <?php bloginfo( 'description' ); ?></p>
					</div>

					<div class="social-icons">
						<?php dynamic_sidebar( 'footer-icons' ); ?>
					</div>
				</div><!-- footer-inside -->
			</div><!--footer-->
		</div><!-- main -->
	</div><!-- wrapper -->

	<?php wp_footer(); ?>

</body>
</html>
