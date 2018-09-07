<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/_SEPARATOR.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls: Advanced
//   02. Controls: Standard (Design - Colors)
//   03. Values
// =============================================================================

// Control
// =============================================================================

function x_controls_separator_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_separator.php' );

  $controls = $control_group_separator_adv_setup;

  return $controls;

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_separator_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_separator.php' );

  $controls = $control_group_separator_std_design_colors;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Values
// =============================================================================

function x_values_separator( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_separator.php' );


  // Setup
  // -----
  // Requires some extra steps as the particle is a 2nd level mixin to be used
  // in other 1st level mixins, such as the anchor.

  if ( isset( $settings['k_pre'] ) && ! empty( $settings['k_pre'] ) ) {

    $ends_with_underscore = substr( $settings['k_pre'], -1 ) == '_';

    $k_pre = ( $ends_with_underscore ) ? $settings['k_pre'] : $settings['k_pre'] . '_';

  } else {

    $k_pre = '';

  }


  // Values
  // ------

  $values = array(
    $k_pre . 'separator'             => x_module_value( false, 'all' ),
    $k_pre . 'separator_location'    => x_module_value( $location, 'all' ),
    $k_pre . 'separator_type'        => x_module_value( 'angle-in', 'markup' ),
    $k_pre . 'separator_angle_point' => x_module_value( '50', 'attr' ),
    $k_pre . 'separator_height'      => x_module_value( '50px', 'attr' ),
    $k_pre . 'separator_inset'       => x_module_value( '0px', 'attr' ),
    $k_pre . 'separator_color'       => x_module_value( 'rgba(0, 0, 0, 0.75)', 'attr' ),
  );



  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
