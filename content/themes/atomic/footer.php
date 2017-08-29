<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Atomic
 */
?>

	</div><!-- #content -->
</div><!-- #page .container -->

<?php
	// Related Posts
	if ( class_exists( 'Jetpack_RelatedPosts' ) && is_singular( 'post' ) ) {
		echo '<div class="related-post-wrap">';
			echo '<div class="container">';
				echo do_shortcode( '[jetpack-related-posts]' );
			echo '</div>';
		echo '</div>';
	}
?>

<footer id="colophon" class="site-footer">
	<?php
		// Footer background image
		$footer_bg = get_theme_mod( 'atomic_footer_bg' );

		if ( $footer_bg ) { ?>
			<div class="cover-image-footer-wrap">
				<div class="cover-image-footer" style="background-image: url(<?php echo esc_url( $footer_bg ) ?>);"></div>
			</div>
	<?php } ?>

	<div class="container">

		<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
			<div class="footer-widgets">
				<?php if ( is_active_sidebar( 'footer-1' ) ) { ?>
					<div class="footer-column">
						<?php dynamic_sidebar( 'footer-1' ); ?>
					</div>
				<?php } ?>

				<?php if ( is_active_sidebar( 'footer-2' ) ) { ?>
					<div class="footer-column">
						<?php dynamic_sidebar( 'footer-2' ); ?>
					</div>
				<?php } ?>

				<?php if ( is_active_sidebar( 'footer-3' ) ) { ?>
					<div class="footer-column">
						<?php dynamic_sidebar( 'footer-3' ); ?>
					</div>
				<?php } ?>

				<?php if ( is_active_sidebar( 'footer-4' ) ) { ?>
					<div class="footer-column">
						<?php dynamic_sidebar( 'footer-4' ); ?>
					</div>
				<?php } ?>
			</div>
		<?php endif; ?>

		<div class="footer-bottom">
			<div class="footer-tagline">
				<div class="site-info">
					<?php echo atomic_filter_footer_text(); ?>
				</div>
			</div><!-- .footer-tagline -->
			
			<?php if ( has_nav_menu( 'social' ) ) { ?>
				<nav class="social-navigation">
					<?php wp_nav_menu( array(
						'theme_location' => 'social',
						'depth'          => 1,
						'fallback_cb'    => false
					) );?>
				</nav><!-- .social-navigation -->
			<?php } ?>
		</div><!-- .footer-bottom -->
	</div><!-- .container -->
</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
