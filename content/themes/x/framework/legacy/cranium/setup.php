<?php

// =============================================================================
// LEGACY/SETUP.PHP
// -----------------------------------------------------------------------------
// Sets up the legacy theme views, features, options, et cetera.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Require Files
//   02. Enqueue Styles
//   03. Enqueue Scripts
// =============================================================================

// Require Files
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

  wp_enqueue_style( 'x-cranium-migration', X_TEMPLATE_URL . '/framework/legacy/cranium/css/dist/site/' . $stack . $ext . '.css', NULL, X_ASSET_REV, 'all' );

}

add_action( 'x_enqueue_styles', 'x_legacy_cranium_enqueue_styles' );



// Enqueue Scripts
// =============================================================================

function x_legacy_cranium_enqueue_scripts() {

  $ext = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.js' : '.min.js';

  wp_enqueue_script( 'x-cranium-migration-head', X_TEMPLATE_URL . "/framework/legacy/cranium/js/dist/site/x-head$ext", array( 'jquery', 'hoverIntent' ), X_ASSET_REV, false );
  wp_enqueue_script( 'x-cranium-migration-body', X_TEMPLATE_URL . "/framework/legacy/cranium/js/dist/site/x-body$ext", array( 'jquery' ), X_ASSET_REV, true );

}

add_action( 'wp_enqueue_scripts', 'x_legacy_cranium_enqueue_scripts', 99999 );
