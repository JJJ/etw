<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Baseline
 */

// Get the sidebar widgets
if ( is_active_sidebar( 'sidebar' ) || has_nav_menu( 'social' ) ) : ?>
	<div id="secondary" class="widget-area">
		<?php
		// Get the social icon menu
		if ( has_nav_menu( 'social' ) ) { ?>
			<aside class="widget social-widget">
				<nav class="social-navigation" role="navigation">
					<?php wp_nav_menu( array(
						'theme_location' => 'social',
						'depth'          => 1,
						'fallback_cb'    => false
					) );?>
				</nav><!-- .footer-navigation -->
			</aside>
		<?php } ?>

		<?php dynamic_sidebar( 'sidebar' ); ?>
	</div>
<?php endif; ?>
