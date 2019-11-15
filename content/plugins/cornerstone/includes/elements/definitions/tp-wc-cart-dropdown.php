<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-CART-DROPDOWN.PHP
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
  'dropdown',
  cs_values( array(
    'dropdown_width' => cs_value( '350px', 'style' ),
    'dropdown_padding' => cs_value( '2em', 'style' )
  ) ),
  'cart',
  'cart-button',
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_style_tp_wc_cart_dropdown() {

  $style = cs_get_partial_style( 'anchor', array(
    'selector' => '.x-anchor-toggle',
    'key_prefix'    => 'toggle'
  ) );

  $style .= cs_get_partial_style( 'dropdown' );
  $style .= cs_get_partial_style( 'mini-cart' );

  $style .= cs_get_partial_style( 'anchor', array(
    'selector' => ' .buttons .x-anchor',
    'key_prefix'    => 'cart'
  ) );

  return $style;

}



// Render
// =============================================================================

function x_element_render_tp_wc_cart_dropdown( $data ) {

  if ( function_exists( 'wc_get_cart_url' ) ) {
    $anchor_href = wc_get_cart_url();
  } else {
    $anchor_href = '';
  }

  $data = array_merge(
    $data,
    array(
      'anchor_href'      => $anchor_href,
      'dropdown_is_list' => false
    ),
    cs_make_aria_atts( 'toggle_anchor', array(
      'controls' => 'dropdown',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Dropdown Content', '__x__' ),
    ), $data['id'], $data['mod_id'] )
  );

  return x_get_view( 'elements', 'tp-wc-cart-dropdown', '', $data, false );

}



// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Cart Dropdown', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_tp_wc_cart_dropdown',
  'style' => 'x_element_style_tp_wc_cart_dropdown',
  'render' => 'x_element_render_tp_wc_cart_dropdown',
  'icon' => 'native',
  'active'             => class_exists( 'WC_API' )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_wc_cart_dropdown() {
  return cs_compose_controls(
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:cart-toggle' ) ),
    cs_partial_controls( 'dropdown' ),
    cs_partial_controls( 'cart' ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:cart-button' ) ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'tp-wc-cart-dropdown', $data );
