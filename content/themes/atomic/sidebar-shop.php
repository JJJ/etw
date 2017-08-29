<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Atomic
 */

// Get the sidebar widgets
if ( is_active_sidebar( 'sidebar-shop' ) ) { ?>
	<div id="secondary" class="widget-area shop-sidebar">
		<?php do_action( 'atomic_above_shop_sidebar' );

		dynamic_sidebar( 'sidebar-shop' );

		do_action( 'atomic_below_shop_sidebar' ); ?>
	</div><!-- #secondary .widget-area -->
<?php } ?>