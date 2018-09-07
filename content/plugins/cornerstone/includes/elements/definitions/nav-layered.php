<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/NAV-LAYERED.PHP
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
  'title'  => __( 'Navigation Layered', '__x__' ),
  'values' => x_values_element_nav_layered(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_nav_layered() {
  return array(
    'controls'           => x_controls_element_nav_layered(),
    'controls_adv'       => x_controls_element_nav_layered( true ),
    'control_groups'     => x_control_groups_element_nav_layered(),
    'control_groups_adv' => x_control_groups_element_nav_layered( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'nav-layered', x_element_base( $data ) );
