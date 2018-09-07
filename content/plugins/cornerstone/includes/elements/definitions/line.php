<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/LINE.PHP
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
  'title'  => __( 'Line', '__x__' ),
  'values' => x_values_element_line(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_line() {
  return array(
    'controls'           => x_controls_element_line(),
    'controls_adv'       => x_controls_element_line( true ),
    'control_groups'     => x_control_groups_element_line(),
    'control_groups_adv' => x_control_groups_element_line( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'line', x_element_base( $data ) );
