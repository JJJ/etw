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
  'values' => x_values_element_tp_wc_cart_off_canvas(),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_wc_cart_off_canvas() {
  return array(
    'controls'           => x_controls_element_tp_wc_cart_off_canvas(),
    'controls_adv'       => x_controls_element_tp_wc_cart_off_canvas( true ),
    'control_groups'     => x_control_groups_element_tp_wc_cart_off_canvas(),
    'control_groups_adv' => x_control_groups_element_tp_wc_cart_off_canvas( true ),
    'active'             => class_exists( 'WC_API' )
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'tp-wc-cart-off-canvas', x_element_base( $data ) );
