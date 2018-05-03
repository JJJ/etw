<?php

// =============================================================================
// FRAMEWORK/LEGACY/MODE_TOOTSIES/SETUP.PHP
// -----------------------------------------------------------------------------
// Setup all footer migration fallbacks.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Require Files
//   02. Generated CSS
//   03. Reroute Templates
// =============================================================================

// Require Files
// =============================================================================



// Generated CSS
// =============================================================================

function x_legacy_cranium_footers_get_generated_css() {

  $outp_path = X_TEMPLATE_PATH . '/framework/legacy/cranium/footers/output';

  include( $outp_path . '/variables.php' );
  $stack_css_file = $outp_path . '/' . $x_stack . '.php';

  ob_start();

  if ( file_exists( $stack_css_file ) ) {
    include( $stack_css_file );
  }

  $css = ob_get_clean();

  if ( function_exists('cornerstone_post_process_css' ) ) {
    $css = cornerstone_post_process_css( $css );
  }

  return x_get_clean_css( $css );

}


function x_legacy_cranium_footers_generated_css() {

  echo x_legacy_cranium_footers_get_generated_css();

}

add_action( 'x_head_css', 'x_legacy_cranium_footers_generated_css' );



// Reroute Templates
// =============================================================================

function x_legacy_cranium_footers_reroute_templates( $view, $directory, $file_base, $file_extension ) {

  // Child Themes
  // ------------
  // Check to see if overwriting view in child theme

  if ( is_child_theme() ) {

    $view_base      = $view['base'];
    $view_extension = $view['extension'];
    $template       = ( '' == $view_extension ) ? "{$view_base}.php" : "{$view_base}-{$view_extension}.php";

    if ( file_exists( STYLESHEETPATH . '/' . $template ) ) {
      return $view;
    }

  }


  // Whitelist Templates
  // -------------------
  // Introduced to accomodate new structure using legacy views.
  //
  // 01. Use /framework/legacy/cranium/footers/views/header/base.php
  // 02. Ignore calls entirely

  static $migration_templates = array(
    'footer' => array(
      'base'     => array( '' ), // 01
      'colophon' => false        // 02
    )
  );


  // Blacklist Templates
  // -------------------
  // Preservation of old templates.
  //
  // 01. Empty strings are explicitly baseless

  static $legacy_templates = array(
    'integrity' => array(
      'wp' => array( 'footer' )
    ),
    'renew' => array(
      'wp' => array( 'footer' )
    ),
    'icon' => array(
      'wp' => array( 'footer' )
    ),
    'ethos' => array(
      'wp' => array( 'footer' )
    ),
    'global' => array(
      '_footer' => array( '', 'widget-areas' ), // 01
      '_nav'    => array( 'footer' )
    ),
  );


  // Whitelist Replacements
  // ----------------------
  // 01. Reroute named templates

  if ( isset( $migration_templates[$directory] )
  && ( isset( $migration_templates[$directory][$file_base] ) ) ) {
    if ( false === $migration_templates[$directory][$file_base]  ) {
      $view['base'] = '';
    } elseif ( in_array( $file_extension, $migration_templates[$directory][$file_base] ) ) {
      $view['base'] = 'framework/legacy/cranium/footers/views/' . $directory . '/' . $file_base; // 01
    }
    return $view;
  }


  // Blacklist Replacements
  // ----------------------

  if ( isset( $legacy_templates[$directory] )
  && ( isset( $legacy_templates[$directory][$file_base] ) )
  && in_array( $file_extension, $legacy_templates[$directory][$file_base] ) ) {
    $view['base'] = 'framework/legacy/cranium/footers/views/' . $directory . '/' . $file_base;
  }

  return $view;

}

add_filter( 'x_get_view', 'x_legacy_cranium_footers_reroute_templates', 10, 4 );
