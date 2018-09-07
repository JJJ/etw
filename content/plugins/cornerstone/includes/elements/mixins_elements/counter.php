<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_ELEMENTS/COUNTER.PHP
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

function x_controls_element_counter( $adv = false ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  if ( $adv ) {

    $controls = array_merge(
      x_controls_counter_adv( array( 'adv' => true ) ),
      x_controls_omega()
    );

  } else {

    $controls = array_merge(
      x_controls_counter_std_content(),
      x_controls_counter_std_design_setup(),
      x_controls_counter_std_design_colors(),
      x_controls_omega( $settings_std_customize )
    );

  }

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_element_counter( $adv = false ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  if ( $adv ) {

    $control_groups = array_merge(
      x_control_groups_counter(),
      x_control_groups_omega()
    );

  } else {

    $control_groups = x_control_groups_std( array( 'group_title' => __( 'Counter', '__x__' ) ) ); 

  }

  return $control_groups;

}



// Values
// =============================================================================

function x_values_element_counter( $settings = array() ) {

  $values = array_merge(
    x_values_counter(),
    x_values_omega()
  );

  return x_bar_mixin_values( $values, $settings );

}
