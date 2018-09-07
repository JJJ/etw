<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/LINE.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Shared
//   02. Setup
//   03. Groups
//   04. Conditions
//   05. Options
//   06. Individual Controls
//   07. Control Lists
//   08. Control Groups (Advanced)
//   09. Control Groups (Standard)
// =============================================================================

// Shared
// =============================================================================

include( '_.php' );



// Setup
// =============================================================================

$group       = ( isset( $settings['group'] )       ) ? $settings['group']     : 'line';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Line', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition'] : array();



// Groups
// =============================================================================

$group_line_setup  = $group . ':setup';
$group_line_design = $group . ':design';



// Conditions
// =============================================================================

$conditions                = x_module_conditions( $condition );
$condition_line_horizontal = array( 'line_direction' => 'horizontal' );
$condition_line_vertical   = array( 'line_direction' => 'vertical' );



// Options
// =============================================================================

$options_line_direction = array(
  'choices' => array(
    array( 'value' => 'horizontal', 'label' => __( 'Horizontal', '__x__' ) ),
    array( 'value' => 'vertical',   'label' => __( 'Vertical', '__x__' ) ),
  ),
);

$options_line_base_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '1em',
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
    'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
  ),
);

$options_line_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'valid_keywords'  => array( 'calc', 'auto' ),
  'fallback_value'  => '100%',
);

$options_line_max_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'valid_keywords'  => array( 'calc', 'none' ),
  'fallback_value'  => 'none',
);

$options_line_height = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'valid_keywords'  => array( 'calc', 'auto' ),
  'fallback_value'  => '50px',
);

$options_line_max_height = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'valid_keywords'  => array( 'calc', 'none' ),
  'fallback_value'  => 'none',
);

$options_line_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '8px',
  'ranges'          => array(
    'px'  => array( 'min' => 0, 'max' => 25, 'step' => 1   ),
    'em'  => array( 'min' => 0, 'max' => 2,  'step' => 0.1 ),
    'rem' => array( 'min' => 0, 'max' => 2,  'step' => 0.1 ),
  ),
);

$options_line_style = array(
  'choices' => array(
    array( 'value' => 'solid',  'label' => __( 'Solid', '__x__' ) ),
    array( 'value' => 'dotted', 'label' => __( 'Dotted', '__x__' ) ),
    array( 'value' => 'dashed', 'label' => __( 'Dashed', '__x__' ) ),
    array( 'value' => 'double', 'label' => __( 'Double', '__x__' ) ),
    array( 'value' => 'groove', 'label' => __( 'Groove', '__x__' ) ),
    array( 'value' => 'ridge',  'label' => __( 'Ridge', '__x__' ) ),
  ),
);



// Settings
// =============================================================================

$settings_line_design = array(
  'k_pre'     => 'line',
  'group'     => $group_line_design,
  'condition' => $conditions,
);

$settings_line_std_design = array(
  'k_pre'     => 'line',
  'group'     => $group_std_design,
  'condition' => $conditions,
);



// Individual Controls
// =============================================================================

$control_line_direction = array(
  'key'     => 'line_direction',
  'type'    => 'choose',
  'label'   => __( 'Direction', '__x__' ),
  'options' => $options_line_direction,
);

$control_line_base_font_size = array(
  'key'     => 'line_base_font_size',
  'type'    => 'unit-slider',
  'label'   => __( 'Base Font Size', '__x__' ),
  'options' => $options_line_base_font_size,
);

$control_line_width = array(
  'key'       => 'line_width',
  'type'      => $is_adv ? 'unit' : 'unit-slider',
  'label'   => __( 'Width', '__x__' ),
  'options'   => $options_line_width,
  'condition' => $condition_line_horizontal,
);

$control_line_max_width = array(
  'key'       => 'line_max_width',
  'type'      => $is_adv ? 'unit' : 'unit-slider',
  'label'   => __( 'Max Width', '__x__' ),
  'options'   => $options_line_max_width,
  'condition' => $condition_line_horizontal,
);

$control_line_width_and_max_width = array(
  'type'      => 'group',
  'label'     => __( 'Width &amp; Max Width', '__x__' ),
  'condition' => $condition_line_horizontal,
  'controls'  => array(
    $control_line_width,
    $control_line_max_width
  ),
);

$control_line_height = array(
  'key'       => 'line_height',
  'type'      => $is_adv ? 'unit' : 'unit-slider',
  'label'   => __( 'Height', '__x__' ),
  'options'   => $options_line_height,
  'condition' => $condition_line_vertical,
);

$control_line_max_height = array(
  'key'       => 'line_max_height',
  'type'      => $is_adv ? 'unit' : 'unit-slider',
  'label'   => __( 'Max Height', '__x__' ),
  'options'   => $options_line_max_height,
  'condition' => $condition_line_vertical,
);

$control_line_height_and_max_height = array(
  'type'      => 'group',
  'label'     => __( 'Height &amp; Max Height', '__x__' ),
  'condition' => $condition_line_vertical,
  'controls'  => array(
    $control_line_height,
    $control_line_max_height,
  ),
);

$control_line_size = array(
  'key'     => 'line_size',
  'type'    => 'unit-slider',
  'label'   => __( 'Size', '__x__' ),
  'options' => $options_line_size,
);

$control_line_color = array(
  'key'     => 'line_color',
  'type'    => 'color',
  'label'   => __( 'Color', '__x__' ),
  'options' => array(
    'label' => __( 'Select', '__x__' ),
  ),
);

$control_line_style = array(
  'key'     => 'line_style',
  'type'    => 'select',
  'label'   => __( 'Style', '__x__' ),
  'options' => $options_line_style,
);

$control_line_color_and_style = array(
  'type'     => 'group',
  'label'    => __( 'Color &amp; Style', '__x__' ),
  'controls' => array(
    $control_line_color,
    $control_line_style,
  ),
);



// Control Lists
// =============================================================================

// Advanced
// --------

$control_list_line_adv_setup = array(
  $control_line_direction,
  $control_line_base_font_size,
  $control_line_width_and_max_width,
  $control_line_height_and_max_height,
  $control_line_size,
  $control_line_color_and_style,
);


// Standard
// --------

$control_list_alert_std_design_setup = array(
  $control_line_base_font_size,
  $control_line_width,
  $control_line_max_width,
  $control_line_height,
  $control_line_max_height,
  $control_line_size,
  $control_line_style,
);

$control_list_alert_std_design_colors_base = array(
  $control_line_color,
  array(
    'keys'      => array( 'value' => 'line_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'line_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
);



// Control Groups (Advanced)
// =============================================================================

$control_group_line_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_line_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_line_adv_setup,
  ),
);



// Control Groups (Standard)
// =============================================================================

$control_group_line_std_design_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Design Setup', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_alert_std_design_setup,
  ),
);

$control_group_line_std_design_colors = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Base Colors', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_alert_std_design_colors_base,
  ),
);
