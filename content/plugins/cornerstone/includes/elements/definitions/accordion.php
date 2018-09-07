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
  'title'   => __( 'Accordion', '__x__' ),
  'values'  => x_values_element_accordion(),
  'options' => array(
    'default_children' => array(
      array( '_type' => 'accordion-item', 'accordion_item_header_content' => __( 'Accordion Item 1', '__x__' ) ),
      array( '_type' => 'accordion-item', 'accordion_item_header_content' => __( 'Accordion Item 2', '__x__' ) ),
    ),
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_accordion() {
  return array(
    'controls'           => x_controls_element_accordion(),
    'controls_adv'       => x_controls_element_accordion( true ),
    'control_groups'     => x_control_groups_element_accordion(),
    'control_groups_adv' => x_control_groups_element_accordion( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'accordion', x_element_base( $data ) );
