<?php

// =============================================================================
// FUNCTIONS/GLOBAL/ADMIN/THUMBNAILS/SETUP.PHP
// -----------------------------------------------------------------------------
// Sets up entry thumbnail sizes based on Theme Options.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Add Thumbnail Sizes
//   02. Standard Entry Thumbnail Width
//   03. Fullwidth Entry Thumbnail Width
//   04. Cropped Entry Thumbnail Height
//   05. Fullwidth Cropped Entry Thumbnail Height
// =============================================================================

// Add Thumbnail Sizes
// =============================================================================

function x_setup_thumbnails() {

  add_theme_support( 'post-thumbnails' );
  set_post_thumbnail_size( 100, 9999 );
  add_image_size( 'entry',                   x_post_thumbnail_width(),      9999,                                   false );
  add_image_size( 'entry-cropped',           x_post_thumbnail_width(),      x_post_thumbnail_cropped_height(),      true  );
  add_image_size( 'entry-fullwidth',         x_post_thumbnail_width_full(), 9999,                                   false );
  add_image_size( 'entry-cropped-fullwidth', x_post_thumbnail_width_full(), x_post_thumbnail_cropped_height_full(), true  );

}

add_action( 'after_setup_theme', 'x_setup_thumbnails' );



// Standard Entry Thumbnail Width
// =============================================================================

if ( ! function_exists( 'x_post_thumbnail_width' ) ) :
  function x_post_thumbnail_width() {

    // Get Stack
    // ---------

    $stack = x_get_stack();


    // Adjustments
    // -----------
    // 01. Subtract half of the span margin setup by the grid.
    // 02. Subtract due to padding and border around featured image.

    switch ( $stack ) {
      case 'integrity' :
        $m = 2.463055; // 01
        $p = 0;        // 02
        break;
      case 'renew' :
        $m = 3.20197;
        $p = 16;
        break;
      case 'icon' :
        $m = 0;
        $p = 16;
        break;
      case 'ethos' :
        $m = 0;
        $p = 0;
        break;
    }


    // Get Settings
    // ------------

    $a = x_get_option( 'x_layout_site' );
    $b = x_get_option( 'x_layout_content' );
    $c = (float) x_get_option( 'x_layout_site_width' );
    $d = (float) x_get_option( 'x_layout_site_max_width' );
    $e = (float) x_get_option( 'x_layout_content_width' );
    $f = (float) x_get_option( 'x_layout_sidebar_width' );


    // Adjust Settings
    // ---------------

    $site_layout    = ( empty( $a ) ) ? 'full-width'      : $a;
    $content_layout = ( empty( $b ) ) ? 'content-sidebar' : $b;
    $site_width     = ( empty( $c ) ) ? 88 / 100          : $c / 100;
    $site_max_width = ( empty( $d ) ) ? 1200              : $d;
    $content_width  = ( empty( $e ) ) ? 72 - $m           : $e - $m;


    // Calculations
    // ------------

    if ( $content_layout == 'full-width' ) {
      if ( $site_layout == 'full-width' ) {
        $output = $site_max_width - $p;
      } elseif ( $site_layout == 'boxed' ) {
        $output = $site_max_width * $site_width - $p;
      }
    } else {
      if ( $site_layout == 'full-width' ) {
        if ( $stack == 'icon' ) {
          $output = round( $site_max_width - $p );
        } else {
          $output = round( $site_max_width * ( $content_width / 100 ) - $p );
        }
      } elseif ( $site_layout == 'boxed' ) {
        if ( $stack == 'icon' ) {
          $output = round( $site_max_width * $site_width - $p );
        } else {
          $output = round( $site_max_width * ( $content_width / 100 ) * $site_width - $p );
        }
      }
    }


    // Calculations (if Site Max Width < 979px)
    // ----------------------------------------

    if ( $site_layout == 'full-width' ) {
      if ( $site_max_width < 979 * $site_width ) {
        $output = $site_max_width - $p;
      } else {
        if ( $output < ( 979 * $site_width ) ) {
          $output = round( 979 * $site_width - $p );
        }
      }
    } elseif ( $site_layout == 'boxed' ) {
      if ( $site_max_width * $site_width < 979 * $site_width * $site_width ) {
        $output = $site_max_width * $site_width - $p;
      } else {
        if ( $output < ( 979 * $site_width * $site_width ) ) {
          $output = round( 979 * $site_width * $site_width - $p );
        }
      }
    }

    return intval( $output );

  }
endif;



// Fullwidth Entry Thumbnail Width
// =============================================================================

if ( ! function_exists( 'x_post_thumbnail_width_full' ) ) :
  function x_post_thumbnail_width_full() {

    // Get Stack
    // ---------

    $stack = x_get_stack();


    // Adjustments
    // -----------
    // 01. Subtract due to padding and border around featured image.

    switch ( $stack ) {
      case 'integrity' :
        $p = 0; // 01
        break;
      case 'renew' :
        $p = 16;
        break;
      case 'icon' :
        $p = 16;
        break;
      case 'ethos' :
        $p = 0;
        break;
    }


    // Get Settings
    // ------------

    $a = x_get_option( 'x_layout_site' );
    $b = (float) x_get_option( 'x_layout_site_width' );
    $c = (float) x_get_option( 'x_layout_site_max_width' );


    // Adjust Settings
    // ---------------

    $site_layout    = ( empty( $a ) ) ? 'full-width' : $a;
    $site_width     = ( empty( $b ) ) ? 88 / 100     : $b / 100;
    $site_max_width = ( empty( $c ) ) ? 1200         : $c;


    // Calculations
    // ------------

    if ( $site_layout == 'full-width' ) {
      $output = $site_max_width - $p;
    } elseif ( $site_layout == 'boxed' ) {
      $output = $site_max_width * $site_width - $p;
    }

    return intval( $output );

  }
  add_action( 'cs_theme_options_after_save', 'x_post_thumbnail_width_full' );
endif;



// Cropped Entry Thumbnail Height
// =============================================================================

if ( ! function_exists( 'x_post_thumbnail_cropped_height' ) ) :
  function x_post_thumbnail_cropped_height() {

    $stack = x_get_stack();

    switch ( $stack ) {
      case 'integrity' :
        $output = round( x_post_thumbnail_width() * 0.558823529 );
        break;
      case 'renew' :
        $output = round( x_post_thumbnail_width() * 0.558823529 );
        break;
      case 'icon' :
        $output = round( x_post_thumbnail_width() * 0.558823529 );
        break;
      case 'ethos' :
        $output = round( x_post_thumbnail_width() * 0.558823529 );
        break;
    }

    return intval( $output );

  }
endif;



// Fullwidth Cropped Entry Thumbnail Height
// =============================================================================

if ( ! function_exists( 'x_post_thumbnail_cropped_height_full' ) ) :
  function x_post_thumbnail_cropped_height_full() {

    $stack = x_get_stack();

    switch ( $stack ) {
      case 'integrity' :
        $output = round( x_post_thumbnail_width_full() * 0.558823529 );
        break;
      case 'renew' :
        $output = round( x_post_thumbnail_width_full() * 0.558823529 );
        break;
      case 'icon' :
        $output = round( x_post_thumbnail_width_full() * 0.558823529 );
        break;
      case 'ethos' :
        $output = round( x_post_thumbnail_width_full() * 0.558823529 );
        break;
    }

    return intval( $output );

  }
endif;
