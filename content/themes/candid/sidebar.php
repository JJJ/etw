<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Candid
 */

// Get the sidebar widgets
if ( is_active_sidebar( 'sidebar' ) ) : ?>
	<div id="secondary" class="widget-area">
		<?php dynamic_sidebar( 'sidebar' ); ?>
	</div>
<?php endif; ?>