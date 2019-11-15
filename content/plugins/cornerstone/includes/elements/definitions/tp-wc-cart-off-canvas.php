<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-CART-OFF-CANVAS.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Control Groups
//   03. Values
//   04. Define Element
//   05. Builder Setup
//   06. Register Element
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  'toggle-cart',
  'off-canvas',
  'cart',
  'cart-button',
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_style_tp_wc_cart_off_canvas() {

  $style = cs_get_partial_style( 'anchor', array(
    'selector' => '.x-anchor-toggle',
    'key_prefix'    => 'toggle'
  ) );

  $style .= cs_get_partial_style( 'off-canvas' );
  $style .= cs_get_partial_style( 'mini-cart' );

  $style .= cs_get_partial_style( 'anchor', array(
    'selector' => ' .buttons .x-anchor',
    'key_prefix'    => 'cart'
  ) );

  return $style;
}



// Render
// =============================================================================

function x_element_render_tp_wc_cart_off_canvas( $data ) {

  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', array(
      'controls' => 'off-canvas',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Off Canvas Content', '__x__' ),
    ), $data['id'], $data['mod_id'] )
  );

  cs_defer_partial( 'off-canvas', array_merge(
    cs_extract( $data, array( 'off_canvas' => '' ) ),
    array( 'off_canvas_content' => cs_get_partial_view( 'mini-cart', cs_extract( $data, array( 'cart' => '' ) ) ) )
  ) );

  return cs_get_partial_view( 'anchor', cs_extract( $data, array( 'toggle_anchor' => 'anchor', 'toggle' => '' ) ) );

}



// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Cart Off Canvas', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_tp_wc_cart_off_canvas',
  'style' => 'x_element_style_tp_wc_cart_off_canvas',
  'render' => 'x_element_render_tp_wc_cart_off_canvas',
  'icon' => 'native',
  'active' => class_exists( 'WC_API' )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_wc_cart_off_canvas() {
  return cs_compose_controls(
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:cart-toggle' ) ),
    cs_partial_controls( 'off-canvas' ),
    cs_partial_controls( 'cart' ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:cart-button' ) ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'tp-wc-cart-off-canvas', $data );
