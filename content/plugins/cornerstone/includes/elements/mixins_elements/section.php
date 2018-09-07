<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_ELEMENTS/SECTION.PHP
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

function x_controls_element_section( $adv = false ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  if ( $adv ) {

    $controls = array_merge(
      x_controls_section_adv( array( 'adv' => $adv ) ),
      x_controls_omega( array( 'add_style' => true ) )
    );

  } else {

    $controls = array_merge(
      x_controls_section_std_design_setup(),
      x_controls_section_std_design_colors(),
      x_controls_omega( array_merge( $settings_std_customize, array( 'add_style' => true ) ) )
    );

  }

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_element_section( $adv = false ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  if ( $adv ) {

    $control_groups = array_merge(
      x_control_groups_section(),
      x_control_groups_omega( array( 'add_style' => true ) )
    );

  } else {

    $control_groups = x_control_groups_std( array( 'group_title' => __( 'Section', '__x__' ), 'no_content' => true ) ); 

  }

  return $control_groups;

}



// Values
// =============================================================================

function x_values_element_section( $settings = array() ) {

  $values = array_merge(
    x_values_section(),
    x_values_omega( array( 'add_style' => true ) )
  );

  return x_bar_mixin_values( $values, $settings );

}
