<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/NAV-DROPDOWN.PHP
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
  'title'  => __( 'Navigation Dropdown', '__x__' ),
  'values' => x_values_element_nav_dropdown(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_nav_dropdown() {
  return array(
    'controls'           => x_controls_element_nav_dropdown(),
    'controls_adv'       => x_controls_element_nav_dropdown( true ),
    'control_groups'     => x_control_groups_element_nav_dropdown(),
    'control_groups_adv' => x_control_groups_element_nav_dropdown( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'nav-dropdown', x_element_base( $data ) );
