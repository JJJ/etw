<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/SEPARATOR.PHP
// -----------------------------------------------------------------------------
// Element Controls
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
// =============================================================================

// Controls
// =============================================================================

function x_control_partial_separator( $settings ) {

  // Setup
  // -----

  $label_prefix = ( isset( $settings['label_prefix'] ) ) ? $settings['label_prefix'] : '';
  $k_pre        = ( isset( $settings['k_pre'] )        ) ? $settings['k_pre'] . '_' : '';
  $group        = ( isset( $settings['group'] )        ) ? $settings['group']       : 'design';
  $conditions   = ( isset( $settings['conditions'] )   ) ? $settings['conditions']   : array();
  $location     = ( isset( $settings['location'] )     ) ? $settings['location']    : 'top';


  // Individual Controls
  // -------------------

  $control_separator = array(
    'key'     => $k_pre . 'separator',
    'type'    => 'choose',
    'label'   => __( 'Enable', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_separator_type = array(
    'key'       => $k_pre . 'separator_type',
    'type'      => 'select',
    'label'     => __( 'Type', '__x__' ),
    'condition' => array( $k_pre . 'separator' => true ),
    'options'   => array(
      'choices' => array(
        array( 'value' => 'angle-in',  'label' => __( 'Angle In', '__x__' ) ),
        array( 'value' => 'angle-out', 'label' => __( 'Angle Out', '__x__' ) ),
        array( 'value' => 'curve-in',  'label' => __( 'Curve In', '__x__' ) ),
        array( 'value' => 'curve-out', 'label' => __( 'Curve Out', '__x__' ) ),
      ),
    ),
  );

  $control_separator_angle_point = array(
    'key'        => $k_pre . 'separator_angle_point',
    'type'       => 'unit-slider',
    'label'      => __( 'Angle Point', '__x__' ),
    'conditions' => array( array( $k_pre . 'separator' => true ), array( 'key' => $k_pre . 'separator_type', 'op' => 'IN', 'value' => array( 'angle-in', 'angle-out' ) ) ),
    'options'    => array(
      'unit_mode'       => 'unitless',
      'fallback_value'  => '50',
      'min'             => 0,
      'max'             => 100,
      'step'            => 1,
    ),
  );

  $control_separator_height = array(
    'key'     => $k_pre . 'separator_height',
    'type'    => 'unit',
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '50px',
      'ranges'          => array(
        'px'  => array( 'min' => 50,  'max' => 150, 'step' => 1   ),
        'em'  => array( 'min' => 2.5, 'max' => 10,  'step' => 0.5 ),
        'rem' => array( 'min' => 2.5, 'max' => 10,  'step' => 0.5 ),
      ),
    ),
  );

  $control_separator_inset = array(
    'key'     => $k_pre . 'separator_inset',
    'type'    => 'unit',
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '0px',
      'ranges'          => array(
        'px'  => array( 'min' => 0, 'max' => 3,    'step' => 1   ),
        'em'  => array( 'min' => 0, 'max' => 0.15, 'step' => 0.5 ),
        'rem' => array( 'min' => 0, 'max' => 0.15, 'step' => 0.5 ),
      ),
    ),
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

  return array(
    'controls' => array(
      array(
        'type'       => 'group',
        'label'      => __( '{{prefix}} Separator', '__x__' ),
        'label_vars' => array( 'prefix' => $label_prefix ),
        'group'      => $group,
        'conditions' => $conditions,
        'controls'   => array(
          $control_separator,
          $control_separator_type,
          $control_separator_angle_point,
          $control_separator_height_and_inset,
          $control_separator_color,
        ),
      ),
    ),
    'controls_std_design_colors' => array(
      array(
        'type'       => 'group',
        'label_vars' => array( 'prefix' => $label_prefix ),
        'label'      => __( '{{prefix}} Separator Base Colors', '__x__' ),
        'conditions'  => array_merge(
          $conditions,
          array( array( $k_pre . 'separator' => true ) )
        ),
        'controls'   => array(
          $control_separator_color,
        ),
      )
    ),
  );
}

cs_register_control_partial( 'separator', 'x_control_partial_separator' );
