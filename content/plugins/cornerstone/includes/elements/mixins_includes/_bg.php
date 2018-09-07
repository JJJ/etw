<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/_BG.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls: Advanced
//   02. Controls: Standard (Design - Setup)
//   03. Values
// =============================================================================

// Controls: Advanced
// =============================================================================

function x_controls_bg_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_bg.php' );

  $controls = array_merge(
    $control_group_bg_adv_lower_layer,
    $control_group_bg_adv_upper_layer,
    $control_group_bg_adv_parallax,
    x_control_border_radius( $settings_bg_border_radius )
  );

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_bg_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_bg.php' );

  $controls = array_merge(
    $control_group_bg_std_lower_layer,
    $control_group_bg_std_upper_layer
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Values
// =============================================================================

function x_values_bg( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_bg.php' );


  // Setup
  // -----
  // Requires some extra steps as the bg is a 2nd level mixin to be used in
  // other 1st level mixins, such as the bar.

  if ( isset( $settings['k_pre'] ) && ! empty( $settings['k_pre'] ) ) {

    $ends_with_underscore = substr( $settings['k_pre'], -1 ) == '_';

    $k_pre = ( $ends_with_underscore ) ? $settings['k_pre'] : $settings['k_pre'] . '_';

  } else {

    $k_pre = '';

  }


  // Values
  // ------

  $values = array(

    $k_pre . 'bg_lower_type'               => x_module_value( 'none', 'markup' ),
    $k_pre . 'bg_lower_color'              => x_module_value( 'rgba(255, 255, 255, 0.5)', 'attr' ),
    $k_pre . 'bg_lower_image'              => x_module_value( '', 'attr', true ),
    $k_pre . 'bg_lower_image_repeat'       => x_module_value( 'no-repeat', 'attr', true ),
    $k_pre . 'bg_lower_image_size'         => x_module_value( 'cover', 'attr', true ),
    $k_pre . 'bg_lower_image_position'     => x_module_value( 'center', 'attr', true ),
    $k_pre . 'bg_lower_video'              => x_module_value( '', 'markup', true ),
    $k_pre . 'bg_lower_video_poster'       => x_module_value( '', 'markup', true ),

    $k_pre . 'bg_upper_type'               => x_module_value( 'none', 'markup' ),
    $k_pre . 'bg_upper_color'              => x_module_value( 'rgba(255, 255, 255, 0.5)', 'attr' ),
    $k_pre . 'bg_upper_image'              => x_module_value( '', 'attr', true ),
    $k_pre . 'bg_upper_image_repeat'       => x_module_value( 'no-repeat', 'attr', true ),
    $k_pre . 'bg_upper_image_size'         => x_module_value( 'cover', 'attr', true ),
    $k_pre . 'bg_upper_image_position'     => x_module_value( 'center', 'attr', true ),
    $k_pre . 'bg_upper_video'              => x_module_value( '', 'markup', true ),
    $k_pre . 'bg_upper_video_poster'       => x_module_value( '', 'markup', true ),

    $k_pre . 'bg_lower_parallax'           => x_module_value( false, 'markup' ),
    $k_pre . 'bg_lower_parallax_size'      => x_module_value( '150%', 'markup' ),
    $k_pre . 'bg_lower_parallax_direction' => x_module_value( 'v', 'markup' ),
    $k_pre . 'bg_lower_parallax_reverse'   => x_module_value( false, 'markup' ),

    $k_pre . 'bg_upper_parallax'           => x_module_value( false, 'markup' ),
    $k_pre . 'bg_upper_parallax_size'      => x_module_value( '150%', 'markup' ),
    $k_pre . 'bg_upper_parallax_direction' => x_module_value( 'v', 'markup' ),
    $k_pre . 'bg_upper_parallax_reverse'   => x_module_value( false, 'markup' ),

    $k_pre . 'bg_border_radius'            => x_module_value( 'inherit', 'attr' ),

  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}