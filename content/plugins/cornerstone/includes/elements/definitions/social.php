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
  'values' => array_merge(
    x_values_anchor( x_bar_module_settings_anchor( 'social' ) ),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_social() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_anchor( x_bar_module_settings_anchor( 'social' ) ),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      x_controls_anchor( x_bar_module_settings_anchor( 'social' ) ),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'social', x_element_base( $data ) );
