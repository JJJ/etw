<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/_MODAL.PHP
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

function x_controls_modal_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_modal.php' );

  $controls = array_merge(
    $control_group_modal_adv_setup,
    $control_group_modal_adv_colors,
    x_control_padding( $settings_modal_content ),
    x_control_border( $settings_modal_content ),
    x_control_border_radius( $settings_modal_content ),
    x_control_box_shadow( $settings_modal_content )
  );

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_modal_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_modal.php' );

  $controls = $control_group_modal_std_design_setup;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_modal_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_modal.php' );

  $controls = $control_group_modal_std_design_colors;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_modal( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_modal.php' );

  $control_groups = array(
    $group             => array( 'title' => $group_title ),
    $group . ':setup'  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':design' => array( 'title' => __( 'Design', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_modal( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_modal.php' );


  // Values
  // ------

  $values = array(
    'modal_base_font_size'                => x_module_value( '16px', 'style' ),
    'modal_close_location'                => x_module_value( 'top-right', 'markup' ),
    'modal_close_font_size'               => x_module_value( '1.5em', 'style' ),
    'modal_close_dimensions'              => x_module_value( '1', 'style' ),
    'modal_content_max_width'             => x_module_value( '28em', 'style' ),
    'modal_bg_color'                      => x_module_value( 'rgba(0, 0, 0, 0.75)', 'style:color' ),
    'modal_close_color'                   => x_module_value( 'rgba(255, 255, 255, 0.5)', 'style:color' ),
    'modal_close_color_alt'               => x_module_value( '#ffffff', 'style:color' ),
    'modal_content_bg_color'              => x_module_value( '#ffffff', 'style:color' ),
    'modal_content_padding'               => x_module_value( '2em', 'style' ),
    'modal_content_border_width'          => x_module_value( '0px', 'style' ),
    'modal_content_border_style'          => x_module_value( 'none', 'style' ),
    'modal_content_border_color'          => x_module_value( 'transparent', 'style:color' ),
    'modal_content_border_radius'         => x_module_value( '0em', 'style' ),
    'modal_content_box_shadow_dimensions' => x_module_value( '0em 0.15em 2em 0em', 'style' ),
    'modal_content_box_shadow_color'      => x_module_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
