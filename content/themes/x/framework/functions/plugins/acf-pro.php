<?php

// =============================================================================
// FUNCTIONS/GLOBAL/PLUGINS/ACF-PRO.PHP
// -----------------------------------------------------------------------------
// Plugin setup for theme compatibility.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Remove License Functionality
// =============================================================================

// Remove License Functionality
// =============================================================================

if ( ! function_exists( 'x_acf_pro_remove_license_functionality' ) ) :

  function x_acf_pro_remove_license_functionality() {

    if ( function_exists( 'acf_updates' ) ) {
      $update_class = acf_updates();
      // Note to reviewer: This remove_filter call disabled ACF Pro automatic updates because we provide those
      // updates directly so the buyer doesn't need to purchase the plugin to get automatic updates.
      remove_filter( 'pre_set_site_transient_update_plugins', array( $update_class, 'modify_plugins_transient' ), 10, 1 );
    }

    add_filter( 'acf/settings/show_updates', '__return_false' );

  }

  add_action( 'init', 'x_acf_pro_remove_license_functionality', 0 );

endif;


