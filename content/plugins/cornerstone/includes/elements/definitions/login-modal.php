<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/LOGIN-MODAL.PHP
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
  'title'  => __( 'Login Modal', '__x__' ),
  'values' => array_merge(
    x_values_toggle( x_bar_module_settings_anchor( 'toggle' ) ),
    x_values_modal(),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_login_modal() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_toggle( x_bar_module_settings_anchor( 'toggle' ) ),
      x_control_groups_modal(),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      x_controls_toggle( x_bar_module_settings_anchor( 'toggle' ) ),
      x_controls_modal(),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'login-modal', x_element_base( $data ) );
