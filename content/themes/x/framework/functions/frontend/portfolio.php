<?php

// =============================================================================
// FUNCTIONS/GLOBAL/PORTFOLIO.PHP
// -----------------------------------------------------------------------------
// Portfolio template tags for use in theme templates.
// Portfolio functionality is inside Cornerstone plugin.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Get Parent Portfolio Link
//   02. Get Parent Portfolio Title
//   03. Output Portfolio Filters
//   04. Output Portfolio Item Project Link
//   05. Output Portfolio Item Tags
//   06. Output Portfolio Item Social
//   07. Entry Class
// =============================================================================


// Get Parent Portfolio Link
// =============================================================================

function x_get_parent_portfolio_link() {
  return ( function_exists( 'cs_get_parent_portfolio_link' ) ) ? cs_get_parent_portfolio_link() : '';
}



// Get Parent Portfolio Title
// =============================================================================

function x_get_parent_portfolio_title() {
  return ( function_exists( 'cs_get_parent_portfolio_title' ) ) ? cs_get_parent_portfolio_title() : '';
}


// Output Portfolio Filters
// =============================================================================

function x_portfolio_filters() {
  return ( function_exists( 'cs_portfolio_filters' ) ) ? cs_portfolio_filters() : '';
}


// Output Portfolio Item Project Link
// =============================================================================

function x_portfolio_item_project_link() {
  return ( function_exists( 'cs_portfolio_item_project_link' ) ) ? cs_portfolio_item_project_link() : '';
}



// Output Portfolio Item Tags
// =============================================================================

function x_portfolio_item_tags() {
  return ( function_exists( 'cs_portfolio_item_tags' ) ) ? cs_portfolio_item_tags() : '';
}



// Output Portfolio Item Social
// =============================================================================

function x_portfolio_item_social() {
  return ( function_exists( 'cs_portfolio_item_social' ) ) ? cs_portfolio_item_social() : '';
}



// Entry Class
// =============================================================================

if ( ! function_exists( 'x_portfolio_entry_classes' ) ) :
  function x_portfolio_entry_classes( $classes ) {

    GLOBAL $post;
    $terms = wp_get_object_terms( $post->ID, 'portfolio-category' );
    foreach ( $terms as $term ) {
      if ( isset( $term->slug ) ) {
        $classes[] = 'x-portfolio-' . md5( $term->slug );
      }
    }
    return $classes;

  }
  add_filter( 'post_class', 'x_portfolio_entry_classes' );
endif;
