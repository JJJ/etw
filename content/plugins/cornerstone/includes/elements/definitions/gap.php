<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/GAP.PHP
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
  'title'  => __( 'Gap', '__x__' ),
  'values' => array_merge(
    x_values_gap(),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_gap() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_gap(),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      x_controls_gap(),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'gap', x_element_base( $data ) );
