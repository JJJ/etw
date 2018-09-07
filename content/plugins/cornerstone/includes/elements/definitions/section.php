<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/SECTION.PHP
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
  'values' => x_values_element_section(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_section() {
  return array(
    'controls'           => x_controls_element_section(),
    'controls_adv'       => x_controls_element_section( true ),
    'control_groups'     => x_control_groups_element_section(),
    'control_groups_adv' => x_control_groups_element_section( true ),
    'options'            => array(
      'default_children' => array(
        array( '_type' => 'row' ),
      ),
    ),
  );
}



// Register Element
// =============================================================================

cornerstone_register_element( 'section', x_element_base( $data ) );
