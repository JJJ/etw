<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Camera
 */
?>

	</div><!-- #content -->
</div><!-- #page -->

<footer class="site-footer">
	<div class="container">
		<nav class="footer-navigation" role="navigation">
			<?php wp_nav_menu( array(
				'theme_location' => 'footer',
				'depth'          => 1,
			) );?>
		</nav><!-- #site-navigation -->

		<div class="site-info">
			<a class="powered-by" href="<?php echo esc_url( __( 'http://wordpress.org/', 'camera' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'camera' ), 'WordPress' ); ?></a> <span class="sep">&mdash;</span> <?php printf( __( 'Theme: %1$s by <a href="https://array.is/">%2$s</a>', 'camera' ), 'Camera', 'Array' ); ?>
		</div><!-- .site-info -->
	</div><!-- .container -->
</footer><!-- .footer -->

<?php wp_footer(); ?>

</body>
</html>
