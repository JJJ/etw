<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TABS.PHP
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
  'title'  => __( 'Tabs', '__x__' ),
  'values' => array_merge(
    x_values_tabs(),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_tabs() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_tabs(),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      x_controls_tabs(),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'tabs', x_element_base( $data ) );
