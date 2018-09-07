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
  'title'   => __( 'Column', '__x__' ),
  'values'  => x_values_element_column(),
  'options' => array(
    'fallback_content' => '&nbsp;'
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_column() {
  return array(
    'controls'           => x_controls_element_column(),
    'controls_adv'       => x_controls_element_column( true ),
    'control_groups'     => x_control_groups_element_column(),
    'control_groups_adv' => x_control_groups_element_column( true ),
  );
}



// Register Element
// =============================================================================

cornerstone_register_element( 'column', x_element_base( $data ) );
