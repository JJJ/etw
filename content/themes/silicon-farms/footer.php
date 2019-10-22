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
			A <a href="http://publicious.org">Publicious</a> Site
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
