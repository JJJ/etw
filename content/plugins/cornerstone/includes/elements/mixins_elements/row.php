<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_ELEMENTS/ROW.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Control
//   02. Control Groups
//   03. Values
// =============================================================================

// Control
// =============================================================================

function x_controls_element_row( $adv = false ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  if ( $adv ) {

    $controls = array_merge(
      x_controls_row_adv( array( 'adv' => $adv ) ),
      x_controls_omega( array( 'add_style' => true ) )
    );

  } else {

    $controls = array_merge(
      x_controls_row_std_design_setup(),
      x_controls_row_std_design_colors(),
      x_controls_omega( array_merge( $settings_std_customize, array( 'add_style' => true ) ) )
    );

  }



  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_element_row( $adv = false ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  if ( $adv ) {

    $control_groups = array_merge(
      x_control_groups_row(),
      x_control_groups_omega( array( 'add_style' => true ) )
    );

  } else {

    $control_groups = x_control_groups_std( array( 'group_title' => __( 'Row', '__x__' ), 'no_content' => true ) ); 

  }

  return $control_groups;

}



// Values
// =============================================================================

function x_values_element_row( $settings = array() ) {

  $values = array_merge(
    x_values_row(),
    x_values_omega( array( 'add_style' => true ) )
  );

  return x_bar_mixin_values( $values, $settings );

}
