<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/SEARCH-INLINE.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Define Element
//   02. Builder Setup
//   03. Register Element
// =============================================================================

// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Search Inline', '__x__' ),
  'values' => array_merge(
    x_values_search( x_bar_module_settings_search( 'inline' ) ),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_search_inline() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_search( x_bar_module_settings_search( 'inline' ) ),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      x_controls_search( x_bar_module_settings_search( 'inline' ) ),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'search-inline', x_element_base( $data ) );
