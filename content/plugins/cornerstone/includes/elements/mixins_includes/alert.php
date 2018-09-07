<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/ALERT.PHP
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

function x_controls_alert_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/alert.php' );

  $controls = array_merge(
    $control_group_alert_adv_setup,
    $control_group_alert_adv_close_setup,
    x_control_margin( $settings_alert_design ),
    x_control_padding( $settings_alert_design ),
    x_control_border( $settings_alert_design ),
    x_control_border_radius( $settings_alert_design ),
    x_control_box_shadow( $settings_alert_design ),
    x_control_text_format( $settings_alert_text ),
    x_control_text_style( $settings_alert_text ),
    x_control_text_shadow( $settings_alert_text )
  );

  return $controls;

}



// Controls: Standard (Content)
// =============================================================================

function x_controls_alert_std_content( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/alert.php' );

  $controls = $control_group_alert_std_content_setup;

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_alert_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/alert.php' );

  $controls = array_merge(
    $control_group_alert_std_design_setup,
    x_control_margin( $settings_alert_std_design )
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_alert_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/alert.php' );

  $controls = $control_group_alert_std_design_colors;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_alert( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/alert.php' );

  $control_groups = array(
    $group              => array( 'title' => $group_title ),
    $group_alert_setup  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_alert_close  => array( 'title' => __( 'Close', '__x__' ) ),
    $group_alert_design => array( 'title' => __( 'Design', '__x__' ) ),
    $group_alert_text   => array( 'title' => __( 'Text', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_alert( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/alert.php' );


  // Values
  // ------

  $values = array(

    'alert_close'                  => x_module_value( true, 'all' ),
    'alert_width'                  => x_module_value( 'auto', 'style' ),
    'alert_max_width'              => x_module_value( 'none', 'style' ),
    'alert_content'                => x_module_value( __( 'This is where the content for your alert goes. Best to keep it short and sweet!', '__x__' ), 'markup:html', true ),
    'alert_bg_color'               => x_module_value( 'transparent', 'style:color' ),

    'alert_close_font_size'        => x_module_value( '1em', 'style' ),
    'alert_close_location'         => x_module_value( 'right', 'style' ),
    'alert_close_offset_top'       => x_module_value( '1.25em', 'style' ),
    'alert_close_offset_side'      => x_module_value( '1em', 'style' ),
    'alert_close_color'            => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'alert_close_color_alt'        => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),

    'alert_margin'                 => x_module_value( '0em', 'style' ),
    'alert_padding'                => x_module_value( '1em 2.75em 1em 1.15em', 'style' ),
    'alert_border_width'           => x_module_value( '1px', 'style' ),
    'alert_border_style'           => x_module_value( 'solid', 'style' ),
    'alert_border_color'           => x_module_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
    'alert_border_radius'          => x_module_value( '3px', 'style' ),
    'alert_box_shadow_dimensions'  => x_module_value( '0em 0.15em 0.25em 0em', 'style' ),
    'alert_box_shadow_color'       => x_module_value( 'rgba(0, 0, 0, 0.05)', 'style:color' ),

    'alert_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
    'alert_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
    'alert_font_size'              => x_module_value( '1em', 'style' ),
    'alert_line_height'            => x_module_value( '1.5', 'style' ),
    'alert_letter_spacing'         => x_module_value( '0em', 'style' ),
    'alert_font_style'             => x_module_value( 'normal', 'style' ),
    'alert_text_align'             => x_module_value( 'none', 'style' ),
    'alert_text_decoration'        => x_module_value( 'none', 'style' ),
    'alert_text_transform'         => x_module_value( 'none', 'style' ),
    'alert_text_color'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'alert_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
    'alert_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),

  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
