<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TAB.PHP
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
  'title'   => __( 'Tab', '__x__' ),
  'values'  => x_values_element_tab(),
  'options' => array(
    'child' => true
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_tab() {
  return array(
    'controls'           => x_controls_element_tab(),
    'controls_adv'       => x_controls_element_tab( true ),
    'control_groups'     => x_control_groups_element_tab(),
    'control_groups_adv' => x_control_groups_element_tab( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'tab', x_element_base( $data ) );
