<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/RATING.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Values
//   02. Style
//   03. Render
//   04. Define Element
//   05. Builder Setup
//   06. Register Element
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  'rating',
  'omega'
);



// Style
// =============================================================================

function x_element_style_rating() {
  return cs_get_partial_style( 'rating' );
}



// Render
// =============================================================================

function x_element_render_rating( $data ) {
  return cs_get_partial_view( 'rating', $data );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Rating', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_rating',
  'style'   => 'x_element_style_rating',
  'render'  => 'x_element_render_rating',
  'icon'    => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_rating() {
  return cs_compose_controls(
    cs_partial_controls( 'rating' ),
    cs_partial_controls( 'omega' )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'rating', $data );
