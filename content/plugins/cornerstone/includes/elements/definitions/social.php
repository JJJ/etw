<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/SOCIAL.PHP
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
  'title'  => __( 'Social', '__x__' ),
  'values' => x_values_element_social(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_social() {
  return array(
    'controls'           => x_controls_element_social(),
    'controls_adv'       => x_controls_element_social( true ),
    'control_groups'     => x_control_groups_element_social(),
    'control_groups_adv' => x_control_groups_element_social( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'social', x_element_base( $data ) );
