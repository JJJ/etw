<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/_DROPDOWN.PHP
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

function x_controls_dropdown_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_dropdown.php' );

  $controls = array_merge(
    $control_group_dropdown_adv_setup,
    x_control_margin( $settings_dropdown_first ),
    x_control_border( $settings_dropdown ),
    x_control_border_radius( $settings_dropdown ),
    x_control_padding( $settings_dropdown ),
    x_control_box_shadow( $settings_dropdown )
  );

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_dropdown_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_dropdown.php' );

  $controls = $control_group_dropdown_std_design_setup;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_dropdown_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_dropdown.php' );

  $controls = $control_group_dropdown_std_design_colors;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_dropdown( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_dropdown.php' );

  $control_groups = array(
    $group                 => array( 'title' => $group_title ),
    $group_dropdown_setup  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_dropdown_design => array( 'title' => __( 'Design', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_dropdown( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_dropdown.php' );


  // Values
  // ------

  $values = array(
    'dropdown_base_font_size'        => x_module_value( '16px', 'style' ),
    'dropdown_width'                 => x_module_value( '14em', 'style' ),
    'dropdown_bg_color'              => x_module_value( '#ffffff', 'style:color' ),
    'dropdown_margin'                => x_module_value( '0em', 'style' ),
    'dropdown_padding'               => x_module_value( '0em', 'style' ),
    'dropdown_border_width'          => x_module_value( '0px', 'style' ),
    'dropdown_border_style'          => x_module_value( 'none', 'style' ),
    'dropdown_border_color'          => x_module_value( 'transparent', 'style:color' ),
    'dropdown_border_radius'         => x_module_value( '0em', 'style' ),
    'dropdown_box_shadow_dimensions' => x_module_value( '0em 0.15em 2em 0em', 'style' ),
    'dropdown_box_shadow_color'      => x_module_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
