<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/WIDGET-AREA.PHP
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

function x_controls_widget_area_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/widget-area.php' );

  $controls = array_merge(
    $control_group_widget_area_adv_setup,
    x_control_margin( $settings_widget_area ),
    x_control_padding( $settings_widget_area ),
    x_control_border( $settings_widget_area ),
    x_control_border_radius( $settings_widget_area ),
    x_control_box_shadow( $settings_widget_area )
  );

  return $controls;

}



// Controls: Standard (Content)
// =============================================================================

function x_controls_widget_area_std_content( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/widget-area.php' );

  $controls = $control_group_widget_area_std_content_setup;

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_widget_area_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/widget-area.php' );

  $controls = array_merge(
    $control_group_widget_area_std_design_setup,
    x_control_margin( $settings_widget_std_design )
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_widget_area_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/widget-area.php' );

  $controls = $control_group_widget_area_std_design_colors;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_widget_area( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/widget-area.php' );

  $control_groups = array(
    $group                    => array( 'title' => __( $group_title, '__x__' ) ),
    $group_widget_area_setup  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_widget_area_design => array( 'title' => __( 'Design', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_widget_area( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/widget-area.php' );

  $values = array(
    'widget_area_sidebar'               => x_module_value( '', 'markup', true ),
    'widget_area_base_font_size'        => x_module_value( '16px', 'style' ),
    'widget_area_bg_color'              => x_module_value( 'transparent', 'style:color' ),
    'widget_area_margin'                => x_module_value( '0em', 'style' ),
    'widget_area_padding'               => x_module_value( '0em', 'style' ),
    'widget_area_border_width'          => x_module_value( '0px', 'style' ),
    'widget_area_border_style'          => x_module_value( 'none', 'style' ),
    'widget_area_border_color'          => x_module_value( 'transparent', 'style:color' ),
    'widget_area_border_radius'         => x_module_value( '0em', 'style' ),
    'widget_area_box_shadow_dimensions' => x_module_value( '0em 0em 0em 0em', 'style' ),
    'widget_area_box_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
  );

  return x_bar_mixin_values( $values, $settings );

}
