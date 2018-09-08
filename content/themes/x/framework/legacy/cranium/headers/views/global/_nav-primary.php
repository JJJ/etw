<?php

// =============================================================================
// VIEWS/GLOBAL/_NAV-PRIMARY.PHP
// -----------------------------------------------------------------------------
// Outputs the primary nav.
// =============================================================================

if( function_exists( 'ubermenu' ) && $config_id = ubermenu_get_menu_instance_by_theme_location( 'primary' ) ):
	ubermenu( $config_id, array( 'theme_location' => 'primary') );
 else: ?>

<a href="#" id="x-btn-navbar" class="x-btn-navbar collapsed" data-x-toggle="collapse-b" data-x-toggleable="x-nav-wrap-mobile" aria-selected="false" aria-expanded="false" aria-controls="x-widgetbar">
  <i class="x-icon-bars" data-x-icon-s="&#xf0c9;"></i>
  <span class="visually-hidden"><?php _e( 'Navigation', '__x__' ); ?></span>
</a>

<nav class="x-nav-wrap desktop" role="navigation">
  <?php x_output_primary_navigation(); ?>
</nav>

<div id="x-nav-wrap-mobile" class="x-nav-wrap mobile x-collapsed" data-x-toggleable="x-nav-wrap-mobile" data-x-toggle-collapse="1" aria-hidden="true" aria-labelledby="x-btn-navbar">
  <?php x_output_primary_navigation(); ?>
</div>

<?php endif; ?>
