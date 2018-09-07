<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_ELEMENTS/IMAGE.PHP
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

function x_controls_element_image( $adv = false ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  if ( $adv ) {

    $controls = array_merge(
      x_controls_image_adv( x_bar_module_settings_image( array( 'adv' => $adv ) ) ),
      x_controls_omega()
    );

  } else {

    $controls = array_merge(
      x_controls_image_std_content( x_bar_module_settings_image() ),
      x_controls_image_std_design_setup( x_bar_module_settings_image() ),
      x_controls_image_std_design_colors( x_bar_module_settings_image() ),
      x_controls_omega( $settings_std_customize )
    );

  }

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_element_image( $adv = false ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_.php' );

  if ( $adv ) {

    $control_groups = array_merge(
      x_control_groups_image( x_bar_module_settings_image() ),
      x_control_groups_omega()
    );

  } else {

    $control_groups = x_control_groups_std( array( 'group_title' => __( 'Image', '__x__' ) ) );

  }

  return $control_groups;

}



// Values
// =============================================================================

function x_values_element_image( $settings = array() ) {

  $values = array_merge(
    x_values_image( x_bar_module_settings_image() ),
    x_values_omega()
  );

  return x_bar_mixin_values( $values, $settings );

}
