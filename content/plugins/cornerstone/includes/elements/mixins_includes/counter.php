<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/COUNTER.PHP
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

function x_controls_counter_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/counter.php' );

  $controls = array_merge(

    $control_group_counter_adv_setup,
    $control_group_counter_adv_setup_above_and_below,

    x_control_margin( $settings_counter ),
    x_control_margin( $settings_counter_number_margin ),

    x_control_text_format( $settings_counter_number ),
    x_control_text_style( $settings_counter_number ),
    x_control_text_shadow( $settings_counter_number ),
    x_control_text_format( $settings_counter_before_after ),
    x_control_text_style( $settings_counter_before_after ),
    x_control_text_shadow( $settings_counter_before_after )

  );

  return $controls;

}



// Controls: Standard (Content)
// =============================================================================

function x_controls_counter_std_content( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/counter.php' );

  $controls = $control_group_counter_std_content_setup;

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_counter_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/counter.php' );

  $controls = array_merge(
    $control_group_counter_std_design_setup,
    x_control_margin( $settings_counter_std_design ),
    x_control_margin( $settings_counter_std_design_number_margin )
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_counter_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/counter.php' );

  $controls = $control_group_counter_std_design_colors;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_counter( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/counter.php' );

  $control_groups = array(
    $group                => array( 'title' => $group_title ),
    $group_counter_setup  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_counter_design => array( 'title' => __( 'Design', '__x__' ) ),
    $group_counter_number => array( 'title' => __( 'Number', '__x__' ) ),
    $group_counter_text   => array( 'title' => __( 'Text', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_counter( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/counter.php' );

  $values = array(

    'counter_base_font_size'                      => x_module_value( '1em', 'style' ),
    'counter_width'                               => x_module_value( 'auto', 'style' ),
    'counter_max_width'                           => x_module_value( 'none', 'style' ),
    'counter_start'                               => x_module_value( '0', 'markup', true ),
    'counter_end'                                 => x_module_value( '100', 'markup', true ),
    'counter_number_prefix_content'               => x_module_value( '', 'markup', true ),
    'counter_number_suffix_content'               => x_module_value( '', 'markup', true ),
    'counter_duration'                            => x_module_value( '1.5s', 'markup' ),
    'counter_before_after'                        => x_module_value( false, 'all' ),
    'counter_before_content'                      => x_module_value( '', 'markup', true ),
    'counter_after_content'                       => x_module_value( '', 'markup', true ),

    'counter_margin'                              => x_module_value( '0em', 'style' ),

    'counter_number_margin'                       => x_module_value( '0em', 'style' ),
    'counter_number_font_family'                  => x_module_value( 'inherit', 'style:font-family' ),
    'counter_number_font_weight'                  => x_module_value( 'inherit:400', 'style:font-weight' ),
    'counter_number_font_size'                    => x_module_value( '1em', 'style' ),
    'counter_number_letter_spacing'               => x_module_value( '0em', 'style' ),
    'counter_number_line_height'                  => x_module_value( '1', 'style' ),
    'counter_number_font_style'                   => x_module_value( 'normal', 'style' ),
    'counter_number_text_align'                   => x_module_value( 'none', 'style' ),
    'counter_number_text_decoration'              => x_module_value( 'none', 'style' ),
    'counter_number_text_transform'               => x_module_value( 'none', 'style' ),
    'counter_number_text_color'                   => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'counter_number_text_shadow_dimensions'       => x_module_value( '0px 0px 0px', 'style' ),
    'counter_number_text_shadow_color'            => x_module_value( 'transparent', 'style:color' ),

    'counter_before_after_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
    'counter_before_after_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
    'counter_before_after_font_size'              => x_module_value( '1em', 'style' ),
    'counter_before_after_letter_spacing'         => x_module_value( '0em', 'style' ),
    'counter_before_after_line_height'            => x_module_value( '1', 'style' ),
    'counter_before_after_font_style'             => x_module_value( 'normal', 'style' ),
    'counter_before_after_text_align'             => x_module_value( 'none', 'style' ),
    'counter_before_after_text_decoration'        => x_module_value( 'none', 'style' ),
    'counter_before_after_text_transform'         => x_module_value( 'none', 'style' ),
    'counter_before_after_text_color'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'counter_before_after_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
    'counter_before_after_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),

  );

  return x_bar_mixin_values( $values, $settings );

}
