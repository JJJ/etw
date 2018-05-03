<?php

// =============================================================================
// FUNCTIONS/GLOBAL/CLASSES.PHP
// -----------------------------------------------------------------------------
// Outputs custom classes for various elements, sometimes depending on options
// selected in the Customizer.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Body Class
//   02. Brand Class
//   03. Masthead Class
//   04. Navbar Class
//   05. Navigation Item Class
// =============================================================================

// Body Class
// =============================================================================


function x_cranium_headers_body_class( $output ) {

  //
  // Navbar.
  //

  switch ( x_get_navbar_positioning() ) {
    case 'static-top' :
      $output[] .= 'x-navbar-static-active';
      break;
    case 'fixed-top' :
      $output[] .= 'x-navbar-fixed-top-active';
      break;
    case 'fixed-left' :
      $output[] .= 'x-navbar-fixed-left-active';
      break;
    case 'fixed-right' :
      $output[] .= 'x-navbar-fixed-right-active';
      break;
  }

  if ( x_is_one_page_navigation() ) {
    $output[] .= 'x-one-page-navigation-active';
  }

  return $output;

}
add_filter( 'body_class', 'x_cranium_headers_body_class' );



// Brand Class
// =============================================================================

if ( ! function_exists( 'x_brand_class' ) ) :
  function x_brand_class() {

    switch ( x_get_option( 'x_logo' ) ) {
      case '' :
        $output = 'x-brand text';
        break;
      default :
        $output = 'x-brand img';
        break;
    }

    echo $output;

  }
endif;



// Masthead Class
// =============================================================================

if ( ! function_exists( 'x_masthead_class' ) ) :
  function x_masthead_class() {

    $navbar_positioning = x_get_navbar_positioning();
    $logo_nav_layout    = x_get_logo_navigation_layout();

    if ( $logo_nav_layout == 'stacked' && ( $navbar_positioning == 'static-top' || $navbar_positioning == 'fixed-top' ) ) :
      $output = 'masthead masthead-stacked';
    else :
      $output = 'masthead masthead-inline';
    endif;

    echo $output;

  }
endif;



// Navbar Class
// =============================================================================

if ( ! function_exists( 'x_navbar_class' ) ) :
  function x_navbar_class() {

    switch ( x_get_navbar_positioning() ) {
      case 'fixed-left' :
        $output = 'x-navbar x-navbar-fixed-left';
        break;
      case 'fixed-right' :
        $output = 'x-navbar x-navbar-fixed-right';
        break;
      default :
        $output = 'x-navbar';
        break;
    }

    echo $output;

  }
endif;



// Navigation Item Class
// =============================================================================

if ( ! function_exists( 'x_navigation_item_class' ) ) :
  function x_navigation_item_class( $classes, $item ) {

    if ( $item->type == 'taxonomy' ) {
      $classes[] = 'tax-item tax-item-' . $item->object_id;
    }

    return $classes;

  }
  add_filter( 'nav_menu_css_class', 'x_navigation_item_class', 10, 2 );
endif;
