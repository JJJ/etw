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
  'values' => x_values_element_image(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_image() {
  return array(
    'controls'           => x_controls_element_image(),
    'controls_adv'       => x_controls_element_image( true ),
    'control_groups'     => x_control_groups_element_image(),
    'control_groups_adv' => x_control_groups_element_image( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'image', x_element_base( $data ) );
