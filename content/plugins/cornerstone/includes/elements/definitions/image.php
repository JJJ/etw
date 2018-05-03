<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/IMAGE.PHP
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
  'title'  => __( 'Image', '__x__' ),
  'values' => array_merge(
    x_values_image( x_bar_module_settings_image() ),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_image() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_image( x_bar_module_settings_image() ),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      x_controls_image( x_bar_module_settings_image() ),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'image', x_element_base( $data ) );
