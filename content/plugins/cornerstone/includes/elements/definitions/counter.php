<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/COUNTER.PHP
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
  'title'  => __( 'Counter', '__x__' ),
  'values' => x_values_element_counter(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_counter() {
  return array(
    'controls'           => x_controls_element_counter(),
    'controls_adv'       => x_controls_element_counter( true ),
    'control_groups'     => x_control_groups_element_counter(),
    'control_groups_adv' => x_control_groups_element_counter( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'counter', x_element_base( $data ) );
