<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_ELEMENTS/ALERT.PHP
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

function x_controls_element_alert( $adv = false ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  if ( $adv ) {

    $controls = array_merge(
      x_controls_alert_adv( array( 'adv' => $adv ) ),
      x_controls_omega()
    );

  } else {

    $controls = array_merge(
      x_controls_alert_std_content(),
      x_controls_alert_std_design_setup(),
      x_controls_alert_std_design_colors(),
      x_controls_omega( $settings_std_customize )
    );

  }

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_element_alert( $adv = false ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  if ( $adv ) {

    $control_groups = array_merge(
      x_control_groups_alert(),
      x_control_groups_omega()
    );

  } else {

    $control_groups = x_control_groups_std( array( 'group_title' => __( 'Alert', '__x__' ) ) );

  }

  return $control_groups;

}



// Values
// =============================================================================

function x_values_element_alert( $settings = array() ) {

  $values = array_merge(
    x_values_alert(),
    x_values_omega()
  );

  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
