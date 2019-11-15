<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/SEARCH-INLINE.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Control Groups
//   03. Values
//   04. Define Element
//   05. Builder Setup
//   06. Register Element
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  'search-inline',
  'omega'
);



// Style
// =============================================================================

function x_element_style_search_inline() {
  return cs_get_partial_style( 'search' );
}



// Render
// =============================================================================

function x_element_render_search_inline( $data ) {
  return cs_get_partial_view( 'search', $data );
}



// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Search Inline', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_search_inline',
  'style' => 'x_element_style_search_inline',
  'render' => 'x_element_render_search_inline',
  'icon' => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_search_inline() {
  return cs_compose_controls(
    cs_partial_controls( 'search', array( 'type' => 'inline' ) ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'search-inline', $data );
