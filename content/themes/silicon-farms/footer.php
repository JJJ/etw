	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">

		<?php
			/*
			 * A sidebar in the footer? Yep. You can can customize
			 * your footer with three columns of widgets.
			 */
			if ( ! is_404() ) {
				get_sidebar( 'footer' );
			}
		?>

		<div id="site-generator">
			<a href="http://easttroyweb.com/" title="<?php esc_attr_e( 'Free web hosting for qualifying East Troy busineses' ); ?>"><?php printf( __( 'Hosted by %s', 'twentyeleven' ), 'East Troy Web' ); ?></a>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>