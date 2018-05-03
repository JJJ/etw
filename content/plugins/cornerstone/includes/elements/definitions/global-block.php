<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/GLOBAL-BLOCK.PHP
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
  'title'  => __( 'Global Block', '__x__' ),
  'values' => array_merge(
    x_values_global_block(),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_global_block() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_global_block(),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      x_controls_global_block(),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'global-block', x_element_base( $data ) );
