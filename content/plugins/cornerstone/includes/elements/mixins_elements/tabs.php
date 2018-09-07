<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_ELEMENTS/TABS.PHP
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

function x_controls_element_tabs( $adv = false ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  if ( $adv ) {

    $controls = array_merge(
      x_controls_tabs_adv( array( 'adv' => $adv ) ),
      x_controls_omega()
    );

  } else {

    $controls = array_merge(
      x_controls_tabs_std_content(),
      x_controls_tabs_std_design_setup(),
      x_controls_tabs_std_design_colors(),
      x_controls_omega( $settings_std_customize )
    );

  }

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_element_tabs( $adv = false ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  if ( $adv ) {

    $control_groups = array_merge(
      x_control_groups_tabs(),
      x_control_groups_omega()
    );

  } else {

    $control_groups = x_control_groups_std( array( 'group_title' => __( 'Tabs', '__x__' ) ) );

  }

  return $control_groups;

}



// Values
// =============================================================================

function x_values_element_tabs( $settings = array() ) {

  $values = array_merge(
    x_values_tabs(),
    x_values_omega()
  );

  return x_bar_mixin_values( $values, $settings );

}
