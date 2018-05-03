<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-CART-DROPDOWN.PHP
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
  'title'  => __( 'Cart Dropdown', '__x__' ),
  'values' => array_merge(
    x_values_anchor( x_bar_module_settings_anchor( 'cart-toggle' ) ),
    x_values_dropdown( array( 'theme' => array( 'dropdown_width' => x_module_value( '350px', 'style' ), 'dropdown_padding' => x_module_value( '2em', 'style' ) ) ) ),
    x_values_cart(),
    x_values_anchor( x_bar_module_settings_anchor( 'cart-button' ) ),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_wc_cart_dropdown() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_anchor( x_bar_module_settings_anchor( 'cart-toggle' ) ),
      x_control_groups_dropdown( array( 'theme' => array( 'dropdown_width' => x_module_value( '350px', 'style' ), 'dropdown_padding' => x_module_value( '2em', 'style' ) ) ) ),
      x_control_groups_cart(),
      x_control_groups_anchor( x_bar_module_settings_anchor( 'cart-button' ) ),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      x_controls_anchor( x_bar_module_settings_anchor( 'cart-toggle' ) ),
      x_controls_dropdown( array( 'theme' => array( 'dropdown_width' => x_module_value( '350px', 'style' ), 'dropdown_padding' => x_module_value( '2em', 'style' ) ) ) ),
      x_controls_cart(),
      x_controls_anchor( x_bar_module_settings_anchor( 'cart-button' ) ),
      x_controls_omega()
    ),
    'active' => class_exists( 'WC_API' )
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'tp-wc-cart-dropdown', x_element_base( $data ) );
