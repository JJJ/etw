<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_ELEMENTS/TP-WC-CART-MODAL.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Control Groups
//   03. Values
// =============================================================================

// Controls
// =============================================================================

function x_controls_element_tp_wc_cart_modal( $adv = false ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  $cond_adv           = array( 'adv' => $adv );

  $toggle_adv         = x_bar_module_settings_anchor( 'cart-toggle', $cond_adv );
  $modal_adv          = $cond_adv;
  $cart_adv           = $cond_adv;
  $buttons_adv        = x_bar_module_settings_anchor( 'cart-button', $cond_adv );

  $toggle_std_content = x_bar_module_settings_anchor( 'cart-toggle', array( 'inc_t_pre' => true, 'group' => $group_std_content ) );
  $toggle_std_design  = x_bar_module_settings_anchor( 'cart-toggle', array( 'inc_t_pre' => true, 'group' => $group_std_design ) );
  $buttons_std_design = x_bar_module_settings_anchor( 'cart-button', array( 'inc_t_pre' => true, 'group' => $group_std_design ) );

  if ( $adv ) {

    $controls = array_merge(
      x_controls_anchor_adv( $toggle_adv ),
      x_controls_modal_adv( $modal_adv ),
      x_controls_cart_adv( $cart_adv ),
      x_controls_anchor_adv( $buttons_adv ),
      x_controls_omega()
    );

  } else {

    $controls = array_merge(

      x_controls_anchor_std_content( $toggle_std_content ),
      x_controls_cart_std_content(),

      x_controls_anchor_std_design_setup( $toggle_std_design ),
      x_controls_modal_std_design_setup(),
      x_controls_anchor_std_design_setup( $buttons_std_design ),

      x_controls_anchor_std_design_colors( $toggle_std_design ),
      x_controls_modal_std_design_colors(),
      x_controls_cart_std_design_colors(),
      x_controls_anchor_std_design_colors( $buttons_std_design ),

      x_controls_omega( $settings_std_customize )

    );

  }

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_element_tp_wc_cart_modal( $adv = false ) {

  $toggle  = x_bar_module_settings_anchor( 'cart-toggle' );
  $buttons = x_bar_module_settings_anchor( 'cart-button' );

  if ( $adv ) {

    $control_groups = array_merge(
      x_control_groups_anchor( $toggle ),
      x_control_groups_modal(),
      x_control_groups_cart(),
      x_control_groups_anchor( $buttons ),
      x_control_groups_omega()
    );

  } else {

    $control_groups = x_control_groups_std( array( 'group_title' => __( 'Cart Modal', '__x__' ) ) );

  }

  return $control_groups;

}



// Values
// =============================================================================

function x_values_element_tp_wc_cart_modal( $settings = array() ) {

  $toggle  = x_bar_module_settings_anchor( 'cart-toggle' );
  $buttons = x_bar_module_settings_anchor( 'cart-button' );

  $values = array_merge(
    x_values_anchor( $toggle ),
    x_values_modal(),
    x_values_cart(),
    x_values_anchor( $buttons ),
    x_values_omega()
  );

  return x_bar_mixin_values( $values, $settings );

}
