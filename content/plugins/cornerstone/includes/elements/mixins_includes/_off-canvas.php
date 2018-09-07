<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/_OFF-CANVAS.PHP
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

function x_controls_off_canvas_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_off-canvas.php' );

  $controls = array_merge(
    $control_group_off_canvas_adv_setup,
    $control_group_off_canvas_adv_colors,
    x_control_border( $settings_off_canvas_content ),
    x_control_box_shadow( $settings_off_canvas_content )
  );

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_off_canvas_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_off-canvas.php' );

  $controls = $control_group_off_canvas_std_design_setup;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_off_canvas_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_off-canvas.php' );

  $controls = $control_group_off_canvas_std_design_colors;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_off_canvas( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_off-canvas.php' );

  $control_groups = array(
    $group                   => array( 'title' => $group_title ),
    $group_off_canvas_setup  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_off_canvas_design => array( 'title' => __( 'Design', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_off_canvas( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_off-canvas.php' );


  // Values
  // ------

  $values = array(
    'off_canvas_base_font_size'                => x_module_value( '16px', 'style' ),
    'off_canvas_location'                      => x_module_value( 'right', 'markup' ),
    'off_canvas_close_font_size'               => x_module_value( '1.5em', 'style' ),
    'off_canvas_close_dimensions'              => x_module_value( '2', 'style' ),
    'off_canvas_content_max_width'             => x_module_value( '24em', 'style' ),
    'off_canvas_close_color'                   => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'off_canvas_close_color_alt'               => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'off_canvas_content_bg_color'              => x_module_value( '#ffffff', 'style:color' ),
    'off_canvas_bg_color'                      => x_module_value( 'rgba(0, 0, 0, 0.75)', 'style:color' ),
    'off_canvas_content_border_width'          => x_module_value( '0px', 'style' ),
    'off_canvas_content_border_style'          => x_module_value( 'none', 'style' ),
    'off_canvas_content_border_color'          => x_module_value( 'transparent', 'style:color' ),
    'off_canvas_content_box_shadow_dimensions' => x_module_value( '0em 0em 2em 0em', 'style' ),
    'off_canvas_content_box_shadow_color'      => x_module_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
