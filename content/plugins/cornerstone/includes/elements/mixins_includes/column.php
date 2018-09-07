<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/COLUMN.PHP
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

function x_controls_column_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/column.php' );

  $controls = array_merge(

    $control_group_column_adv_setup,

    x_controls_bg_adv( array_merge( $settings_column_bg, array( 'adv' => true ) ) ),

    $control_group_column_adv_formatting,

    x_control_padding( $settings_column_design ),
    x_control_border( $settings_column_design ),
    x_control_border_radius( $settings_column_design ),
    x_control_box_shadow( $settings_column_design )

  );

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_column_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/column.php' );

  $controls = array_merge(
    $control_group_column_std_design_setup,
    x_controls_bg_std_design_setup()
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_column_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/column.php' );

  $controls = $control_group_column_std_design_colors;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_column( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/column.php' );

  $control_groups = array(
    $group               => array( 'title' => $group_title ),
    $group_column_setup  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_column_design => array( 'title' => __( 'Design', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_column( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/column.php' );

  $values = array_merge(
    array(
      'title'                        => x_module_value('', 'attr'),
      '_active'                      => x_module_value( false, 'attr' ),
      'size'                         => x_module_value( '1/1', 'attr' ),
      'column_base_font_size'        => x_module_value( '1em', 'style' ),
      'column_z_index'               => x_module_value( '1', 'style' ),
      'column_fade'                  => x_module_value( false, 'markup' ),
      'column_fade_duration'         => x_module_value( '0.5s', 'markup' ),
      'column_fade_animation'        => x_module_value( 'in', 'markup' ),
      'column_fade_animation_offset' => x_module_value( '50px', 'markup' ),
      'column_bg_color'              => x_module_value( 'transparent', 'style:color' ),
      'column_bg_advanced'           => x_module_value( false, 'all' ),
    ),
    x_values_bg(),
    array(
      'column_text_align'            => x_module_value( 'none', 'style' ),
      'column_padding'               => x_module_value( '0em', 'style' ),
      'column_border_width'          => x_module_value( '0px', 'style' ),
      'column_border_style'          => x_module_value( 'none', 'style' ),
      'column_border_color'          => x_module_value( 'transparent', 'style:color' ),
      'column_border_radius'         => x_module_value( '0px 0px 0px 0px', 'style' ),
      'column_box_shadow_dimensions' => x_module_value( '0em 0em 0em 0em', 'style' ),
      'column_box_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
    )
  );

  return x_bar_mixin_values( $values, $settings );

}
