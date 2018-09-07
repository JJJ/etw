<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/STATBAR.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls: Advanced
//   02. Controls: Standard (Content)
//   03. Controls: Standard (Design - Setup)
//   04. Controls: Standard (Design - Colors)
//   05. Control Group
//   06. Values
// =============================================================================

// Controls: Advanced
// =============================================================================

function x_controls_statbar_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/statbar.php' );

  $controls = array_merge(

    $control_group_statbar_adv_setup,
    x_control_margin( $settings_statbar_design ),
    x_control_padding( $settings_statbar_design ),
    x_control_border( $settings_statbar_design ),
    x_control_border_radius( $settings_statbar_design ),
    x_control_box_shadow( $settings_statbar_design ),

    $control_group_statbar_adv_setup_bar,
    x_control_border_radius( $settings_statbar_bar_design ),
    x_control_box_shadow( $settings_statbar_bar_design ),

    $control_group_statbar_adv_setup_label,
    $control_group_statbar_adv_label_dimensions_and_position,
    x_control_padding( $settings_statbar_label_design ),
    x_control_border( $settings_statbar_label_design ),
    x_control_border_radius( $settings_statbar_label_design ),
    x_control_box_shadow( $settings_statbar_label_design ),

    x_control_text_format( $settings_statbar_label_text ),
    x_control_text_style( $settings_statbar_label_text ),
    x_control_text_shadow( $settings_statbar_label_text )

  );

  return $controls;

}



// Controls: Standard (Content)
// =============================================================================

function x_controls_statbar_std_content( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/statbar.php' );

  $controls = $control_group_statbar_std_content_setup;

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_statbar_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/statbar.php' );

  $controls = array_merge(
    $control_group_statbar_std_design_setup,
    x_control_margin( $settings_statbar_std_design ),
    $control_group_statbar_std_design_setup_bar_and_label
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_statbar_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/statbar.php' );

  $controls = $control_group_statbar_std_design_colors;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_statbar( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/statbar.php' );

  $control_groups = array(

    $group                      => array( 'title' => $group_title ),
    $group_statbar_setup        => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_statbar_design       => array( 'title' => __( 'Design', '__x__' ) ),

    $group_statbar_bar          => array( 'title' => __( 'Bar', '__x__' ) ),
    $group_statbar_bar_setup    => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_statbar_bar_design   => array( 'title' => __( 'Design', '__x__' ) ),

    $group_statbar_label        => array( 'title' => __( 'Label', '__x__' ) ),
    $group_statbar_label_setup  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_statbar_label_design => array( 'title' => __( 'Design', '__x__' ) ),
    $group_statbar_label_text   => array( 'title' => __( 'Text', '__x__' ) ),

  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_statbar( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/statbar.php' );

  $values = array(

    'statbar_base_font_size'               => x_module_value( '1em', 'style' ),
    'statbar_direction'                    => x_module_value( 'row', 'style' ),
    'statbar_width_row'                    => x_module_value( '100%', 'style' ),
    'statbar_max_width_row'                => x_module_value( 'none', 'style' ),
    'statbar_height_row'                   => x_module_value( '2em', 'style' ),
    'statbar_max_height_row'               => x_module_value( 'none', 'style' ),
    'statbar_width_column'                 => x_module_value( '2em', 'style' ),
    'statbar_max_width_column'             => x_module_value( 'none', 'style' ),
    'statbar_height_column'                => x_module_value( '18em', 'style' ),
    'statbar_max_height_column'            => x_module_value( 'none', 'style' ),
    'statbar_bg_color'                     => x_module_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'statbar_trigger_offset'               => x_module_value( '50%', 'style' ),

    'statbar_margin'                       => x_module_value( '0em 0em 0em 0em', 'style' ),
    'statbar_padding'                      => x_module_value( '0em 0em 0em 0em', 'style' ),
    'statbar_border_width'                 => x_module_value( '0px', 'style' ),
    'statbar_border_style'                 => x_module_value( 'none', 'style' ),
    'statbar_border_color'                 => x_module_value( 'transparent', 'style:color' ),
    'statbar_border_radius'                => x_module_value( '3px 3px 3px 3px', 'style' ),
    'statbar_box_shadow_dimensions'        => x_module_value( '0em 0em 0em 0em', 'style' ),
    'statbar_box_shadow_color'             => x_module_value( 'transparent', 'style:color' ),

    'statbar_bar_length'                   => x_module_value( '92%', 'all', true ),
    'statbar_bar_bg_color'                 => x_module_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'statbar_bar_border_radius'            => x_module_value( '3px 3px 3px 3px', 'style' ),
    'statbar_bar_box_shadow_dimensions'    => x_module_value( '0em 0em 0em 0em', 'style' ),
    'statbar_bar_box_shadow_color'         => x_module_value( 'transparent', 'style:color' ),

    'statbar_label'                        => x_module_value( true, 'all' ),
    'statbar_label_custom_text'            => x_module_value( false, 'markup' ),
    'statbar_label_always_show'            => x_module_value( false, 'markup' ),
    'statbar_label_text_content'           => x_module_value( __( 'HTML &amp; CSS', '__x__' ), 'markup', true ),
    'statbar_label_justify'                => x_module_value( 'flex-end', 'all' ),
    'statbar_label_bg_color'               => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'statbar_label_width'                  => x_module_value( 'auto', 'style' ),
    'statbar_label_height'                 => x_module_value( 'auto', 'style' ),
    'statbar_label_translate_x'            => x_module_value( '-0.5em', 'style' ),
    'statbar_label_translate_y'            => x_module_value( '0em', 'style' ),

    'statbar_label_padding'                => x_module_value( '0.35em 0.5em 0.35em 0.5em', 'style' ),
    'statbar_label_border_width'           => x_module_value( '0px', 'style' ),
    'statbar_label_border_style'           => x_module_value( 'none', 'style' ),
    'statbar_label_border_color'           => x_module_value( 'transparent', 'style:color' ),
    'statbar_label_border_radius'          => x_module_value( '2px 2px 2px 2px', 'style' ),
    'statbar_label_box_shadow_dimensions'  => x_module_value( '0em 0em 0em 0em', 'style' ),
    'statbar_label_box_shadow_color'       => x_module_value( 'transparent', 'style:color' ),

    'statbar_label_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
    'statbar_label_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
    'statbar_label_font_size'              => x_module_value( '0.75em', 'style' ),
    'statbar_label_letter_spacing'         => x_module_value( '0em', 'style' ),
    'statbar_label_line_height'            => x_module_value( '1', 'style' ),
    'statbar_label_font_style'             => x_module_value( 'normal', 'style' ),
    'statbar_label_text_align'             => x_module_value( 'none', 'style' ),
    'statbar_label_text_decoration'        => x_module_value( 'none', 'style' ),
    'statbar_label_text_transform'         => x_module_value( 'none', 'style' ),
    'statbar_label_text_color'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'statbar_label_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
    'statbar_label_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),

  );

  return x_bar_mixin_values( $values, $settings );

}
