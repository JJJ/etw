<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/NAV-COLLAPSED.PHP
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
  'title'  => __( 'Navigation Collapsed', '__x__' ),
  'values' => x_values_element_nav_collapsed(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_nav_collapsed() {
  return array(
    'controls'           => x_controls_element_nav_collapsed(),
    'controls_adv'       => x_controls_element_nav_collapsed( true ),
    'control_groups'     => x_control_groups_element_nav_collapsed(),
    'control_groups_adv' => x_control_groups_element_nav_collapsed( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'nav-collapsed', x_element_base( $data ) );
