<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/MAP.PHP
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
  'title'   => __( 'Map', '__x__' ),
  'values'  => x_values_element_map(),
  'options' => array(
    'cache'            => false,
    'render_children'  => true,
    'default_children' => array(),
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_map() {
  return array(
    'controls'           => x_controls_element_map(),
    'controls_adv'       => x_controls_element_map( true ),
    'control_groups'     => x_control_groups_element_map(),
    'control_groups_adv' => x_control_groups_element_map( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'map', x_element_base( $data ) );
