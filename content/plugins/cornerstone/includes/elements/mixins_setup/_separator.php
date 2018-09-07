<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/_SEPARATOR.PHP
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
//   09. Control Groups (Standard Design)
// =============================================================================

// Shared
// =============================================================================

include( '_.php' );



// Setup
// =============================================================================

$t_pre     = ( isset( $settings['t_pre'] )     ) ? $settings['t_pre'] . ' ' : '';
$k_pre     = ( isset( $settings['k_pre'] )     ) ? $settings['k_pre'] . '_' : '';
$group     = ( isset( $settings['group'] )     ) ? $settings['group']       : 'design';
$condition = ( isset( $settings['condition'] ) ) ? $settings['condition']   : array();
$location  = ( isset( $settings['location'] )  ) ? $settings['location']    : 'top';



// Groups
// =============================================================================
// Parent mixins will pass in group.



// Conditions
// =============================================================================

$conditions = x_module_conditions( $condition );



// Options
// =============================================================================

$options_separator_type = array(
  'choices' => array(
    array( 'value' => 'angle-in',  'label' => __( 'Angle In', '__x__' ) ),
    array( 'value' => 'angle-out', 'label' => __( 'Angle Out', '__x__' ) ),
    array( 'value' => 'curve-in',  'label' => __( 'Curve In', '__x__' ) ),
    array( 'value' => 'curve-out', 'label' => __( 'Curve Out', '__x__' ) ),
  ),
);

$options_separator_height = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '50px',
  'ranges'          => array(
    'px'  => array( 'min' => 50,  'max' => 150, 'step' => 1   ),
    'em'  => array( 'min' => 2.5, 'max' => 10,  'step' => 0.5 ),
    'rem' => array( 'min' => 2.5, 'max' => 10,  'step' => 0.5 ),
  ),
);

$options_separator_inset = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '0px',
  'ranges'          => array(
    'px'  => array( 'min' => 0, 'max' => 3,    'step' => 1   ),
    'em'  => array( 'min' => 0, 'max' => 0.15, 'step' => 0.5 ),
    'rem' => array( 'min' => 0, 'max' => 0.15, 'step' => 0.5 ),
  ),
);

$options_separator_angle_point = array(
  'unit_mode'       => 'unitless',
  'fallback_value'  => '50',
  'min'             => 0,
  'max'             => 100,
  'step'            => 1,
);



// Individual Controls
// =============================================================================

$control_separator = array(
  'key'     => $k_pre . 'separator',
  'type'    => 'choose',
  'label'   => __( 'Enable', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_separator_type = array(
  'key'       => $k_pre . 'separator_type',
  'type'      => 'select',
  'label'     => __( 'Type', '__x__' ),
  'condition' => array( $k_pre . 'separator' => true ),
  'options'   => $options_separator_type,
);

$control_separator_angle_point = array(
  'key'        => $k_pre . 'separator_angle_point',
  'type'       => 'unit-slider',
  'label'      => __( 'Angle Point', '__x__' ),
  'options'    => $options_separator_angle_point,
  'conditions' => array( array( $k_pre . 'separator' => true ), array( 'key' => $k_pre . 'separator_type', 'op' => 'IN', 'value' => array( 'angle-in', 'angle-out' ) ) ),
);

$control_separator_height = array(
  'key'     => $k_pre . 'separator_height',
  'type'    => 'unit',
  'options' => $options_separator_height,
);

$control_separator_inset = array(
  'key'     => $k_pre . 'separator_inset',
  'type'    => 'unit',
  'options' => $options_separator_inset,
);

$control_separator_height_and_inset = array(
  'type'      => 'group',
  'label'     => __( 'Height &amp; Inset', '__x__' ),
  'group'     => $group,
  'condition' => array( $k_pre . 'separator' => true ),
  'controls'  => array(
    $control_separator_height,
    $control_separator_inset,
  ),
);

$control_separator_color = array(
  'key'       => $k_pre . 'separator_color',
  'type'      => 'color',
  'label'     => __( 'Color', '__x__' ),
  'condition' => array( $k_pre . 'separator' => true ),
  'options'   => array(
    'label' => __( 'Select', '__x__' ),
  ),
);



// Control Lists
// =============================================================================

$control_list_separator_adv_setup = array(
  $control_separator,
  $control_separator_type,
  $control_separator_angle_point,
  $control_separator_height_and_inset,
  $control_separator_color,
);

$control_list_separator_std_design_colors_base = array(
  $control_separator_color,
);



// Control Groups (Advanced)
// =============================================================================

$control_group_separator_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( $t_pre . 'Separator', '__x__' ),
    'group'      => $group,
    'conditions' => $conditions,
    'controls'   => $control_list_separator_adv_setup,
  ),
);



// Control Groups (Standard Design)
// =============================================================================

$control_group_separator_std_design_colors = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Separator Base Colors', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_separator_std_design_colors_base,
  ),
);
