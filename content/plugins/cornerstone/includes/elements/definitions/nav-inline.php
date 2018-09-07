<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/NAV-INLINE.PHP
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
  'title'  => __( 'Navigation Inline', '__x__' ),
  'values' => x_values_element_nav_inline(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_nav_inline() {
  return array(
    'controls'           => x_controls_element_nav_inline(),
    'controls_adv'       => x_controls_element_nav_inline( true ),
    'control_groups'     => x_control_groups_element_nav_inline(),
    'control_groups_adv' => x_control_groups_element_nav_inline( true ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'nav-inline', x_element_base( $data ) );
