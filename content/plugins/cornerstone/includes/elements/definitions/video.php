<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/VIDEO.PHP
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
  'title'  => __( 'Video', '__x__' ),
  'values' => array_merge(
    x_values_video(),
    x_values_frame( array( 'frame_content_type' => 'video' ) ),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_video() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_video(),
      x_control_groups_frame( array( 'frame_content_type' => 'video' ) ),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      x_controls_video(),
      x_controls_frame( array( 'frame_content_type' => 'video' ) ),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'video', x_element_base( $data ) );
