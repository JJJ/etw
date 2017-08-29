<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Baseline
 */
?>

	</div><!-- #content -->
</div><!-- #page -->

<?php if ( has_nav_menu( 'category-footer' ) ) { ?>
	<div class="category-drawer footer-drawer">
		<button class="sort-list-toggle"><?php esc_html_e( 'Categories', 'baseline' ); ?> <i class="fa fa-caret-down"></i></button>
		<?php wp_nav_menu( array(
			'theme_location' => 'category-footer',
			'menu_id'        => 'footer-category-menu',
			'menu_class'     => 'sort-list',
			'depth'          => 1,
		) );?>

		<div class="featured-posts-wrap clear">
			<div class="featured-posts clear">
				<div class="post-container clear"></div>
			</div>
		</div><!-- .featured-posts -->
	</div><!-- .category-drawer -->
<?php } ?>

<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="container">
		<div class="footer-bottom">
			<?php if ( has_nav_menu( 'footer' ) ) { ?>
				<nav class="footer-navigation" role="navigation">
					<?php wp_nav_menu( array(
						'theme_location' => 'footer',
						'depth'          => 1,
					) );?>
				</nav><!-- #site-navigation -->
			<?php } ?>


			<div class="site-info">
				<?php echo baseline_filter_footer_text(); ?>
			</div>
		</div>
	</div><!-- .container -->
</footer><!-- #colophon -->

<?php wp_footer(); ?>
</body>
</html>
