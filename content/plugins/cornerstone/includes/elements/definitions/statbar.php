<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/STATBAR.PHP
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
  'title'  => __( 'Statbar', '__x__' ),
  'values' => array_merge(
    x_values_statbar(),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_statbar() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_statbar(),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      x_controls_statbar(),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'statbar', x_element_base( $data ) );
