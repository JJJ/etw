<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/_FRAME.PHP
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

function x_controls_frame_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_frame.php' );

  $controls = array_merge(
    $control_group_frame_adv_setup,
    x_control_margin( $settings_frame ),
    x_control_border( $settings_frame ),
    x_control_border_radius( $settings_frame ),
    x_control_padding( $settings_frame ),
    x_control_box_shadow( $settings_frame )
  );

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_frame_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_frame.php' );

  $controls = array_merge(
    $control_group_frame_std_design_setup,
    x_control_margin( $settings_frame_std_design )
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_frame_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_frame.php' );

  $controls = $control_group_frame_std_design_colors;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_frame( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_frame.php' );

  $control_groups = array(
    $group              => array( 'title' => $group_title ),
    $group_frame_setup  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_frame_design => array( 'title' => __( 'Design', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_frame( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_frame.php' );


  // Values
  // ------

  $values = array(
    'frame_content_type'                => x_module_value( $type, 'markup' ),
    'frame_content_sizing'              => x_module_value( 'aspect-ratio', 'style' ),
    'frame_base_font_size'              => x_module_value( '16px', 'style' ),
    'frame_width'                       => x_module_value( '100%', 'style' ),
    'frame_max_width'                   => x_module_value( 'none', 'style' ),
    'frame_content_aspect_ratio_width'  => x_module_value( '16', 'style' ),
    'frame_content_aspect_ratio_height' => x_module_value( '9', 'style' ),
    'frame_content_height'              => x_module_value( '350px', 'style' ),
    'frame_bg_color'                    => x_module_value( '#ffffff', 'style:color' ),
    'frame_margin'                      => x_module_value( '0em', 'style' ),
    'frame_padding'                     => x_module_value( '0em', 'style' ),
    'frame_border_width'                => x_module_value( '0px', 'style' ),
    'frame_border_style'                => x_module_value( 'none', 'style' ),
    'frame_border_color'                => x_module_value( 'transparent', 'style:color' ),
    'frame_border_radius'               => x_module_value( '0em', 'style' ),
    'frame_box_shadow_dimensions'       => x_module_value( '0em 0em 0em 0em', 'style' ),
    'frame_box_shadow_color'            => x_module_value( 'transparent', 'style:color' ),
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
