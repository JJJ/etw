<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-CART-OFF-CANVAS.PHP
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
  'title'  => __( 'Cart Off Canvas', '__x__' ),
  'values' => array_merge(
    x_values_anchor( x_bar_module_settings_anchor( 'cart-toggle' ) ),
    x_values_off_canvas(),
    x_values_cart(),
    x_values_anchor( x_bar_module_settings_anchor( 'cart-button' ) ),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_wc_cart_off_canvas() {
  return array(
    'control_groups' => array_merge(
      x_control_groups_anchor( x_bar_module_settings_anchor( 'cart-toggle' ) ),
      x_control_groups_off_canvas(),
      x_control_groups_cart(),
      x_control_groups_anchor( x_bar_module_settings_anchor( 'cart-button' ) ),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      x_controls_anchor( x_bar_module_settings_anchor( 'cart-toggle' ) ),
      x_controls_off_canvas(),
      x_controls_cart(),
      x_controls_anchor( x_bar_module_settings_anchor( 'cart-button' ) ),
      x_controls_omega()
    ),
    'active' => class_exists( 'WC_API' )
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'tp-wc-cart-off-canvas', x_element_base( $data ) );
