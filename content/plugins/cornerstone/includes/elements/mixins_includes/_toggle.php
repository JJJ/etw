<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/_TOGGLE.PHP
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

// Controls: Advanced
// =============================================================================

function x_controls_toggle_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_toggle.php' );

  $controls = $control_group_toggle_adv_setup;

  return $controls;

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_toggle_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_toggle.php' );

  $controls = $control_group_toggle_std_design_colors;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Values
// =============================================================================

function x_values_toggle( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_toggle.php' );


  // Setup
  // -----
  // Requires some extra steps as the toggle is a 2nd level mixin to be used in
  // other 1st level mixins, such as the anchor.

  if ( isset( $settings['k_pre'] ) && ! empty( $settings['k_pre'] ) ) {

    $ends_with_underscore = substr( $settings['k_pre'], -1 ) == '_';

    $k_pre = ( $ends_with_underscore ) ? $settings['k_pre'] : $settings['k_pre'] . '_';

  } else {

    $k_pre = '';

  }


  // Values
  // ------

  $values = array(
    $k_pre . 'toggle_type'           => x_module_value( 'burger-1', 'all' ),
    $k_pre . 'toggle_burger_size'    => x_module_value( '0.1em', 'style' ),
    $k_pre . 'toggle_burger_spacing' => x_module_value( '3.25em', 'style' ),
    $k_pre . 'toggle_burger_width'   => x_module_value( '12em', 'style' ),
    $k_pre . 'toggle_grid_size'      => x_module_value( '0.25em', 'style' ),
    $k_pre . 'toggle_grid_spacing'   => x_module_value( '1.75em', 'style' ),
    $k_pre . 'toggle_more_size'      => x_module_value( '0.35em', 'style' ),
    $k_pre . 'toggle_more_spacing'   => x_module_value( '1.75em', 'style' ),
    $k_pre . 'toggle_color'          => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    $k_pre . 'toggle_color_alt'      => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
