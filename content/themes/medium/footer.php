<?php
/**
 * Template for displaying the footer.
 *
 * @package Medium
 * @since 1.0
 */
?>
			</div><!-- main -->
		</div><!-- wrapper -->

		<footer>
			<div class="overthrow navigation-content">
				<div class="navigation-inner">
					<?php dynamic_sidebar( 'right-sidebar' ); ?>
					<div class="copyright">
						<div class="copyright-date">&copy; <?php echo date("Y"); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></div>
						<div class="copyright-desc"><?php bloginfo( 'description' ); ?></div>
					</div>
				</div>
			</div>
		</footer>

	</div><!-- body wrap -->

	<?php wp_footer(); ?>
</body>
</html>