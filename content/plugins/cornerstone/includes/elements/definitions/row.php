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
  'values' => array_merge(
    x_values_row(),
    x_values_omega( array( 'add_style' => true ) )
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_row() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_row(),
      x_control_groups_omega( array( 'add_style' => true ) )
    ),
    'controls' => array_merge(
      x_controls_row(),
      x_controls_omega( array( 'add_style' => true ) )
    ),
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
