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
  'values' => array_merge(
    x_values_menu( x_bar_module_settings_menu( 'inline' ) ),
    x_values_anchor( x_bar_module_settings_anchor( 'menu-item-inline-top' ) ),
    x_values_dropdown(),
    x_values_anchor( x_bar_module_settings_anchor( 'menu-item-inline-sub' ) ),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_nav_inline() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_menu( x_bar_module_settings_menu( 'inline' ) ),
      x_control_groups_anchor( x_bar_module_settings_anchor( 'menu-item-inline-top' ) ),
      x_control_groups_dropdown(),
      x_control_groups_anchor( x_bar_module_settings_anchor( 'menu-item-inline-sub' ) ),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      x_controls_menu( x_bar_module_settings_menu( 'inline' ) ),
      x_controls_anchor( x_bar_module_settings_anchor( 'menu-item-inline-top' ) ),
      x_controls_dropdown(),
      x_controls_anchor( x_bar_module_settings_anchor( 'menu-item-inline-sub' ) ),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'nav-inline', x_element_base( $data ) );
