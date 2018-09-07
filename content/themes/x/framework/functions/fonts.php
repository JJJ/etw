<?php

// =============================================================================
// FUNCTIONS/GLOBAL/FONTS.PHP
// -----------------------------------------------------------------------------
// Legacy Font Handling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Queue Fonts
//   02. Register Subsets
//   03. Cache Busting
//   04. Font Data
//   05. Helpers
// =============================================================================

// Queue Fonts
// =============================================================================

function x_google_fonts_queue() {

  //
  // Raw data.
  //

  $assignments = array( 'body', 'headings', 'logo', 'navbar');
  $fonts = array();

  foreach ($assignments as $name) {

    $family = x_get_option( "x_${name}_font_family" );
    $weight = str_replace( 'italic', 'i', x_get_option( "x_${name}_font_weight" ) );

    if ( ! isset( $fonts[$family] ) ) {
      $fonts[$family] = array(
        'family' => $family,
        'weights' => array(),
        'stack' => x_get_font_data( $family, 'stack' ),
        'source' => x_get_font_data( $family, 'source' )
      );
    }

    if ( 'body' === $name ) {
      $weight = str_replace( 'i', '', $weight );
      $fonts[$family]['weights'] = array_merge( $fonts[$family]['weights'], array( $weight, $weight . 'i', '700', '700i' ));
    } else {
      $fonts[$family]['weights'][] = $weight;
    }

  }

  return array_values( $fonts );

}

function x_google_fonts_queue_cached() {

  if ( x_get_option( 'x_enable_font_manager' ) || ! function_exists('cornerstone_queue_font') ) {
    return;
  }

  $cached = get_option( 'x_cache_google_fonts_request', false );

  if ( false === $cached || ! is_array( $cached ) ) {

    $cached = x_google_fonts_queue();
    update_option( 'x_cache_google_fonts_request', $cached );

  }

  foreach ($cached as $font) {
    cornerstone_queue_font($font);
  }

}

add_action('x_before_head_css', 'x_google_fonts_queue_cached');



// Register Subsets
// =============================================================================

function x_google_fonts_subsets( $config ) {

  if ( ! x_get_option( 'x_enable_font_manager' ) && x_get_option( 'x_google_fonts_subsets' ) == '1' ) {

    if ( x_get_option( 'x_google_fonts_subset_cyrillic' ) == '1' ) {
      $config['googleSubsets'][] = 'cyrillic';
      $config['googleSubsets'][] = 'cyrillic-ext';
    }

    if ( x_get_option( 'x_google_fonts_subset_greek' ) == '1' ) {
      $config['googleSubsets'][] = 'greek';
      $config['googleSubsets'][] = 'greek-ext';
    }

    if ( x_get_option( 'x_google_fonts_subset_vietnamese' ) == '1' ) {
      $config['googleSubsets'][] = 'vietnamese';
      $config['googleSubsets'][] = 'vietnamese-ext';
    }

  }

  return $config;
}

add_filter('cs_google_font_config', 'x_google_fonts_subsets');



// Cache Busting
// =============================================================================

function x_bust_google_fonts_cache() {

  delete_option( 'x_cache_google_fonts_request' );

}

add_action( 'cs_theme_options_after_save', 'x_bust_google_fonts_cache' );



// Font Data
// =============================================================================

function x_fonts_data() {

  static $data = null;

  if ( is_null( $data ) ) {
    $path = X_TEMPLATE_PATH . '/framework/data';
    $system_fonts = include "$path/fonts-system.php";
    $google_fonts = include "$path/fonts-google.php";
    $data = array_merge( $system_fonts, $google_fonts );
  }

  return apply_filters( 'x_fonts_data', $data );

}

add_filter( 'cs_font_data', 'x_fonts_data' );



// Helpers
// =============================================================================

//
// Get Font Data
//

function x_get_font_data( $font_family, $font_family_data_key ) {

  static $fonts_data = null;

  if ( is_null( $fonts_data) ) {
    $fonts_data = x_fonts_data();
  }

  $font_family = sanitize_key( $font_family );
  if ( isset( $fonts_data[$font_family] ) && isset( $fonts_data[$font_family][$font_family_data_key] ) ) {
    return $fonts_data[$font_family][$font_family_data_key];
  }

  return '';

}


//
// Is Font Italic
//

function x_is_font_italic( $font_weight_and_style ) {
  return false !== strpos( $font_weight_and_style, 'italic' );
}


//
// Get Font Weight
//

function x_get_font_weight( $font_weight_and_style ) {
  return str_replace( 'italic', '', $font_weight_and_style );
}
