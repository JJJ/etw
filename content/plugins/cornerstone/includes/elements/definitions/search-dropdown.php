<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/SEARCH-DROPDOWN.PHP
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
  'title'  => __( 'Search Dropdown', '__x__' ),
  'values' => array_merge(
    x_values_anchor( x_bar_module_settings_anchor( 'toggle' ) ),
    x_values_dropdown( array( 'theme' => array( 'dropdown_width' => x_module_value( '300px', 'style' ) ) ) ),
    x_values_search( x_bar_module_settings_search( 'dropdown', array( 't_pre' => __( 'Search', '__x__' ), 'theme' => x_module_theme_dropdown_search_default() ) ) ),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_search_dropdown() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_anchor( x_bar_module_settings_anchor( 'toggle' ) ),
      x_control_groups_dropdown( array( 'theme' => array( 'dropdown_width' => x_module_value( '300px', 'style' ) ) ) ),
      x_control_groups_search( x_bar_module_settings_search( 'dropdown', array( 't_pre' => __( 'Search', '__x__' ), 'theme' => x_module_theme_dropdown_search_default() ) ) ),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      x_controls_anchor( x_bar_module_settings_anchor( 'toggle' ) ),
      x_controls_dropdown( array( 'theme' => array( 'dropdown_width' => x_module_value( '300px', 'style' ) ) ) ),
      x_controls_search( x_bar_module_settings_search( 'dropdown', array( 't_pre' => __( 'Search', '__x__' ), 'theme' => x_module_theme_dropdown_search_default() ) ) ),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'search-dropdown', x_element_base( $data ) );
