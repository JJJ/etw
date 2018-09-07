<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_ELEMENTS/BUTTON.PHP
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

function x_controls_element_button( $adv = false ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  $button_adv         = x_bar_module_settings_anchor( 'button', array( 'adv' => $adv ) );
  $button_std_content = x_bar_module_settings_anchor( 'button', array( 'group' => $group_std_content ) );
  $button_std_design  = x_bar_module_settings_anchor( 'button', array( 'group' => $group_std_design ) );

  if ( $adv ) {

    $controls = array_merge(
      x_controls_anchor_adv( $button_adv ),
      x_controls_omega()
    );

  } else {

    $controls = array_merge(
      x_controls_anchor_std_content( $button_std_content ),
      x_controls_anchor_std_design_setup( $button_std_design ),
      x_controls_anchor_std_design_colors( $button_std_design ),
      x_controls_omega( $settings_std_customize )
    );

  }

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_element_button( $adv = false ) {

  if ( $adv ) {

    $control_groups = array_merge(
      x_control_groups_anchor( x_bar_module_settings_anchor( 'button' ) ),
      x_control_groups_omega()
    );

  } else {

    $control_groups = x_control_groups_std( array( 'group_title' => __( 'Button', '__x__' ) ) );

  }

  return $control_groups;

}



// Values
// =============================================================================

function x_values_element_button( $settings = array() ) {

  $values = array_merge(
    x_values_anchor( x_bar_module_settings_anchor( 'button' ) ),
    x_values_omega()
  );

  return x_bar_mixin_values( $values, $settings );

}
