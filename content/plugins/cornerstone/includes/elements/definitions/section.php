<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/X-SECTION.PHP
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
  'title'  => __( 'Section', '__x__' ),
  'values' => array_merge(
    x_values_section(),
    x_values_omega( array( 'add_style' => true ) )
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_section() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_section(),
      x_control_groups_omega( array( 'add_style' => true ) )
    ),
    'controls' => array_merge(
      x_controls_section(),
      x_controls_omega( array( 'add_style' => true ) )
    ),
    'options' => array(
      'default_children' => array(
        array( '_type' => 'row' )
      )
    )
  );
}



// Register Element
// =============================================================================

cornerstone_register_element( 'section', x_element_base( $data ) );
