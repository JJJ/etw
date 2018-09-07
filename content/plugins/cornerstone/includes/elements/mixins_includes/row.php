<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/ROW.PHP
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

function x_controls_row_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/row.php' );

  $controls = array_merge(

    $control_group_row_adv_setup,

    x_controls_bg_adv( array_merge( $settings_row_bg, array( 'adv' => true ) ) ),

    $control_group_row_adv_formatting,

    x_control_margin( $settings_row_design_margin ),
    x_control_padding( $settings_row_design ),
    x_control_border( $settings_row_design ),
    x_control_border_radius( $settings_row_design ),
    x_control_box_shadow( $settings_row_design )

  );

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_row_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/row.php' );

  $controls = array_merge(
    $control_group_row_std_design_setup,
    x_controls_bg_std_design_setup(),
    x_control_margin( $settings_row_std_design_margin )
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_row_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/row.php' );

  $controls = $control_group_row_std_design_colors;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_row( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/row.php' );

  $control_groups = array(
    $group            => array( 'title' => $group_title ),
    $group_row_setup  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_row_design => array( 'title' => __( 'Design', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_row( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/row.php' );

  $values = array_merge(
    array(
      'title'                  => x_module_value( '', 'attr' ),
      'row_base_font_size'     => x_module_value( '1em', 'style' ),
      'row_z_index'            => x_module_value( '1', 'style' ),
      'row_width'              => x_module_value( 'auto', 'style' ),
      'row_max_width'          => x_module_value( 'none', 'style' ),
      'row_inner_container'    => x_module_value( true, 'markup' ),
      'row_marginless_columns' => x_module_value( false, 'markup' ),
      'row_bg_color'           => x_module_value( 'transparent', 'style:color' ),
      'row_bg_advanced'        => x_module_value( false, 'all' ),
    ),
    x_values_bg(),
    array(
      'row_text_align'              => x_module_value( 'none', 'style' ),
      'row_margin'                  => x_module_value( '0em auto 0em auto', 'style' ),
      'row_padding'                 => x_module_value( '0em', 'style' ),
      'row_border_width'            => x_module_value( '0px', 'style' ),
      'row_border_style'            => x_module_value( 'none', 'style' ),
      'row_border_color'            => x_module_value( 'transparent', 'style:color' ),
      'row_border_radius'           => x_module_value( '0px', 'style' ),
      'row_box_shadow_dimensions'   => x_module_value( '0em 0em 0em 0em', 'style' ),
      'row_box_shadow_color'        => x_module_value( 'transparent', 'style:color' ),
    )
  );

  return x_bar_mixin_values( $values, $settings );

}
