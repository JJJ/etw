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
  'values' => x_values_element_gap(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_gap() {
  return array(
    'controls'           => x_controls_element_gap(),
    'controls_adv'       => x_controls_element_gap( true ),
    'control_groups'     => x_control_groups_element_gap(),
    'control_groups_adv' => x_control_groups_element_gap( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'gap', x_element_base( $data ) );
