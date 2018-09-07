<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/SECTION.PHP
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

function x_controls_section_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/section.php' );

  $controls = array_merge(

    $control_group_section_adv_setup,

    x_controls_bg_adv( array_merge( $settings_section_bg, array( 'adv' => true ) ) ),

    x_controls_separator_adv( array_merge( $settings_section_separator_top, array( 'adv' => true ) ) ),
    x_controls_separator_adv( array_merge( $settings_section_separator_bottom, array( 'adv' => true ) ) ),

    $control_group_section_adv_formatting,

    x_control_margin( $settings_section_design ),
    x_control_padding( $settings_section_design ),
    x_control_border( $settings_section_design ),
    x_control_box_shadow( $settings_section_design )

  );

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_section_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/section.php' );

  $controls = array_merge(
    $control_group_section_std_design_setup,
    x_controls_bg_std_design_setup(),
    x_control_margin( $settings_section_std_design )
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_section_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/section.php' );

  $controls = array_merge(
    $control_group_section_std_design_colors,
    x_controls_separator_std_design_colors( $settings_section_separator_top ),
    x_controls_separator_std_design_colors( $settings_section_separator_bottom )
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_section( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/section.php' );

  $control_groups = array(
    $group                => array( 'title' => __( $group_title, '__x__' ) ),
    $group_section_setup  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_section_design => array( 'title' => __( 'Design', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_section( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/section.php' );

  $values = array_merge(
    array(
      'title'                  => x_module_value('', 'attr'),
      'section_base_font_size' => x_module_value( '1em', 'style' ),
      'section_z_index'        => x_module_value( '1', 'style' ),
      'section_bg_color'       => x_module_value( 'transparent', 'style:color' ),
      'section_bg_advanced'    => x_module_value( false, 'all' ),
    ),
    x_values_bg(),
    x_values_separator( array( 'k_pre' => 'section_top', 'location' => 'top' ) ),
    x_values_separator( array( 'k_pre' => 'section_bottom', 'location' => 'bottom' ) ),
    array(
      'section_text_align'            => x_module_value( 'none', 'style' ),
      'section_margin'                => x_module_value( '0em', 'style' ),
      'section_padding'               => x_module_value( '45px 0px 45px 0px', 'style' ),
      'section_border_width'          => x_module_value( '0px', 'style' ),
      'section_border_style'          => x_module_value( 'none', 'style' ),
      'section_border_color'          => x_module_value( 'transparent', 'style:color' ),
      'section_box_shadow_dimensions' => x_module_value( '0em 0em 0em 0em', 'style' ),
      'section_box_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
    )
  );

  return x_bar_mixin_values( $values, $settings );

}
