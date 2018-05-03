<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/ACCORDION.PHP
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
  'title'  => __( 'Accordion', '__x__' ),
  'values' => array_merge(
    x_values_accordion(),
    x_values_omega()
  ),
  'options' => array(
    'default_children' => array(
      array( '_type' => 'accordion-item' ),
      array( '_type' => 'accordion-item' )
    )
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_accordion() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_accordion(),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      x_controls_accordion(),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'accordion', x_element_base( $data ) );
