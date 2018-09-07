<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_ELEMENTS/MAP-MARKER.PHP
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

function x_controls_element_map_marker( $adv = true ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  $controls = x_controls_map_marker( array( 'adv' => $adv ) );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_element_map_marker( $adv = true ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  if ( $adv ) {
    $control_groups = x_control_groups_map_marker();
  } else {
    $control_groups = x_control_groups_std( array( 'group_title' => __( 'Map Marker', '__x__' ) ) );
  }

  return $control_groups;

}



// Values
// =============================================================================

function x_values_element_map_marker( $settings = array() ) {

  $values = x_values_map_marker();

  return x_bar_mixin_values( $values, $settings );

}
