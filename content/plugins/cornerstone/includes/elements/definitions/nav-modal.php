<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/NAV-MODAL.PHP
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
  'title'  => __( 'Navigation Modal', '__x__' ),
  'values' => x_values_element_nav_modal(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_nav_modal() {
  return array(
    'controls'           => x_controls_element_nav_modal(),
    'controls_adv'       => x_controls_element_nav_modal( true ),
    'control_groups'     => x_control_groups_element_nav_modal(),
    'control_groups_adv' => x_control_groups_element_nav_modal( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'nav-modal', x_element_base( $data ) );
