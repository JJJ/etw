<?php
/**
 * This template adds the mobile menu drawer
 *
 * @package Meteor
 * @since Meteor 1.0
 */
?>

<div class="mobile-navigation">
	<button class="menu-toggle button-toggle">
		<span>
			<i class="fa fa-bars"></i>
			<?php esc_html_e( 'Menu', 'meteor' ); ?>
		</span>
		<span>
			<i class="fa fa-times"></i>
			<?php esc_html_e( 'Close', 'meteor' ); ?>
		</span>
	</button><!-- .overlay-toggle -->
</div>

<div class="drawer-wrap">
	<div class="drawer drawer-menu-explore">
		<?php if ( has_nav_menu( 'primary' ) ) { ?>
			<nav id="drawer-navigation" class="drawer-navigation">
				<?php wp_nav_menu( array(
					'theme_location' => 'primary'
				) );?>
			</nav><!-- #site-navigation -->
		<?php } ?>
	</div><!-- .drawer -->
</div>
