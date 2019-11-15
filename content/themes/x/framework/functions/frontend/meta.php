<?php

// =============================================================================
// FUNCTIONS/GLOBAL/META.PHP
// -----------------------------------------------------------------------------
// Additions and alterations to site headers and <head> meta data.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Filter <title> Output
//   02. Generic <head> Meta Data
// =============================================================================

// Filter <title> Output
// =============================================================================


if ( ! function_exists( 'x_title_separator' ) ) :
  function x_title_separator( $sep ) {

    $sep = "|";

    return $sep;

  }

  add_filter( 'document_title_separator', 'x_title_separator' );
endif;



// Generic <head> Meta Data
// =============================================================================

if ( ! function_exists( 'x_head_meta' ) ) :
  function x_head_meta() {

    x_get_view( 'global', '_meta' );

  }
  add_action( 'wp_head', 'x_head_meta', 0 );
endif;
