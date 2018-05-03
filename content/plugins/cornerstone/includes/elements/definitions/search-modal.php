<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/SEARCH-MODAL.PHP
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
  'title'  => __( 'Search Modal', '__x__' ),
  'values' => array_merge(
    x_values_anchor( x_bar_module_settings_anchor( 'toggle' ) ),
    x_values_modal(),
    x_values_search( x_bar_module_settings_search( 'modal', array( 't_pre' => __( 'Search', '__x__' ) ) ) ),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_search_modal() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_anchor( x_bar_module_settings_anchor( 'toggle' ) ),
      x_control_groups_modal(),
      x_control_groups_search( x_bar_module_settings_search( 'modal', array( 't_pre' => __( 'Search', '__x__' ) ) ) ),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      x_controls_anchor( x_bar_module_settings_anchor( 'toggle' ) ),
      x_controls_modal(),
      x_controls_search( x_bar_module_settings_search( 'modal', array( 't_pre' => __( 'Search', '__x__' ) ) ) ),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'search-modal', x_element_base( $data ) );
