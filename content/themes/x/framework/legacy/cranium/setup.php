<?php

// =============================================================================
// LEGACY/SETUP.PHP
// -----------------------------------------------------------------------------
// Sets up the legacy theme views, features, options, et cetera.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Enqueue Styles
//   02. Enqueue Scripts
// =============================================================================

// Enqueue Styles
// =============================================================================

function x_legacy_cranium_enqueue_styles() {

  $stack  = x_get_stack();
  $design = x_get_option( 'x_integrity_design' );

  if ( $stack == 'integrity' && $design == 'light' ) {
    $ext = '-light';
  } elseif ( $stack == 'integrity' && $design == 'dark' ) {
    $ext = '-dark';
  } else {
    $ext = '';
  }

  wp_enqueue_style( 'x-cranium-migration', X_TEMPLATE_URL . '/framework/legacy/cranium/dist/css/site/' . $stack . $ext . '.css', NULL, X_ASSET_REV, 'all' );

}

add_action( 'x_enqueue_styles', 'x_legacy_cranium_enqueue_styles' );
