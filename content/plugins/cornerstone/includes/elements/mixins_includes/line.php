<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/LINE.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls: Advanced
//   02. Controls: Standard (Design - Setup)
//   03. Controls: Standard (Design - Colors)
//   04. Control Group
//   05. Values
// =============================================================================

// Controls: Advanced
// =============================================================================

function x_controls_line_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/line.php' );

  $controls = array_merge(
    $control_group_line_adv_setup,
    x_control_margin( $settings_line_design ),
    x_control_border_radius( $settings_line_design ),
    x_control_box_shadow( $settings_line_design )
  );

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_line_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/line.php' );

  $controls = array_merge(
    $control_group_line_std_design_setup,
    x_control_margin( $settings_line_std_design )
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_line_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/line.php' );

  $controls = $control_group_line_std_design_colors;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_line( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/line.php' );

  $control_groups = array(
    $group             => array( 'title' => $group_title ),
    $group_line_setup  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_line_design => array( 'title' => __( 'Design', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_line( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/line.php' );


  // Values
  // ------

  $values = array(
    'line_direction'             => x_module_value( 'horizontal', 'style' ),
    'line_base_font_size'        => x_module_value( '1em', 'style' ),
    'line_width'                 => x_module_value( '100%', 'style' ),
    'line_max_width'             => x_module_value( 'none', 'style' ),
    'line_height'                => x_module_value( '50px', 'style' ),
    'line_max_height'            => x_module_value( 'none', 'style' ),
    'line_size'                  => x_module_value( '8px', 'style' ),
    'line_color'                 => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'line_style'                 => x_module_value( 'solid', 'style' ),
    'line_margin'                => x_module_value( '0px', 'style' ),
    'line_border_radius'         => x_module_value( '0em', 'style' ),
    'line_box_shadow_dimensions' => x_module_value( '0em 0em 0em 0em', 'style' ),
    'line_box_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
