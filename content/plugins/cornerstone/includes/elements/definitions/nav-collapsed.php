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
  'values' => array_merge(
    x_values_menu( x_bar_module_settings_menu( 'collapsed' ) ),
    x_values_anchor( x_bar_module_settings_anchor( 'toggle', array( 'tbf_only' => true ) ) ),
    x_values_off_canvas( array( 'tbf_only' => true ) ),
    x_values_anchor( x_bar_module_settings_anchor( 'menu-item-collapsed-top' ) ),
    x_values_anchor( x_bar_module_settings_anchor( 'menu-item-collapsed-sub' ) ),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_nav_collapsed() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_menu( x_bar_module_settings_menu( 'collapsed' ) ),
      x_control_groups_anchor( x_bar_module_settings_anchor( 'toggle', array( 'tbf_only' => true ) ) ),
      x_control_groups_off_canvas( array( 'tbf_only' => true ) ),
      x_control_groups_anchor( x_bar_module_settings_anchor( 'menu-item-collapsed-top' ) ),
      x_control_groups_anchor( x_bar_module_settings_anchor( 'menu-item-collapsed-sub' ) ),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      x_controls_menu( x_bar_module_settings_menu( 'collapsed' ) ),
      x_controls_anchor( x_bar_module_settings_anchor( 'toggle', array( 'tbf_only' => true ) ) ),
      x_controls_off_canvas( array( 'tbf_only' => true ) ),
      x_controls_anchor( x_bar_module_settings_anchor( 'menu-item-collapsed-top' ) ),
      x_controls_anchor( x_bar_module_settings_anchor( 'menu-item-collapsed-sub' ) ),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'nav-collapsed', x_element_base( $data ) );
