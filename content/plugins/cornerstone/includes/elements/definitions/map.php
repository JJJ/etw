<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/MAP.PHP
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
  'title'  => __( 'Map', '__x__' ),
  'values' => array_merge(
    x_values_map(),
    x_values_frame( array( 'frame_content_type' => 'map' ) ),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_map() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_map(),
      x_control_groups_frame( array( 'frame_content_type' => 'map' ) ),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      x_controls_map(),
      x_controls_frame( array( 'frame_content_type' => 'map' ) ),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'map', x_element_base( $data ) );
