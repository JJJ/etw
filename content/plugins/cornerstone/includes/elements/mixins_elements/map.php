<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_ELEMENTS/MAP.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Control Group
//   03. Values
// =============================================================================

// Controls: Advanced
// =============================================================================

function x_controls_element_map( $adv = false ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  if ( $adv ) {

    $controls = array_merge(
      x_controls_map_adv( array( 'adv' => $adv ) ),
      x_controls_frame_adv( array( 'frame_content_type' => 'map', 'adv' => $adv ) ),
      x_controls_omega()
    );

  } else {

    $controls = array_merge(
      x_controls_map_std_content(),
      x_controls_map_std_design_setup(),
      x_controls_frame_std_design_setup( array( 'frame_content_type' => 'map' ) ),
      x_controls_frame_std_design_colors( array( 'frame_content_type' => 'map' ) ),
      x_controls_omega( $settings_std_customize )
    );

  }

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_element_map( $adv = false ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  if ( $adv ) {

    $control_groups = array_merge(
      x_control_groups_map(),
      x_control_groups_frame( array( 'frame_content_type' => 'map' ) ),
      x_control_groups_omega()
    );

  } else {

    $control_groups = x_control_groups_std( array( 'group_title' => __( 'Map', '__x__' ) ) );

  }

  return $control_groups;

}



// Values
// =============================================================================

function x_values_element_map( $settings = array() ) {

  $values = array_merge(
    x_values_map(),
    x_values_frame( array( 'frame_content_type' => 'map' ) ),
    x_values_omega()
  );

  return x_bar_mixin_values( $values, $settings );

}
