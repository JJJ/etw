<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/ROW.PHP
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
  'title'  => __( 'Row', '__x__' ),
  'values' => x_values_element_row(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_row() {
  return array(
    'controls'           => x_controls_element_row(),
    'controls_adv'       => x_controls_element_row( true ),
    'control_groups'     => x_control_groups_element_row(),
    'control_groups_adv' => x_control_groups_element_row( true ),
    'options' => array(
      'default_children' => array(
				array( '_type' => 'column', '_active' => true ),
				array( '_type' => 'column' ),
				array( '_type' => 'column' ),
				array( '_type' => 'column' ),
				array( '_type' => 'column' ),
				array( '_type' => 'column' ),
      )
    )
  );
}



// Register Element
// =============================================================================

cornerstone_register_element( 'row', x_element_base( $data ) );
