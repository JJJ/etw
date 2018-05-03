<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/COLUMN.PHP
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
  'title'  => __( 'Column', '__x__' ),
  'values' => array_merge(
    x_values_column(),
    x_values_omega( array( 'add_style' => true ) )
  ),
  'options' => array(
    'fallback_content' => '&nbsp;'
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_column() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_column(),
      x_control_groups_omega( array( 'add_style' => true ) )
    ),
    'controls' => array_merge(
      x_controls_column(),
      x_controls_omega( array( 'add_style' => true ) )
    ),
  );
}



// Register Element
// =============================================================================

cornerstone_register_element( 'column', x_element_base( $data ) );
