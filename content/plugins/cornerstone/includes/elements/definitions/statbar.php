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
  'values' => x_values_element_statbar(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_statbar() {
  return array(
    'controls'           => x_controls_element_statbar(),
    'controls_adv'       => x_controls_element_statbar( true ),
    'control_groups'     => x_control_groups_element_statbar(),
    'control_groups_adv' => x_control_groups_element_statbar( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'statbar', x_element_base( $data ) );
