<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-BBP-DROPDOWN.PHP
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
  'title'  => __( 'bbPress Dropdown', '__x__' ),
  'values' => array_merge(
    x_values_anchor( x_bar_module_settings_anchor( 'toggle' ) ),
    x_values_dropdown(),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_bbp_dropdown() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_anchor( x_bar_module_settings_anchor( 'toggle' ) ),
      x_control_groups_dropdown(),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      x_controls_anchor( x_bar_module_settings_anchor( 'toggle' ) ),
      x_controls_dropdown(),
      x_controls_omega()
    ),
    'active' => class_exists( 'bbPress' )
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'tp-bbp-dropdown', x_element_base( $data ) );
