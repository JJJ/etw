<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/SEPARATOR.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Control
//   02. Values
// =============================================================================

// Control
// =============================================================================

function x_controls_separator( $settings = array() ) {

  // Setup
  // -----

  $t_pre     = ( isset( $settings['t_pre'] )     ) ? $settings['t_pre'] . ' ' : '';
  $k_pre     = ( isset( $settings['k_pre'] )     ) ? $settings['k_pre'] . '_' : '';
  $group     = ( isset( $settings['group'] )     ) ? $settings['group']       : 'design';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition']   : array();
  $location  = ( isset( $settings['location'] )  ) ? $settings['location']    : 'top';

  $conditions = x_module_conditions( $condition );


  // Setup - Options
  // ---------------

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

  $options_separator_angle_point = array(
    'unit_mode'       => 'unitless',
    'fallback_value'  => '50',
    'min'             => 0,
    'max'             => 100,
    'step'            => 1,
  );


  // Data
  // ----

  $data = array(
    array(
      'type'       => 'group',
      'title'      => __( $t_pre . 'Separator', '__x__' ),
      'group'      => $group,
      'conditions' => $conditions,
      'controls'   => array(
        array(
          'key'     => $k_pre . 'separator',
          'type'    => 'choose',
          'label'   => __( 'Enable', '__x__' ),
          'options' => array(
            'choices' => array(
              array( 'value' => false, 'label' => __( 'Off', '__x__' ) ),
              array( 'value' => true,  'label' => __( 'On', '__x__' ) ),
            ),
          ),
        ),
        array(
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
        ),
        array(
          'key'        => $k_pre . 'separator_angle_point',
          'type'       => 'unit-slider',
          'label'      => __( 'Angle Point', '__x__' ),
          'options'    => $options_separator_angle_point,
          'conditions' => array( array( $k_pre . 'separator' => true ), array( 'key' => $k_pre . 'separator_type', 'op' => 'IN', 'value' => array( 'angle-in', 'angle-out' ) ) ),
        ),
        array(
          'key'       => $k_pre . 'separator_height',
          'type'      => 'unit-slider',
          'label'     => __( 'Height', '__x__' ),
          'options'   => $options_separator_height,
          'condition' => array( $k_pre . 'separator' => true ),
        ),
        array(
          'key'       => $k_pre . 'separator_color',
          'type'      => 'color',
          'label'     => __( 'Color', '__x__' ),
          'condition' => array( $k_pre . 'separator' => true ),
          'options'   => array(
            'label' => __( 'Select', '__x__' ),
          ),
        ),
      ),
    ),
  );


  // Returned Value
  // --------------

  $controls = $data;

  return $controls;

}



// Values
// =============================================================================

function x_values_separator( $settings = array() ) {

  // Setup
  // -----
  // Requires some extra steps as the particle is a 2nd level mixin to be used
  // in other 1st level mixins, such as the anchor.

  if ( isset( $settings['k_pre'] ) && ! empty( $settings['k_pre'] ) ) {

    $ends_with_underscore = substr( $settings['k_pre'], -1 ) == '_';

    $k_pre = ( $ends_with_underscore ) ? $settings['k_pre'] : $settings['k_pre'] . '_';

  } else {

    $k_pre = '';

  }

  $location = ( isset( $settings['location'] ) ) ? $settings['location'] : 'top';


  // Values
  // ------

  $values = array(
    $k_pre . 'separator'             => x_module_value( false, 'all' ),
    $k_pre . 'separator_location'    => x_module_value( $location, 'all' ),
    $k_pre . 'separator_type'        => x_module_value( 'angle-in', 'markup' ),
    $k_pre . 'separator_angle_point' => x_module_value( '50', 'attr' ),
    $k_pre . 'separator_height'      => x_module_value( '50px', 'attr' ),
    $k_pre . 'separator_color'       => x_module_value( 'rgba(0, 0, 0, 0.75)', 'attr' ),
  );



  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
