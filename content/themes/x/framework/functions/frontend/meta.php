<?php

// =============================================================================
// FUNCTIONS/GLOBAL/META.PHP
// -----------------------------------------------------------------------------
// Additions and alterations to site headers and <head> meta data.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Add Headers
//   02. Filter <title> Output
//   03. Generic <head> Meta Data
// =============================================================================

// Add Headers
// =============================================================================

if ( ! function_exists( 'x_add_headers' ) ) :
  function x_add_headers( $headers ) {

    if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false ) {
      $headers['X-UA-Compatible'] = 'IE=edge';
    }

    return $headers;

  }
  add_filter( 'wp_headers', 'x_add_headers' );
endif;



// Filter <title> Output
// =============================================================================

if ( ! function_exists( 'x_wp_title' ) ) :
  function x_wp_title( $title ) {

    if ( is_front_page() ) {
      return get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' );
    } elseif ( is_feed() ) {
      return ' | RSS Feed';
    } else {
      return trim( $title ) . ' | ' . get_bloginfo( 'name' ); 
    }

  }
  add_filter( 'wp_title', 'x_wp_title' );
endif;



// Generic <head> Meta Data
// =============================================================================

if ( ! function_exists( 'x_head_meta' ) ) :
  function x_head_meta() {

    x_get_view( 'global', '_meta' );

  }
  add_action( 'wp_head', 'x_head_meta', 0 );
endif;